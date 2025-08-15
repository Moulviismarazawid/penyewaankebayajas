<?php
function generate_invoice_code(): string {
    return 'INV' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)),0,6));
}
function wa_link(string $phone, string $text): string {
    $digits = preg_replace('/\D/','',$phone);
    return 'https://wa.me/' . $digits . '?text=' . urlencode($text);
}
