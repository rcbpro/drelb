<?php

class User_validate{

	var $messges = "";	
	var $letter = "";
	var $errors = array();
	var $new_user = array();
	var $new_errors = array();
	var $required_field_errors = array();	
	var $new_admin_input = array();
	var $having_uname_error = false;
	var $having_email_error = false;	
	var $having_wrong_email_error = false;
	var $having_passwords_not_equal_error = false;	
	var $having_uname_min_length_error = false;
	var $having_password_min_length_error = false;	
	var $having_allowed_credits_error = false;

	function validate_new_user_for_all($user){

		$this->required_field_errors = check_required_fields($user);	

		if (empty($this->required_field_errors)){
/*		
			if (!empty($user['security_code'])){
				if (!$this->validate_captcha_code($user['security_code'], $sec_code)){
					$this->new_errors['captcha'] = "Invalid Security Code"; 
					$this->errors = array_merge($this->new_errors, $this->errors);
				}
			}*/
			if ((!empty($user['username'])) && (!empty($user['email'])) && (!empty($user['username'])) && (!empty($user['confirm_password'])) && (!empty($user['allowd_credits']))){	
			
				if ($this->validate_username_email("username", $user['username'])){
					$this->having_uname_error = true;					
				}
				if ($this->validate_username_email("email", $user['email'])){
					$this->having_email_error = true;										
				}
				if (!$this->isValidEmail($user['email'])){
					$this->having_wrong_email_error	= true;			
				}
				if ($this->isPasswordAreSame($user['password'], $user['confirm_password'])){
					$this->having_passwords_not_equal_error	= true;								
				}
				if (!$this->isCurrency_allowedCredits($user['allowd_credits'])){
					$this->having_allowed_credits_error	= true;								
				}
				
				$username_length = array($user['username'] => 6);
				$min_length_error = check_min_field_length($username_length);
				if (!empty($min_length_error)){
					$this->having_uname_min_length_error = true;
				}
				$password_length = array($user['password'] => 6);									
				$min_length_error = check_min_field_length($password_length);
				if (!empty($min_length_error)){
					$this->having_password_min_length_error = true;
				}		
				
				if ($this->having_uname_error){
					$this->new_errors['username_exist'] = "username exist";					
				}
				if ($this->having_email_error){
					$this->new_errors['email_exist'] = "email exist";							
				}
				if ($this->having_wrong_email_error){
					$this->new_errors['invalid_email'] = "Invalid email";											
				}
				if (!$this->having_passwords_not_equal_error){
					$this->new_errors['passwords_not_match'] = "Passwords not equal";															
				}
				if ($this->having_uname_min_length_error){
					$this->new_errors['username_min_length'] = "Username dose not meet the minimun length";																				
				}
				if ($this->having_password_min_length_error){
					$this->new_errors['password_min_length'] = "Password dose not meet the minimun length";																				
				}
				if ($this->having_allowed_credits_error){
					$this->new_errors['allowed_credits_not_currency'] = "Entered value for credits are not in currency type";																									
				}				
				
				$this->errors = array_merge($this->new_errors, $this->errors);																									
			}
		}else{
			
				$this->errors = $this->required_field_errors;
		}
			
		if (empty($this->errors)){
		
				foreach($user as $user_field => $user_value){			
					$this->new_user[$user_field] = mysql_preperation($user_value);		
				}
				return $this->new_user;			
		}else{
			
			$this->display_error_messages($this->errors, "index.php?cntrl=users&view=users");			
		}
				
	}	
	
	function validate_captcha_code($user_code, $session_code){
	
		return ($user_code == $session_code) ? true : false;
	}
	
	function validate_username_email($field_to_validate, $value_to_validate){
	
		$query = "SELECT {$field_to_validate} FROM users WHERE {$field_to_validate} = '{$value_to_validate}'";
		$result = mysql_query($query);		
		return (mysql_num_rows($result) > 0) ? true : false;
	}
	
	function isValidEmail($email){
	
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	function isPasswordAreSame($password, $conf_password){
		
		return ($password == $conf_password) ? true : false;
	}
	
	function validateUserPaymentInfo($userPaymentInfo){
		
		$correctPaymentInfo = array();
		$this->required_field_errors = check_required_fields($userPaymentInfo);			
		
		if (empty($this->required_field_errors)){
			if ($this->check_creditCardExpiry($userPaymentInfo['expiryDate'])){
				$this->new_errors['ccDateExpired'] = "Credit Card Expired"; 
				$this->errors = array_merge($this->new_errors, $this->errors);
			}
			if (!$this->checkCreditCard($userPaymentInfo['creditCardNumber'], $userPaymentInfo['creditCardType'])){
					$this->new_errors['invalidCCNumber'] = "Invalid Credit Card Number"; 
					$this->errors = array_merge($this->new_errors, $this->errors);
			}
			if (!$this->isTheCorrectSecurityAnswer($userPaymentInfo['security_answer'], $_SESSION['logged_user_id'])){
					$this->new_errors['invalidAnswer'] = "Invalid Answer"; 
					$this->errors = array_merge($this->new_errors, $this->errors);				
			}		
		}else{
			$this->errors = $this->required_field_errors;		
		}
		
		if (empty($this->errors)){
		
				$correctPaymentInfo['ccNumber'] = $userPaymentInfo['creditCardNumber'];
				list($year, $month, $date) = explode("-", $userPaymentInfo['expiryDate']);
				$correctPaymentInfo['expDate'] = $month.substr($year, -2);
				return $correctPaymentInfo;
		}else{
			
			$this->display_error_messages($this->errors, "index.php?cntrl=users&view=payments");			
		}
		
	}
	
	function checkCreditCard ($cardnumber, $cardname) {
	
	  // Define the cards we support. You may add additional card types.
	  
	  //  Name:      As in the selection box of the form - must be same as user's
	  //  Length:    List of possible valid lengths of the card number for the card
	  //  prefixes:  List of possible prefixes for the card
	  //  checkdigit Boolean to say whether there is a check digit
	  
	  // Don't forget - all but the last array definition needs a comma separator!
	  
	  $errornumber = 0;
	  $errortext = "";
	  $valid = false;
	  $ccErrInfo = array();
	  
	  $cards = array (  array ('name' => 'American Express', 
							  'length' => '15', 
							  'prefixes' => '34,37',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Diners Club Carte Blanche', 
							  'length' => '14', 
							  'prefixes' => '300,301,302,303,304,305',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Diners Club', 
							  'length' => '14,16',
							  'prefixes' => '305,36,38,54,55',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Discover', 
							  'length' => '16', 
							  'prefixes' => '6011,622,64,65',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Diners Club Enroute', 
							  'length' => '15', 
							  'prefixes' => '2014,2149',
							  'checkdigit' => true
							 ),
					   array ('name' => 'JCB', 
							  'length' => '16', 
							  'prefixes' => '35',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Maestro', 
							  'length' => '12,13,14,15,16,18,19', 
							  'prefixes' => '5018,5020,5038,6304,6759,6761',
							  'checkdigit' => true
							 ),
					   array ('name' => 'MasterCard', 
							  'length' => '16', 
							  'prefixes' => '51,52,53,54,55',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Solo', 
							  'length' => '16,18,19', 
							  'prefixes' => '6334,6767',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Switch', 
							  'length' => '16,18,19', 
							  'prefixes' => '4903,4905,4911,4936,564182,633110,6333,6759',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Visa', 
							  'length' => '13,16', 
							  'prefixes' => '4',
							  'checkdigit' => true
							 ),
					   array ('name' => 'Visa Electron', 
							  'length' => '16', 
							  'prefixes' => '417500,4917,4913,4508,4844',
							  'checkdigit' => true
							 ),
					   array ('name' => 'LaserCard', 
							  'length' => '16,17,18,19', 
							  'prefixes' => '6304,6706,6771,6709',
							  'checkdigit' => true
							 )
					);
	
	  $ccErrors [1] = "No card number provided";
	  $ccErrors [2] = "Credit card number has invalid format";
	  $ccErrors [3] = "Credit card number is invalid";
	  $ccErrors [4] = "Credit card number is wrong length";
				   
	  // Establish card type
	  $cardType = -1;
	  for ($i=0; $i<sizeof($cards); $i++) {
	
		// See if it is this card (ignoring the case of the string)
		if (strtolower($cardname) == strtolower($cards[$i]['name'])) {
		  $cardType = $i;
		  break;
		}
	  }
	  
	  // If card type not found, report an error
	  if ($cardType == -1) {
		 $errornumber = 0;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
	   
	  // Ensure that the user has provided a credit card number
	  if (strlen($cardnumber) == 0)  {
		 $errornumber = 1;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
	  
	  // Remove any spaces from the credit card number
	  $cardNo = str_replace (' ', '', $cardnumber);  
	   
	  // Check that the number is numeric and of the right sort of length.
	  if (!eregi('^[0-9]{13,19}$',$cardNo))  {
		 $errornumber = 2;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
		   
	  // Now check the modulus 10 check digit - if required
	  if ($cards[$cardType]['checkdigit']) {
		$checksum = 0;                                  // running checksum total
		$mychar = "";                                   // next char to process
		$j = 1;                                         // takes value of 1 or 2
	  
		// Process each digit one by one starting at the right
		for ($i = strlen($cardNo) - 1; $i >= 0; $i--) {
		
		  // Extract the next digit and multiply by 1 or 2 on alternative digits.      
		  $calc = $cardNo{$i} * $j;
		
		  // If the result is in two digits add 1 to the checksum total
		  if ($calc > 9) {
			$checksum = $checksum + 1;
			$calc = $calc - 10;
		  }
		
		  // Add the units element to the checksum total
		  $checksum = $checksum + $calc;
		
		  // Switch the value of j
		  if ($j ==1) {$j = 2;} else {$j = 1;};
		} 
	  
		// All done - if checksum is divisible by 10, it is a valid modulus 10.
		// If not, report an error.
		if ($checksum % 10 != 0) {
		 $errornumber = 3;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
		}
	  }  
	
	  // The following are the card-specific checks we undertake.
	
	  // Load an array with the valid prefixes for this card
	  $prefix = split(',',$cards[$cardType]['prefixes']);
		  
	  // Now see if any of them match what we have in the card number  
	  $PrefixValid = false; 
	  for ($i=0; $i<sizeof($prefix); $i++) {
		$exp = '^' . $prefix[$i];
		if (ereg($exp,$cardNo)) {
		  $PrefixValid = true;
		  break;
		}
	  }
		  
	  // If it isn't a valid prefix there's no point at looking at the length
	  if (!$PrefixValid) {
		 $errornumber = 3;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  }
		
	  // See if the length is valid for this card
	  $LengthValid = false;
	  $lengths = split(',',$cards[$cardType]['length']);
	  for ($j=0; $j<sizeof($lengths); $j++) {
		if (strlen($cardNo) == $lengths[$j]) {
		  $LengthValid = true;
		  break;
		}
	  }
	  
	  // See if all is OK by seeing if the length was valid. 
	  if (!$LengthValid) {
		 $errornumber = 4;     
		 $errortext = $ccErrors [$errornumber];
		 return false; 
	  };   
	  
	  // The credit card is in the required format.
		 return true; 
	}
	
	function check_creditCardExpiry($ccExpDate){	
		
		return ($ccExpDate <= date("Y-m-d")) ? true : false;
	}
	
	function isCurrency_allowedCredits($credits){		
		
		$matches = array();
		preg_match('#^([0-9,\s]*\.?[0-9]{0,2})$#', $credits, $matches);
		if (count($matches) > 0){
			return true;
		}else{
			return false;		
		}
	}
	
	function isTheCorrectSecurityAnswer($answer, $u_id){
	
		$query = sprintf("SELECT security_answer FROM users WHERE id = '%s'", $u_id);
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			$security_answer = $row['security_answer'];
			if ($security_answer === $answer){
				return true;
			}else{
				return false;				
			}
		}
	}
	
	function validateAdminInput($adminInputPostParam){

		$this->required_field_errors = check_required_fields($adminInputPostParam);			

		if (empty($this->required_field_errors)){
			
			if (!$this->checkImageFileUploaded($_FILES['imageInput']['name'])){
				$this->new_errors['imageFileNotExist'] = "Image File Not Uploaded"; 
				$this->errors = array_merge($this->new_errors, $this->errors);							
			}
			if (!$this->checkMediaFileUploaded($_FILES['movieInput']['name'])){
				$this->new_errors['movFileNotExist'] = "Movie File Not Uploaded"; 
				$this->errors = array_merge($this->new_errors, $this->errors);				
			}			
			if (!$this->checkImageFileMaxSize($_FILES['imageInput']['size'])){
				$this->new_errors['imageFileSizeExceed'] = "Image File size exceeds max file size"; 
				$this->errors = array_merge($this->new_errors, $this->errors);							
			}
			if (!$this->checkMediaFileMaxSize($_FILES['movieInput']['size'])){
				$this->new_errors['mediaFileSizeExceed'] = "Media File size exceeds max file size"; 
				$this->errors = array_merge($this->new_errors, $this->errors);				
			}			
			if (!$this->checkImageFileType($_FILES['imageInput']['type'])){
				$this->new_errors['imageFileTypeInvalid'] = "Image File Type invalid"; 
				$this->errors = array_merge($this->new_errors, $this->errors);							
			}
			if (!$this->checkMediaFileType($_FILES['movieInput']['type'])){
				$this->new_errors['mediaFileTypeInvalid'] = "Movie File Type invalid"; 
				$this->errors = array_merge($this->new_errors, $this->errors);				
			}						
		}else{
			$this->errors = $this->required_field_errors;		
		}
		
		if (empty($this->errors)){
		
				foreach($adminInputPostParam as $admin_field => $admin_value){			
					$this->new_admin_input[$admin_field] = mysql_preperation($admin_value);		
				}
				return $this->new_admin_input;			
		}else{
			$this->display_error_messages($this->errors, "admin.php?cntrl=admin&view=add");
		}
		
	}
	
	function checkMediaFileUploaded($mediaFileName){
		
		return ($mediaFileName != "") ? true : false;
	}
	
	function checkImageFileUploaded($imageFileName){
	
		return ($imageFileName != "") ? true : false;	
	}
	
	function checkMediaFileMaxSize($mediaFileSize){
	
		return ($mediaFileSize <= MAX_SIZE_MEDIA_UPLOAD) ? true : false;	
		//3836585
	}

	function checkImageFileMaxSize($imageFileSize){
	
		return ($imageFileSize <= MAX_SIZE_IMG_UPLOAD) ? true : false;			
	}

	function checkMediaFileType($mediaFileType){
	
		if (($mediaFileType == "video/x-flv") || ($mediaFileType == "video/divx") 
			|| ($mediaFileType == "video/quicktime")){
			return true;
		}else{
			return false;	
		}	
	}
	
	function checkImageFileType($imageFileType){
	
		if (($imageFileType == "image/jpeg") || ($imageFileType == "image/jpg")
			|| ($imageFileType == "image/png") || ($imageFileType == "image/gif")){ 
			return true;
		}else{
			return false;	
		}	
	}
	
	function display_error_messages($errArray, $url){

		$_SESSION['errors'] = $errArray;
		$this->messages = "There ";
		if (count($this->errors) == 1){
			$this->messages .= "was ";
			$this->letter .= "";
		}else{
			$this->messages .= "were ";					
			$this->letter .= "s";				
		}
		$this->messages .= count($this->errors) . " error{$this->letter} in the form : Cannot go further. ";
		$this->messages .= review_errors($this->errors);
		
		$_SESSION['user_validate_err_msg'] = "<span style='color:red; font-size:12px;'>".$this->messages."</span>";
		redirect_to($url);			
		
	}
	
	function validate_user_login_help($userDetails, $subView){
		
		$this->required_field_errors = check_required_fields($userDetails);	
		if (empty($this->required_field_errors)){
			if (!$this->validate_firstname($userDetails['Firstname'])){
				$this->new_errors['firstname_not_exist'] = "This name does not exist !"; 
				$this->errors = array_merge($this->new_errors, $this->errors);
			}
			if (!$this->validate_email($userDetails['Email'])){
				$this->new_errors['email_not_exist'] = "This Email does not exist !"; 
				$this->errors = array_merge($this->new_errors, $this->errors);
			}
			if (isset($userDetails['Username'])){
			
				if (!$this->validate_username($userDetails['Username'])){
					$this->new_errors['username_not_exist'] = "This Username does not exist !"; 
					$this->errors = array_merge($this->new_errors, $this->errors);
				}
			}elseif (isset($userDetails['Password'])){
			
				if (!$this->validate_password($userDetails['Password'])){
					$this->new_errors['password_not_correct'] = "This Password is Incorrect !"; 
					$this->errors = array_merge($this->new_errors, $this->errors);
				}
			}	
			
		}else{
			$this->errors = $this->required_field_errors;			
		}
		
		if (empty($this->errors)){
			return $userDetails;
		}else{
			$this->display_error_messages($this->errors, "index.php?cntrl=users&view=loginHelp&subView=".$subView);
		}
				
	}
	
	function validate_firstname($firstname){
		
		$query = "SELECT first_name FROM users WHERE first_name = '" . strtolower($firstname) . "'";
		$result = mysql_query($query);
		return (mysql_num_rows($result)>0) ? true : false;  
	}

	function validate_username($username){
		
		$query = "SELECT username FROM users WHERE username = '" . strtolower($username) . "'";
		$result = mysql_query($query);
		return (mysql_num_rows($result)>0) ? true : false;  
	}

	function validate_email($email){
		
		$query = "SELECT email FROM users WHERE email = '" . strtolower($email) . "'";
		$result = mysql_query($query);
		return (mysql_num_rows($result)>0) ? true : false;  
	}
	
	function validate_password($password){
		
		$query = "SELECT password FROM users WHERE password = '". md5($password) . "'";
		$result = mysql_query($query);
		return (mysql_num_rows($result)>0) ? true : false;  
	}
	
	function validate_change_password_options($changePWOptions, $user_id){

		$this->required_field_errors = check_required_fields($changePWOptions);	

		if (empty($this->required_field_errors)){
			if (!$this->validate_passsword($changePWOptions['current_password'], $user_id)){
				$this->new_errors['password_incorrect'] = "Password Incorrect !"; 
				$this->errors = array_merge($this->new_errors, $this->errors);
			}
			if (!$this->validate_newpasswords($changePWOptions['new_password'], $changePWOptions['confirm_password'])){
				$this->new_errors['new_passwords_not_same'] = "Passwords are not equal !"; 
				$this->errors = array_merge($this->new_errors, $this->errors);
			}
			
		}else{
			$this->errors = $this->required_field_errors;			
		}
		
		if (empty($this->errors)){
			return $changePWOptions;
		}else{
			$this->display_error_messages($this->errors, "index.php?cntrl=users&view=pwChange");
		}
		
	}
	
	function validate_passsword($cur_password, $u_id){
	
		$query = sprintf("SELECT id FROM users WHERE id = '%s' and password = '%s'",																					
							mysql_preperation($u_id),
							md5(mysql_preperation($cur_password))						
						); 
		$result = mysql_query($query);
		return ($result) ? true : false;
	}
	
	function validate_newpasswords($newpassword, $conf_password){
	
		return ($newpassword == $conf_password) ? true : false;
	}	
	
	function validateAdminInputForEdit($adminInputForEdit, $movNo){
	
		$this->required_field_errors = check_required_fields($adminInputForEdit);	

		if (empty($this->required_field_errors)){
			
		}else{
			$this->errors = $this->required_field_errors;			
		}
		
		if (empty($this->errors)){
			return $adminInputForEdit;
		}else{
			$this->display_error_messages($this->errors, "admin.php?cntrl=admin&view=edit&mov=".$movNo);
		}
		
	}
	
	function validateAdminInputForNewAdmin($adminInputPostParam){

		$this->required_field_errors = check_required_fields($adminInputPostParam);			

		if (empty($this->required_field_errors)){
			
			if (!$this->isPasswordAreSame($adminInputPostParam['password'], $adminInputPostParam['confirmpassword'])){
				$this->new_errors['adminPasswordsAreNotSame'] = "Passwords are not same"; 
				$this->errors = array_merge($this->new_errors, $this->errors);				
			}						
		}else{
			$this->errors = $this->required_field_errors;		
		}
		
		if (empty($this->errors)){
		
				foreach($adminInputPostParam as $admin_field => $admin_value){			
					$this->new_admin_input[$admin_field] = mysql_preperation($admin_value);		
				}
				return $this->new_admin_input;			
		}else{
			$this->display_error_messages($this->errors, "admin.php?cntrl=admin&view=newadminuser");
		}
		
	}
	
	
}

?>