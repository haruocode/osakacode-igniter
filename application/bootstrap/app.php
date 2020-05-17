<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 1/2/2016
 * Time: 5:34 PM
 */
use DI\ContainerBuilder;
require __DIR__ . '/../../vendor/autoload.php';
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
$container = $containerBuilder->build();
return $container;