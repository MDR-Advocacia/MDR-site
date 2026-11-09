<?php
if (!defined('ABSPATH')) { exit; }

function mdr_home_nav_items() {
    return ['Reconhecimentos'=>'premiacoes','Blog'=>'blog','Sócios'=>'socios','Compromissos'=>'compromissos','Atuação'=>'atuacao','O que nos orienta'=>'orienta'];
}
function mdr_home_icon() {
    return '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true" focusable="false"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/></svg>';
}
function mdr_layout_content($post) {
    $blocks = parse_blocks($post->post_content);
    if ($post->post_name === 'recuperacao-credito') {
        $kept=[];
        foreach ($blocks as $b) {
            if ($b['blockName'] === 'core/heading' && str_contains(wp_strip_all_tags($b['innerHTML']), 'Conheça a liderança')) { break; }
            if ($b['blockName'] !== 'core/image') { $kept[]=$b; }
        }
        $blocks=$kept;
    }
    return str_replace([' ↗','↗'], '', apply_filters('the_content', serialize_blocks($blocks)));
}
function mdr_award_visual($post) {
    $samples=['award-panama'=>'trofeu-laqi-transparente.webp','award-fenalaw2025'=>'trofeu-fenalaw-transparente.webp'];
    if (isset($samples[$post->post_name]) && file_exists(__DIR__.'/assets/'.$samples[$post->post_name])) {
        $url=mdr_asset($samples[$post->post_name]);
        return '<span class="trophy-cutout" style="--trophy-mask:url('.esc_url($url).')"><img src="'.esc_url($url).'" alt="'.esc_attr($post->post_title).'" width="1280" height="1280" loading="lazy"></span>';
    }
    return '<span class="'.($post->post_name==='award-gptw-2026'?'official-badge':'trophy-studio').'">'.get_the_post_thumbnail($post,'large',['loading'=>'lazy']).'</span>';
}
function mdr_detail_dialog($post, $kind='award') {
    $id='detail-'.$post->ID;
    $image=$kind==='award'?mdr_award_visual($post):'';
    $label=$kind==='award'?get_post_meta($post->ID,'mdr_subtitle',true):'Área de atuação';
    ?>
    <dialog class="partner-dialog detail-dialog <?php echo $kind==='award'?'award-dialog':'practice-dialog'; ?>" id="<?php echo esc_attr($id); ?>" aria-labelledby="<?php echo esc_attr($id); ?>-title">
      <button class="dialog-close" type="button" data-dialog-close aria-label="Fechar detalhes" autofocus><span aria-hidden="true">×</span></button>
      <div class="detail-dialog-layout">
       <?php if($image){ ?><div class="detail-visual"><?php echo $image; ?></div><?php } ?>
       <div class="detail-copy"><p class="eyebrow"><?php echo esc_html($label); ?></p><h2 id="<?php echo esc_attr($id); ?>-title"><?php echo esc_html($post->post_title); ?></h2><div class="prose"><?php echo mdr_layout_content($post); ?></div></div>
      </div>
    </dialog>
    <?php
}
function mdr_recognition_section() {
    $awards=get_posts(['post_type'=>'mdr_premio','post_status'=>'publish','numberposts'=>-1,'orderby'=>'menu_order title','order'=>'ASC']);
    ?>
    <section class="section recognition recognition-showcase" id="premiacoes" aria-labelledby="recognition-title">
      <div class="section-heading"><div><p class="eyebrow">Reconhecimentos institucionais</p><h2 id="recognition-title">Uma trajetória reconhecida</h2></div><a class="button outline" href="<?php echo esc_url(get_post_type_archive_link('mdr_premio')); ?>">Histórico e certificados</a></div>
      <div class="award-carousel" data-award-carousel role="region" aria-roledescription="carrossel" aria-label="Reconhecimentos da MDR">
        <div class="carousel-toolbar"><p>Conquistas que fazem parte da nossa história.</p><div class="carousel-controls"><button type="button" data-carousel-prev aria-label="Reconhecimentos anteriores">Anterior</button><span data-carousel-position aria-live="off"></span><button type="button" data-carousel-next aria-label="Próximos reconhecimentos">Próximo</button><button type="button" data-carousel-toggle aria-pressed="false">Pausar apresentação</button></div></div>
        <div class="award-track" tabindex="0" aria-label="Lista de reconhecimentos; deslize para explorar">
        <?php foreach($awards as $i=>$award){ ?>
          <article class="award-card" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr(($i+1).' de '.count($awards)); ?>">
            <a class="award-image" href="<?php echo esc_url(get_permalink($award)); ?>" data-profile-dialog="detail-<?php echo esc_attr($award->ID); ?>" aria-label="Conhecer <?php echo esc_attr($award->post_title); ?>"><?php echo mdr_award_visual($award); ?></a>
            <p class="eyebrow"><?php echo esc_html(get_post_meta($award->ID,'mdr_subtitle',true)); ?></p><h3><a href="<?php echo esc_url(get_permalink($award)); ?>" data-profile-dialog="detail-<?php echo esc_attr($award->ID); ?>"><?php echo esc_html($award->post_title); ?></a></h3>
          </article>
        <?php } ?>
        </div>
      </div>
      <?php foreach($awards as $award){mdr_detail_dialog($award);} ?>
    </section>
    <?php
}
function mdr_commitment_cards() {
    $cards=[['diversidade','01 / PESSOAS','Diversidade e inclusão','Conheça o comitê, o manifesto e as frentes de atuação.'],['compliance-e-privacidade','02 / INTEGRIDADE','Ética e compliance','Programa de integridade e documentos para colaboradores, parceiros e fornecedores.'],['privacidade','03 / PROTEÇÃO DE DADOS','Privacidade','Informações, documentos e canal de contato da Encarregada.'],['pacto-global-gptw','04 / COMPROMISSO GLOBAL','Pacto Global','Nossa participação e os princípios que orientam esse compromisso.']];
    echo '<div class="commitment-portal">';
    foreach($cards as [$slug,$number,$title,$text]) {echo '<a class="commitment-card" href="'.esc_url(home_url('/'.$slug.'/')).'"><span class="eyebrow">'.esc_html($number).'</span><h3>'.esc_html($title).'</h3><p>'.esc_html($text).'</p><span class="text-link">Conhecer compromisso</span></a>';}
    echo '</div>';
}
function mdr_sections_from_blocks($post) {
    $sections=[];$current=['title'=>'Apresentação','body'=>''];
    foreach(parse_blocks($post->post_content) as $block){
        if($block['blockName']==='core/heading' && ($block['attrs']['level']??2)===2){
            if(trim($current['body'])){$sections[]=$current;}
            $current=['title'=>wp_strip_all_tags($block['innerHTML']),'body'=>''];
        }else{$current['body'].=render_block($block);}
    }
    if(trim($current['body'])){$sections[]=$current;}
    return $sections;
}
function mdr_document_extract($html) {
    $docs=[];
    $clean=preg_replace_callback('~<p\b[^>]*>.*?</p>~si',function($m)use(&$docs){
        if(!preg_match('~href=["\']([^"\']+\.pdf(?:\?[^"\']*)?)["\']~i',$m[0],$url)){return $m[0];}
        preg_match('~<strong[^>]*>(.*?)</strong>~si',$m[0],$title);
        $name=isset($title[1])?wp_strip_all_tags($title[1]):urldecode(basename(wp_parse_url(html_entity_decode($url[1]),PHP_URL_PATH)));
        $docs[html_entity_decode($url[1])]=['title'=>$name,'url'=>html_entity_decode($url[1])];return '';
    },$html);
    return ['html'=>$clean,'documents'=>$docs];
}
function mdr_render_document_cards($docs) {
    if(!$docs){return;}
    echo '<section class="document-library" aria-labelledby="document-library-title"><p class="eyebrow">Consulta e transparência</p><h2 id="document-library-title">Documentos institucionais</h2><div class="document-grid">';
    foreach($docs as $doc){echo '<article class="document-card"><span class="document-type">PDF</span><h3>'.esc_html($doc['title']).'</h3><div><a href="'.esc_url($doc['url']).'" target="_blank" rel="noopener">Consultar documento</a><a href="'.esc_url($doc['url']).'" download>Baixar PDF</a></div></article>';}
    echo '</div></section>';
}
function mdr_render_institutional($post) {
    if($post->post_name==='esg') {
        echo '<p class="institutional-lead">Conheça os compromissos da MDR, as iniciativas relacionadas à nossa atuação e os documentos disponíveis para consulta.</p>';
        mdr_commitment_cards();
        echo '<div class="institutional-bottom-note"><h2>Informação acessível, compromisso contínuo</h2><p>Os documentos e canais estão organizados por assunto para facilitar a consulta.</p><a class="text-link" href="'.esc_url(home_url('/#orienta')).'">Conheça o que nos orienta</a></div>';
        return;
    }
    if($post->post_name==='pacto-global-gptw') {
        $content=$post->post_content;
        preg_match('~<img[^>]+src="([^"]+)"[^>]+alt="Logo de participante[^"]*"[^>]*>~i',$content,$logo);
        echo '<div class="pacto-layout"><div class="prose"><p class="eyebrow">Participação institucional</p><h2>Dez Princípios, um compromisso compartilhado</h2>';
        // Reuse only the approved-origin Pacto paragraphs, not the adjacent GPTW assets.
        $started=false;
        foreach(parse_blocks($content)as $b){
            $plain=wp_strip_all_tags($b['innerHTML']);
            if($b['blockName']==='core/heading'&&str_contains($plain,'Participante do Pacto Global')){$started=true;continue;}
            if($started&&$b['blockName']==='core/image'){break;}
            if($started){echo render_block($b);}
        }
        echo '<a class="text-link" href="https://unglobalcompact.org/what-is-gc/mission/principles" target="_blank" rel="noopener">Conheça os Dez Princípios</a></div>';
        if(!empty($logo[1])){echo '<figure class="participant-mark"><img src="'.esc_url($logo[1]).'" alt="Pacto Global da ONU — participante 2026" loading="lazy"><figcaption>A participação expressa compromisso com os princípios da iniciativa; não representa certificação ou endosso aos serviços do escritório.</figcaption></figure>';}
        echo '</div><p class="preview-editorial-note">Prévia para avaliação: o vínculo com a Comunicação de Progresso será incluído após validação da documentação correspondente.</p>';
        return;
    }
    $html=mdr_layout_content($post);$extracted=mdr_document_extract($html);
    if(in_array($post->post_name,['compliance-e-privacidade','privacidade'],true)) {
        mdr_render_document_cards($extracted['documents']);
        echo '<div class="institutional-reading"><aside><span class="eyebrow">Informação institucional</span><h2>'.($post->post_name==='privacidade'?'Seus dados, seus direitos':'Integridade em cada relação').'</h2><p>Consulte os documentos e conheça os canais responsáveis por cada assunto.</p><a class="text-link" href="mailto:'.esc_attr(get_option('mdr_dpo_email')).'">Falar com a Encarregada</a></aside><div class="institutional-sections">';
        $sections=mdr_sections_from_blocks($post);
        foreach($sections as $i=>$section){$body=mdr_document_extract($section['body'])['html'];if(!trim(wp_strip_all_tags($body))){continue;}echo '<details'.($i===0?' open':'').'><summary>'.esc_html($section['title']).'</summary><div class="prose">'.str_replace(' ↗','',$body).'</div></details>';}
        echo '</div></div><p class="preview-editorial-note">Organização apresentada para avaliação interna. A atualização dos avisos e das políticas para as futuras integrações será revisada pela DPO.</p>';
        return;
    }
    echo '<div class="prose">'.$html.'</div>';
}
function mdr_history_data() {
    $page=get_page_by_path('certificados',OBJECT,'page');$entries=[];$certificates='';$order=0;
    if(!$page){return ['entries'=>[],'certificates'=>''];}
    $walk=function($blocks)use(&$walk,&$entries,&$certificates,&$order){
        foreach($blocks as $b){$class=$b['attrs']['className']??'';
            if(str_contains($class,'recognition-history-card')){
                $html=render_block($b);preg_match('~<h3[^>]*>(.*?)</h3>~si',$html,$match);$title=html_entity_decode(wp_strip_all_tags($match[1]??'Reconhecimento institucional'));
                preg_match('~\b(20\d{2})\b~',$title,$year);$year=(int)($year[1]??0);
                // Old certification artwork is not displayed as a current badge.
                if(preg_match('~Great Place|GPTW~i',$title)&&$year&&$year<2026){$html=preg_replace('~<figure\b.*?</figure>~si','',$html);}
                $entries[]=['title'=>$title,'year'=>$year,'html'=>$html,'order'=>$order++];
            }elseif(str_contains($class,'certificate-grid')){$certificates.=render_block($b);}
            elseif(!empty($b['innerBlocks'])){$walk($b['innerBlocks']);}
        }
    };
    $walk(parse_blocks($page->post_content));
    $normalize=function($title){return preg_replace('/[^a-z0-9]/','',strtolower(remove_accents(html_entity_decode($title))));};
    $seen=[];foreach($entries as $entry){$seen[$normalize($entry['title'])]=true;}
    foreach(get_posts(['post_type'=>'mdr_premio','post_status'=>'publish','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC'])as $award){
        $title=$award->post_title;$key=$normalize($title);
        $aliases=['award-gptw-2026'=>'Great Place To Work 2026','award-fenalaw2025'=>'Ouro - Categoria Gestão','award-gptw'=>'AB2L Infinite De Inovação Jurídica 2025','award-fenalaw'=>'AB2L Infinite De Inovação Jurídica 2024'];
        if(isset($seen[$key])||(isset($aliases[$award->post_name])&&isset($seen[$normalize($aliases[$award->post_name])]))){continue;}
        $year=(int)get_post_meta($award->ID,'mdr_year',true);if(!$year&&preg_match('/\b(20\d{2})\b/',$title,$m)){$year=(int)$m[1];}
        $html='<div class="history-award-visual">'.mdr_award_visual($award).'</div><h3>'.esc_html($title).'</h3><p>'.esc_html(get_post_meta($award->ID,'mdr_subtitle',true)).'</p>'.mdr_layout_content($award);
        $entries[]=['title'=>$title,'year'=>$year,'html'=>$html,'order'=>$order++];$seen[$key]=true;
    }
    usort($entries,function($a,$b){return ($b['year']<=>$a['year'])?:($a['order']<=>$b['order']);});
    return ['entries'=>$entries,'certificates'=>$certificates];
}
function mdr_card_data($post) {
    $email=sanitize_email(get_post_meta($post->ID,'mdr_email',true));$phone=get_post_meta($post->ID,'mdr_phone',true);
    return ['name'=>get_the_title($post),'role'=>get_post_meta($post->ID,'mdr_role',true),'email'=>$email?:sanitize_email(get_option('mdr_email')),'phone'=>$phone?:get_option('mdr_phone'),'personal_contact'=>(bool)($email||$phone),'url'=>get_permalink($post)];
}
add_action('template_redirect',function(){
    if(is_page('about')){wp_safe_redirect(home_url('/#orienta'),302);exit;}
    if(!is_singular('mdr_socio')||($_GET['mdr_vcard']??'')!=='1'){return;}
    $post=get_queried_object();if($post->post_status!=='publish'){return;}$d=mdr_card_data($post);
    $escape=function($text){return str_replace(["\\","\r","\n",';',','],["\\\\",'',"\\n","\\;","\\,"],wp_strip_all_tags($text));};
    $lines=['BEGIN:VCARD','VERSION:4.0','FN:'.$escape($d['name']),'ORG:MDR Advocacia','TITLE:'.$escape($d['role']),'EMAIL;TYPE=work:'.$escape($d['email']),'TEL;TYPE=work;VALUE=uri:tel:+'.mdr_phone_digits($d['phone']),'URL:'.$d['url'],'END:VCARD'];
    $fold=[];foreach($lines as $line){while(strlen($line)>75){$part=mb_strcut($line,0,75,'UTF-8');$fold[]=$part;$line=' '.substr($line,strlen($part));}$fold[]=$line;}
    nocache_headers();header('Content-Type: text/vcard; charset=utf-8');header('Content-Disposition: attachment; filename="'.sanitize_file_name($post->post_name).'.vcf"');echo implode("\r\n",$fold)."\r\n";exit;
},4);
add_filter('the_title',function($title,$id){if(!is_admin()&&is_page('pacto-global-gptw')&&(int)$id===get_queried_object_id()){return 'Pacto Global';}return $title;},9,2);
