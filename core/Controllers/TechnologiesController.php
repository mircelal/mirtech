<?php
declare(strict_types=1);

namespace App\Controllers;

class TechnologiesController extends BaseController
{
    public static function index(): void
    {
        $technologies = sortByOrder(readJson('technologies.json'));
        $q = mb_strtolower(trim($_GET['q'] ?? ''));
        $catFilter = $_GET['cat'] ?? '';

        if ($q !== '') {
            $technologies = array_values(array_filter($technologies, static function ($t) use ($q) {
                $name = localized($t, 'name') ?: ($t['name'] ?? '');
                $hay = mb_strtolower($name . ' ' . techCategoryLabel($t['category'] ?? ''));
                return str_contains($hay, $q);
            }));
        }
        if ($catFilter !== '') {
            $technologies = array_values(array_filter(
                $technologies,
                static fn($t) => ($t['category'] ?? '') === $catFilter
            ));
        }

        $techByCat = [];
        foreach ($technologies as $t) {
            $techByCat[$t['category'] ?? 'web'][] = $t;
        }

        $data = [
            'technologies' => $technologies,
            'techByCat' => $techByCat,
            'catOrder' => techCategoryOrder(),
            'allTech' => sortByOrder(readJson('technologies.json')),
            'q' => $q,
            'catFilter' => $catFilter,
            'pageTitle' => t('tech.title'),
            'pageDescription' => t('meta.tech_desc'),
            'activeNav' => 'tech',
        ];

        self::render('technologies', $data, 'technologies');
    }
}
