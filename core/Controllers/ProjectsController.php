<?php
declare(strict_types=1);

namespace App\Controllers;

class ProjectsController extends BaseController
{
    public static function index(): void
    {
        $allProjects = sortByOrder(readJson('projects.json'));
        $status = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : null;
        $category = isset($_GET['category']) && $_GET['category'] !== '' ? $_GET['category'] : null;
        $q = trim($_GET['q'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;

        $filtered = filterProjects($allProjects, $status, $category, $q !== '' ? $q : null);
        $paged = paginate($filtered, $page, $perPage);

        $data = [
            'allProjects' => $allProjects,
            'status' => $status,
            'category' => $category,
            'q' => $q,
            'paged' => $paged,
            'categories' => projectCategories($allProjects),
            'pageTitle' => t('projects.title'),
            'pageDescription' => t('meta.projects_desc'),
            'activeNav' => 'projects',
        ];

        self::render('projects', $data, 'projects');
    }
}
