<?php
if (!defined('ABSPATH')) { exit; }
// Fail closed until Rildon approves physical testing. Reading the panel never
// creates commands, polls SSAP or requests a new capture from a TV.
function mdr_tv_panel_review(){return (bool)get_option('mdr_tv_panel_review',true);}
function mdr_tv_panel_locations(){return ['capim'=>['name'=>'Recepção','office'=>'Capim Macio'],'capim70'=>['name'=>'Salão','office'=>'Capim Macio'],'manhattan'=>['name'=>'Manhattan','office'=>'Tirol']];}
function mdr_tv_panel_date($stamp){return $stamp?wp_date('d/m/Y · H:i:s',(int)$stamp,new DateTimeZone('America/Fortaleza')):'';}
function mdr_tv_panel_image_allowed($unit){return current_user_can('mdr_tv_start')&&mdr_tv_unit_allowed($unit);}
function mdr_tv_panel_error($message){
    if(stripos($message,'Wake-on-LAN')!==false||stripos($message,'TV sem resposta')!==false)return ['code'=>'tv_unreachable','title'=>'A TV não respondeu','message'=>'Confira se a TV está na tomada. Se continuar, abra um chamado para a TI.'];
    if(stripos($message,'Expirou')!==false)return ['code'=>'service_timeout','title'=>'Solicitação sem resposta','message'=>'O serviço não confirmou a execução no prazo. Abra um chamado para a TI se o problema continuar.'];
    return ['code'=>'unconfirmed','title'=>'Início não confirmado','message'=>'Não conseguimos confirmar a reprodução nesta TV. Você pode tentar novamente ou abrir um chamado para a TI.'];
}
function mdr_tv_panel_command($post,$state,$now){
    if(!$post)return null;
    $created=strtotime($post->post_date_gmt.' UTC');$result=get_post_meta($post->ID,'mdr_tv_result',true);
    $data=['id'=>$post->ID,'action'=>$post->post_title,'at'=>$created,'when'=>mdr_tv_panel_date($created),'state'=>'pending','title'=>'Solicitação enviada','message'=>'Aguarde a resposta da TV. Não é preciso clicar novamente.','code'=>'pending'];
    if(!$result){
        if($now-$created>150)$data=array_merge($data,['state'=>'error'],mdr_tv_panel_error('Expirou'));
        elseif($post->post_status==='draft')$data=array_merge($data,['state'=>'running','title'=>'Aguardando a TV','message'=>'O serviço recebeu a solicitação e está aguardando a resposta.']);
        return $data;
    }
    if(empty($result['ok'])){
        if($post->post_title==='capture')return array_merge($data,['state'=>'error','code'=>'capture_failed','title'=>'Imagem não atualizada','message'=>'Não foi possível atualizar a imagem. A captura anterior foi mantida. Se continuar, abra um chamado para a TI.']);
        return array_merge($data,['state'=>'error'],mdr_tv_panel_error($result['message']??''));
    }
    if($post->post_title==='capture')return array_merge($data,['state'=>'success','title'=>'Imagem recebida','message'=>'Confira a data e a hora da captura.','code'=>'capture_received']);
    // Old agents reported success after merely sending a URL. Only an explicit
    // playback acknowledgement is a confirmed start; transport acceptance is not.
    $confirmed=str_starts_with($result['message']??'','Player confirmou reprodução nesta abertura.');
    if($confirmed)return array_merge($data,['state'=>'success','title'=>'Início confirmado','message'=>'O player confirmou a reprodução para esta solicitação.','code'=>'playback_confirmed']);
    return array_merge($data,['state'=>'unconfirmed','title'=>'Abertura solicitada','message'=>'A TV recebeu a abertura, mas ainda não há confirmação de reprodução para esta solicitação.','code'=>'playback_unconfirmed']);
}
function mdr_tv_panel_unit($unit,$state,$posts,$now=null){
    $now=$now??time();$location=mdr_tv_panel_locations()[$unit];$last=null;$capture_command=null;
    foreach($posts as $post){if(mdr_tv_command_unit($post)!==$unit)continue;if(!$last&&$post->post_title==='start')$last=$post;if(!$capture_command&&$post->post_title==='capture')$capture_command=$post;}
    $command=mdr_tv_panel_command($last,$state,$now);$service_at=strtotime($state['at']??'')?:0;$seen=(int)($state['player_seen']??0);$player=(string)($state['player']??'');
    $service_fresh=$service_at&&$now-$service_at>=0&&$now-$service_at<90;
    $playing=$seen&&$now-$seen>=0&&$now-$seen<35&&str_starts_with($player,'playing')&&preg_match('/(?:^| )ready=[234](?: |$)/',$player)&&strpos($player,'paused=false')!==false;
    $status=['state'=>'unknown','title'=>'Sem confirmação recente','message'=>'O painel ainda não tem uma confirmação recente de reprodução. Isso não informa se a TV está ligada ou desligada.'];
    if($service_fresh&&$playing)$status=['state'=>'playing','title'=>'Campanha em reprodução','message'=>'O player está enviando sinais recentes de reprodução. Confira também o horário da imagem.'];
    elseif(!$service_fresh)$status=['state'=>'service_offline','title'=>'Serviço sem comunicação','message'=>'O serviço não envia sinais recentes. Abra um chamado para a TI se o problema continuar.'];
    if($command&&in_array($command['state'],['pending','running'],true))$status=['state'=>'starting','title'=>$command['title'],'message'=>$command['message']];
    elseif($command&&$command['state']==='error'&&$now-$command['at']<300&&!$playing)$status=['state'=>'error','title'=>$command['title'],'message'=>$command['message']];
    $capture_at=strtotime($state['capture_at']??'')?:0;$path=mdr_tv_capture_path($unit);$exists=$capture_at&&is_readable($path);
    $image=['url'=>'','at'=>$exists?$capture_at:0,'when'=>$exists?mdr_tv_panel_date($capture_at):'Sem captura disponível','stale'=>!$exists||$now-$capture_at>120,'flip'=>$unit==='capim'];
    // Keep raw query separators in JSON; escape only when emitting HTML.
    if($exists)$image['url']=add_query_arg('_wpnonce',wp_create_nonce('mdr_tv_panel_image_'.$unit),admin_url('admin-post.php?action=mdr_tv_panel_image&tv_unit='.$unit.'&v='.$capture_at));
    $campaign_id=(int)(mdr_tv_settings($unit)['campaign']??0);$term=$campaign_id?get_term($campaign_id,'mdr_tv_campaign'):null;
    return ['id'=>$unit]+$location+['status'=>$status,'command'=>$command,'captureCommand'=>mdr_tv_panel_command($capture_command,$state,$now),'image'=>$image,'lastSignal'=>$seen?mdr_tv_panel_date($seen):'Nenhum sinal recebido','campaign'=>$term&&!is_wp_error($term)?$term->name:'Programação da unidade'];
}
function mdr_tv_panel_snapshot(){
    $posts=get_posts(['post_type'=>'mdr_tv_command','post_status'=>['private','draft'],'numberposts'=>200,'orderby'=>'ID','order'=>'DESC']);$units=[];
    foreach(mdr_tv_panel_locations() as $unit=>$location)if(mdr_tv_panel_image_allowed($unit))$units[]=mdr_tv_panel_unit($unit,get_option(mdr_tv_option('mdr_tv_bridge_state',$unit),[]),$posts);
    return ['review'=>mdr_tv_panel_review(),'at'=>time(),'when'=>mdr_tv_panel_date(time()),'units'=>$units];
}
function mdr_tv_panel_queue($unit,$action){
    if(!mdr_tv_panel_image_allowed($unit))return new WP_Error('permission','TV não autorizada.');
    if(!in_array($action,['start','capture'],true))return new WP_Error('permission','Ação não autorizada.');
    if(mdr_tv_panel_review())return new WP_Error('panel_review','Modo de validação: nenhum comando foi enviado à TV.');
    $lock='mdr_tv_panel_cooldown_'.$unit.'_'.$action;
    if(get_transient($lock))return new WP_Error('rate_limit','Aguarde alguns segundos antes de solicitar novamente.');
    $id=mdr_tv_queue($action,null,$unit);if(!is_wp_error($id))set_transient($lock,true,$action==='capture'?30:10);return $id;
}
add_action('wp_ajax_mdr_tv_panel_snapshot',function(){
    check_ajax_referer('mdr_tv_panel');if(!current_user_can('mdr_tv_start'))wp_send_json_error(['message'=>'Sem permissão.'],403);
    nocache_headers();wp_send_json_success(mdr_tv_panel_snapshot());
});
add_action('wp_ajax_mdr_tv_panel_action',function(){
    check_ajax_referer('mdr_tv_panel');if($_SERVER['REQUEST_METHOD']!=='POST')wp_send_json_error(['message'=>'Use POST.'],405);
    $unit=sanitize_key($_POST['unit']??'');$action=sanitize_key($_POST['command']??'');
    if(!mdr_tv_panel_image_allowed($unit))wp_send_json_error(['code'=>'permission','message'=>'TV não autorizada.'],403);
    // A tab opened during review must reload before it can issue real commands.
    if(($_POST['panel_version']??'')!=='0.2.1')wp_send_json_error(['code'=>'panel_reload','message'=>'O painel foi atualizado. Recarregue a página antes de iniciar a TV.'],409);
    $result=mdr_tv_panel_queue($unit,$action);
    if(is_wp_error($result))wp_send_json_error(['code'=>$result->get_error_code(),'message'=>$result->get_error_message()],$result->get_error_code()==='permission'?403:409);
    wp_send_json_success(['id'=>$result,'unit'=>$unit,'command'=>$action]);
});
add_action('admin_post_mdr_tv_panel_image',function(){
    $unit=sanitize_key($_GET['tv_unit']??'');
    if(!mdr_tv_panel_image_allowed($unit))wp_die('Sem permissão.','',['response'=>403]);
    check_admin_referer('mdr_tv_panel_image_'.$unit);$path=mdr_tv_capture_path($unit);if(!is_readable($path))wp_die('Imagem indisponível.','',['response'=>404]);
    nocache_headers();header('Cache-Control: private, no-store');header('Content-Type: image/jpeg');header('X-Content-Type-Options: nosniff');header('Cross-Origin-Resource-Policy: same-origin');readfile($path);exit;
});
add_action('admin_enqueue_scripts',function($hook){
    if($hook!=='toplevel_page_mdr-tv')return;
    $base=plugins_url('mdr-tv/',dirname(__FILE__).'/../mdr-tv.php');wp_enqueue_style('mdr-tv-operator',$base.'operator.css',[],'0.2.2');wp_enqueue_script('mdr-tv-operator',$base.'operator.js',[],'0.2.2',true);
    wp_localize_script('mdr-tv-operator','mdrTVPanel',['ajax'=>admin_url('admin-ajax.php'),'nonce'=>wp_create_nonce('mdr_tv_panel'),'support'=>'https://interno.mdradvocacia.com/glpi/','snapshot'=>mdr_tv_panel_snapshot()]);
});
add_filter('admin_body_class',function($classes){return (!empty($_GET['page'])&&$_GET['page']==='mdr-tv'&&current_user_can('mdr_tv_start')&&!current_user_can('edit_posts'))?$classes.' mdr-tv-operator-only':$classes;});
function mdr_tv_operator_panel(){
    $user=wp_get_current_user();$first=$user->first_name?:explode(' ',$user->display_name)[0];$snapshot=mdr_tv_panel_snapshot();
    echo '<main class="mdr-tv-panel" id="mdr-tv-panel"><header class="tvp-header"><div><p class="tvp-eyebrow">MDR ADVOCACIA · TV CORPORATIVA</p><h1>Olá, '.esc_html($first).'.</h1><p>Escolha a TV e acompanhe o início da exibição.</p></div><a class="tvp-logout" href="'.esc_url(wp_logout_url(wp_login_url())).'">Sair</a></header>';
    if($snapshot['review'])echo '<aside class="tvp-review"><strong>Validação da interface · comandos às TVs pausados</strong><p>As imagens abaixo são capturas já guardadas. Os botões de iniciar demonstram o retorno, sem ligar, desligar ou alterar as TVs.</p><label>Demonstrar retorno: <select id="tvp-demo-result"><option value="success">Reprodução confirmada</option><option value="tv_unreachable">TV não respondeu</option><option value="service_offline">Serviço sem comunicação</option><option value="unconfirmed">Reprodução não confirmada</option></select></label><button type="button" class="tvp-text-button" id="tvp-demo-reset">Voltar aos dados recebidos</button></aside>';
    echo '<div class="tvp-grid">';
    foreach($snapshot['units'] as $tv){
        $image=$tv['image'];echo '<article class="tvp-card" data-unit="'.esc_attr($tv['id']).'"><div class="tvp-card-heading"><p class="tvp-office">'.esc_html($tv['office']).'</p><h2>'.esc_html($tv['name']).'</h2><p class="tvp-status" data-state="'.esc_attr($tv['status']['state']).'" role="status"><span class="tvp-dot" aria-hidden="true"></span><span data-status>'.esc_html($tv['status']['title']).'</span></p></div><button type="button" class="tvp-image" data-zoom aria-label="Ampliar última captura da TV '.esc_attr($tv['name']).'" '.(!$image['url']?'disabled':'').'>';
        echo '<img alt="Última captura da TV '.esc_attr($tv['name']).'" data-image '.($image['flip']?'class="tvp-flip" ':'').($image['url']?'src="'.esc_url($image['url']).'"':'hidden').'><span data-empty '.($image['url']?'hidden':'').'>Nenhuma captura disponível.<br>Isso não informa se a TV está ligada ou desligada.</span></button><p class="tvp-capture-time" data-capture-time>'.esc_html($image['when']).($image['stale']&&$image['url']?' · Imagem antiga':'').'</p><div class="tvp-card-body"><p class="tvp-campaign">'.esc_html($tv['campaign']).'</p><p class="tvp-message" data-message aria-live="polite">'.esc_html($tv['status']['message']).'</p><div class="tvp-actions"><button type="button" class="tvp-button tvp-primary" data-start>Iniciar exibição</button><button type="button" class="tvp-text-button" data-refresh '.($snapshot['review']?'disabled':'').'>Atualizar imagem</button><small data-refresh-note>'.($snapshot['review']?'Nova captura disponível após a validação.':'Captura pontual, sem transmissão ao vivo.').'</small><button type="button" class="tvp-button tvp-support" data-support>Abrir chamado no GLPI</button></div><details><summary>Última solicitação e suporte</summary><p data-last-command>'.esc_html($tv['command']?$tv['command']['when'].' · '.$tv['command']['title']:'Sem solicitação recente.').'</p><p data-last-signal>Último sinal do player: '.esc_html($tv['lastSignal']).'. Horário de Fortaleza.</p></details></div></article>';
    }
    if(!$snapshot['units'])echo '<p>Nenhuma TV foi autorizada para seu acesso. Solicite orientação à TI.</p>';
    echo '</div><p class="tvp-footer">Imagens são capturas pontuais com data e hora, não transmissão ao vivo. Dados recebidos: <span id="tvp-updated">'.esc_html($snapshot['when']).'</span> · Fortaleza.</p><p id="tvp-global-status" role="status" aria-live="polite"></p><dialog id="tvp-image-dialog"><div class="tvp-dialog-heading"><h2>Última captura</h2><button type="button" class="tvp-button" data-close>Fechar</button></div><img alt="Captura ampliada" id="tvp-large-image"><p id="tvp-large-caption"></p></dialog><dialog id="tvp-support-dialog"><div class="tvp-dialog-heading"><h2>Chamado para a TI</h2><button type="button" class="tvp-button" data-close>Fechar</button></div><p>Copie os dados abaixo e abra o GLPI para registrar o chamado. Nenhum chamado é criado automaticamente.</p><textarea id="tvp-support-description" readonly aria-label="Dados para o chamado"></textarea><div class="tvp-dialog-actions"><button type="button" class="tvp-button" id="tvp-copy">Copiar dados</button><a class="tvp-button tvp-primary" href="https://interno.mdradvocacia.com/glpi/" target="_blank" rel="noopener noreferrer">Abrir GLPI</a></div><p id="tvp-copy-status" role="status"></p></dialog></main>';
}
