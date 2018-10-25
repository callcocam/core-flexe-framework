<?php

$loader = require __DIR__ . "/vendor/autoload.php";

$loader->addPsr4('App\\', sprintf('%s/%ssrc/', __DIR__,__APP_PROJECT__));

return $loader;
