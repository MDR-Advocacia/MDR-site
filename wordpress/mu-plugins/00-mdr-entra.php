<?php
/** Plugin Name: MDR — Identidade Entra restrita */
if (!defined('ABSPATH')) { exit; }
function mdr_private_config() {
    static $config;
    if ($config === null) {
        $path = defined('MDR_TV_CONFIG_PATH') ? MDR_TV_CONFIG_PATH : '/var/lib/mdr-tv/integration.json';
        $config = is_readable($path) ? json_decode(file_get_contents($path), true) : [];
        if (!is_array($config)) { $config = []; }
    }
    return $config;
}
add_filter('openid-connect-generic-settings', function ($s) {
    $c = mdr_private_config();
    if (empty($c['entra']['client_id']) || empty($c['entra']['client_secret'])) { return $s; }
    $e=$c['entra']; $base='https://login.microsoftonline.com/'.$e['tenant'];
    foreach ([
        'client_id'=>$e['client_id'], 'client_secret'=>$e['client_secret'],
        'scope'=>'openid profile email', 'login_type'=>'button', 'login_button_text'=>'Entrar com Microsoft 365',
        'endpoint_login'=>$base.'/oauth2/v2.0/authorize', 'endpoint_token'=>$base.'/oauth2/v2.0/token',
        'endpoint_jwks'=>$base.'/discovery/v2.0/keys', 'issuer'=>$base.'/v2.0', 'endpoint_userinfo'=>'',
        'endpoint_end_session'=>'', 'create_if_does_not_exist'=>0, 'link_existing_users'=>0,
        'token_refresh_enable'=>0, 'enable_logging'=>0, 'redirect_user_back'=>1,
        'redirect_on_logout'=>0, 'enforce_privacy'=>0, 'no_sslverify'=>0, 'state_time_limit'=>300,
    ] as $key=>$value) { $s->$key=$value; }
    return $s;
});
// Runs only after the upstream library verifies signature, issuer, audience,
// expiration and nonce. Bind stable tenant/object IDs, never an email or role claim.
add_filter('openid-connect-generic-user-login-test', function ($allowed,$claim) {
    $e=mdr_private_config()['entra']??[];
    if (!$allowed || !is_array($claim) || ($claim['tid']??'')!==($e['tenant']??null)) { return false; }
    $oid=$claim['oid']??''; $id=absint($e['users'][$oid]??0); $user=get_user_by('id',$id);
    $sub=$claim['sub']??'';
    if (!$id || !$user || !is_string($sub) || !$sub || strlen($sub)>255) { return false; }
    $matches=get_users(['meta_key'=>'openid-connect-generic-subject-identity','meta_value'=>$sub,'fields'=>'ID']);
    if (array_diff(array_map('intval',$matches),[$id])) { return false; }
    update_user_option($id,'openid-connect-generic-subject-identity',$sub,true);
    update_user_meta($id,'mdr_entra_oid',$oid);
    return true;
},10,2);
add_filter('openid-connect-generic-user-creation-test','__return_false');
add_filter('login_redirect',function ($to,$requested,$user) {
    if ($user instanceof WP_User && user_can($user,'mdr_tv_start') && !user_can($user,'edit_posts')) {
        return admin_url('admin.php?page=mdr-tv');
    }
    return $to;
},10,3);
add_action('openid-connect-generic-user-logged-in',function ($user) {
    if (function_exists('mdr_tv_audit')) { mdr_tv_audit('entra_login',$user->ID); }
    if(user_can($user,'mdr_tv_start')&&!user_can($user,'edit_posts')){wp_safe_redirect(admin_url('admin.php?page=mdr-tv'));exit;}
});
