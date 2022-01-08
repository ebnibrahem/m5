<?php
require_once 'app/init.php';

$url = $_GET['url'];

$app_args = [
   "url"    => $url,
   "status" => 1,
];

/*Runing Application*/
M5\MVC\App::play($app_args);

/* Use RESTful Route rules */
// M5\MVC\APP::API($app_args);
