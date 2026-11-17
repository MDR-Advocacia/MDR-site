<?php
$checks=[];function panel_check($value,$label){if(!$value)throw new Exception($label);$GLOBALS['checks'][]=$label;}
$count_before=wp_count_posts('mdr_tv_command');
wp_set_current_user(7);$snapshot=mdr_tv_panel_snapshot();panel_check($snapshot['review']===true,'review fails closed');panel_check(count($snapshot['units'])===3,'Jailma sees three authorized TVs');panel_check(mdr_tv_panel_image_allowed('capim70'),'operator may read assigned capture');
foreach($snapshot['units'] as $tv)if($tv['image']['url'])panel_check(strpos($tv['image']['url'],'&amp;')===false,'JSON image URL has raw query separators '.$tv['id']);
foreach(['start','capture'] as $a){$r=mdr_tv_panel_queue('capim',$a);panel_check(is_wp_error($r)&&$r->get_error_code()==='panel_review','review blocks '.$a);}
foreach(['volume','off','status','start_dynamic'] as $a)panel_check(is_wp_error(mdr_tv_panel_queue('capim',$a)),'operator cannot '.$a);
wp_set_current_user(25);$snapshot=mdr_tv_panel_snapshot();panel_check(count($snapshot['units'])===2,'another operator sees own two TVs');panel_check(!mdr_tv_panel_image_allowed('capim70'),'unassigned capture denied');panel_check(is_wp_error(mdr_tv_panel_queue('capim70','start')),'unassigned TV command denied');
wp_set_current_user(0);panel_check(!mdr_tv_panel_image_allowed('capim'),'anonymous image denied');panel_check(count(mdr_tv_panel_snapshot()['units'])===0,'anonymous sees no TVs');
wp_set_current_user(7);$now=time();$fixture=(object)['ID'=>999001,'post_date_gmt'=>gmdate('Y-m-d H:i:s',$now-4),'post_status'=>'draft','post_title'=>'start','post_content'=>'{"unit":"capim"}'];$fixture_result='';
add_filter('get_post_metadata',function($check,$id,$key)use(&$fixture_result){if($id===999001&&$key==='mdr_tv_result')return [$fixture_result];return $check;},10,3);
$state=['at'=>gmdate('c',$now),'player_seen'=>$now,'player'=>'playing #1 t=3/22 paused=false ended=false ready=4 frames=0'];
$r=mdr_tv_panel_unit('capim',$state,[$fixture],$now);panel_check($r['status']['state']==='starting','pending request overrides previous player signal');
$fixture_result=['ok'=>true,'message'=>'URL enviada; sinal do player ainda não confirmado.'];$r=mdr_tv_panel_command($fixture,$state,$now);panel_check($r['state']==='unconfirmed','legacy URL accepted is not playback confirmation');
$fixture_result=['ok'=>true,'message'=>'Player confirmou reprodução nesta abertura. Confira a imagem.'];$r=mdr_tv_panel_command($fixture,$state,$now);panel_check($r['state']==='success','explicit playback acknowledgement is success');
$r=mdr_tv_panel_unit('capim',$state,[],$now);panel_check($r['status']['state']==='playing','fresh ready media is detected');
$state['player']='playing #1 t=0/0 paused=false ready=0 frames=0';$r=mdr_tv_panel_unit('capim',$state,[],$now);panel_check($r['status']['state']!=='playing','unready media not shown as playing');
$state['player']='playing #1 t=2/22 paused=false ready=4';$state['player_seen']=$now-70;$r=mdr_tv_panel_unit('capim',$state,[],$now);panel_check($r['status']['state']!=='playing','stale player not green');
$state['at']=gmdate('c',$now-150);$r=mdr_tv_panel_unit('capim',$state,[],$now);panel_check($r['status']['state']==='service_offline','service silence distinct from TV off');
$fixture_result=['ok'=>false,'message'=>'Falha: ValueError · TV sem resposta após tentativa de Wake-on-LAN'];$r=mdr_tv_panel_command($fixture,$state,$now);panel_check($r['code']==='tv_unreachable'&&strpos($r['message'],'chamado')!==false,'plain language error with support instruction');
$fixture->post_title='capture';$r=mdr_tv_panel_command($fixture,$state,$now);panel_check($r['code']==='capture_failed'&&strpos($r['message'],'captura anterior')!==false,'capture failure preserves previous image without claiming playback failed');$fixture->post_title='start';
$fixture_result='';$fixture->post_date_gmt=gmdate('Y-m-d H:i:s',$now-200);$r=mdr_tv_panel_command($fixture,$state,$now);panel_check($r['state']==='error','expired command not indefinitely pending');
// A process-local fixture proves repeated requests reuse the pending command.
// Any unexpected insert is rejected before touching the database.
$fixture->post_date_gmt=gmdate('Y-m-d H:i:s',$now-5);
add_filter('pre_option_mdr_tv_panel_review',function(){return 0;});
add_filter('posts_pre_query',function($posts,$query)use($fixture){return $query->get('post_type')==='mdr_tv_command'?[$fixture]:$posts;},10,2);
add_filter('wp_insert_post_empty_content',function($empty,$data){return ($data['post_type']??'')==='mdr_tv_command'?true:$empty;},10,2);
$r=mdr_tv_queue('start',null,'capim');panel_check($r===999001,'duplicate start reuses pending request');
$fixture->post_title='capture';$r=mdr_tv_queue('capture',null,'capim');panel_check($r===999001,'operator capture allowed without technical controls');
$r=mdr_tv_queue('off',null,'capim');panel_check(is_wp_error($r)&&$r->get_error_code()==='permission','technical control still forbidden');
panel_check(wp_count_posts('mdr_tv_command')==$count_before,'no command posts created by tests');
echo json_encode(['passed'=>count($checks),'checks'=>$checks,'command_posts_unchanged'=>true]);
