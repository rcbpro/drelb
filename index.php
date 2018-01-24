<?php

	session_start();
	
	require "./config.php";
	require "./moviesXML_Creator.php";	

	require MODEL_PATH."index".DS.'movie_cats.php';		
	$movieCategories = new movieCategories();	

	//Instantiating the Configuration class
	$config = new Configuration();	
	$config->dispatcher();
	
	// Instantiating the moviesXML_Creator class
	// Prepare the moviesXml file for the suggestions
	$movSuggest = new moviesXML_Creator();
	if (!$movSuggest->readMoviesSuggestXML()) $movSuggest->createMoviesXML();	
	
?>