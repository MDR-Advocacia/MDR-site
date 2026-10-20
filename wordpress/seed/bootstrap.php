<?php
// Explicit one-time initialization, invoked over SSH stdin after deployment.
// No credentials are stored in the repository or echoed by this script.
define('WP_INSTALLING', true);
require '/var/www/html/wp-load.php';
require_once ABSPATH.'wp-admin/includes/upgrade.php';
require_once ABSPATH.'wp-admin/includes/file.php';
require_once ABSPATH.'wp-admin/includes/media.php';
require_once ABSPATH.'wp-admin/includes/image.php';
$secrets=json_decode(stream_get_contents(STDIN),true,512,JSON_THROW_ON_ERROR);
if(!is_blog_installed()) {
    wp_install('MDR Advocacia — Laboratório', $secrets['admin_user'], 'laboratorio@example.invalid', false, '', $secrets['admin_password'], 'pt_BR');
}
if(get_option('mdr_seed_version')==='1.0.0') { echo json_encode(['status'=>'already_initialized']); exit; }
$admin=get_user_by('login',$secrets['admin_user']);
if(!$admin){throw new RuntimeException('Administrador esperado não encontrado');}
wp_set_current_user($admin->ID);
$editor=get_user_by('login',$secrets['editor_user']);
if(!$editor){$eid=wp_insert_user(['user_login'=>$secrets['editor_user'],'user_pass'=>$secrets['editor_password'],'user_email'=>'comunicacao@example.invalid','display_name'=>'Comunicação MDR','role'=>'editor']);if(is_wp_error($eid)){throw new RuntimeException($eid->get_error_message());}}
switch_theme('mdr');
update_option('blog_public','0');
update_option('blogdescription','Direito, pessoas e conhecimento.');
update_option('timezone_string','America/Fortaleza');
update_option('date_format','d/m/Y');
update_option('permalink_structure','/blog/%postname%/');
update_option('posts_per_page',9);
update_option('default_comment_status','closed');
update_option('default_ping_status','closed');
update_option('show_avatars',0);
$data=json_decode(file_get_contents(__DIR__.'/content.json'),true,512,JSON_THROW_ON_ERROR);
foreach($data['contact'] as $key=>$value){if(is_string($value)){update_option('mdr_'.$key,$value);}elseif($key==='social'){foreach($value as $network=>$url){update_option('mdr_social_'.$network,$url);}}}
function mdr_seed_post($type,$slug,$title,$content,$extra=[]){
    $old=get_page_by_path($slug,OBJECT,$type);
    $id=wp_insert_post(array_merge(['ID'=>$old?$old->ID:0,'post_type'=>$type,'post_name'=>$slug,'post_title'=>$title,'post_content'=>$content,'post_status'=>'publish','comment_status'=>'closed','ping_status'=>'closed'], $extra),true);
    if(is_wp_error($id)){throw new RuntimeException($id->get_error_message());}return $id;
}
function mdr_seed_image($file,$parent,$alt){
    $existing=get_posts(['post_type'=>'attachment','meta_key'=>'mdr_source_file','meta_value'=>$file,'posts_per_page'=>1]);
    if($existing){return $existing[0]->ID;}
    $source=get_template_directory().'/assets/'.basename($file);
    $tmp=wp_tempnam($source);copy($source,$tmp);
    $id=media_handle_sideload(['name'=>basename($file),'tmp_name'=>$tmp],$parent,$alt);
    if(is_wp_error($id)){@unlink($tmp);throw new RuntimeException($id->get_error_message());}
    update_post_meta($id,'mdr_source_file',$file);update_post_meta($id,'_wp_attachment_image_alt',$alt);return $id;
}
function mdr_p($text,$class=''){return '<!-- wp:paragraph'.($class?' '.wp_json_encode(['className'=>$class]):'').' --><p'.($class?' class="'.esc_attr($class).'"':'').'>'.esc_html($text).'</p><!-- /wp:paragraph -->';}
function mdr_h($text,$level=2){return '<!-- wp:heading '.wp_json_encode(['level'=>$level]).' --><h'.$level.' class="wp-block-heading">'.esc_html($text).'</h'.$level.'><!-- /wp:heading -->';}
foreach(get_posts(['post_type'=>'post','post_status'=>'any','posts_per_page'=>-1]) as $post){if($post->post_name==='hello-world'){wp_delete_post($post->ID,true);}}
$photo=mdr_seed_image($data['home']['photo'],0,'Espaço do escritório MDR Advocacia');
$photo_url=wp_get_attachment_url($photo);
$home='<!-- wp:group {"align":"full","className":"intro-block","anchor":"escritorio"} --><div class="wp-block-group alignfull intro-block" id="escritorio"><!-- wp:columns --><div class="wp-block-columns"><!-- wp:column {"width":"43%"} --><div class="wp-block-column" style="flex-basis:43%"><!-- wp:image '.wp_json_encode(['id'=>$photo,'sizeSlug'=>'full','linkDestination'=>'none','className'=>'intro-photo']).' --><figure class="wp-block-image size-full intro-photo"><img src="'.esc_url($photo_url).'" alt="Espaço do escritório MDR Advocacia" class="wp-image-'.$photo.'"/></figure><!-- /wp:image --></div><!-- /wp:column --><!-- wp:column {"width":"57%"} --><div class="wp-block-column" style="flex-basis:57%">'.mdr_p('MDR Advocacia','eyebrow').mdr_h('Um escritório moderno',1);
foreach($data['home']['presentation'] as $p){$home.=mdr_p($p);}
$home.='</div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->';
$home.='<!-- wp:group {"align":"full","className":"mvv"} --><div class="wp-block-group alignfull mvv">'.mdr_p('O que nos orienta','eyebrow').'<!-- wp:columns --><div class="wp-block-columns">';
foreach(['mission'=>'Missão','vision'=>'Visão','values'=>'Valores'] as $key=>$title){$home.='<!-- wp:column --><div class="wp-block-column">'.mdr_h($title).mdr_p($data['home'][$key]).'</div><!-- /wp:column -->';}
$home.='</div><!-- /wp:columns --></div><!-- /wp:group -->';
$home_id=mdr_seed_post('page','inicio','Início',$home);
$blog_id=mdr_seed_post('page','blog','Blog','');
update_option('show_on_front','page');update_option('page_on_front',$home_id);update_option('page_for_posts',$blog_id);
$privacy=mdr_h('Sobre este ambiente').mdr_p('Esta é uma prévia privada, destinada à avaliação do novo site da MDR Advocacia. O conteúdo institucional de referência continua disponível no site atual.').mdr_h('Navegação e edição').mdr_p('Esta versão não utiliza analytics, pixels publicitários ou feeds incorporados de redes sociais. O acesso editorial utiliza cookies necessários para autenticação e funcionamento do WordPress. A infraestrutura também produz registros técnicos de acesso para operação e segurança.').mdr_h('Contato de privacidade').mdr_p('Para esclarecimentos ou solicitações relativas a dados pessoais, entre em contato com dpo@mdradvocacia.com. Os avisos, políticas, fornecedores e prazos definitivos serão revisados pela DPO antes da publicação do novo site.');
mdr_seed_post('page','privacidade-da-previa','Privacidade desta prévia',$privacy);
$order=['Bruna Costa Ribeiro'=>0,'Marcos Delli Ribeiro'=>1,'Natália Ribeiro Linhares'=>2,'Rodrigo Cavalcanti'=>3,'Weuder Martins Câmara'=>4];
foreach($data['socios'] as $p){$id=mdr_seed_post('mdr_socio',sanitize_title($p['name']),$p['name'],mdr_p($p['bio']),['post_excerpt'=>$p['mini_bio'],'menu_order'=>$order[$p['name']]]);foreach(['role','instagram','linkedin'] as $key){update_post_meta($id,'mdr_'.$key,$p[$key]);}set_post_thumbnail($id,mdr_seed_image($p['photo'],$id,$p['name']));}
$priority=['award-gptw-2026'=>0,'award-panama'=>1,'award-fenalaw2025'=>2,'award-gptw'=>3];
foreach($data['awards'] as $i=>$p){$id=mdr_seed_post('mdr_premio',$p['id'],$p['title'],mdr_p($p['description']),['post_excerpt'=>$p['subtitle'],'menu_order'=>$priority[$p['id']]??($i+10)]);update_post_meta($id,'mdr_year',$p['year']?(string)$p['year']:'');update_post_meta($id,'mdr_subtitle',$p['subtitle']);set_post_thumbnail($id,mdr_seed_image($p['image'],$id,$p['title']));}
$demos=[
 ['slug'=>'seguranca-juridica-e-negocios','title'=>'Segurança jurídica como parte da estratégia de negócio','category'=>'Negócios','image'=>'negocios.svg','excerpt'=>'Um espaço para conectar os temas do Direito às decisões e aos desafios das empresas.'],
 ['slug'=>'esg-em-perspectiva','title'=>'ESG em perspectiva: compromissos que ganham espaço','category'=>'ESG','image'=>'esg.svg','excerpt'=>'Uma proposta de editoria para reunir reflexões sobre responsabilidade e governança.'],
 ['slug'=>'direito-e-transformacao','title'=>'Direito, pessoas e transformação: uma conversa contínua','category'=>'Institucional','image'=>'institucional.svg','excerpt'=>'Conhecimento que aproxima o escritório de quem acompanha sua atuação.']
];
foreach($demos as $i=>$p){$cat=term_exists($p['category'],'category');if(!$cat){$cat=wp_insert_term($p['category'],'category');}$content=mdr_p('Conteúdo demonstrativo — este artigo apresenta o modelo editorial da prévia. Não é uma publicação jurídica oficial da MDR.','demo-notice').mdr_p($p['excerpt']).mdr_h('Um espaço para compartilhar conhecimento').mdr_p('Aqui, a Comunicação poderá publicar textos completos, imagens e referências, organizados por categoria. Cada publicação terá autoria, data e endereço próprio para divulgação nas redes sociais.').mdr_h('Da elaboração à publicação').mdr_p('O conteúdo poderá ser salvo como rascunho e revisado antes de ser publicado. Este exemplo pode ser editado ou substituído durante a avaliação do laboratório.');$id=mdr_seed_post('post',$p['slug'],$p['title'],$content,['post_excerpt'=>$p['excerpt'],'post_author'=>get_user_by('login',$secrets['editor_user'])->ID,'post_category'=>[(int)$cat['term_id']],'post_date'=>wp_date('Y-m-d H:i:s',time()-$i*60)]);update_post_meta($id,'mdr_demo','1');update_post_meta($id,'mdr_demo_cover',$p['image']);}
update_option('mdr_seed_version','1.0.0');
flush_rewrite_rules(true);
echo json_encode(['status'=>'initialized','home'=>$home_id,'blog'=>$blog_id,'partners'=>wp_count_posts('mdr_socio')->publish,'awards'=>wp_count_posts('mdr_premio')->publish,'posts'=>wp_count_posts('post')->publish],JSON_PRETTY_PRINT);
