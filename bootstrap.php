<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$containerBuilder = new ContainerBuilder();

// definindo as configuracoes no container
$settings = require __DIR__ . '/config/settings.php';
$containerBuilder->addDefinitions($settings);

$container = $containerBuilder->build();

// inserindo o entity manager no container
require __DIR__.'/config/doctrine.php';
$entityManager = getEntityManager($container);
$container->set('em', $entityManager);

$app = AppFactory::createFromContainer($container);

require_once "routes.php";
