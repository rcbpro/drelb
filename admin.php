<?php

	session_start();

	require "./config.php";
	require "./moviesXML_Creator.php";	

	require MODEL_PATH."index".DS.'movie_cats.php';		
	$movieCategories = new movieCategories();	

	if ((isset($_SESSION['user_type'])) && ($_SESSION['user_type'] == 'S')){
		//Instantiating the Configuration class
		$config = new Configuration();	
		$config->dispatcher();
	}else{
		include "404.php";
	}	
?>