<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../src/app.php';

require __DIR__.'/../src/controllers.php';

use Symfony\Component\HttpFoundation\Request as Request;

$app->register(new Silex\Provider\SessionServiceProvider());

$app->run();