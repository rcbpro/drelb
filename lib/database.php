<?php

class Database{

	/* This function will return the database connection */
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
	/* End of the function */
	
	/* This function will turn the mysql resource in to an array */
	function result_to_array($result){
	
		$result_array = array();
		
		for ($i=0; $row = mysql_fetch_array($result); $i++){
			$result_array[$i] = $row;
		}
		
		return $result_array;
	}
	/* End of the function */	
}

?>