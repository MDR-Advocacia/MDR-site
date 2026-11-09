<?php get_header(); ?>
<main id="conteudo" class="digital-card-page"><?php while(have_posts()){the_post();$card=mdr_card_data(get_post()); ?>
 <article class="digital-card">
  <div class="digital-card-photo"><?php mdr_picture(get_the_ID(),'large'); ?></div>
  <div class="digital-card-intro"><a class="breadcrumb" href="<?php echo esc_url(home_url('/#socios')); ?>">Nossos sócios</a><p class="eyebrow"><?php echo esc_html($card['role']); ?></p><h1><?php the_title(); ?></h1><p class="digital-card-summary"><?php echo esc_html(get_the_excerpt()); ?></p><div class="social-links"><?php mdr_social(get_the_ID()); ?></div>
   <div class="digital-card-actions"><a class="button" href="<?php echo esc_url(add_query_arg('mdr_vcard','1',get_permalink())); ?>" download="<?php echo esc_attr(get_post_field('post_name',get_the_ID())); ?>.vcf">Salvar contato</a><button class="button outline" type="button" data-share-card data-url="<?php the_permalink(); ?>" data-title="<?php echo esc_attr(get_the_title().' — MDR Advocacia'); ?>">Compartilhar cartão</button></div><p class="share-status" role="status" aria-live="polite"></p>
  </div>
  <div class="digital-card-contact"><p class="eyebrow"><?php echo $card['personal_contact']?'Contato profissional':'Contato institucional'; ?></p><a href="mailto:<?php echo esc_attr($card['email']); ?>"><?php echo esc_html($card['email']); ?></a><a href="<?php echo esc_url('tel:+'.mdr_phone_digits($card['phone'])); ?>"><?php echo esc_html($card['phone']); ?></a><p><?php echo esc_html(get_option('mdr_matrix')); ?></p></div>
  <section class="digital-card-bio"><p class="eyebrow">Trajetória</p><div class="prose"><?php the_content(); ?></div></section>
 </article><?php } ?></main><?php get_footer(); ?>
