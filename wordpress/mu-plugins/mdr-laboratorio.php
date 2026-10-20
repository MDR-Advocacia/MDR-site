<?php
/** Plugin Name: MDR — Controles do laboratório */
if (!defined('ABSPATH')) { exit; }
// The preview proxy has its own HTTP Basic credentials. They are not WordPress
// application passwords; the editorial panel authenticates with secure cookies.
add_filter('wp_is_application_passwords_available', '__return_false');
add_filter('xmlrpc_enabled', '__return_false');
add_filter('comments_open', '__return_false', 99);
add_filter('pings_open', '__return_false', 99);
add_filter('pre_wp_mail', function () { return false; });
add_filter('wp_robots', function ($robots) { $robots['noindex']=true; $robots['nofollow']=true; $robots['noarchive']=true; return $robots; });
add_action('init', function () {
    remove_action('wp_head','print_emoji_detection_script',7);
    remove_action('wp_print_styles','print_emoji_styles');
    remove_action('wp_head','wp_generator');
    remove_action('wp_head','wp_oembed_add_discovery_links');
    remove_action('wp_head','wp_oembed_add_host_js');
    remove_action('wp_head','wp_resource_hints',2);
});
add_action('send_headers', function () {
    header('X-Robots-Tag: noindex, nofollow, noarchive');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header('X-Frame-Options: SAMEORIGIN');
    if (!is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php') {
        header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:; media-src 'self'; connect-src 'self'; frame-src 'self'; frame-ancestors 'self'; form-action 'self'; base-uri 'self'; object-src 'none'");
    }
});
function mdr_audit_event($event, $object=0, $actor=null) {
    if (defined('WP_CLI') && WP_CLI) { return; }
    $events=get_option('mdr_lab_events',[]);
    $events[]=['utc'=>gmdate('c'),'event'=>$event,'object'=>(int)$object,'actor'=>$actor===null?get_current_user_id():(int)$actor];
    update_option('mdr_lab_events',array_slice($events,-200),false);
}
add_action('wp_login',function($login,$user){mdr_audit_event('login',0,$user->ID);},10,2);
add_action('save_post',function($id,$post,$update){if(!wp_is_post_revision($id)&&!wp_is_post_autosave($id)){mdr_audit_event($update?'edit':'create',$id);}},20,3);
add_action('deleted_post',function($id){mdr_audit_event('delete',$id);});
add_action('admin_menu',function(){
    add_management_page('Registro do laboratório','Registro do laboratório','manage_options','mdr-registro',function(){
        if(!current_user_can('manage_options')){return;}
        echo '<div class="wrap"><h1>Registro do laboratório</h1><p>Últimos 200 eventos de edição e acesso. Identificadores técnicos; não armazena senhas, conteúdo ou IP. Revisões de texto ficam em cada publicação. A política definitiva de retenção será definida para produção.</p><table class="widefat"><thead><tr><th>UTC</th><th>Evento</th><th>ID conteúdo</th><th>ID usuário</th></tr></thead><tbody>';
        foreach(array_reverse(get_option('mdr_lab_events',[])) as $e){echo '<tr><td>'.esc_html($e['utc']).'</td><td>'.esc_html($e['event']).'</td><td>'.esc_html($e['object']).'</td><td>'.esc_html($e['actor']).'</td></tr>';}
        echo '</tbody></table></div>';
    });
    add_options_page('Dados institucionais','Dados institucionais','manage_options','mdr-institucional',function(){
        if(!current_user_can('manage_options')){return;}
        echo '<div class="wrap"><h1>Dados institucionais</h1><p>Informações exibidas no contato e rodapé. Confirmar alterações de privacidade com a DPO antes de publicar.</p><form method="post" action="options.php">';
        settings_fields('mdr_institucional');
        echo '<table class="form-table">';
        foreach(mdr_institutional_fields() as $key=>$label){echo '<tr><th><label for="mdr_'.esc_attr($key).'">'.esc_html($label).'</label></th><td><input class="regular-text" id="mdr_'.esc_attr($key).'" name="mdr_'.esc_attr($key).'" value="'.esc_attr(get_option('mdr_'.$key)).'"></td></tr>';}
        echo '</table>';submit_button();echo '</form></div>';
    });
});
function mdr_institutional_fields(){return ['oab'=>'Registro OAB','cnpj'=>'CNPJ','matrix'=>'Endereço da matriz','postal_code'=>'CEP','branch'=>'Endereço da filial','phone'=>'Telefone','whatsapp'=>'WhatsApp','email'=>'E-mail de contato','hours'=>'Horário de atendimento','maps'=>'Link Google Maps','dpo_name'=>'Encarregada','dpo_substitute'=>'Substituto','dpo_email'=>'E-mail DPO','social_linkedin'=>'LinkedIn institucional','social_instagram'=>'Instagram institucional','social_facebook'=>'Facebook institucional'];}
add_action('admin_init',function(){foreach(mdr_institutional_fields() as $key=>$label){$sanitize=(str_starts_with($key,'social_')||$key==='maps')?'esc_url_raw':(str_contains($key,'email')?'sanitize_email':'sanitize_text_field');register_setting('mdr_institucional','mdr_'.$key,['type'=>'string','sanitize_callback'=>$sanitize]);}});
add_action('admin_notices',function(){if(current_user_can('edit_posts')){echo '<div class="notice notice-info"><p><strong>Laboratório privado MDR.</strong> E-mails externos e comentários estão desativados. Artigos de exemplo são demonstrativos. Os documentos institucionais seguem no site atual.</p></div>';}});
add_action('pre_get_posts',function($q){if(!is_admin()&&$q->is_main_query()&&$q->is_post_type_archive('mdr_premio')){$q->set('posts_per_page',12);$q->set('orderby','menu_order');$q->set('order','ASC');}});
