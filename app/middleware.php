<?php
declare(strict_types=1);

use Application\Middleware\SessionMiddleware;
use Pmo\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
};
