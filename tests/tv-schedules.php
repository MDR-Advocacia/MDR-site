<?php
$before=(int)$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts}");$checks=[];$fake_results=[];$calls=[];
function schedule_check($v,$label){if(!$v)throw new Exception($label);$GLOBALS['checks'][]=$label;}
function mdr_tv_schedule_test_queue($action,$value,$unit){$id=900000+count($GLOBALS['calls']);$GLOBALS['calls'][]=['action'=>$action,'unit'=>$unit,'id'=>$id];return $id;}
add_filter('get_post_metadata',function($check,$id,$key)use(&$fake_results){if($id>=900000&&$key==='mdr_tv_result')return [$fake_results[$id]??''];return $check;},10,3);
register_post_type('mdr_tv_schedule',['public'=>false]);$wpdb->query('START TRANSACTION');
try{
 wp_set_current_user(7);schedule_check(is_wp_error(mdr_tv_test_schedule_create('off',['capim'],time()+600)),'operator cannot schedule shutdown');
 wp_set_current_user(1);schedule_check(is_wp_error(mdr_tv_test_schedule_create('off',['invalid'],time()+600)),'unknown TV rejected');schedule_check(is_wp_error(mdr_tv_test_schedule_create('off',['capim'],time()-1)),'past date rejected');
 $at=time()+3600;$id=mdr_tv_test_schedule_create('off',['capim','capim70','manhattan'],$at);schedule_check(!is_wp_error($id),'admin may schedule three TVs');
 mdr_tv_test_schedule_tick($at-1);schedule_check(count($calls)===0,'future job sends no command');
 mdr_tv_test_schedule_tick($at);schedule_check(count($calls)===3,'due job dispatches once to three TVs');
 mdr_tv_test_schedule_tick($at+1);schedule_check(count($calls)===3,'pending job not duplicated');
 foreach($calls as $call)$fake_results[$call['id']]=['ok'=>true];mdr_tv_test_schedule_tick($at+60);$m=get_post_meta($id,'mdr_tv_schedule',true);schedule_check($m['status']==='done','off results reconciled');mdr_tv_test_schedule_tick($at+120);schedule_check(count($calls)===3,'completed one-off never repeats');
 $start=mdr_tv_test_schedule_create('start',['capim'],$at+200);mdr_tv_test_schedule_tick($at+200);$m=get_post_meta($start,'mdr_tv_schedule',true);$first=$m['commands']['capim'][0];$fake_results[$first]=['ok'=>false];mdr_tv_test_schedule_tick($at+260);$m=get_post_meta($start,'mdr_tv_schedule',true);schedule_check(count($m['commands']['capim'])===2,'start has at most one bounded retry');$retry=end($m['commands']['capim']);$fake_results[$retry]=['ok'=>true];mdr_tv_test_schedule_tick($at+320);$m=get_post_meta($start,'mdr_tv_schedule',true);schedule_check($m['status']==='capturing','confirmed playback requests capture');$capture=$m['captures']['capim'];$fake_results[$capture]=['ok'=>false];mdr_tv_test_schedule_tick($at+380);$m=get_post_meta($start,'mdr_tv_schedule',true);schedule_check($m['status']==='done_warning','capture error does not negate confirmed playback');
 $missed=mdr_tv_test_schedule_create('off',['capim'],$at+500);$n=count($calls);mdr_tv_test_schedule_tick($at+1101);schedule_check(get_post_meta($missed,'mdr_tv_schedule',true)['status']==='missed'&&count($calls)===$n,'late job not executed');
 $cancelled=mdr_tv_test_schedule_create('off',['capim'],$at+1500);$m=get_post_meta($cancelled,'mdr_tv_schedule',true);$m['status']='cancelled';update_post_meta($cancelled,'mdr_tv_schedule',$m);mdr_tv_test_schedule_tick($at+1500);schedule_check(count($calls)===$n,'cancelled job not executed');
 $revoked=mdr_tv_test_schedule_create('off',['capim'],$at+1600);wp_update_post(['ID'=>$revoked,'post_author'=>7]);mdr_tv_test_schedule_tick($at+1600);schedule_check(count($calls)===$n&&get_post_meta($revoked,'mdr_tv_schedule',true)['status']==='failed','permission rechecked at execution');
}finally{$wpdb->query('ROLLBACK');}
schedule_check((int)$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts}")===$before,'all fixtures rolled back');echo json_encode(['passed'=>count($checks),'checks'=>$checks,'physical_commands_sent'=>0]);
