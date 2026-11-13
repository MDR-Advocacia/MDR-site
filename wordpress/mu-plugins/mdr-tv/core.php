<?php
if (!defined('ABSPATH')) { exit; }
function mdr_tv_root() { return '/var/lib/mdr-tv/media'; }
function mdr_tv_audit($event,$object=0) {
    wp_insert_post(['post_type'=>'mdr_tv_event','post_status'=>'private','post_title'=>sanitize_key($event),
        'post_author'=>get_current_user_id(),'post_content'=>wp_json_encode(['at'=>gmdate('c'),'object'=>absint($object)])]);
}
function mdr_tv_install_roles() {
    $caps=['mdr_tv_start','mdr_tv_manage','mdr_tv_control','edit_mdr_tv_items','edit_others_mdr_tv_items','publish_mdr_tv_items',
        'read_private_mdr_tv_items','delete_mdr_tv_items','delete_private_mdr_tv_items','delete_published_mdr_tv_items',
        'delete_others_mdr_tv_items','edit_private_mdr_tv_items','edit_published_mdr_tv_items'];
    foreach (['administrator','editor'] as $role) { $r=get_role($role);if ($r) foreach ($caps as $cap) $r->add_cap($cap); }
    if (!get_role('mdr_tv_operator')) { add_role('mdr_tv_operator','Recepção — iniciar TV',['read'=>true,'mdr_tv_start'=>true]); }
    update_option('mdr_tv_schema','0.1.0',false);
}
function mdr_tv_register() {
    if (get_option('mdr_tv_schema')!=='0.1.0') { mdr_tv_install_roles(); }
    register_post_type('mdr_tv_item',[
        'labels'=>['name'=>'Conteúdos da TV','singular_name'=>'Conteúdo da TV','add_new_item'=>'Adicionar conteúdo da TV'],
        'public'=>false,'publicly_queryable'=>false,'exclude_from_search'=>true,'show_in_rest'=>false,
        'show_ui'=>true,'show_in_menu'=>'mdr-tv','rewrite'=>false,'query_var'=>false,
        'supports'=>['title','editor','revisions'],'capability_type'=>['mdr_tv_item','mdr_tv_items'],'map_meta_cap'=>true,
    ]);
    register_post_type('mdr_tv_command',['public'=>false,'publicly_queryable'=>false,'show_ui'=>false,'show_in_rest'=>false,'rewrite'=>false,'query_var'=>false]);
    register_post_type('mdr_tv_event',['public'=>false,'publicly_queryable'=>false,'show_ui'=>false,'show_in_rest'=>false,'rewrite'=>false,'query_var'=>false]);
    register_post_type('mdr_tv_asset',['public'=>false,'publicly_queryable'=>false,'show_ui'=>false,'show_in_rest'=>false,'rewrite'=>false,'query_var'=>false]);
}
add_action('init','mdr_tv_register');
function mdr_tv_assets() { return get_posts(['post_type'=>'mdr_tv_asset','post_status'=>'private','numberposts'=>200,'orderby'=>'ID','order'=>'DESC']); }
function mdr_tv_settings() { return array_merge(['music'=>0,'volume'=>14,'seconds'=>18],(array)get_option('mdr_tv_settings',[])); }
function mdr_tv_asset_info($id) {
    $a=get_post($id);
    if (!$a || $a->post_type!=='mdr_tv_asset' || $a->post_status!=='private') { return null; }
    $hash=get_post_meta($id,'mdr_tv_hash',true);$mime=get_post_meta($id,'mdr_tv_mime',true);
    if (!preg_match('/^[a-f0-9]{64}$/',$hash)) { return null; }
    return ['id'=>$id,'hash'=>$hash,'mime'=>$mime,'bytes'=>(int)get_post_meta($id,'mdr_tv_bytes',true),'name'=>$a->post_title];
}
function mdr_tv_asset_path($id) {
    $a=mdr_tv_asset_info($id);return $a?mdr_tv_root().'/'.$a['hash']:null;
}
function mdr_tv_manifest($now=null) {
    $now=$now??time();$rows=[];
    foreach(get_posts(['post_type'=>'mdr_tv_item','post_status'=>'publish','numberposts'=>200]) as $p) {
        $m=(array)get_post_meta($p->ID,'mdr_tv',true);
        if (!empty($m['hidden']) || (!empty($m['start'])&&$m['start']>$now) || (!empty($m['end'])&&$m['end']<=$now)) continue;
        $assets=[];foreach((array)($m['assets']??[]) as $id) { $a=mdr_tv_asset_info(absint($id));if($a)$assets[]=$a; }
        $rows[]=['id'=>$p->ID,'title'=>$p->post_title,'text'=>html_entity_decode(wp_strip_all_tags($p->post_content),ENT_QUOTES,'UTF-8'),
            'format'=>$m['format']??'post','assets'=>$assets,'seconds'=>max(8,min(90,(int)($m['seconds']??18))),
            'pinned'=>!empty($m['pinned']),'priority'=>(int)($m['priority']??0),'published_at'=>$p->post_date_gmt,
            'end'=>(int)($m['end']??0),'audio'=>!empty($m['audio']),'video'=>!empty($m['video']),
            'source'=>$m['source']??'Material MDR','credit'=>$m['credit']??'MDR Advocacia'];
    }
    usort($rows,function($a,$b){ return ($b['pinned']<=>$a['pinned'])?:($b['priority']<=>$a['priority'])?:strcmp($b['published_at'],$a['published_at'])?:($b['id']<=>$a['id']); });
    $settings=mdr_tv_settings();$playlist=[];foreach((array)($settings['playlist']??[]) as $id){$a=mdr_tv_asset_info(absint($id));if($a&&str_starts_with($a['mime'],'audio/'))$playlist[]=$a;}
    $data=['items'=>$rows,'settings'=>$settings,'playlist'=>$playlist];
    return ['version'=>hash('sha256',wp_json_encode($data)),'generated_at'=>gmdate('c'),'valid_until'=>$now+600]+$data;
}
function mdr_tv_parse_fields($input) {
    if(!is_array($input))return new WP_Error('fields','Campos inválidos.');
    foreach($input as $value)if(!is_scalar($value))return new WP_Error('fields','Campo inválido.');
    $formats=['post','photo','carousel','story','video','campaign'];
    $format=sanitize_key($input['format']??'post');if(!in_array($format,$formats,true))return new WP_Error('format','Formato inválido.');
    $assets=[];
    foreach(array_slice(explode(',',(string)($input['assets']??'')),0,12) as $id){$id=absint($id);if($id&&!mdr_tv_asset_info($id))return new WP_Error('asset','Arquivo inválido.');if($id)$assets[]=$id;}
    $dates=[];foreach(['start','end'] as $key){$v=trim((string)($input[$key]??''));$dates[$key]=0;if($v){try{$d=new DateTimeImmutable($v,new DateTimeZone('America/Fortaleza'));$dates[$key]=$d->getTimestamp();}catch(Exception $e){return new WP_Error('date','Data inválida.');}}}
    if($dates['start']&&$dates['end']&&$dates['end']<=$dates['start'])return new WP_Error('date_order','O término deve ser posterior ao início.');
    return $dates+['format'=>$format,'assets'=>array_values(array_unique($assets)),'seconds'=>max(8,min(90,absint($input['seconds']??18))),
        'priority'=>max(0,min(100,absint($input['priority']??0))),'pinned'=>!empty($input['pinned']),'hidden'=>!empty($input['hidden']),
        'video'=>!empty($input['video']),'audio'=>!empty($input['audio']),
        'source'=>sanitize_text_field($input['source']??'Material MDR'),'credit'=>sanitize_text_field($input['credit']??'MDR Advocacia')];
}
function mdr_tv_queue($action,$value=null) {
    $allowed=['start','start_dynamic','volume','mute','capture','status','off'];
    if(!in_array($action,$allowed,true))return new WP_Error('action','Comando inválido.');
    if(!current_user_can('mdr_tv_start') || ($action!=='start'&&!current_user_can('mdr_tv_control')))return new WP_Error('permission','Sem permissão.');
    if($action==='volume'&&(!is_numeric($value)||$value<0||$value>50))return new WP_Error('volume','Volume permitido:0a50.');
    global $wpdb;
    $active=(int)$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='mdr_tv_command' AND post_status='private' AND post_date_gmt>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 2 MINUTE)");
    if($active>=5)return new WP_Error('busy','Há comandos recentes na fila; aguarde a confirmação.');
    $id=wp_insert_post(['post_type'=>'mdr_tv_command','post_status'=>'private','post_title'=>$action,'post_content'=>wp_json_encode(['value'=>$value]),'post_author'=>get_current_user_id()],true);
    if(!is_wp_error($id))mdr_tv_audit('command_'.$action,$id);return $id;
}
