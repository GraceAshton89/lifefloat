<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Task\Controller;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();

// Debugging.
$app['debug'] = $isDevMode = true;

$conn = [
    'driver' => 'pdo_pgsql',
    'user' => 'gracecooper',
    'password' => '1234',
    'dbname' => 'lifefloat',
    'host' => 'localhost',
    'port' => '5432',
];

// obtaining the entity manager
// Create a simple "default" Doctrine ORM configuration for Annotations
$doctrineConfig = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/db"), $isDevMode);
$app['entity.manager'] = EntityManager::create($conn, $doctrineConfig);

// Service Registry.
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
