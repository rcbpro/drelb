<?php

class Get_User{

	/**
	 * Resturn user email and the user name for the activation
	 * @u_id
	 * return result resource
	 */
	function get_user_email_name($u_id){
	
		$query = sprintf("SELECT email, first_name FROM users WHERE id = '%s'", $u_id);
		$result = mysql_query($query);
		$user_info = array();
		while($row = mysql_fetch_array($result)){
			$user_info['email'] = $row['email'];
			$user_info['first_name'] = $row['first_name'];
		}
		if (!empty($user_info)) return $user_info;		
	}

	/**
	 * Resturn user email and the user name for the activation
	 * @u_id
	 * return result resource
	 */
	function get_user_id_firstname($uname){
	
		$query = sprintf("SELECT id, first_name FROM users WHERE uname '= '%s''", $uname);
		$result = mysql_query($query);
		$logged_user = array();
		while($row = mysql_fetch_array($result)){
			$logged_user['id'] = $row['id'];
			$logged_user['first_name'] = $row['first_name'];
		}
		if (!empty($logged_user)) return $logged_user;		
	}
	
	/**
	 * Resturn user security question and the answer 
	 * @u_id
	 * return result resource
	 */
	function get_user_security_question_answer($u_id){
	
		$query = sprintf("SELECT selected_security_question, security_answer FROM users WHERE id = '%s'", $u_id);
		$result = mysql_query($query);
		$user_security_questions = array();
		while($row = mysql_fetch_array($result)){
			$user_security_questions['security_question'] = $row['selected_security_question'];
			$user_security_questions['security_answer'] = $row['security_answer'];			
		}
		if (!empty($user_security_questions)) return $user_security_questions;
	}
	
	function get_user_updated_credit_limit($u_id){
	
		$query = sprintf("SELECT credits_allowed FROM users WHERE id = '%s'", mysql_real_escape_string($u_id));
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return $row['credits_allowed'];
	}
	
	function get_user_viewed_movie_name($Mov_id){
		
		$query = sprintf("SELECT movie_name FROM movies WHERE id = '%s'", mysql_real_escape_string($Mov_id));
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return $row['movie_name'];		
	}
	
	function get_count_of_user_viewed_movies($u_id){
		
		$query = sprintf("SELECT COUNT(downloaded_movie) AS viewedCount FROM movies_viewed WHERE user_id = '%s'", mysql_real_escape_string($u_id));
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return $row['viewedCount'];
	}
	
	function get_user_registered_date($u_id){
	
		$query = sprintf("SELECT registered_date FROM users WHERE id = '%s'", mysql_real_escape_string($u_id));
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return $row['registered_date'];		
	}
	
	function get_user_password($email){
	
		$query = sprintf("SELECT password FROM users WHERE email = '%s'", mysql_real_escape_string($email));
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return base64_decode($row['password']);				
	}
	
	function get_user_username($email){
	
		$query = sprintf("SELECT username FROM users WHERE email = '%s'", mysql_real_escape_string($email));
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return $row['username'];				
	}
	
}

?>