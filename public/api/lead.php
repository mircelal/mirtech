<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/core/bootstrap.php';

\App\Controllers\ApiController::dispatch('lead');
