<?php
/** Plugin Name: MDR — Edição do blog e destaques */
if (!defined('ABSPATH')) { exit; }

add_action('init', function () {
    register_post_type('mdr_autor', [
        'labels'=>['name'=>'Autores do blog','singular_name'=>'Autor do blog','add_new_item'=>'Adicionar autor do blog','edit_item'=>'Editar autor do blog'],
        'public'=>false, 'show_ui'=>true, 'show_in_menu'=>'edit.php', 'show_in_rest'=>true,
        'supports'=>['title','editor','excerpt','thumbnail','revisions'], 'map_meta_cap'=>true,
    ]);
    foreach (['mdr_blog_byline'=>'string','mdr_blog_authors'=>'array','mdr_blog_square'=>'integer'] as $key=>$type) {
        register_post_meta('post', $key, ['type'=>$type,'single'=>true,'show_in_rest'=>false,'revisions_enabled'=>true,
            'auth_callback'=>function ($allowed,$meta_key,$post_id) { return current_user_can('edit_post',$post_id); }]);
    }
});

function mdr_editorial_author_posts() {
    return get_posts(['post_type'=>['mdr_socio','mdr_autor'],'post_status'=>'publish','numberposts'=>-1,'orderby'=>'title','order'=>'ASC']);
}
function mdr_editorial_author_ids($values) {
    if (!is_array($values)) { return []; }
    $ids=[];
    foreach ($values as $value) {
        if (!is_scalar($value)) { continue; }
        $id=absint($value);$post=get_post($id);
        if ($post && $post->post_status==='publish' && in_array($post->post_type,['mdr_socio','mdr_autor'],true)) { $ids[]=$id; }
    }
    return array_values(array_unique($ids));
}
function mdr_editorial_image_id($value) {
    $id=is_scalar($value)?absint($value):0;
    return $id && wp_attachment_is_image($id) ? $id : 0;
}
function mdr_editorial_save_post_fields($id, $input) {
    if (!current_user_can('edit_post',$id) || get_post_type($id)!=='post') { return new WP_Error('permission','Sem permissão para editar esta publicação.'); }
    $mode=isset($input['mdr_blog_byline']) && $input['mdr_blog_byline']==='people'?'people':'institutional';
    $authors=mdr_editorial_author_ids($input['mdr_blog_authors']??[]);
    if ($mode==='people' && !$authors) { return new WP_Error('authors','Selecione ao menos um autor publicado ou use a assinatura MDR Advocacia.'); }
    update_post_meta($id,'mdr_blog_byline',$mode);
    update_post_meta($id,'mdr_blog_authors',$authors);
    update_post_meta($id,'mdr_blog_square',mdr_editorial_image_id($input['mdr_blog_square']??0));
    return true;
}
add_action('add_meta_boxes_post', function () {
    add_meta_box('mdr-blog-editorial','Autoria e chamada da home',function ($post) {
        wp_nonce_field('mdr_blog_fields','mdr_blog_nonce');
        $mode=get_post_meta($post->ID,'mdr_blog_byline',true)==='people'?'people':'institutional';
        $selected=mdr_editorial_author_ids(get_post_meta($post->ID,'mdr_blog_authors',true));
        echo '<p>A autoria pública é independente da conta que publica. Notícias institucionais devem usar MDR Advocacia.</p><fieldset><legend><strong>Assinatura da publicação</strong></legend>';
        foreach (['institutional'=>'MDR Advocacia — notícias institucionais','people'=>'Um ou mais autores'] as $value=>$label) {
            echo '<p><label><input type="radio" name="mdr_blog_byline" value="'.esc_attr($value).'" '.checked($mode,$value,false).'> '.esc_html($label).'</label></p>';
        }
        echo '</fieldset><fieldset><legend><strong>Autores (usados na assinatura por pessoas)</strong></legend><p>Selecione os coautores. Sócios já cadastrados também aparecem aqui.</p><div style="max-height:240px;overflow:auto">';
        foreach (mdr_editorial_author_posts() as $author) {
            echo '<p><label><input type="checkbox" name="mdr_blog_authors[]" value="'.esc_attr($author->ID).'" '.checked(in_array($author->ID,$selected,true),true,false).'> '.esc_html($author->post_title).'</label></p>';
        }
        echo '</div><p><a href="'.esc_url(admin_url('edit.php?post_type=mdr_autor')).'">Gerenciar outros autores e suas fotos</a></p></fieldset><hr>';
        $image=mdr_editorial_image_id(get_post_meta($post->ID,'mdr_blog_square',true));
        echo '<div data-editorial-image><p><strong>Miniatura quadrada para a home (opcional)</strong></p><p>O banner usa a Imagem destacada do post. Sem miniatura própria, a home usa essa mesma imagem em recorte quadrado. Use o campo Resumo para escrever a chamada; ele também será limitado na apresentação.</p><div data-image-preview>'.($image?wp_get_attachment_image($image,'thumbnail'):'' ).'</div><input data-image-id type="hidden" name="mdr_blog_square" value="'.esc_attr($image).'"><p><button type="button" class="button" data-select-image>Escolher miniatura</button> <button type="button" class="button-link-delete" data-remove-image>Remover miniatura</button></p></div>';
        echo '<p><a href="'.esc_url(admin_url('edit.php?page=mdr-home-featured')).'">Escolher os três destaques da home</a></p>';
    },'post','normal','high');
});
add_action('save_post_post',function ($id) {
    if (wp_is_post_revision($id) || wp_is_post_autosave($id) || (defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) || !isset($_POST['mdr_blog_nonce']) || !is_scalar($_POST['mdr_blog_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mdr_blog_nonce'])),'mdr_blog_fields')) { return; }
    $result=mdr_editorial_save_post_fields($id,wp_unslash($_POST));
    if (is_wp_error($result)) { set_transient('mdr_editorial_error_'.get_current_user_id(),$result->get_error_message(),60); }
});
add_action('admin_notices',function () {
    $key='mdr_editorial_error_'.get_current_user_id();$message=get_transient($key);
    if ($message) { delete_transient($key);echo '<div class="notice notice-error"><p>'.esc_html($message).' Os campos de autoria e miniatura anteriores foram preservados.</p></div>'; }
});
add_action('admin_enqueue_scripts',function ($hook) {
    $screen=get_current_screen();
    if (in_array($hook,['post.php','post-new.php'],true) && $screen && $screen->post_type==='post') {
        wp_enqueue_media();wp_enqueue_script('mdr-editorial-media',plugins_url('mdr-editorial/media.js',__FILE__),['media-views'],'1.0.0',true);
    }
});

function mdr_editorial_featured_ids() {
    $stored=get_option('mdr_home_featured',[]);$result=[];
    if (!is_array($stored)) { return []; }
    foreach (array_slice($stored,0,3) as $value) {
        $id=is_scalar($value)?absint($value):0;$post=get_post($id);
        if ($post && $post->post_type==='post' && $post->post_status==='publish' && !$post->post_password) { $result[]=$id; }
    }
    return array_values(array_unique($result));
}
function mdr_editorial_featured_version() { return wp_hash(wp_json_encode(get_option('mdr_home_featured',[]))); }
function mdr_editorial_save_featured($values,$version) {
    if (!current_user_can('edit_others_posts')) { return new WP_Error('permission','Sem permissão para organizar os destaques.'); }
    if (!is_string($version)||!hash_equals(mdr_editorial_featured_version(),$version)) { return new WP_Error('stale','Os destaques foram alterados por outra pessoa. Recarregue e confira a seleção.'); }
    if (!is_array($values)||count($values)>3) { return new WP_Error('limit','Escolha no máximo três publicações.'); }
    $ids=[];
    foreach ($values as $value) {
        if (!is_scalar($value)) { return new WP_Error('invalid','Seleção inválida.'); }
        $id=absint($value);if (!$id) { continue; }$post=get_post($id);
        if (!$post||$post->post_type!=='post'||$post->post_status!=='publish'||$post->post_password||!current_user_can('edit_post',$id)) { return new WP_Error('invalid','Escolha somente publicações públicas já publicadas que você possa editar.'); }
        if (in_array($id,$ids,true)) { return new WP_Error('duplicate','Uma publicação não pode ocupar dois destaques.'); }
        $ids[]=$id;
    }
    update_option('mdr_home_featured',$ids,false);
    if (function_exists('mdr_audit_event')) { mdr_audit_event('home_featured'); }
    return true;
}
add_action('admin_menu',function () {
    add_submenu_page('edit.php','Destaques da home','Destaques da home','edit_others_posts','mdr-home-featured',function () {
        if (!current_user_can('edit_others_posts')) { return; }
        $ids=mdr_editorial_featured_ids();
        echo '<div class="wrap"><h1>Destaques da home</h1><p>Escolha até três publicações, na ordem desejada. Vagas livres são preenchidas pelas publicações mais recentes, sem repetir as escolhidas. A ordem do blog continua sendo a data de publicação.</p>';
        $status=isset($_GET['mdr_result'])&&is_scalar($_GET['mdr_result'])?sanitize_key(wp_unslash($_GET['mdr_result'])):'';
        if ($status==='saved') { echo '<div class="notice notice-success"><p>Destaques atualizados.</p></div>'; }
        $error=get_transient('mdr_featured_error_'.get_current_user_id());if ($error) { delete_transient('mdr_featured_error_'.get_current_user_id());echo '<div class="notice notice-error"><p>'.esc_html($error).'</p></div>'; }
        echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'">';wp_nonce_field('mdr_featured','mdr_featured_nonce');
        echo '<input type="hidden" name="action" value="mdr_save_featured"><input type="hidden" name="mdr_featured_version" value="'.esc_attr(mdr_editorial_featured_version()).'"><table class="form-table">';
        $posts=get_posts(['post_type'=>'post','post_status'=>'publish','numberposts'=>-1,'has_password'=>false,'orderby'=>'date','order'=>'DESC']);
        for ($i=0;$i<3;$i++) {
            echo '<tr><th><label for="featured-'.esc_attr($i).'">Destaque '.esc_html($i+1).'</label></th><td><select id="featured-'.esc_attr($i).'" name="mdr_featured[]"><option value="0">Preencher com publicação recente</option>';
            foreach ($posts as $post) { if (current_user_can('edit_post',$post->ID)) { echo '<option value="'.esc_attr($post->ID).'" '.selected($ids[$i]??0,$post->ID,false).'>'.esc_html($post->post_title.' — '.get_the_date('d/m/Y',$post)).'</option>'; } }
            echo '</select></td></tr>';
        }
        echo '</table>';submit_button('Salvar destaques');echo '</form><p><a href="'.esc_url(home_url('/#blog')).'" target="_blank" rel="noopener">Conferir a home</a></p></div>';
    });
});
add_action('admin_post_mdr_save_featured',function () {
    if (!current_user_can('edit_others_posts')) { wp_die('Sem permissão.',403); }
    check_admin_referer('mdr_featured','mdr_featured_nonce');
    $result=mdr_editorial_save_featured(wp_unslash($_POST['mdr_featured']??[]),wp_unslash($_POST['mdr_featured_version']??''));
    if (is_wp_error($result)) { set_transient('mdr_featured_error_'.get_current_user_id(),$result->get_error_message(),60); }
    wp_safe_redirect(add_query_arg('mdr_result',is_wp_error($result)?'error':'saved',admin_url('edit.php?page=mdr-home-featured')));exit;
});
