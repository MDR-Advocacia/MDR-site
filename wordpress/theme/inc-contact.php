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
// Current public MDR listing, obtained from Google Maps sharing for the matrix address.
function mdr_contact_map_embed_url() { return 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.926157323864!2d-35.198056199999996!3d-5.8660055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7b2fffbe2a98dd9%3A0x98bfd57aede5e543!2sMDR%20Advocacia!5e0!3m2!1spt-BR!2sbr!4v1794247687982!5m2!1spt-BR!2sbr'; }
