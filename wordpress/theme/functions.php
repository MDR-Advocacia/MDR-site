<?php
if (!defined('ABSPATH')) { exit; }
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
    wp_enqueue_script('mdr', mdr_asset('site.js'), [], wp_get_theme()->get('Version'), true);
});
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
function mdr_post_card() { ?>
<article class="article-card">
  <a class="cover-link" href="<?php the_permalink(); ?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('large'); } else { $cover=get_post_meta(get_the_ID(),'mdr_demo_cover',true); if(!in_array($cover,['negocios.svg','esg.svg','institucional.svg'],true)){$cover='institucional.svg';} ?><img src="<?php echo esc_url(mdr_asset($cover)); ?>" alt="" loading="lazy"><?php } ?><span class="cover-arrow" aria-hidden="true">↗</span></a>
  <div class="meta"><span><?php $c=get_the_category(); echo esc_html($c ? $c[0]->name : 'Institucional'); ?></span><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time></div>
  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html(get_the_excerpt()); ?></p>
  <?php if (get_post_meta(get_the_ID(),'mdr_demo',true)) { ?><span class="demo-label">Conteúdo demonstrativo</span><?php } ?>
</article>
<?php }
