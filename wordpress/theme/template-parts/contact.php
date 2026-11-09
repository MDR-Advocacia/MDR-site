<?php if (!defined('ABSPATH')) { exit; } ?>
<section class="section contact contact-unified" id="contato" aria-labelledby="contact-title">
 <div class="contact-heading"><p class="eyebrow">Contato</p><h2 id="contact-title">Vamos conversar</h2></div>
 <div class="contact-addresses">
  <h3>Matriz</h3><p><?php echo esc_html(get_option('mdr_matrix')); ?><br>CEP <?php echo esc_html(get_option('mdr_postal_code')); ?></p>
  <h3>Filial</h3><p><?php echo esc_html(get_option('mdr_branch')); ?></p>
  <p class="contact-hours"><?php echo esc_html(get_option('mdr_hours')); ?></p>
 </div>
 <div class="contact-links" aria-label="Canais de contato">
  <a href="mailto:<?php echo esc_attr(get_option('mdr_email')); ?>"><?php echo esc_html(get_option('mdr_email')); ?></a>
  <?php foreach (mdr_contact_numbers() as $number) { $digits=mdr_phone_digits($number['value']);if (!$digits) { continue; }$label=mdr_format_phone($number['value']); ?>
   <a <?php if ($number['whatsapp']) { ?>class="contact-whatsapp" aria-label="<?php echo esc_attr('WhatsApp: '.$label); ?>" target="_blank" rel="noopener noreferrer"<?php } ?> href="<?php echo esc_url($number['whatsapp']?'https://wa.me/'.$digits:'tel:+'.$digits); ?>"><?php if ($number['whatsapp']) { ?><svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><use href="<?php echo esc_url(mdr_asset('social-icons.svg#whatsapp')); ?>"></use></svg><?php } ?><?php echo esc_html($label); ?></a>
  <?php } ?>
 </div>
 <div class="contact-map" data-contact-map>
  <div class="map-frame" data-map-frame>
   <div class="map-placeholder">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
    <p>Encontre a nossa matriz</p><button type="button" data-map-load data-map-src="<?php echo esc_url(mdr_contact_map_embed_url()); ?>" aria-describedby="map-notice">Carregar mapa do Google</button>
   </div>
  </div>
  <p class="map-notice" id="map-notice">O mapa só se conecta ao Google quando você clicar para carregar.</p>
  <a class="map-route" href="<?php echo esc_url(get_option('mdr_maps')); ?>" target="_blank" rel="noopener noreferrer">Ver rotas no Google Maps</a>
  <noscript><p>Ative o JavaScript para abrir o mapa nesta página ou use o link de rotas.</p></noscript>
 </div>
</section>
