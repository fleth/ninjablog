<?php

spl_autoload_register(
	function($classname){
		$classname = str_replace("\\", "/", $classname);
		$classname = str_replace("common/", "", $classname);
		$path = __DIR__."/".$classname.".php";
		if(file_exists($path)){
			require_once($path);
		}
	}
);

