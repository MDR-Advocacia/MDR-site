<?php
if (!defined('ABSPATH')) { exit; }
function mdr_jobs_url() { return 'https://vagas.quarkrh.com.br/httpsmdradvocaciacom'; }
function mdr_format_phone($value) {
    $digits=preg_replace('/\D+/','',(string)$value);
    if (str_starts_with($digits,'55') && in_array(strlen($digits),[12,13],true)) { $digits=substr($digits,2); }
    if (preg_match('/^(\d{2})(\d{4,5})(\d{4})$/',$digits,$parts)) { return '('.$parts[1].') '.$parts[2].'-'.$parts[3]; }
    return (string)$value;
}
function mdr_contact_numbers() {
    return [
        ['value'=>get_option('mdr_phone'),'whatsapp'=>false],
        ['value'=>get_option('mdr_phone_secondary','84 2040-1566'),'whatsapp'=>false],
        ['value'=>get_option('mdr_whatsapp'),'whatsapp'=>true],
    ];
}
// Reuse the matrix embed already present in the original MDR site.
function mdr_contact_map_embed_url() { return 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.037437207656!2d-35.1980595!3d-5.866003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7b2ff467975d4b5%3A0x46d31a58d103d69a!2sMDR%20ADVOCACIA!5e0!3m2!1spt-BR!2sbr!4v1700000000000!5m2!1spt-BR!2sbr'; }
