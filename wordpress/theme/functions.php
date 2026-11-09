<?php
if (!defined('ABSPATH')) { exit; }
require_once __DIR__.'/inc-institutional.php';
require_once __DIR__.'/inc-preview-layout.php';
require_once __DIR__.'/inc-blog.php';
require_once __DIR__.'/inc-contact.php';
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('assets/editor.css');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus(['primary' => 'Navegação principal']);
});
function mdr_asset($path) { return get_template_directory_uri() . '/assets/' . ltrim($path, '/'); }
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('mdr', mdr_asset('site.css'), [], wp_get_theme()->get('Version'));
    wp_enqueue_style('mdr-visual', mdr_asset('visual-review.css'), ['mdr'], wp_get_theme()->get('Version'));
    wp_enqueue_style('mdr-architecture', mdr_asset('architecture.css'), ['mdr-visual'], wp_get_theme()->get('Version'));
    wp_enqueue_style('mdr-blog', mdr_asset('blog.css'), ['mdr-architecture'], wp_get_theme()->get('Version'));
    wp_enqueue_script('mdr', mdr_asset('site.js'), [], wp_get_theme()->get('Version'), true);
});
add_filter('wp_nav_menu_objects', function ($items, $args) {
    if (empty($args->mdr_glass_header)) { return $items; }
    $order=['premiacoes'=>0,'quem-somos'=>1,'compromissos'=>2,'atuacao'=>3,'orienta'=>4,'blog'=>5];
    $paths=['about'=>'orienta','atuacao'=>'atuacao','blog'=>'blog','esg'=>'compromissos','reconhecimentos'=>'premiacoes'];
    $kept=[];
    foreach($items as $item){
        $fragment=wp_parse_url($item->url,PHP_URL_FRAGMENT);if($fragment==='contato'||untrailingslashit($item->url)===untrailingslashit(mdr_jobs_url())){continue;}
        $path=trim((string)wp_parse_url($item->url,PHP_URL_PATH),'/');$anchor=$paths[$path]??$fragment;if($anchor==='socios'){$anchor='quem-somos';}
        if(isset($order[$anchor])){$item->url=$anchor==='blog'?home_url('/blog/'):home_url('/#'.$anchor);if($anchor==='orienta'){$item->title='O que nos orienta';}if($anchor==='quem-somos'){$item->title='Quem somos';}$item->menu_order=$order[$anchor];}
        $kept[]=$item;
    }
    usort($kept,fn($a,$b)=>$a->menu_order<=>$b->menu_order);return $kept;
}, 10, 2);
add_filter('wp_nav_menu_items',function($items,$args){
    if (empty($args->mdr_glass_header)) { return $items; }
    return $items.'<li class="menu-careers"><a href="'.esc_url(mdr_jobs_url()).'" target="_blank" rel="noopener noreferrer">Trabalhe conosco</a></li>';
},10,2);
add_filter('nav_menu_link_attributes', function ($attributes, $item, $args) {
    if (!empty($args->mdr_glass_header) && wp_parse_url($item->url, PHP_URL_FRAGMENT)) {
        unset($attributes['aria-current']);
    }
    if (!empty($args->mdr_glass_header) && untrailingslashit($item->url)===untrailingslashit(home_url('/blog/')) && (is_home()||is_singular('post')||is_category()||is_tag()||is_date()||is_search())) { $attributes['aria-current']='page'; }
    return $attributes;
}, 10, 3);
function mdr_register_content_types() {
    foreach (['mdr_socio' => ['Sócios', 'Sócio', 'socios'], 'mdr_premio' => ['Reconhecimentos', 'Reconhecimento', 'reconhecimentos']] as $type => $labels) {
        register_post_type($type, [
            'labels' => ['name' => $labels[0], 'singular_name' => $labels[1], 'add_new_item' => 'Adicionar ' . $labels[1], 'edit_item' => 'Editar ' . $labels[1]],
            'public' => true, 'show_in_rest' => true, 'has_archive' => $type === 'mdr_premio',
            'rewrite' => ['slug' => $labels[2], 'with_front' => false], 'menu_icon' => $type === 'mdr_socio' ? 'dashicons-groups' : 'dashicons-awards',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'],
        ]);
    }
    foreach (['role','instagram','linkedin','year','subtitle'] as $key) {
        foreach (['mdr_socio','mdr_premio'] as $type) {
            register_post_meta($type, 'mdr_' . $key, ['type' => 'string', 'single' => true, 'show_in_rest' => true,
                'sanitize_callback' => in_array($key, ['instagram','linkedin'], true) ? 'esc_url_raw' : 'sanitize_text_field',
                'auth_callback' => function ($allowed, $meta_key, $post_id) { return current_user_can('edit_post', $post_id); }]);
        }
    }
}
add_action('init', 'mdr_register_content_types');
add_action('add_meta_boxes', function () {
    add_meta_box('mdr-details', 'Informações do cadastro', function ($post) {
        wp_nonce_field('mdr_details', 'mdr_nonce');
        $fields = $post->post_type === 'mdr_socio' ? ['role'=>'Função', 'instagram'=>'Link do Instagram', 'linkedin'=>'Link do LinkedIn'] : ['year'=>'Ano (deixar vazio se não confirmado)', 'subtitle'=>'Entidade, categoria ou validade'];
        echo '<p>A foto é definida em “Imagem destacada”. O resumo aparece na janela do sócio na home; o texto principal fica no perfil completo.</p>';
        foreach ($fields as $key => $label) {
            echo '<p><label>' . esc_html($label) . '<br><input class="widefat" type="' . (in_array($key,['instagram','linkedin'],true) ? 'url' : 'text') . '" name="mdr_' . esc_attr($key) . '" value="' . esc_attr(get_post_meta($post->ID,'mdr_'.$key,true)) . '"></label></p>';
        }
    }, ['mdr_socio','mdr_premio'], 'normal', 'high');
});
add_action('save_post', function ($id) {
    if (!isset($_POST['mdr_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mdr_nonce'])), 'mdr_details') || !current_user_can('edit_post',$id) || wp_is_post_revision($id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) { return; }
    foreach (['role','instagram','linkedin','year','subtitle'] as $key) {
        if (isset($_POST['mdr_'.$key])) {
            $value = wp_unslash($_POST['mdr_'.$key]);
            update_post_meta($id, 'mdr_'.$key, in_array($key,['instagram','linkedin'],true) ? esc_url_raw($value) : sanitize_text_field($value));
        }
    }
});
function mdr_picture($id, $size='large', $class='') {
    if (has_post_thumbnail($id)) { echo get_the_post_thumbnail($id,$size,['class'=>$class,'loading'=>'lazy']); }
}
function mdr_social_icon($network, $url, $label) {
    if (!$url || !in_array($network,['linkedin','instagram','facebook','whatsapp'],true)) { return; }
    echo '<a class="social-icon" href="'.esc_url($url).'" target="_blank" rel="noopener noreferrer" aria-label="'.esc_attr($label).'" title="'.esc_attr($label).'"><svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><use href="'.esc_url(mdr_asset('social-icons.svg').'#'.$network).'"></use></svg></a>';
}
function mdr_social($id) {
    foreach (['linkedin'=>'LinkedIn','instagram'=>'Instagram'] as $key=>$label) {
        mdr_social_icon($key,get_post_meta($id,'mdr_'.$key,true),$label.' de '.get_the_title($id));
    }
}
