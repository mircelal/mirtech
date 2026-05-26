<?php
declare(strict_types=1);

/** Versiyalı asset URL (uzunmüddətli cache + təhlükəsiz bust). */
function assetVersion(string $path): string
{
    $rel = ltrim(str_replace('\\', '/', $path), '/');
    $full = PUBLIC_PATH . '/' . $rel;
    $url = asset($rel);
    if (is_file($full)) {
        return $url . '?v=' . filemtime($full);
    }
    return $url;
}

/** CSS-i render-blocking olmadan yüklə. */
function perfAsyncStylesheet(string $href): string
{
    $href = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
    return '<link rel="preload" href="' . $href . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">'
        . '<noscript><link rel="stylesheet" href="' . $href . '"></noscript>';
}

function perfPageUsesDevicon(string $pageType): bool
{
    return in_array($pageType, ['home', 'technologies', 'project'], true);
}

function perfPreconnectHints(bool $devicon, bool $fonts, bool $fontawesome): string
{
    $html = '';
    if ($fonts) {
        $html .= '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        $html .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    }
    if ($fontawesome) {
        $html .= '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>' . "\n";
    }
    if ($devicon) {
        $html .= '<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">' . "\n";
    }
    return $html;
}
