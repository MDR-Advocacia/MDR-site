<?php
if (!defined('ABSPATH')) { exit; }
// Apache BasicAuth protects the whole preview. Its service credential is not a
// WordPress Application Password; bridge requests authenticate separately by HMAC.
add_filter('application_password_is_api_request',function($is_api){
    return strpos($_SERVER['REQUEST_URI']??'','/mdr-tv/v1/bridge/')!==false?false:$is_api;
});
function mdr_tv_bridge_auth($r){
    $key=mdr_private_config()['bridge_key']??'';$stamp=$r->get_header('x-mdr-time');$nonce=$r->get_header('x-mdr-nonce');$sig=$r->get_header('x-mdr-signature');
    if(strlen($key)<32||!ctype_digit((string)$stamp)||abs(time()-(int)$stamp)>180||!preg_match('/^[a-f0-9]{32}$/',(string)$nonce))return new WP_Error('denied','Não autorizado.',['status'=>401]);
    $message=$r->get_method()."\n".$r->get_route()."\n".$stamp."\n".$nonce."\n".hash('sha256',$r->get_body());
    if(!hash_equals(hash_hmac('sha256',$message,$key),(string)$sig))return new WP_Error('denied','Não autorizado.',['status'=>401]);
    if(!add_option('mdr_tv_nonce_'.$nonce,time(),'','no'))return new WP_Error('replay','Solicitação repetida.',['status'=>401]);
    global $wpdb;$like=$wpdb->esc_like('mdr_tv_nonce_').'%';
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s AND CAST(option_value AS UNSIGNED)<%d",$like,time()-240));
    return true;
}
add_action('rest_api_init',function(){
    register_rest_route('mdr-tv/v1','/bridge/sync',['methods'=>'POST','permission_callback'=>'mdr_tv_bridge_auth','callback'=>function($r){
        $d=$r->get_json_params();if(!is_array($d)||strlen($r->get_body())>100000)return new WP_Error('body','Corpo inválido.',['status'=>400]);
        $state=get_option('mdr_tv_bridge_state',[]);$state['at']=gmdate('c');
        foreach(['power','app','received_version','player','error'] as $k)if(isset($d[$k])&&is_scalar($d[$k]))$state[$k]=substr(sanitize_text_field((string)$d[$k]),0,150);
        foreach(array_slice((array)($d['results']??[]),0,10) as $result){
            $id=absint($result['id']??0);$p=get_post($id);
            if(!$p||$p->post_type!=='mdr_tv_command'||$p->post_status!=='draft'||get_post_meta($id,'mdr_tv_result',true))continue;
            update_post_meta($id,'mdr_tv_result',['ok'=>!empty($result['ok']),'message'=>substr(sanitize_text_field($result['message']??''),0,240),'at'=>gmdate('c')]);
            mdr_tv_audit(!empty($result['ok'])?'command_received':'command_failed',$id);
        }
        update_option('mdr_tv_bridge_state',$state,false);
        $commands=[];foreach(get_posts(['post_type'=>'mdr_tv_command','post_status'=>'private','numberposts'=>5,'orderby'=>'ID','order'=>'ASC']) as $p){
            if(strtotime($p->post_date_gmt.' UTC')<time()-120){update_post_meta($p->ID,'mdr_tv_result',['ok'=>false,'message'=>'Expirou sem execução.','at'=>gmdate('c')]);wp_update_post(['ID'=>$p->ID,'post_status'=>'draft']);continue;}
            wp_update_post(['ID'=>$p->ID,'post_status'=>'draft']);$v=json_decode($p->post_content,true);
            $commands[]=['id'=>$p->ID,'action'=>$p->post_title,'value'=>$v['value']??null];
        }
        return ['manifest'=>mdr_tv_manifest(),'commands'=>$commands];
    }]);
    register_rest_route('mdr-tv/v1','/bridge/media/(?P<id>\d+)',['methods'=>'GET','permission_callback'=>'mdr_tv_bridge_auth','callback'=>function($r){
        $id=absint($r['id']);$a=mdr_tv_asset_info($id);$p=mdr_tv_asset_path($id);
        if(!$a||!is_readable($p))return new WP_Error('missing','Arquivo indisponível.',['status'=>404]);
        nocache_headers();header('Content-Type:'.$a['mime']);header('Content-Length:'.filesize($p));header('X-Content-Type-Options:nosniff');readfile($p);exit;
    }]);
    register_rest_route('mdr-tv/v1','/bridge/capture',['methods'=>'POST','permission_callback'=>'mdr_tv_bridge_auth','callback'=>function($r){
        $b=$r->get_body();if(strlen($b)>4*1024*1024||!str_starts_with($b,"\xff\xd8")||!@getimagesizefromstring($b))return new WP_Error('image','Captura inválida.',['status'=>400]);
        $p='/var/lib/mdr-tv/capture.jpg';$tmp=$p.'.tmp';file_put_contents($tmp,$b,LOCK_EX);chmod($tmp,0600);rename($tmp,$p);
        $s=get_option('mdr_tv_bridge_state',[]);$s['capture_at']=gmdate('c');update_option('mdr_tv_bridge_state',$s,false);return ['stored'=>true];
    }]);
});
