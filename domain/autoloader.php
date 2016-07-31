<?php

require_once(__DIR__."/../common/autoloader.php");

spl_autoload_register(
	function($classname){
		$classname = str_replace("\\", "/", $classname);
		$classname = str_replace("domain/", "", $classname);
		$path = __DIR__."/".$classname.".php";
		if(file_exists($path)){
			require_once($path);
		}
	}
);

