<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput as ConsoleOutput;

/*
 * Code inspired by https://github.com/javiereguiluz/EasyAdminBundle
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 */
$file = __DIR__.'/../vendor/autoload.php';

if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies using Composer to run the test suite.');
}

$autoload = require $file;

AnnotationRegistry::registerLoader(function ($class) use ($autoload) {
    $autoload->loadClass($class);

    return class_exists($class, false);
});

include __DIR__.'/../app/AppKernel.php';

if(file_exists(__DIR__.'/../var/test-data.sqlite')) {
    unlink(__DIR__.'/../var/test-data.sqlite');
}

$application = new Application(new AppKernel('test', true));
$application->setAutoExit(false);
$application->setCatchExceptions(false);

// Create database
$input = new ArrayInput(array('command' => 'doctrine:database:create'));
try {
    $x = $application->run($input, new ConsoleOutput());
} catch(Exception $e) {
    echo 'Error on `doctrine:database:create`';
    exit;
}

// Create database schema
$input = new ArrayInput(array('command' => 'doctrine:schema:create'));
try {
    $application->run($input, new ConsoleOutput());
} catch(Exception $e) {
    echo 'Error on `doctrine:schema:create`';
    exit;
}

// Load fixtures of the AppTestBundle
$input = new ArrayInput(array('command' => 'doctrine:fixtures:load', '--no-interaction' => true, '--append' => false));
try {
    $application->run($input, new ConsoleOutput());
} catch(Exception $e) {
    echo 'Error on `doctrine:fixtures:load`';
    exit;
}

unset($input, $application);