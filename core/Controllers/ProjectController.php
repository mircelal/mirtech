<?php
declare(strict_types=1);

namespace App\Controllers;

class ProjectController extends BaseController
{
    public static function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $project = $id > 0 ? getProjectById($id) : null;

        if (!$project) {
            http_response_code(404);
            $data = applySeo([
                'pageTitle' => t('project.not_found'),
                'pageDescription' => t('meta.error_desc'),
                'activeNav' => 'projects',
                'seoNoindex' => true,
            ], 'error');
            view('layouts/header', $data);
            view('pages/project-not-found', $data);
            view('layouts/footer', $data);
            return;
        }

        $data = [
            'project' => $project,
            'techs' => resolveProjectTechnologies($project),
            'timeline' => localizedTimeline($project),
            'stats' => localizedStats($project),
            'features' => localizedList($project, 'features'),
            'pName' => localized($project, 'name'),
            'pDesc' => localized($project, 'desc'),
            'pOverview' => localized($project, 'overview'),
            'pCategory' => localized($project, 'category'),
            'pDuration' => localized($project, 'duration'),
            'related' => relatedProjects($project),
            'status' => $project['status'] ?? 'ongoing',
            'img' => trim($project['image'] ?? ''),
            'pageTitle' => localized($project, 'name'),
            'pageDescription' => localized($project, 'desc'),
            'activeNav' => 'projects',
            'extraScripts' => [assetVersion('assets/js/project-detail.js')],
            'extraStyles' => [assetVersion('assets/css/project-detail.css')],
        ];

        self::render('project', $data, 'project');
    }
}
