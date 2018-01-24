<?php

class User_reg{

	/**
	 * Creates a new user for the system
	 * @param array
	 * return bool
	 */
	function create_new_user($param_array){			

		$query = sprintf("INSERT INTO users 
						SET
							user_type = 'N',
							first_name = '%s',
							last_name = '%s',										
							username = '%s',
							password = '%s',
							selected_security_question = '%s',									
							security_answer = '%s',		
							credits_allowed = '%s',																																			
							email = '%s',
							registered_date = NOW(),
							expired_date = '" . EX_DATE . 
							"', status = 'D',
							activation_code = " . mt_rand(),										
							$param_array['firstname'],
							$param_array['lastname'],
							$param_array['username'],
							md5($param_array['password']),
							$param_array['security_question'],														
							$param_array['security_answer'],							
							$credits = ereg_replace('/\$|\,', '', $param_array['allowd_credits']),							
							$param_array['email']
					);
		$result = mysql_query($query) or die(mysql_error());		
		return (!$result) ? false : mysql_insert_id();
	}
	
	/**
	 * Edit user password
	 * @param u_id
	 * @param newpassword	 
	 * return bool
	 */
	function change_user_password($u_id, $newpassword){
	
		$query = sprintf("UPDATE users SET 
								password = '%s'
								WHERE id = '%s'",
						mysql_real_escape_string(md5($newpassword)),
						mysql_real_escape_string($u_id)
				);				
		$result = mysql_query($query);	
		return ($result) ? true : false;
	}	
	
	/**
	 * Update the new user as activated
	 * @random_no
	 * return bool
	 */	
 	function activation_success($u_email){
	
 	 	$query = sprintf("UPDATE users SET 
							status = 'A'
							WHERE email = '%s'",
							mysql_real_escape_string($u_email)
						);
		$result = mysql_query($query);
 	 	if(mysql_affected_rows() > 0){
			return true;
 	 	}
 	}
	
	function update_credit_limit($u_id, $creditLimit){
		
		$query = sprintf("UPDATE users SET 
									credits_allowed = '%s'
									WHERE id = '%s'",
									mysql_real_escape_string($creditLimit),
									mysql_real_escape_string($u_id)
						);
		$result = mysql_query($query);
		if (mysql_affected_rows() > 0){
			return true;
		}
	}		

	function reduce_current_user_credits($u_id, $amounToReduce){
	
		$query = sprintf("UPDATE users 
									SET credits_allowed = (credits_allowed - '%s') WHERE id = '%s'",
									mysql_real_escape_string($amounToReduce),
									mysql_real_escape_string($u_id)
						);	
		$result = mysql_query($query);
		if (mysql_affected_rows() > 0){
			return true;
		}
	}
	
	function notify_user_paid_movies($u_id, $movie_name){
		
		$query = sprintf("INSERT INTO movies_viewed SET 
											user_id = '%s',
											downloaded_movie = '%s'",
											mysql_real_escape_string($u_id),
											mysql_real_escape_string($movie_name)
							);
		$result = mysql_query($query);
	}

}
	
?>