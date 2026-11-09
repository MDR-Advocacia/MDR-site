<?php
if (!defined('ABSPATH')) { exit; }
add_action('init', function () { add_post_type_support('page', 'excerpt'); });

function mdr_practice_pages() {
    return get_posts(['post_type'=>'page', 'post_status'=>'publish', 'numberposts'=>30, 'meta_key'=>'mdr_practice_area', 'meta_value'=>'1', 'orderby'=>'menu_order title', 'order'=>'ASC']);
}
add_action('add_meta_boxes', function () {
    add_meta_box('mdr-area', 'Área de atuação', function ($post) {
        wp_nonce_field('mdr_practice', 'mdr_practice_nonce');
        echo '<label><input type="checkbox" name="mdr_practice_area" value="1" '.checked(get_post_meta($post->ID, 'mdr_practice_area', true), '1', false).'> Exibir esta página entre as áreas da home</label><p>A ordem usa o campo Ordem dos atributos da página.</p>';
    }, 'page', 'side');
});
add_action('save_post_page', function ($id) {
    if (!isset($_POST['mdr_practice_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mdr_practice_nonce'])), 'mdr_practice') || !current_user_can('edit_post', $id) || wp_is_post_revision($id) || wp_is_post_autosave($id)) { return; }
    update_post_meta($id, 'mdr_practice_area', isset($_POST['mdr_practice_area']) ? '1' : '0');
});

function mdr_phone_digits($value) {
    $digits = preg_replace('/\D+/', '', (string)$value);
    if (in_array(strlen($digits), [10, 11], true)) { $digits = '55'.$digits; }
    return strlen($digits) >= 12 && strlen($digits) <= 15 ? $digits : '';
}
function mdr_phone_href() {
    $digits = mdr_phone_digits(get_option('mdr_phone'));
    return $digits ? 'tel:+'.$digits : '';
}
function mdr_whatsapp_href() {
    $digits = mdr_phone_digits(get_option('mdr_whatsapp'));
    return $digits ? 'https://wa.me/'.$digits : '';
}
function mdr_primary_fallback() {
    echo '<ul class="site-menu"><li><a class="home-link" href="'.esc_url(home_url('/#inicio')).'" aria-label="Início" title="Início">'.mdr_home_icon().'<span class="mobile-home-label">Início</span></a></li>';
    foreach(mdr_home_nav_items()as $label=>$anchor){$jobs=$anchor==='jobs';echo '<li><a href="'.esc_url($jobs?mdr_jobs_url():home_url($anchor==='blog'?'/blog/':'/#'.$anchor)).'"'.($jobs?' target="_blank" rel="noopener noreferrer"':'').'>'.esc_html($label).'</a></li>';}
    echo '</ul>';
}

// Legacy public routes stay inside the staging site and never loop back to
// KingHost. The certificates remain part of one recognition archive.
add_action('template_redirect', function () {
    if (is_admin() || is_preview()) { return; }
    $path = untrailingslashit((string)wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH));
    $aliases = ['/premios'=>'/reconhecimentos/', '/certificados'=>'/reconhecimentos/#certificados', '/compliance'=>'/compliance-e-privacidade/'];
    if (isset($aliases[$path])) { wp_safe_redirect(home_url($aliases[$path]), 301); exit; }
    if ($path === '/equipe-recuperacao-credito' && !current_user_can('edit_pages')) {
        wp_safe_redirect(home_url('/recuperacao-credito/'), 302); exit;
    }
});

// Sharing metadata contains public editorial content only, even in the
// protected preview. No user identifiers, credentials or analytics are added.
add_action('wp_head', function () {
    if (is_404() || is_search()) { return; }
    $id = is_home() ? (int)get_option('page_for_posts') : (is_singular() ? get_queried_object_id() : 0);
    $title = is_singular() ? get_the_title($id).' · MDR Advocacia' : wp_get_document_title();
    $description = $id ? get_post_field('post_excerpt', $id) : '';
    if (!$description && $id) { $description = wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $id))); }
    $description = wp_html_excerpt(trim(preg_replace('/\s+/', ' ', $description ?: get_bloginfo('description'))), 170, '…');
    if (is_page('pacto-global-gptw')) { $description='Participação da MDR no Pacto Global da ONU e compromissos com os Dez Princípios.'; }
    $url = is_front_page() ? home_url('/') : ($id ? get_permalink($id) : get_post_type_archive_link('mdr_premio'));
    $image = $id ? get_the_post_thumbnail_url($id, 'large') : false;
    if (!$image) { $image = mdr_asset('hero-poster.webp'); }
    echo '<meta name="description" content="'.esc_attr($description).'">' . "\n";
    foreach (['og:locale'=>'pt_BR', 'og:site_name'=>'MDR Advocacia', 'og:type'=>is_singular('post')?'article':'website', 'og:title'=>$title, 'og:description'=>$description, 'og:url'=>$url, 'og:image'=>$image, 'og:image:alt'=>$id && has_post_thumbnail($id) ? get_post_meta(get_post_thumbnail_id($id), '_wp_attachment_image_alt', true) : 'MDR Advocacia'] as $key=>$value) {
        echo '<meta property="'.esc_attr($key).'" content="'.esc_attr($value).'">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    if (is_singular('post')) { echo '<meta property="article:published_time" content="'.esc_attr(get_the_date('c', $id)).'">' . "\n"; }
}, 5);

add_action('admin_init', function () {
    register_setting('mdr_institucional', 'mdr_home_awards_count', ['type'=>'integer', 'default'=>4, 'sanitize_callback'=>function ($value) { return max(1, min(12, (int)$value)); }]);
});
