<?php
if (!defined('ABSPATH')) { exit; }

function mdr_blog_filters($input=null) {
    $input=$input??$_GET;
    $term=isset($input['blog_q'])&&is_scalar($input['blog_q'])?sanitize_text_field(wp_unslash($input['blog_q'])):'';
    $category=isset($input['blog_cat'])&&is_scalar($input['blog_cat'])?absint($input['blog_cat']):0;
    $month=isset($input['blog_month'])&&is_scalar($input['blog_month'])?sanitize_text_field(wp_unslash($input['blog_month'])):'';
    if (!preg_match('/^(19|20)\d{2}-(0[1-9]|1[0-2])$/',$month)) { $month=''; }
    return ['term'=>$term,'category'=>$category,'month'=>$month];
}
function mdr_is_blog_query($query) {
    return $query->is_home()||$query->is_category()||$query->is_tag()||$query->is_date()||($query->is_search()&&$query->get('post_type')==='post');
}
function mdr_apply_blog_filters($query,$filters) {
    $query->set('post_type','post');$query->set('post_status','publish');$query->set('has_password',false);
    $query->set('posts_per_page',6);$query->set('ignore_sticky_posts',true);$query->set('orderby',['date'=>'DESC','ID'=>'DESC']);
    if ($filters['term']!=='') { $query->set('s',$filters['term']); }
    if ($filters['category']) { $query->set('cat',$filters['category']); }
    if ($filters['month']) { $query->set('date_query',[['year'=>(int)substr($filters['month'],0,4),'month'=>(int)substr($filters['month'],5,2)]]); }
}
add_action('pre_get_posts',function ($query) {
    if (!is_admin()&&$query->is_main_query()&&mdr_is_blog_query($query)) { mdr_apply_blog_filters($query,mdr_blog_filters()); }
});
function mdr_blog_excerpt($post_id,$limit=500) {
    $post=get_post($post_id);if (!$post) { return ''; }
    $text=trim(preg_replace('/\s+/u',' ',wp_strip_all_tags(strip_shortcodes($post->post_excerpt?:$post->post_content))));
    $excerpt=wp_html_excerpt($text,$limit-1,'');
    return $excerpt===$text?$text:rtrim(preg_replace('/\s+\S*$/u','',$excerpt),' ,;:-').'…';
}
function mdr_blog_author_data($post_id) {
    $result=[];
    if (get_post_meta($post_id,'mdr_blog_byline',true)==='people') {
        foreach (mdr_editorial_author_ids(get_post_meta($post_id,'mdr_blog_authors',true)) as $id) {
            $author=get_post($id);$result[]=['name'=>$author->post_title,'image'=>get_post_thumbnail_id($id),'bio'=>mdr_blog_excerpt($id,400),'url'=>$author->post_type==='mdr_socio'?get_permalink($id):''];
        }
    }
    return $result?:[['name'=>'MDR Advocacia','image'=>0,'bio'=>'Artigos, notícias e reflexões da MDR Advocacia.','url'=>'','institutional'=>true]];
}
function mdr_blog_author_image($author) {
    if (!empty($author['institutional'])) { return '<span class="author-avatar institutional-avatar"><img src="'.esc_url(mdr_asset('logo.png')).'" width="80" height="80" alt="" loading="lazy"></span>'; }
    if ($author['image']) { return '<span class="author-avatar">'.wp_get_attachment_image($author['image'],'thumbnail',['alt'=>'','loading'=>'lazy']).'</span>'; }
    return '<span class="author-avatar author-initial" aria-hidden="true">'.esc_html(wp_html_excerpt($author['name'],1,'')).'</span>';
}
function mdr_blog_byline($id) {
    echo '<div class="blog-byline" aria-label="Autoria">';
    foreach (mdr_blog_author_data($id) as $author) {
        echo '<span class="blog-author">'.mdr_blog_author_image($author).'<span>'.esc_html($author['name']).'</span></span>';
    }
    echo '</div>';
}
function mdr_blog_image($id,$square=false,$listing=false) {
    $attachment=($square||$listing)?mdr_editorial_image_id(get_post_meta($id,$square?'mdr_blog_square':'mdr_blog_strip',true)):0;
    $attachment=$attachment?:get_post_thumbnail_id($id);
    if ($attachment) { echo wp_get_attachment_image($attachment,$square?'medium_large':'large',['loading'=>'lazy','alt'=>'']);return; }
    $cover=get_post_meta($id,'mdr_demo_cover',true);if (!in_array($cover,['negocios.svg','esg.svg','institucional.svg'],true)) { $cover='institucional.svg'; }
    echo '<img src="'.esc_url(mdr_asset($cover)).'" alt="" loading="lazy" width="1200" height="600">';
}
function mdr_home_blog_ids() {
    $ids=mdr_editorial_featured_ids();
    if (count($ids)<4) {
        $recent=get_posts(['post_type'=>'post','post_status'=>'publish','has_password'=>false,'numberposts'=>4-count($ids),'post__not_in'=>$ids,'orderby'=>['date'=>'DESC','ID'=>'DESC'],'ignore_sticky_posts'=>true,'fields'=>'ids']);
        $ids=array_merge($ids,$recent);
    }
    return $ids;
}
function mdr_post_card() {
    $id=get_the_ID(); ?>
    <article class="article-card home-blog-card">
      <a class="cover-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Ler '.get_the_title()); ?>"><?php mdr_blog_image($id,true); ?></a>
      <div class="meta"><span><?php $categories=get_the_category();echo esc_html($categories?$categories[0]->name:'Institucional'); ?></span><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time></div>
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html(mdr_blog_excerpt($id,120)); ?></p>
      <?php mdr_blog_byline($id);if (get_post_meta($id,'mdr_demo',true)) { ?><span class="demo-label">Conteúdo demonstrativo</span><?php } ?>
    </article>
    <?php
}
function mdr_blog_list_entry() {
    $id=get_the_ID(); ?>
    <article class="blog-entry">
      <a class="blog-banner" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Ler '.get_the_title()); ?>"><?php mdr_blog_image($id,false,true); ?></a>
      <div class="blog-entry-meta"><span><?php $cats=get_the_category();echo esc_html($cats?$cats[0]->name:'Institucional'); ?></span><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d \d\e F \d\e Y')); ?></time></div>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php mdr_blog_byline($id); ?>
      <p class="blog-excerpt"><?php echo esc_html(mdr_blog_excerpt($id)); ?></p>
      <a class="blog-read-more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Ler na íntegra: '.get_the_title()); ?>">Ler na íntegra</a>
      <?php if (get_post_meta($id,'mdr_demo',true)) { ?><span class="demo-label">Conteúdo demonstrativo</span><?php } ?>
    </article>
    <?php
}
function mdr_blog_months() {
    global $wpdb;
    return $wpdb->get_results("SELECT YEAR(post_date) AS year, MONTH(post_date) AS month, COUNT(ID) AS total FROM {$wpdb->posts} WHERE post_type='post' AND post_status='publish' AND post_password='' GROUP BY YEAR(post_date),MONTH(post_date) ORDER BY year DESC,month DESC");
}
function mdr_blog_month_label($value) {
    return wp_date('F \d\e Y',mktime(12,0,0,(int)substr($value,5,2),1,(int)substr($value,0,4)));
}
function mdr_blog_sidebar() {
    $filters=mdr_blog_filters();if (!$filters['category']&&is_category()) { $filters['category']=get_queried_object_id(); }
    $months=mdr_blog_months(); ?>
    <aside class="blog-sidebar" aria-label="Pesquisa e arquivo do blog"><details class="blog-filter-panel" open><summary>Pesquisar e explorar</summary><div class="blog-filter-content">
      <form class="blog-search-form" method="get" action="<?php echo esc_url(home_url('/blog/')); ?>" role="search">
        <label for="blog-query">Buscar por assunto</label><input id="blog-query" type="search" name="blog_q" maxlength="200" value="<?php echo esc_attr($filters['term']); ?>" placeholder="Digite uma palavra ou assunto">
        <label for="blog-category">Tema</label><select id="blog-category" name="blog_cat"><option value="0">Todos os temas</option><?php foreach(get_categories(['hide_empty'=>true]) as $cat){ ?><option value="<?php echo esc_attr($cat->term_id); ?>" <?php selected($filters['category'],$cat->term_id); ?>><?php echo esc_html($cat->name); ?></option><?php } ?></select>
        <label for="blog-month">Mês de publicação</label><select id="blog-month" name="blog_month"><option value="">Todos os períodos</option><?php foreach($months as $month){$value=sprintf('%04d-%02d',$month->year,$month->month);?><option value="<?php echo esc_attr($value); ?>" <?php selected($filters['month'],$value); ?>><?php echo esc_html(mdr_blog_month_label($value)); ?></option><?php } ?></select>
        <button type="submit">Pesquisar</button><a class="blog-clear" href="<?php echo esc_url(home_url('/blog/')); ?>">Limpar filtros</a>
      </form>
      <div class="blog-archive"><h2>Arquivo de publicações</h2><?php $grouped=[];foreach($months as $month){$grouped[$month->year][]=$month;}foreach($grouped as $year=>$entries){ ?><details class="blog-archive-year" <?php echo $year===array_key_first($grouped)?'open':''; ?>><summary><?php echo esc_html($year); ?></summary><ul><?php foreach($entries as $month){$value=sprintf('%04d-%02d',$year,$month->month); ?><li><a href="<?php echo esc_url(add_query_arg('blog_month',$value,home_url('/blog/'))); ?>"><?php echo esc_html(wp_date('F',mktime(12,0,0,$month->month,1,$year))); ?><span><?php echo esc_html($month->total); ?></span></a></li><?php } ?></ul></details><?php }if(!$months){echo '<p>As publicações aparecerão aqui por ano e mês.</p>';} ?></div>
    </div></details></aside>
    <?php
}
function mdr_blog_author_bios($id) {
    echo '<section class="blog-author-bios" aria-label="Sobre a autoria"><h2>Sobre a autoria</h2><div>';
    foreach (mdr_blog_author_data($id) as $author) {
        echo '<div class="blog-author-bio">'.mdr_blog_author_image($author).'<div><h3>'.esc_html($author['name']).'</h3><p>'.esc_html($author['bio']).'</p>';
        if ($author['url']) { echo '<a href="'.esc_url($author['url']).'">Conhecer perfil</a>'; }
        echo '</div></div>';
    }
    echo '</div></section>';
}
