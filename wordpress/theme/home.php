<?php get_header();$filters=mdr_blog_filters(); ?>
<main id="conteudo" class="blog-classic">
  <section class="section blog-heading"><p class="eyebrow">MDR em perspectiva</p><h1><?php echo is_category()?esc_html(single_cat_title('',false)):'Blog'; ?></h1><p>Artigos, notícias e reflexões da MDR Advocacia.</p></section>
  <div class="section blog-layout"><div class="blog-posts">
    <?php if($filters['term']||$filters['category']||$filters['month']||is_search()){ ?><p class="blog-results" role="status"><?php global $wp_query;echo esc_html(sprintf(_n('%s publicação encontrada','%s publicações encontradas',$wp_query->found_posts),number_format_i18n($wp_query->found_posts))); ?></p><?php } ?>
    <?php if(have_posts()){while(have_posts()){the_post();mdr_blog_list_entry();}}else{ ?><div class="blog-empty"><h2>Nenhuma publicação encontrada</h2><p>Tente outro assunto ou amplie o período da pesquisa.</p><a class="blog-read-more" href="<?php echo esc_url(home_url('/blog/')); ?>">Ver todas as publicações</a></div><?php } ?>
    <?php the_posts_pagination(['prev_text'=>'Página anterior','next_text'=>'Próxima página','mid_size'=>2]); ?>
  </div><?php mdr_blog_sidebar(); ?></div>
</main><?php get_footer(); ?>
