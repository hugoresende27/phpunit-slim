<?php

require '../vendor/autoload.php';

// Run app
$app = (new Pyjac\TodoAPI\App())->get();
$app->run();