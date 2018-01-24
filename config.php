<?php
	
	require "./define.inc";		
	require "./lib/database.php";

	$db = new Database();
	$db_settings = new drelb_settings();
	$settings = $db_settings->settings;
	$db->db_connect($db_settings->settings);		
	
	require "./lib/controller.php";
	require "./lib/model.php";
	require "./lib/view.php";
	require "./lib/send_email.php";	
	require_once './lib/php_thumb/phpthumb.class.php'; 	

	class Configuration{

		/**
		 * Include the neccessary controller and view for the requested url
		 * @param view		 
		 * No return value
		 */
		function dispatcher(){					

			$controller = (empty($_GET['cntrl'])) ? 'index' : $_GET['cntrl'];			
			$view = (empty($_GET['view'])) ? 'index' : $_GET['view'];			
			
			$controllersArray = array('index', 'users', 'admin');
			$viewsArray = array('create', 'users', 'activated', 'activate', 'login', 'loginError', 'loggedin', 'clear', 'payments', 'loginHelp', 'viewProfile', 'pwChange',
								'index', 'details', 'search', 'advanceSearch', 'add', 'edit', 'newadminuser');			
			
			if (
				(in_array($controller, $controllersArray)) &&
				(in_array($view, $viewsArray))
				){
				
				$public_src = "public/";
				// Include controller
				include(CONTROLLER_PATH.$controller.'.php');
		
				// Include layout
				include (file_exists(VIEW_PATH.'layouts'.DS.$controller.'.html')) ? (VIEW_PATH.'layouts'.DS.$controller.'.html') : (VIEW_PATH.'layouts'.DS.'index.html');
			}else{
				include "404.php";
			}
		}	
		
	
	}
	
?>