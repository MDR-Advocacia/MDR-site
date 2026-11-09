<?php get_header();$history=mdr_history_data(); ?>
<main id="conteudo" class="history-page">
 <section class="section blog-intro"><a class="breadcrumb" href="<?php echo esc_url(home_url('/#premiacoes')); ?>">Reconhecimentos na home</a><p class="eyebrow">Memória institucional</p><h1>Uma história de<br>reconhecimentos</h1><p>Conquistas, certificações e registros que integram a trajetória da MDR, organizados do mais recente ao mais antigo.</p><p class="history-date-note">Os registros sem data completa estão agrupados pelo ano disponível.</p><nav class="history-nav"><a class="text-link" href="#linha-do-tempo">Linha do tempo</a><a class="text-link" href="#certificados">Galeria de certificados</a></nav></section>
 <section class="section history-timeline" id="linha-do-tempo" aria-label="Histórico em ordem cronológica decrescente">
 <?php $year=null;foreach($history['entries']as $entry){if($entry['year']!==$year){if($year!==null){echo '</div>';} $year=$entry['year'];echo '<div class="history-year"><h2>'.esc_html($year?:'Data a confirmar').'</h2>'; } ?>
  <details class="history-entry"><summary><?php echo esc_html($entry['title']); ?><span>Consultar registro</span></summary><div class="prose history-entry-body"><?php echo str_replace(' ↗','',$entry['html']); ?></div></details>
 <?php }if($year!==null){echo '</div>';} ?>
 </section>
 <section class="section history-certificates" id="certificados"><p class="eyebrow">Acervo documental</p><h2>Certificados para consulta</h2><p>Selecione um documento para ampliar.</p><?php echo $history['certificates']; ?></section>
</main><?php get_footer(); ?>
