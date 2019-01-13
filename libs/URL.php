<?php
class URL{
	public static function redirect($link){
		header('location: ' . $link);
		exit();
	}	
}