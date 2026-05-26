<?php
declare(strict_types=1);

namespace App\Controllers;

class CalculatorController extends BaseController
{
    public static function index(): void
    {
        $data = [
            'pageTitle' => t('calc.title'),
            'pageDescription' => t('meta.calc_desc'),
            'activeNav' => 'calculator',
            'bodyClass' => 'calc-app-mode',
            'extraScripts' => [assetVersion('assets/js/calculator.js')],
            'calcI18nJson' => json_encode(calcLangPack(), JSON_UNESCAPED_UNICODE),
        ];

        self::render('calculator', $data, 'calculator');
    }
}
