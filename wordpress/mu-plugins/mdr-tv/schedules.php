<?php
if(!defined('ABSPATH'))exit;
add_action('init',function(){register_post_type('mdr_tv_schedule',['public'=>false,'publicly_queryable'=>false,'show_ui'=>false,'show_in_rest'=>false,'rewrite'=>false,'query_var'=>false]);});
function mdr_tv_schedule_create($action,$units,$at){
    if(!current_user_can('mdr_tv_control'))return new WP_Error('permission','Sem permissão para agendar.');
    if(!in_array($action,['start','off'],true)||!is_array($units)||!$units)return new WP_Error('fields','Escolha ação e TVs.');
    $units=array_values(array_unique(array_map('sanitize_key',$units)));foreach($units as $unit)if(!mdr_tv_unit_allowed($unit))return new WP_Error('permission','TV não autorizada.');
    if($at<time()+10||$at>time()+90*DAY_IN_SECONDS)return new WP_Error('date','Escolha um horário futuro, em até90dias.');
    $data=['action'=>$action,'units'=>$units,'at'=>(int)$at,'status'=>'scheduled','commands'=>[],'captures'=>[],'created_at'=>time()];
    $id=wp_insert_post(['post_type'=>'mdr_tv_schedule','post_status'=>'private','post_author'=>get_current_user_id(),'post_title'=>($action==='off'?'Desligar':'Ligar e iniciar campanha').' · '.mdr_tv_panel_date($at)],true);
    if(!is_wp_error($id)){update_post_meta($id,'mdr_tv_schedule',$data);mdr_tv_audit('schedule_created',$id);}return $id;
}
function mdr_tv_schedule_label($status){return ['scheduled'=>'Agendado','queued'=>'Comandos enviados','capturing'=>'Exibição confirmada · atualizando imagens','done'=>'Concluído','done_warning'=>'Exibição confirmada · imagem com aviso','partial'=>'Conclusão parcial · conferir TVs','failed'=>'Falha · conferir resultado','missed'=>'Horário perdido · não executado','cancelled'=>'Cancelado'][$status]??'Sem confirmação';}
function mdr_tv_schedule_posts(){return get_posts(['post_type'=>'mdr_tv_schedule','post_status'=>'private','numberposts'=>100,'orderby'=>'ID','order'=>'DESC']);}
function mdr_tv_schedule_public(){
    $rows=[];foreach(mdr_tv_schedule_posts() as $post){$m=get_post_meta($post->ID,'mdr_tv_schedule',true);if(!is_array($m))continue;$units=array_values(array_filter($m['units'],function($u){return mdr_tv_unit_allowed($u);}));if(!$units)continue;if($m['at']<time()-2*DAY_IN_SECONDS)continue;
        $rows[]=['id'=>$post->ID,'action'=>$m['action'],'at'=>$m['at'],'when'=>mdr_tv_panel_date($m['at']),'units'=>$units,'status'=>$m['status'],'label'=>mdr_tv_schedule_label($m['status']),'note'=>$m['note']??''];
    }return ['worker_at'=>(int)get_option('mdr_tv_scheduler_heartbeat',0),'worker_when'=>mdr_tv_panel_date((int)get_option('mdr_tv_scheduler_heartbeat',0)),'jobs'=>$rows];
}
function mdr_tv_schedule_reconcile($m,$now){
    $pending=false;$failed=false;
    foreach($m['commands'] as $unit=>$ids){$id=end($ids);$r=get_post_meta($id,'mdr_tv_result',true);if(!$r){$pending=true;continue;}if(empty($r['ok'])){
            if($m['action']==='start'&&count($ids)<2&&$now-$m['at']<600){$retry=mdr_tv_queue('start',null,$unit);if(!is_wp_error($retry)){$m['commands'][$unit][]=$retry;$pending=true;continue;}}
            $failed=true;
        }}
    if($pending&&$now-($m['queued_at']??$now)<360)return $m;
    if($pending||$failed||!empty($m['errors'])){$m['status']='partial';$m['note']='Uma ou mais TVs não confirmaram. Confira o painel e, se necessário, abra um chamado.';return $m;}
    if($m['action']==='off'){$m['status']='done';$m['note']='O serviço confirmou os comandos de desligamento.';return $m;}
    if(!isset($m['capture_queued_at'])){foreach($m['units'] as $unit){$id=mdr_tv_queue('capture',null,$unit);if(is_wp_error($id))$m['capture_errors'][$unit]=$id->get_error_code();else$m['captures'][$unit]=$id;}$m['status']='capturing';$m['capture_queued_at']=$now;return $m;}
    $capture_pending=false;$capture_error=!empty($m['capture_errors']);foreach($m['captures'] as $id){$r=get_post_meta($id,'mdr_tv_result',true);if(!$r)$capture_pending=true;elseif(empty($r['ok']))$capture_error=true;}
    if($capture_pending&&$now-($m['capture_queued_at']??$now)<180)return $m;
    $m['status']=$capture_pending||$capture_error?'done_warning':'done';$m['note']=$m['status']==='done'?'Reprodução e novas capturas confirmadas.':'Reprodução confirmada; uma imagem não foi atualizada.';return $m;
}
function mdr_tv_schedule_tick($now=null){
    global $wpdb;$now=$now??time();if((int)$wpdb->get_var("SELECT GET_LOCK('mdr_tv_schedule_tick',0)")!==1)return ['busy'=>true];$previous=get_current_user_id();$changed=[];
    try{update_option('mdr_tv_scheduler_heartbeat',time(),false);
        foreach(mdr_tv_schedule_posts() as $post){$m=get_post_meta($post->ID,'mdr_tv_schedule',true);if(!is_array($m)||!in_array($m['status'],['scheduled','queued','capturing'],true))continue;
            if($m['status']==='scheduled'&&$m['at']>$now)continue;
            wp_set_current_user($post->post_author);
            if(!current_user_can('mdr_tv_control')){$m['status']='failed';$m['note']='O responsável perdeu permissão para executar o agendamento.';}
            elseif($m['status']==='scheduled'){
                if($now-$m['at']>600){$m['status']='missed';$m['note']='O horário passou há mais de10min. Nenhum comando foi enviado.';}
                else{
                    // Commands and their schedule record are committed together.
                    $wpdb->query('START TRANSACTION');
                    try{foreach($m['units'] as $unit){$id=mdr_tv_queue($m['action'],null,$unit);if(is_wp_error($id))$m['errors'][$unit]=$id->get_error_code();else{$m['commands'][$unit]=[$id];update_post_meta($id,'mdr_tv_schedule_id',$post->ID);}}
                        $m['queued_at']=$now;$m['status']=$m['commands']?'queued':'failed';if(!$m['commands'])$m['note']='Nenhum comando pôde ser enviado. Confira as permissões e o modo de operação.';update_post_meta($post->ID,'mdr_tv_schedule',$m);$wpdb->query('COMMIT');
                    }catch(Throwable $e){$wpdb->query('ROLLBACK');throw $e;}
                }
            }else{$m=mdr_tv_schedule_reconcile($m,$now);}
            update_post_meta($post->ID,'mdr_tv_schedule',$m);$changed[]=['id'=>$post->ID,'status'=>$m['status'],'commands'=>$m['commands']];
        }
    }finally{wp_set_current_user($previous);$wpdb->query("SELECT RELEASE_LOCK('mdr_tv_schedule_tick')");}
    return ['at'=>time(),'jobs'=>$changed];
}
function mdr_tv_schedule_panel(){
    if(!current_user_can('mdr_tv_start'))return;$data=mdr_tv_schedule_public();$locations=mdr_tv_panel_locations();
    echo '<section class="mdr-tv-panel tvp-schedules" id="mdr-tv-schedules"><h2>Agendamentos das TVs</h2><p>Horário de Fortaleza · cada agendamento executa uma única vez, pelo servidor, sem depender de computador ligado ou visitas ao site.</p><p data-scheduler-heartbeat>'.esc_html($data['worker_at']?'Servidor verificado em '.mdr_tv_panel_date($data['worker_at']):'Aguardando a primeira verificação do servidor.').'</p>';
    if(current_user_can('mdr_tv_control')){
        if(!empty($_GET['schedule_result']))echo '<p role="status">'.esc_html($_GET['schedule_result']==='saved'?'Agendamento salvo.':'Agendamento cancelado.').'</p>';
        $error=get_transient('mdr_tv_schedule_error_'.get_current_user_id());if($error){delete_transient('mdr_tv_schedule_error_'.get_current_user_id());echo '<p role="alert">'.esc_html($error).'</p>';}
        echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'" class="tvp-schedule-form">';wp_nonce_field('mdr_tv_schedule');echo '<input type="hidden" name="action" value="mdr_tv_schedule_create"><label>Ação<select name="schedule_action"><option value="off">Desligar TVs</option><option value="start">Ligar e iniciar campanha · volume zero</option></select></label><label>Data e horário<input type="datetime-local" name="when" required></label><fieldset><legend>TVs</legend>';foreach($locations as $unit=>$location)if(mdr_tv_unit_allowed($unit))echo '<label><input type="checkbox" name="units[]" value="'.esc_attr($unit).'" checked> '.esc_html($location['office'].' · '.$location['name']).'</label>';echo '</fieldset><button type="submit" class="tvp-button tvp-primary">Agendar</button></form>';
    }
    echo '<div class="tvp-schedule-list">';foreach($data['jobs'] as $job){$labels=[];foreach($job['units'] as $u)$labels[]=$locations[$u]['name'];echo '<article data-schedule-id="'.absint($job['id']).'"><h3>'.esc_html(($job['action']==='off'?'Desligar TVs':'Ligar e iniciar campanha').' · '.$job['when']).'</h3><p>'.esc_html(implode(' · ',$labels)).'</p><p><strong data-schedule-status>'.esc_html($job['label']).'</strong></p><p data-schedule-note>'.esc_html($job['note']).'</p>';
        if(current_user_can('mdr_tv_control')&&$job['status']==='scheduled'){echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'">';wp_nonce_field('mdr_tv_schedule');echo '<input type="hidden" name="action" value="mdr_tv_schedule_cancel"><input type="hidden" name="schedule_id" value="'.absint($job['id']).'"><button type="submit" class="tvp-text-button">Cancelar agendamento</button></form>';}echo '</article>';
    }if(!$data['jobs'])echo '<p>Nenhum agendamento nesta janela.</p>';echo '</div></section>';
}
function mdr_tv_schedule_redirect($result){
    if(is_wp_error($result)){set_transient('mdr_tv_schedule_error_'.get_current_user_id(),$result->get_error_message(),60);$status='';}else$status=$result;
    wp_safe_redirect(add_query_arg('schedule_result',$status,admin_url('admin.php?page=mdr-tv')).'#mdr-tv-schedules');exit;
}
add_action('admin_post_mdr_tv_schedule_create',function(){
    if(!current_user_can('mdr_tv_control'))wp_die('Sem permissão.','',['response'=>403]);check_admin_referer('mdr_tv_schedule');$raw=sanitize_text_field($_POST['when']??'');$date=DateTimeImmutable::createFromFormat('!Y-m-d\TH:i',$raw,new DateTimeZone('America/Fortaleza'));
    if(!$date||$date->format('Y-m-d\TH:i')!==$raw)mdr_tv_schedule_redirect(new WP_Error('date','Data inválida.'));
    $r=mdr_tv_schedule_create(sanitize_key($_POST['schedule_action']??''),isset($_POST['units'])?array_map('sanitize_key',(array)$_POST['units']):[],$date->getTimestamp());mdr_tv_schedule_redirect(is_wp_error($r)?$r:'saved');
});
add_action('admin_post_mdr_tv_schedule_cancel',function(){
    global $wpdb;if(!current_user_can('mdr_tv_control'))wp_die('Sem permissão.','',['response'=>403]);check_admin_referer('mdr_tv_schedule');$id=absint($_POST['schedule_id']??0);$p=get_post($id);if(!$p||$p->post_type!=='mdr_tv_schedule')wp_die('Agendamento inválido.','',['response'=>404]);
    if((int)$wpdb->get_var("SELECT GET_LOCK('mdr_tv_schedule_tick',0)")!==1)mdr_tv_schedule_redirect(new WP_Error('busy','A execução está em andamento. Aguarde e confira o resultado.'));
    try{$m=get_post_meta($id,'mdr_tv_schedule',true);if(($m['status']??'')!=='scheduled')$r=new WP_Error('running','Este agendamento já não pode ser cancelado.');else{$m['status']='cancelled';update_post_meta($id,'mdr_tv_schedule',$m);mdr_tv_audit('schedule_cancelled',$id);$r='cancelled';}}finally{$wpdb->query("SELECT RELEASE_LOCK('mdr_tv_schedule_tick')");}mdr_tv_schedule_redirect($r);
});
