<?php
declare(strict_types=1);

use App\Application\Actions\Pdf\GenerateAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/pdf', function (Group $group) {
        $group->get('/generate', GenerateAction::class);
    });
};
