<?php

	/** Review errors
	 *  @param Array errors
	 *  return String messages
	 */
	function review_errors($errors){
	
		$message = "";
		$message .= "Please review the following error(s) :- <br />";			
		foreach ($errors as $err_name => $err_value){
			$message .= " * " . $err_value . "<br />";
		}
		
		return $message;
	}	
	
	/** Prepare the post values
	 *  @param value
	 *  return value
	 */
	function mysql_preperation($value){		
	
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_escape_string"); // i.e. PHP >= v4.3.0
		if ($new_enough_php){ // PHP v4.3.0 or higher
				// undo any magic quote effects so mysql_real_escape_string can do the work
			if ($magic_quotes_active){ 
				$value = stripslashes($value); 
			}
				$value = mysql_real_escape_string($value);
			}else{ // before PHP v4.3.0
				// if magic quotes aren't already on then add slashes manually
				if (!$magic_quotes_active){ 
					$value = addslashes( $value ); 
				}
				// if magic quotes are active, then the slashes already exist
			}
			return $value;
		}

	/** Checks the fields empty
	 *  @param Array required_field_array
	 *  return field_erros Array
	 */
	function check_required_fields($required_fields_array){
	
		$field_errors = array();		
		foreach ($required_fields_array as $field_name => $field_value){
			if ((empty($field_value)) || (!isset($field_value)) && (($field_value != 0) || ($field_value != ""))){
				$field_errors[] = $field_name;			
			}
		}	
		return $field_errors;
	}
	
	/** Checks field's maximum length
	 *  @param Array field_length_array
	 *  return field_errors array
	 */
	function check_min_field_length($field_length_array){
	
		$field_errors = array();
		foreach ($field_length_array as $field_value => $min_length){
			if (strlen(trim(mysql_preperation($field_value))) < $min_length){
				$field_errors[] = $field_value;
			}
		}
		return $field_errors;		
	}
	
?>