<?php

//	notify_user_paid_movies($settings = array("host" => "localhost", "username" => "leighmac", "password" => "password", "database" => "drelb"), 40, "Jaw");	

	function db_connect($database_settings){
		
		$connection = @mysql_connect($database_settings['host'], $database_settings['username'], $database_settings['password']);
		if (!$connection){
			return false;
		}
		if (!mysql_select_db($database_settings['database'], $connection)){
			return false;
		}
		return $connection;
	}
	
	function notify_user_paid_movies($settings, $u_id, $movie_name){
		
		db_connect($settings);				
		
		$query = sprintf("INSERT INTO movies_viewed SET 
											user_id = '%s',
											downloaded_movie = '%s'",
											mysql_real_escape_string($u_id),
											mysql_real_escape_string($movie_name)
							);
		$result = mysql_query($query);
	}		
	
?>	
	<?php
echo base64_decode(da907a1b8f74e6922d93b025eecfb852)."<br />";
//echo md5("future");
?>