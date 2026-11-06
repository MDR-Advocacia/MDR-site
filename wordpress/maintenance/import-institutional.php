<?php
/** Explicit, idempotent migration for the protected staging site. WP-CLI only. */
if (!defined('WP_CLI') || !WP_CLI || wp_get_environment_type() !== 'staging') {
    throw new RuntimeException('This migration is restricted to staging WP-CLI.');
}
$manifest = json_decode(file_get_contents(__DIR__.'/institutional-content.json'), true, 512, JSON_THROW_ON_ERROR);
$version = $manifest['version'];
if (get_option('mdr_institutional_version') === $version) {
    echo wp_json_encode(['status'=>'already_imported', 'version'=>$version]);
    return;
}
require_once ABSPATH.'wp-admin/includes/file.php';
require_once ABSPATH.'wp-admin/includes/media.php';
require_once ABSPATH.'wp-admin/includes/image.php';
$admins = get_users(['role'=>'administrator', 'number'=>1, 'fields'=>'ID']);
if (!$admins) { throw new RuntimeException('Expected staging administrator.'); }
wp_set_current_user((int)$admins[0]);
$assets = [];
foreach ($manifest['assets'] as $key=>$spec) {
    $file = __DIR__.'/institutional-assets/'.basename($spec['file']);
    if (!is_file($file) || hash_file('sha256', $file) !== $spec['sha256']) {
        throw new RuntimeException('Asset integrity mismatch: '.$key);
    }
    $existing = get_posts(['post_type'=>'attachment', 'post_status'=>'inherit', 'meta_key'=>'mdr_source_sha256', 'meta_value'=>$spec['sha256'], 'numberposts'=>1]);
    if ($existing) {
        $id = $existing[0]->ID;
    } else {
        $temp = wp_tempnam($file);
        if (!$temp || !copy($file, $temp)) { throw new RuntimeException('Could not stage media.'); }
        $name = sanitize_file_name(rawurldecode(basename(parse_url($spec['source'], PHP_URL_PATH))));
        $id = media_handle_sideload(['name'=>$name, 'tmp_name'=>$temp], 0);
        if (is_wp_error($id)) { @unlink($temp); throw new RuntimeException($id->get_error_message()); }
        update_post_meta($id, 'mdr_source_sha256', $spec['sha256']);
        update_post_meta($id, 'mdr_source_url', esc_url_raw($spec['source']));
    }
    $assets['{{asset:'.$key.'}}'] = wp_get_attachment_url($id);
}
$assets['{{site}}'] = untrailingslashit(home_url('/'));
$pages = []; $created = []; $updated = []; $preserved = [];
foreach ($manifest['pages'] as $spec) {
    $content = strtr($spec['content'], $assets);
    if (preg_match('/\{\{(?:asset:|site)/', $content)) { throw new RuntimeException('Unresolved content reference.'); }
    $old = get_page_by_path($spec['slug'], OBJECT, 'page');
    if ($old) {
        $pages[$spec['slug']] = $old->ID;
        $old_version = get_post_meta($old->ID, 'mdr_institutional_version', true);
        $old_hash = get_post_meta($old->ID, 'mdr_imported_content_sha256', true);
        if ($old_version && $old_hash && hash_equals($old_hash, hash('sha256', $old->post_content))) {
            // Only revise untouched importer-owned content; keep titles, status,
            // summaries, ordering and all subsequent editorial changes intact.
            $result = wp_update_post(wp_slash(['ID'=>$old->ID, 'post_content'=>$content]), true);
            if (is_wp_error($result)) { throw new RuntimeException($result->get_error_message()); }
            update_post_meta($old->ID, 'mdr_institutional_version', $version);
            update_post_meta($old->ID, 'mdr_imported_content_sha256', hash('sha256', $content));
            $updated[] = $spec['slug'];
        } else {
            $preserved[] = $spec['slug'];
        }
        continue;
    }
    $id = wp_insert_post(wp_slash(['post_type'=>'page', 'post_name'=>$spec['slug'], 'post_title'=>$spec['title'], 'post_content'=>$content, 'post_excerpt'=>$spec['summary'], 'post_status'=>$spec['status'], 'post_author'=>(int)$admins[0], 'comment_status'=>'closed', 'ping_status'=>'closed']), true);
    if (is_wp_error($id)) { throw new RuntimeException($id->get_error_message()); }
    update_post_meta($id, 'mdr_institutional_version', $version);
    update_post_meta($id, 'mdr_imported_content_sha256', hash('sha256', $content));
    $pages[$spec['slug']] = $id;
    $created[] = $spec['slug'];
}
foreach ($manifest['pages'] as $order=>$spec) {
    if (!in_array($spec['slug'], $created, true)) { continue; }
    $values = ['ID'=>$pages[$spec['slug']], 'menu_order'=>$order];
    if ($spec['parent'] === 'atuacao') { update_post_meta($pages[$spec['slug']], 'mdr_practice_area', '1'); }
    wp_update_post($values);
}
// Preserve existing custom menus. Initialize navigation only if unassigned.
$locations = get_nav_menu_locations();
if (empty($locations['primary'])) {
    $menu = wp_create_nav_menu('MDR Institucional');
    if (is_wp_error($menu)) { $menu = wp_get_nav_menu_object('MDR Institucional')->term_id; }
    foreach (['O escritório'=>'/about/', 'Atuação'=>'/atuacao/', 'Sócios'=>'/#socios', 'Reconhecimentos'=>'/reconhecimentos/', 'Compromissos'=>'/esg/', 'Blog'=>'/blog/', 'Contato'=>'/#contato'] as $title=>$route) {
        wp_update_nav_menu_item($menu, 0, ['menu-item-title'=>$title, 'menu-item-url'=>home_url($route), 'menu-item-type'=>'custom', 'menu-item-status'=>'publish']);
    }
    $locations['primary'] = (int)$menu;
    set_theme_mod('nav_menu_locations', $locations);
}
$sample = get_page_by_path('sample-page', OBJECT, 'page');
if ($sample && !get_post_meta($sample->ID, 'mdr_institutional_version', true) && $sample->post_title === 'Sample Page') {
    wp_trash_post($sample->ID); // Recoverable; never purge an editorial page.
}
$facebook = untrailingslashit((string)get_option('mdr_social_facebook'));
if (in_array($facebook, ['https://facebook.com/marcosdelliribeiro','https://www.facebook.com/marcosdelliribeiro'], true)) {
    update_option('mdr_legacy_facebook_reference', $facebook);
    update_option('mdr_social_facebook', '');
}
update_option('mdr_institutional_pages', $pages);
update_option('mdr_institutional_version', $version);
flush_rewrite_rules(false);
echo wp_json_encode(['status'=>'imported', 'version'=>$version, 'created'=>$created, 'updated_untouched_imports'=>$updated, 'existing_preserved'=>$preserved, 'assets'=>count($manifest['assets']), 'certificates'=>count($manifest['certificates'])], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
