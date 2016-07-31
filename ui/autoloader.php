<?php

require_once(__DIR__."/../domain/autoloader.php");
require_once(__DIR__."/../infra/autoloader.php");

spl_autoload_register(
	function($classname){
		$classname = str_replace("\\", "/", $classname);
		$path = __DIR__."/".$classname.".php";
		if(file_exists($path)){
			require_once($path);
		}
	}
);
