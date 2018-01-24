<?php

class User_login{
	
	/**
	 * return false if invalid login or set session if login is valid
	 * the user session and return true
	 * return bool
	 */
	function login_authenticate($username, $password){
	
		$logged_user = array();
		$query = sprintf("SELECT user_type, id, first_name, expired_date, status, credits_allowed FROM users 
						  WHERE username = '%s' and password = '%s'",																					
							mysql_preperation($username),
							md5(mysql_preperation($password))						
						); 
		$result = mysql_query($query);				
		if (mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			$logged_user['status'] = $row['status'];						
			$logged_user['user_type'] = $row['user_type'];			
			$logged_user['id'] = $row['id'];
			$logged_user['first_name'] = $row['first_name'];					
			$logged_user['credit_limit'] = $row['credits_allowed'];
			$logged_user['success'] = true;					
			if ($row['expired_date'] < date('Y-M-D')){
				$logged_user['expired'] = true;
			}
			if ($row['status'] == 'D'){
				$logged_user['notActivated'] = true;				
			}				
		}else{
			$logged_user['success'] = false;
			$logged_user['id'] = "";
			$logged_user['first_name'] = "";											
		}
		return $logged_user;
	}
	
	function update_last_login($user_id){
		
		$query = sprintf("UPDATE users SET last_login = NOW() WHERE id = '%s'", $user_id);
		$result = mysql_query($query);
	}	
	
}

?>