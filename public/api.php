<?php
declare(strict_types=1);

require dirname(__DIR__) . '/core/bootstrap.php';

\App\Controllers\ApiController::dispatch($_GET['action'] ?? $_POST['action'] ?? 'lead');
