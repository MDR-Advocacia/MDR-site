<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<a class="skip" href="#conteudo">Pular para o conteúdo</a>
<div class="preview"><span><i aria-hidden="true"></i>Prévia privada · MDR Advocacia</span><a href="https://mdradvocacia.com" target="_blank" rel="noopener">Visitar site atual</a></div>
<header class="site-header">
 <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="MDR Advocacia — início"><img src="<?php echo esc_url(mdr_asset('logo.png')); ?>" width="240" height="103" alt="MDR Advocacia"></a>
 <div class="header-navigation">
  <button class="menu-toggle" aria-expanded="false" aria-controls="menu-principal">Menu <span aria-hidden="true">☰</span></button>
  <nav id="menu-principal" aria-label="Principal">
   <?php wp_nav_menu(['theme_location'=>'primary', 'container'=>false, 'items_wrap'=>'<ul class="site-menu">%3$s</ul>', 'depth'=>1, 'fallback_cb'=>'mdr_primary_fallback', 'mdr_glass_header'=>true]); ?>
  </nav>
 </div>
 <a class="header-contact" href="<?php echo esc_url(home_url('/#contato')); ?>"><span aria-hidden="true"></span>Contato</a>
</header>
