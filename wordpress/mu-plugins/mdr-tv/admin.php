<?php
if (!defined('ABSPATH')) { exit; }
add_action('admin_menu',function(){
    add_menu_page('TV corporativa','TV corporativa','mdr_tv_start','mdr-tv','mdr_tv_dashboard','dashicons-desktop',25);
    add_submenu_page('mdr-tv','Operação e programação','Operação e programação','mdr_tv_start','mdr-tv','mdr_tv_dashboard',0);
    add_submenu_page('mdr-tv','Arquivos privados','Arquivos privados','mdr_tv_manage','mdr-tv-files','mdr_tv_files_page');
    add_submenu_page('mdr-tv','Campanhas da TV','Campanhas','mdr_tv_manage','edit-tags.php?taxonomy=mdr_tv_campaign&post_type=mdr_tv_item');
});
add_action('admin_menu',function(){
    if(current_user_can('mdr_tv_start')&&!current_user_can('edit_posts')){
        global $menu;foreach($menu as $item){if(!in_array($item[2],['mdr-tv','profile.php'],true))remove_menu_page($item[2]);}
    }
},999);
add_action('admin_enqueue_scripts',function(){
    $screen=get_current_screen();if($screen&&($screen->post_type==='mdr_tv_item'||strpos($screen->id,'mdr-tv')!==false)){
        wp_enqueue_script('mdr-tv-editor',plugins_url('mdr-tv/editor.js',dirname(__FILE__).'/../mdr-tv.php'),[],'0.1.0',true);
    }
});
add_action('restrict_manage_posts',function($type){
    if($type==='mdr_tv_item'&&current_user_can('mdr_tv_manage'))wp_dropdown_categories(['taxonomy'=>'mdr_tv_campaign','name'=>'tv_campaign','hide_empty'=>false,'show_option_all'=>'Todas as campanhas','selected'=>absint($_GET['tv_campaign']??0)]);
});
add_action('pre_get_posts',function($q){
    if(is_admin()&&$q->is_main_query()&&$q->get('post_type')==='mdr_tv_item'&&!empty($_GET['tv_campaign'])&&current_user_can('mdr_tv_manage'))$q->set('tax_query',[['taxonomy'=>'mdr_tv_campaign','field'=>'term_id','terms'=>absint($_GET['tv_campaign'])]]);
});
function mdr_tv_gallery($name,$values,$audio=false){
    $items=[];foreach(mdr_tv_assets() as $a){$info=mdr_tv_asset_info($a->ID);if($info&&($audio?str_starts_with($info['mime'],'audio/'):!str_starts_with($info['mime'],'audio/')))$items[]=['id'=>$a->ID,'name'=>$a->post_title];}
    echo '<div data-tv-gallery data-items="'.esc_attr(wp_json_encode($items)).'"><input type="hidden" name="'.esc_attr($name).'" value="'.esc_attr(implode(',',(array)$values)).'"><div data-selected></div><select data-choice><option value="">Escolher arquivo privado…</option></select> <button type="button" class="button" data-add>Adicionar à sequência</button></div>';
}
function mdr_tv_form_start($action){echo '<form method="post" enctype="multipart/form-data" action="'.esc_url(admin_url('admin-post.php')).'">';wp_nonce_field('mdr_tv_'.$action);echo '<input type="hidden" name="action" value="mdr_tv_'.esc_attr($action).'"><input type="hidden" name="tv_unit" value="'.esc_attr(mdr_tv_requested_unit()).'">';}
function mdr_tv_notice(){
    if(!empty($_GET['tv_ok']))echo '<div class="notice notice-success"><p>Solicitação registrada. Confira o resultado abaixo.</p></div>';
    $error=get_transient('mdr_tv_error_'.get_current_user_id());if($error){delete_transient('mdr_tv_error_'.get_current_user_id());echo '<div class="notice notice-error"><p>'.esc_html($error).'</p></div>';}
}
function mdr_tv_dashboard(){
    if(!current_user_can('mdr_tv_start'))return;
    $unit=mdr_tv_requested_unit();$state=get_option(mdr_tv_option('mdr_tv_bridge_state',$unit),[]);$s=mdr_tv_settings($unit);
    echo '<div class="wrap"><h1>TV corporativa</h1>';mdr_tv_notice();
    echo '<h2>'.esc_html(mdr_tv_units()[$unit]).'</h2>';
    foreach(mdr_tv_units() as $id=>$label)if(mdr_tv_unit_allowed($id))echo '<a class="button" href="'.esc_url(admin_url('admin.php?page=mdr-tv&tv_unit='.$id)).'">'.esc_html($label).'</a> ';
    echo '<p>Cada unidade tem programação, comandos, estado e captura independentes.</p>';
    echo '<div style="background:#fff;border-left:5px solid #b89b58;padding:20px;max-width:850px"><h2>Recepção · iniciar exibição</h2><p>Abra a programação na TV sem navegar pelo controle remoto. O comando é executado pelo serviço interno; este computador não precisa permanecer ligado.</p>';
    mdr_tv_form_start('command');echo '<input type="hidden" name="command" value="start">';submit_button('▶ Iniciar exibição','primary large','submit',false);echo '</form><p><small>O modo de exibição é definido pela TI para cada TV durante a homologação.</small></p></div>';
    echo '<h2>Última comunicação do serviço</h2><p>'.esc_html(!empty($state['at'])?$state['at'].' UTC':'Ainda não houve comunicação autenticada.').'</p>';
    echo '<p>'.esc_html(!empty($state['received_version'])?'Programação recebida: '.substr($state['received_version'],0,12):'Programação ainda não confirmada pelo serviço.').'</p>';
    echo '<p>'.esc_html('Estado informado: '.($state['power']??'não consultado').' · Aplicativo: '.($state['app']??'não consultado')).'</p>';
    if(!empty($state['player_seen']))echo '<p>Último sinal do player: '.esc_html(gmdate('d/m/Y H:i:s',(int)$state['player_seen'])).' UTC · '.esc_html($state['player']??'').'. Não comprova a imagem física da tela.</p>';
    $commands=get_posts(['post_type'=>'mdr_tv_command','post_status'=>['private','draft'],'numberposts'=>8,'orderby'=>'ID','order'=>'DESC']);
    echo '<h2>Comandos recentes</h2><table class="widefat striped" style="max-width:1000px"><thead><tr><th>Solicitado</th><th>Comando</th><th>Resultado</th></tr></thead><tbody>';
    foreach($commands as $p){if(mdr_tv_command_unit($p)!==$unit)continue;$r=get_post_meta($p->ID,'mdr_tv_result',true);echo '<tr><td>'.esc_html($p->post_date).'</td><td>'.esc_html($p->post_title).'</td><td>'.esc_html($r?($r['message']??'Recebido'):($p->post_status==='draft'?'Em execução; confirmação pendente':'Aguardando serviço; expira em2min')).'</td></tr>';}
    echo '</tbody></table>';
    if(current_user_can('mdr_tv_manage')){
        echo '<h2>Programação</h2><p><a class="button" href="'.esc_url(admin_url('edit.php?post_type=mdr_tv_item')).'">Editar conteúdos</a> <a class="button" href="'.esc_url(admin_url('admin.php?page=mdr-tv-files')).'">Arquivos privados</a></p>';
        mdr_tv_form_start('settings');echo '<input type="hidden" name="settings_version" value="'.esc_attr(hash('sha256',serialize($s))).'"><p><label>Programação em exibição: ';wp_dropdown_categories(['taxonomy'=>'mdr_tv_campaign','name'=>'campaign','hide_empty'=>false,'show_option_all'=>'Todos os conteúdos publicados','selected'=>absint($s['campaign']??0)]);echo '</label></p><p>Selecione uma campanha para exibir somente seus conteúdos publicados. Rascunhos, ocultos e expirados continuam fora da fila.</p><p><label><input type="checkbox" name="music" value="1" '.checked($s['music'],1,false).'> Ativar trilha independente</label></p><p>Escolha faixas privadas autorizadas; sem seleção, usa a trilha instrumental do laboratório.</p>';mdr_tv_gallery('playlist',$s['playlist']??[],true);echo '<p><label>Volume da trilha (0–30%) <input type="number" min="0" max="30" name="volume" value="'.esc_attr($s['volume']).'"></label></p>';submit_button('Salvar programação');echo '</form>';
        echo '<p><strong>Fontes:</strong> biblioteca própria. Instagram/RD não conectados. Materiais de funcionários exigem autorização e aprovação antes de publicar. Estes conteúdos não são posts públicos do site.</p>';
    }
    if(current_user_can('mdr_tv_control')){
        echo '<h2>Controle técnico</h2><p>Comandos são registrados; uma solicitação aceita não comprova a ação na tela.</p>';
        foreach(['status'=>'Consultar estado','capture'=>'Obter captura real','start_dynamic'=>'Abrir player HTML para teste','start_clips'=>'Abrir programação por itens (homologação)','start_continuous'=>'Abrir vídeo de recuperação'] as $value=>$label){mdr_tv_form_start('command');echo '<input type="hidden" name="command" value="'.esc_attr($value).'">';submit_button($label,'secondary','submit',false);echo '</form><br>';}
        mdr_tv_form_start('command');echo '<input type="hidden" name="command" value="volume"><label>Volume da TV (0–50): <input name="value" type="number" min="0" max="50" value="15"></label> ';submit_button('Ajustar volume','secondary','submit',false);echo '</form>';
        if(!empty($state['capture_at'])){echo '<h3>Captura real</h3><p>'.esc_html($state['capture_at']).' UTC · captura pontual, não transmissão ao vivo.</p><img style="width:100%;max-width:900px;'.($unit==='capim'?'transform:scaleY(-1)':'').'" alt="Última captura da TV" src="'.esc_url(wp_nonce_url(admin_url('admin-post.php?action=mdr_tv_capture&tv_unit='.$unit),'mdr_tv_capture')).'">';}
    }
    echo '</div>';
}
function mdr_tv_files_page(){
    if(!current_user_can('mdr_tv_manage'))return;
    echo '<div class="wrap"><h1>Arquivos privados da TV</h1>';mdr_tv_notice();
    echo '<p>Arquivos fora da biblioteca pública do WordPress. JPG/PNG/WebP até10MiB, MP4/MP3/WAV até20MiB; quota inicial256MiB. Selecione os IDs no conteúdo da TV, na ordem desejada.</p>';
    mdr_tv_form_start('upload');echo '<input type="file" name="tv_file" required accept="image/jpeg,image/png,image/webp,video/mp4,audio/mpeg,audio/wav"><p><label><input type="checkbox" name="rights" value="1" required> Material próprio ou autorizado para esta exibição.</label></p>';submit_button('Adicionar arquivo privado');echo '</form><table class="widefat striped"><thead><tr><th>ID</th><th>Arquivo</th><th>Tipo</th><th>Tamanho</th></tr></thead><tbody>';
    foreach(mdr_tv_assets() as $p){$a=mdr_tv_asset_info($p->ID);if(!$a)continue;echo '<tr><td>'.absint($p->ID).'</td><td>'.esc_html($p->post_title).'</td><td>'.esc_html($a['mime']).'</td><td>'.esc_html(size_format($a['bytes'])).'</td></tr>';}
    echo '</tbody></table></div>';
}
add_action('add_meta_boxes_mdr_tv_item',function(){add_meta_box('mdr-tv-fields','Exibição e programação','mdr_tv_fields','mdr_tv_item','normal','high');});
function mdr_tv_fields($post){
    wp_nonce_field('mdr_tv_item','mdr_tv_nonce');$m=(array)get_post_meta($post->ID,'mdr_tv',true);
    echo '<p><a class="button" target="_blank" rel="noopener" href="'.esc_url(admin_url('admin.php?page=mdr-tv-preview&item='.$post->ID)).'">Abrir prévia editorial</a> Salve as alterações antes de abrir a prévia.</p>';
    echo '<input type="hidden" name="mdr_tv_version" value="'.esc_attr(hash('sha256',serialize($m))).'"><p>Imagens serão exibidas inteiras. Textos são paginados sem reduzir indefinidamente a fonte. Datas e horários em Natal/Fortaleza.</p><table class="form-table">';
    echo '<tr><th>Exibir nas unidades</th><td><select name="mdr_tv[unit]">';foreach(['capim'=>'Capim Macio — matriz','manhattan'=>'Manhattan — Tirol','both'=>'Ambas as unidades'] as $key=>$label)echo '<option value="'.esc_attr($key).'" '.selected($m['unit']??'capim',$key,false).'>'.esc_html($label).'</option>';echo '</select></td></tr>';
    echo '<tr><th>Formato</th><td><select name="mdr_tv[format]">';foreach(['post'=>'Post com imagem e texto','photo'=>'Foto','carousel'=>'Carrossel','story'=>'Story vertical','video'=>'Vídeo/reel','campaign'=>'Campanha'] as $k=>$v)echo '<option value="'.esc_attr($k).'" '.selected($m['format']??'post',$k,false).'>'.esc_html($v).'</option>';echo '</select></td></tr>';
    echo '<tr><th>Imagens/vídeos na ordem</th><td>';mdr_tv_gallery('mdr_tv[assets]',$m['assets']??[]);echo '<p><a href="'.esc_url(admin_url('admin.php?page=mdr-tv-files')).'">Adicionar arquivo privado</a></p></td></tr>';
    foreach(['seconds'=>['Segundos por tela',18,4,90],'priority'=>['Prioridade',0,0,100]] as $k=>$v)echo '<tr><th>'.esc_html($v[0]).'</th><td><input type="number" name="mdr_tv['.esc_attr($k).']" min="'.$v[2].'" max="'.$v[3].'" value="'.esc_attr($m[$k]??$v[1]).'"></td></tr>';
    echo '<tr><th>Campanhas</th><td>Cadastre telas curtas a partir de4segundos. Para imagens com a arte completa, deixe o texto vazio: a arte ocupa a tela sem sobreposição. Posts comuns usam no mínimo8segundos.</td></tr>';
    foreach(['start'=>'Início (opcional)','end'=>'Término (opcional)'] as $k=>$label){$date=!empty($m[$k])?wp_date('Y-m-d\TH:i',$m[$k],new DateTimeZone('America/Fortaleza')):'';echo '<tr><th>'.esc_html($label).'</th><td><input type="datetime-local" name="mdr_tv['.esc_attr($k).']" value="'.esc_attr($date).'"></td></tr>';}
    foreach(['source'=>'Origem/referência','credit'=>'Crédito/autoria'] as $k=>$label)echo '<tr><th>'.esc_html($label).'</th><td><input class="regular-text" name="mdr_tv['.esc_attr($k).']" value="'.esc_attr($m[$k]??($k==='source'?'Material MDR':'MDR Advocacia')).'"></td></tr>';
    echo '</table>';foreach(['pinned'=>'Fixar na programação','hidden'=>'Ocultar (prevalece sobre fixado)','video'=>'Reproduzir vídeos; desmarcado mostra o texto/capa quando disponível','audio'=>'Permitir som do vídeo; a trilha será pausada'] as $k=>$label)echo '<p><label><input type="checkbox" name="mdr_tv['.esc_attr($k).']" value="1" '.checked(!empty($m[$k]),true,false).'> '.esc_html($label).'</label></p>';
}
add_action('save_post_mdr_tv_item',function($id){
    if(wp_is_post_revision($id)||wp_is_post_autosave($id)||!current_user_can('edit_post',$id)||!isset($_POST['mdr_tv_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mdr_tv_nonce'])),'mdr_tv_item'))return;
    $old=(array)get_post_meta($id,'mdr_tv',true);$version=wp_unslash($_POST['mdr_tv_version']??'');
    $m=hash_equals(hash('sha256',serialize($old)),(string)$version)?mdr_tv_parse_fields(wp_unslash($_POST['mdr_tv']??[])):new WP_Error('stale','A programação foi alterada por outra pessoa. Recarregue antes de salvar.');
    if(is_wp_error($m)){set_transient('mdr_tv_error_'.get_current_user_id(),$m->get_error_message(),120);return;}
    update_post_meta($id,'mdr_tv',$m);mdr_tv_audit('item_saved',$id);
});
function mdr_tv_complete($result,$page='mdr-tv'){
    if(is_wp_error($result))set_transient('mdr_tv_error_'.get_current_user_id(),$result->get_error_message(),120);
    wp_safe_redirect(add_query_arg('tv_ok',is_wp_error($result)?0:1,admin_url('admin.php?page='.$page.'&tv_unit='.mdr_tv_requested_unit())));exit;
}
add_action('admin_post_mdr_tv_command',function(){check_admin_referer('mdr_tv_command');mdr_tv_complete(mdr_tv_queue(sanitize_key($_POST['command']??''),$_POST['value']??null,mdr_tv_requested_unit()));});
add_action('admin_post_mdr_tv_settings',function(){
    if(!current_user_can('mdr_tv_manage'))wp_die('Sem permissão.',403);check_admin_referer('mdr_tv_settings');
    $unit=mdr_tv_requested_unit();$old=mdr_tv_settings($unit);if(!hash_equals(hash('sha256',serialize($old)),(string)wp_unslash($_POST['settings_version']??'')))mdr_tv_complete(new WP_Error('stale','A programação mudou. Recarregue a página antes de salvar.'));
    $campaign=absint($_POST['campaign']??0);if($campaign&&!term_exists($campaign,'mdr_tv_campaign'))mdr_tv_complete(new WP_Error('campaign','Campanha indisponível. Recarregue a página.'));
    $ids=[];foreach(array_slice(explode(',',sanitize_text_field(wp_unslash($_POST['playlist']??''))),0,12) as $id){$id=absint($id);$a=mdr_tv_asset_info($id);if($a&&str_starts_with($a['mime'],'audio/'))$ids[]=$id;}
    update_option(mdr_tv_option('mdr_tv_settings',$unit),array_merge($old,['campaign'=>$campaign,'music'=>empty($_POST['music'])?0:1,'volume'=>min(30,absint($_POST['volume']??14)),'playlist'=>array_unique($ids)]),false);mdr_tv_audit('settings_saved');mdr_tv_complete(true);
});
add_action('admin_post_mdr_tv_upload',function(){
    if(!current_user_can('mdr_tv_manage'))wp_die('Sem permissão.',403);check_admin_referer('mdr_tv_upload');
    $f=$_FILES['tv_file']??null;
    if(empty($_POST['rights'])||!$f||$f['error']!==UPLOAD_ERR_OK||!is_uploaded_file($f['tmp_name']))mdr_tv_complete(new WP_Error('file','Selecione um arquivo autorizado válido.'),'mdr-tv-files');
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);$allowed=['image/jpeg','image/png','image/webp','video/mp4','audio/mpeg','audio/x-wav','audio/wav'];
    $max=str_starts_with((string)$mime,'image/')?10*1024*1024:20*1024*1024;$size=filesize($f['tmp_name']);
    if(!in_array($mime,$allowed,true)||!$size||$size>$max)mdr_tv_complete(new WP_Error('type','Formato ou tamanho não permitido.'),'mdr-tv-files');
    if(str_starts_with($mime,'image/')&&!@getimagesize($f['tmp_name']))mdr_tv_complete(new WP_Error('image','Imagem inválida.'),'mdr-tv-files');
    wp_mkdir_p(mdr_tv_root());$lock=fopen(mdr_tv_root().'/upload.lock','c');flock($lock,LOCK_EX);
    $used=0;foreach(glob(mdr_tv_root().'/*') as $path)if(is_file($path))$used+=filesize($path);
    $hash=hash_file('sha256',$f['tmp_name']);$dest=mdr_tv_root().'/'.$hash;
    if(!is_file($dest)&&$used+$size>256*1024*1024){flock($lock,LOCK_UN);fclose($lock);mdr_tv_complete(new WP_Error('quota','Quota de256MiB atingida.'),'mdr-tv-files');}
    if(!is_file($dest)&&!move_uploaded_file($f['tmp_name'],$dest)){flock($lock,LOCK_UN);fclose($lock);mdr_tv_complete(new WP_Error('write','Falha ao guardar arquivo.'),'mdr-tv-files');}
    chmod($dest,0600);flock($lock,LOCK_UN);fclose($lock);
    $id=wp_insert_post(['post_type'=>'mdr_tv_asset','post_status'=>'private','post_title'=>sanitize_file_name($f['name'])]);
    foreach(['hash'=>$hash,'mime'=>$mime,'bytes'=>$size,'rights_confirmed'=>gmdate('c')] as $k=>$v)update_post_meta($id,'mdr_tv_'.$k,$v);
    mdr_tv_audit('asset_uploaded',$id);mdr_tv_complete(true,'mdr-tv-files');
});
add_action('admin_post_mdr_tv_capture',function(){
    if(!current_user_can('mdr_tv_control'))wp_die('Sem permissão.',403);check_admin_referer('mdr_tv_capture');
    $unit=mdr_tv_requested_unit();$p='/var/lib/mdr-tv/capture'.($unit==='capim'?'':'-manhattan').'.jpg';if(!is_readable($p))wp_die('Captura indisponível.',404);
    nocache_headers();header('Content-Type:image/jpeg');header('X-Content-Type-Options:nosniff');readfile($p);exit;
});
