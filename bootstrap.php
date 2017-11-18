<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Task\Controller;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    return $twig;
});


$app->get('/', function(){
	return new Symfony\Component\HttpFoundation\Response("Hello world");
});

$app->mount("/tasks", new Task\Controller());

$app->run();
