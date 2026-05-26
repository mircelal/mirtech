<?php
declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    protected static function render(string $page, array $data, string $pageType = 'page'): void
    {
        if (!isset($data['seo'])) {
            $data = applySeo($data, $pageType);
        }
        view('layouts/header', $data);
        view('pages/' . $page, $data);
        view('layouts/footer', $data);
    }
}
