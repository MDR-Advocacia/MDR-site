<?php
/** CLI-only, idempotent media update for the visual review v1. Originals are retained. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once '/var/www/html/wp-load.php';
require_once ABSPATH.'wp-admin/includes/file.php';
require_once ABSPATH.'wp-admin/includes/media.php';
require_once ABSPATH.'wp-admin/includes/image.php';
$data=json_decode(file_get_contents('/opt/mdr-seed/content.json'),true,512,JSON_THROW_ON_ERROR);
$results=[];
foreach($data['awards'] as $award) {
    if(empty($award['original_image'])) { continue; }
    $post=get_page_by_path($award['id'],OBJECT,'mdr_premio');
    if(!$post) { throw new RuntimeException('Reconhecimento ausente: '.$award['id']); }
    $source=get_template_directory().'/assets/'.basename($award['image']);
    if(!is_file($source)) { throw new RuntimeException('Imagem tratada ausente'); }
    $hash=hash_file('sha256',$source);
    $current=get_post_thumbnail_id($post->ID);
    if(get_post_meta($current,'mdr_trophy_cleanup_hash',true)===$hash) {
        $results[]=['slug'=>$award['id'],'status'=>'already_updated','attachment'=>$current]; continue;
    }
    // Stop if someone has independently changed the featured image since the original seed.
    if(get_post_meta($current,'mdr_source_file',true)!==$award['original_image']) {
        throw new RuntimeException('Imagem destacada alterada por outra edição: '.$award['id']);
    }
    $found=get_posts(['post_type'=>'attachment','post_status'=>'inherit','meta_key'=>'mdr_trophy_cleanup_hash','meta_value'=>$hash,'posts_per_page'=>1]);
    if($found) { $id=$found[0]->ID; }
    else {
        $tmp=wp_tempnam($source);
        if(!copy($source,$tmp)) { throw new RuntimeException('Falha ao preparar mídia'); }
        $id=media_handle_sideload(['name'=>basename($source),'tmp_name'=>$tmp],$post->ID,$award['title'].' — imagem tratada');
        if(is_wp_error($id)) { @unlink($tmp); throw new RuntimeException($id->get_error_message()); }
        update_post_meta($id,'mdr_trophy_cleanup_hash',$hash);
        update_post_meta($id,'mdr_source_file',$award['image']);
        update_post_meta($id,'mdr_original_attachment',$current);
        update_post_meta($id,'_wp_attachment_image_alt',$award['title']);
    }
    add_post_meta($post->ID,'mdr_visual_previous_thumbnail_v1',$current,true);
    set_post_thumbnail($post->ID,$id);
    $results[]=['slug'=>$award['id'],'status'=>'updated','original_attachment'=>$current,'attachment'=>$id,'sha256'=>$hash];
}
echo json_encode($results,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)."\n";
