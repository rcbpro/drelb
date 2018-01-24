<?php

	// Application Directory
	define('APP_ROOT', 'drelb');
	// Directory Structure
	define('DS', '/');
	// Web Site URL
	define('WEBSITE', 'http://'.$_SERVER['HTTP_HOST'].'/drelb/');
	// Database Configuration Constants
	define('HOST', 'localhost');
	define('USERNAME', 'leighmac');
	define('PASSWORD', 'password');
	define('DATABASE', 'drelb');
	//User Activation mail
	define('USER_ACTIVATION_EMAIL', 'registrations@drelb.com'); 	        
	//Number of Records per page
    define('NO_OF_RECORDS_PER_PAGE', 12);    
	//Number of Records per page for admin    
	define("DISPLAY_LIMIT_FOR_ADMIN", 14);    
    // Maximum size of Image Upload
    define('MAX_SIZE_IMG_UPLOAD', 10000000);	
    // Maximum size of Media File Upload
    define('MAX_SIZE_MEDIA_UPLOAD', 1000000000);	
        
	// MVC Paths
	define('MODEL_PATH', 'models'.DS);
	define('CONTROLLER_PATH', 'controllers'.DS);
	define('VIEW_PATH', 'views'.DS);
    
	$mkex_date = mktime(0,0,0,date("m"),date("d"),date("Y")+1);
	$ex_date = date("Y/m/d", $mkex_date);
	//Expiry Date
	define('EX_DATE',$ex_date);    

	class drelb_settings{        

		var $settings = array(
		                    'host' => HOST,
		                    'username' => USERNAME,
		                    'password' => PASSWORD,
		                    'database' => DATABASE,
		                );
		}

?>