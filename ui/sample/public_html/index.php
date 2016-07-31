<?php

header('Access-Control-Allow-Origin: *');
require_once(__DIR__."/../../../vendor/autoload.php");
require_once(__DIR__."/../routes.php");

foreach($routes as $route){
	$routeinfo = $route->toArray();
	Flight::route($routeinfo["path"], $routeinfo["callback"]);
}

Flight::start();
