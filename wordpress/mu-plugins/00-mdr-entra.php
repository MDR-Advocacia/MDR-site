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
// Bind the authorization round trip to this browser, and add nonce + PKCE.
// The upstream library remains responsible for JWT signature/issuer/audience.
add_action('init',function(){
    if(($GLOBALS['pagenow']??'')!=='wp-login.php'||(defined('WP_CLI')&&WP_CLI))return;
    if(empty($_COOKIE['mdr_oidc_browser'])){
        $value=bin2hex(random_bytes(32));
        setcookie('mdr_oidc_browser',$value,['expires'=>time()+3600,'path'=>'/','secure'=>true,'httponly'=>true,'samesite'=>'Lax']);
        $_COOKIE['mdr_oidc_browser']=$value;
    }
},1);
add_filter('openid-connect-generic-new-state-value',function($values){
    foreach($values as &$state){
        $state['mdr_nonce']=bin2hex(random_bytes(32));$state['mdr_verifier']=bin2hex(random_bytes(32));
        $state['mdr_browser']=hash('sha256',$_COOKIE['mdr_oidc_browser']??'');
    }
    return $values;
});
function mdr_entra_state($key=null){
    $key=$key??($_REQUEST['state']??'');
    if(!is_string($key)||!preg_match('/^[a-f0-9]{32}$/',$key))return null;
    $values=get_transient('openid-connect-generic-state--'.$key);$s=$values[$key]??null;
    if(!$s||empty($_COOKIE['mdr_oidc_browser'])||!hash_equals($s['mdr_browser']??'',hash('sha256',$_COOKIE['mdr_oidc_browser'])))return null;
    return $s;
}
add_filter('openid-connect-generic-auth-url',function($url){
    parse_str(wp_parse_url($url,PHP_URL_QUERY),$q);$s=mdr_entra_state($q['state']??'');
    if(!$s)return $url;
    $challenge=rtrim(strtr(base64_encode(hash('sha256',$s['mdr_verifier'],true)),'+/','-_'),'=');
    return add_query_arg(['nonce'=>$s['mdr_nonce'],'code_challenge'=>$challenge,'code_challenge_method'=>'S256'],$url);
});
add_filter('openid-connect-generic-alter-request',function($request,$operation){
    if($operation==='get-authentication-token'){
        $s=mdr_entra_state();if(!$s)wp_die('Sessão de entrada inválida ou expirada. Inicie novamente.','Acesso não autorizado',['response'=>403]);
        $request['body']['code_verifier']=$s['mdr_verifier'];
    }
    return $request;
},10,2);
// Runs only after the upstream library verifies signature, issuer, audience,
// expiration and nonce. Bind stable tenant/object IDs, never an email or role claim.
add_filter('openid-connect-generic-user-login-test', function ($allowed,$claim) {
    $e=mdr_private_config()['entra']??[];
    if (!$allowed || !is_array($claim) || ($claim['tid']??'')!==($e['tenant']??null)) { return false; }
    $oid=$claim['oid']??''; $id=absint($e['users'][$oid]??0); $user=get_user_by('id',$id);
    $sub=$claim['sub']??'';
    if (!$id || !$user || !is_string($sub) || !$sub || strlen($sub)>255) { return false; }
    $state=mdr_entra_state();
    if(!$state||!is_string($claim['nonce']??null)||!hash_equals($state['mdr_nonce'],$claim['nonce']))return false;
    $flow=sanitize_key($_REQUEST['state']??'');
    if(!add_option('mdr_sso_used_'.$flow,time(),'','no'))return false;
    global $wpdb;$like=$wpdb->esc_like('mdr_sso_used_').'%';
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s AND CAST(option_value AS UNSIGNED)<%d",$like,time()-600));
    $GLOBALS['mdr_sso_login']=true;
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
    delete_transient('openid-connect-generic-state--'.sanitize_key($_REQUEST['state']??''));
    wp_safe_redirect(user_can($user,'mdr_tv_start')&&!user_can($user,'edit_posts')?admin_url('admin.php?page=mdr-tv'):admin_url());exit;
});
add_filter('auth_cookie_expiration',function($seconds){return !empty($GLOBALS['mdr_sso_login'])?HOUR_IN_SECONDS:$seconds;});
