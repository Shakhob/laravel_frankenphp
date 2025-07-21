<?php

use Laravel\Octane\ApplicationFactory;
use Laravel\Octane\Server\RoadRunnerServer;

require __DIR__.'/vendor/autoload.php';

$server = new RoadRunnerServer(
    new ApplicationFactory(__DIR__)
);

$server->start();
