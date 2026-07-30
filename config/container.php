<?php

use Atlas\Container;

$container = new Container();

$services = require __DIR__ . '/services.php';

$services($container);

return $container;