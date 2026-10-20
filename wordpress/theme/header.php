<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<a class="skip" href="#conteudo">Pular para o conteúdo</a>
<div class="preview"><span><i aria-hidden="true"></i>Prévia privada · MDR Advocacia</span><a href="https://mdradvocacia.com" target="_blank" rel="noopener">Visitar site atual ↗</a></div>
<header class="site-header">
 <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="MDR Advocacia — início"><img src="<?php echo esc_url(mdr_asset('logo.png')); ?>" width="240" height="103" alt="MDR Advocacia"></a>
 <button class="menu-toggle" aria-expanded="false" aria-controls="menu-principal">Menu <span aria-hidden="true">☰</span></button>
 <nav id="menu-principal" aria-label="Principal">
  <a href="<?php echo esc_url(home_url('/#escritorio')); ?>">O escritório</a>
  <a href="<?php echo esc_url(home_url('/#socios')); ?>">Sócios</a>
  <a href="<?php echo esc_url(home_url('/reconhecimentos/')); ?>">Reconhecimentos</a>
  <a href="<?php echo esc_url(home_url('/#compromissos')); ?>">Compromissos</a>
  <a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a>
  <a href="<?php echo esc_url(home_url('/#contato')); ?>">Contato</a>
 </nav>
</header>
