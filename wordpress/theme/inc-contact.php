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

function mdr_contact_location_url($unit) {
    if ($unit==='matrix') { return get_option('mdr_maps'); }
    return 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(get_option('mdr_branch'));
}
function mdr_contact_icon($name) {
    $paths=[
        'phone'=>'<path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 3.1 5.2 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.9a2 2 0 0 1-.5 2.1l-1.3 1.3a16 16 0 0 0 4.8 4.8l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.9.6 2.9.7A2 2 0 0 1 22 16.9Z"/>',
        'pin'=>'<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
    ];
    if (!isset($paths[$name])) { return ''; }
    return '<svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'.$paths[$name].'</svg>';
}
