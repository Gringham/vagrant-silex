<?php
use Symfony\Component\HttpFoundation\Request;

$app->get('/home', function () use ($app) {
    return $app['templating']->render(
        'home.html.php',
        array('active' => 'home')
    );
});

$app->get('/blog', function () use ($app) {
    return $app['templating']->render(
        'blog.html.php',
        array('active' => 'blog')
    );
});

$app->get('/new ', function () use ($app) {
    return $app['templating']->render(
        'new.html.php',
        array('active' => 'new')
    );
});