<?php
if (!defined('ABSPATH')) { exit; }
function mdr_tv_preview_allowed($id){
    $p=get_post($id);
    return $p && $p->post_type==='mdr_tv_item' && $p->post_status!=='trash' && current_user_can('mdr_tv_manage') && current_user_can('edit_post',$id);
}
add_action('admin_menu',function(){add_submenu_page(null,'Prévia editorial da TV','Prévia editorial da TV','mdr_tv_manage','mdr-tv-preview','mdr_tv_preview_page');});
function mdr_tv_preview_page(){
    $id=absint($_GET['item']??0);if(!mdr_tv_preview_allowed($id))wp_die('Conteúdo indisponível.',403);
    $p=get_post($id);$m=(array)get_post_meta($id,'mdr_tv',true);$assets=[];
    foreach((array)($m['assets']??[]) as $asset_id){$a=mdr_tv_asset_info($asset_id);if(!$a)continue;$assets[]=['name'=>$a['name'],'mime'=>$a['mime'],'url'=>add_query_arg('_wpnonce',wp_create_nonce('mdr_tv_preview_asset_'.$asset_id),admin_url('admin-post.php?action=mdr_tv_preview_asset&asset='.$asset_id))];}
    echo '<div class="wrap"><h1>Prévia editorial da TV</h1><p>Última versão salva. Esta prévia não publica o conteúdo nem inicia a TV. O texto completo fica disponível para revisão; a TV o distribui em telas.</p>';
    echo '<p><a class="button" href="'.esc_url(get_edit_post_link($id,'raw')).'">Voltar à edição</a> <strong>'.esc_html($p->post_status==='publish'?'Publicado na programação privada':'Rascunho — fora da programação').'</strong></p>';
    echo '<style>.mdr-tv-preview{display:grid;grid-template-columns:minmax(0,1.1fr) minmax(0,1fr);gap:32px;background:#14273b;color:#edf1f3;padding:32px;border-radius:18px;max-width:1320px;box-sizing:border-box}.mdr-tv-preview h2{font-size:28px;line-height:1.25;color:#fff;margin-top:12px}.mdr-tv-preview p{font-size:17px;line-height:1.7}.mdr-tv-preview figure{margin:0;aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#102234;border-radius:12px;overflow:hidden}.mdr-tv-preview img,.mdr-tv-preview video{max-width:100%;max-height:100%;object-fit:contain}.mdr-tv-preview img[hidden],.mdr-tv-preview video[hidden]{display:none}.mdr-tv-preview footer{color:#ddc58a}.mdr-tv-preview nav{display:flex;gap:14px;align-items:center;margin-top:16px}.mdr-tv-preview figcaption{font-size:13px;overflow-wrap:anywhere}.mdr-tv-preview article{min-width:0}.mdr-tv-campaign-text{grid-template-columns:1fr;min-height:560px;padding:64px}.mdr-tv-campaign-text>div:first-child{display:none}.mdr-tv-campaign-text h2{font-size:44px;max-width:1050px}.mdr-tv-campaign-text .tv-copy{font-size:28px;line-height:1.5;max-width:1050px}.mdr-tv-campaign-art{grid-template-columns:1fr}.mdr-tv-campaign-art>article{display:none}.mdr-tv-campaign-art figure{aspect-ratio:16/9}.mdr-tv-preview .tv-source{color:#ddc58a;font-size:13px}.mdr-tv-preview .tv-copy{white-space:pre-wrap;font-size:17px;line-height:1.7;overflow-wrap:anywhere}@media(max-width:900px){.mdr-tv-preview{grid-template-columns:1fr;padding:20px}.mdr-tv-preview figure{aspect-ratio:16/10}}</style>';
    $mode=($m['format']??'post')==='campaign'?(!$assets?' mdr-tv-campaign-text':(!trim($p->post_content)?' mdr-tv-campaign-art':'')):'';
    echo '<section class="mdr-tv-preview'.esc_attr($mode).'" data-tv-preview data-assets="'.esc_attr(wp_json_encode($assets)).'"><div><figure><img data-tv-image hidden alt="Arquivo da publicação"><video data-tv-video hidden controls preload="metadata"></video><span data-tv-empty>Nenhum arquivo selecionado.</span></figure><nav aria-label="Arquivos da publicação"><button class="button" type="button" data-tv-prev aria-label="Arquivo anterior">‹</button><span data-tv-count></span><button class="button" type="button" data-tv-next aria-label="Próximo arquivo">›</button></nav><figcaption data-tv-name></figcaption></div><article><div class="tv-source">'.esc_html($m['source']??'Material MDR').'</div><h2>'.esc_html($p->post_title).'</h2><div class="tv-copy">'.esc_html(html_entity_decode(wp_strip_all_tags($p->post_content),ENT_QUOTES,'UTF-8')).'</div><footer>'.esc_html($m['credit']??'MDR Advocacia').'</footer></article></section></div>';
    wp_enqueue_script('mdr-tv-preview',plugins_url('mdr-tv/preview.js',dirname(__FILE__).'/../mdr-tv.php'),[],'0.1.0',true);
}
function mdr_tv_preview_range($size,$value){
    if(!$value)return [0,$size-1,false];
    if(!preg_match('/^bytes=(\d*)-(\d*)$/',$value,$m)||($m[1]===''&&$m[2]===''))return null;
    if($m[1]===''){$start=max(0,$size-(int)$m[2]);$end=$size-1;}
    else{$start=(int)$m[1];$end=$m[2]===''?$size-1:min($size-1,(int)$m[2]);}
    return $start>=$size||$end<$start?null:[$start,$end,true];
}
add_action('admin_post_mdr_tv_preview_asset',function(){
    if(!current_user_can('mdr_tv_manage'))wp_die('Sem permissão.',403);
    $id=absint($_GET['asset']??0);check_admin_referer('mdr_tv_preview_asset_'.$id);$a=mdr_tv_asset_info($id);$p=mdr_tv_asset_path($id);
    if(!$a||!is_readable($p)||!in_array($a['mime'],['image/jpeg','image/png','image/webp','video/mp4','audio/mpeg','audio/wav','audio/x-wav'],true))wp_die('Arquivo indisponível.',404);
    $size=filesize($p);$range=mdr_tv_preview_range($size,$_SERVER['HTTP_RANGE']??'');nocache_headers();
    if(!$range){status_header(416);header('Content-Range: bytes */'.$size);exit;}
    [$start,$end,$partial]=$range;status_header($partial?206:200);header('Content-Type:'.$a['mime']);header('X-Content-Type-Options:nosniff');header('Accept-Ranges: bytes');header('Content-Length:'.($end-$start+1));
    if($partial)header('Content-Range: bytes '.$start.'-'.$end.'/'.$size);
    $f=fopen($p,'rb');fseek($f,$start);$left=$end-$start+1;
    while($left&&!feof($f)&&!connection_aborted()){$b=fread($f,min(65536,$left));if($b===false||$b==='')break;echo $b;$left-=strlen($b);}
    fclose($f);exit;
});
