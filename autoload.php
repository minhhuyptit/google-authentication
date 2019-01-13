<?php 
	include_once 'define.php';
	function __autoload($className){
		$fileName = PATH_LIBS . $className . ".php";
		if(file_exists($fileName)) include_once($fileName);
	}

	Session::init();
 ?>