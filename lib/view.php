<?php

	/**		
	 * Print the neccessary error message for the feild.
	 * @param string msg
	 * @param bool error
	 * @return bool or nothing 
	 */
	function error_msg($error ,$msg){
	
		if ($error) { return $msg; }
		return "";
	}

	/**		
	 * Return the correct value for our form element.
	 * @param bool $error
	 * @param string $row
	 * @param string $param	 
	 * @return string
	 */
	function element_value($error, $row, $param){
	
		if ($error) { return ''; }
		if ($row) { return $row; }
		if ($param) { return $param; }
		return '';
	}

	/**		
	 * Checks if the user logged in.
	 * @return bool
	 */
	function logged_in(){
	
		if (@$_SESSION['user']){
			return true;
		}else{
			return false;
		}
	}	

	/**		
	 * Returns user firld
	 * @string $field
	 * returns string	 
	 */
	function current_user($field){
	
		return $_SESSION['user'][$field];
	}

	/**		
	 * Format Date
	 * @param mysql timestamp $mysql_timestamp
	 * @param string	 
	 */
	 function format_date($mysql_timestamp){
	 	
		$unix_time = strtotime($mysql_timestamp);
		return date('M j', $unix_time);
	 }


?>