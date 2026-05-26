<?php
declare(strict_types=1);

namespace App\Controllers;

class HomeController extends BaseController
{
    public static function index(): void
    {
        $settings = getSettingsLocalized();
        $limits = homepageLimits();
        $projects = sortByOrder(readJson('projects.json'));
        $services = sortByOrder(readJson('services.json'));
        $technologies = sortByOrder(readJson('technologies.json'));
        $sc = siteContact();

        $data = [
            'settings' => $settings,
            'waLink' => $sc['whatsapp_link'],
            'featuredProjects' => getFeaturedItems($projects, $limits['projects']),
            'featuredServices' => getFeaturedItems($services, $limits['services']),
            'featuredTech' => getFeaturedItems($technologies, $limits['technologies']),
            'totalProjects' => count($projects),
            'totalTech' => count($technologies),
            'pageTitle' => $settings['site_name'] ?? t('site.name'),
            'pageDescription' => t('meta.home_desc'),
            'activeNav' => 'home',
        ];

        self::render('home', $data, 'home');
    }
}
