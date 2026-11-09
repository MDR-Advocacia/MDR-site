<?php get_header(); ?>
<main id="conteudo"><?php while(have_posts()){the_post();$page=get_post(); ?>
 <article class="section article-page institutional-page institutional-redesign">
  <header class="institutional-hero"><a class="breadcrumb" href="<?php echo esc_url(home_url('/#compromissos')); ?>">Compromissos institucionais</a><p class="eyebrow">MDR Advocacia</p><h1><?php the_title(); ?></h1><?php if(has_excerpt()&&!is_page('pacto-global-gptw')){ ?><p class="page-summary"><?php echo esc_html(get_the_excerpt()); ?></p><?php } ?></header>
  <?php mdr_render_institutional($page); ?>
  <nav class="institutional-links" aria-label="Conteúdo institucional"><a href="<?php echo esc_url(home_url('/#atuacao')); ?>">Áreas de atuação</a><a href="<?php echo esc_url(home_url('/esg/')); ?>">Compromissos institucionais</a><a href="<?php echo esc_url(home_url('/#contato')); ?>">Contato</a></nav>
 </article><?php } ?></main><?php get_footer(); ?>
