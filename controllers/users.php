<?php

	include(MODEL_PATH.$controller.DS.'user_pro.php');
	include(MODEL_PATH.$controller.DS.'user_get.php');	
	include(MODEL_PATH.$controller.DS.'user_validate.php');			
	include(MODEL_PATH.$controller.DS.'user_login.php');				

	$user_reg = new User_reg();
	$user_get = new Get_User();
	$user_validate = new User_validate();
	$login = new User_login();
	$email = new Email();
	$db = new Database();
	global $settings;
	$db->db_connect($settings);
	
	switch ($view){
		
		case "create":				
		
			if (isset($_POST['user_prof'])){
			
				$_SESSION['user_prof'] = $_POST['user_prof'];
			
				$required_fields = $user_validate->validate_new_user_for_all($_POST['user_prof']);
				
				if ($u_id = $user_reg->create_new_user($required_fields)){		
				
					$msg = array();
					$user_info = array();
					$user_info = $user_get->get_user_email_name($u_id);
					$msg['msg_user_email'] = $user_info['email'];
					$msg['msg_text'] = '<span style=\'color:#f60;\'>You have being succefully addeed as a new user to the system.</span>';
					flash_notice($msg);	
					$_SESSION['mail_server'] = "http://www." . substr($_SESSION['msg_user_email'], strpos($_SESSION['msg_user_email'], "@") + 1, strlen($_SESSION['msg_user_email']));
					$random_no = mt_rand();
					$_SESSION['random_no'] = $random_no;
					$from_header =  "Your account activation from http://drelb.com"; 
					$from = USER_ACTIVATION_EMAIL;
					$contents = "Dear " . $user_info['first_name'] .",\n \n Thank you for registering with http://drelb.com !\n \n To confirm your registration, please click the following link or copy it into your address bar.\n \n http://drelb.com/index.php?cntrl=users&view=activated&code={$random_no} \n \n With thanks, \n \n http://drelb.com.";
					$subject = "Registration Confirmation";
					if(!$email->send_email($subject, $from, $from_header, $contents,'', '', '', $msg['msg_user_email'], '', '')){
						$_SESSION['user_validate_err_msg'] = "<span style=\'color:#ff0000; font-size:16px; font-weight:bold;\'>Email Send failed..</span>";
					}
					$_SESSION['activated_uname'] = $user_info['first_name'];
					unset($_SESSION['user_prof']);
					unset($_SESSION['errors']);
					redirect_to('index.php?cntrl=users&view=activate');				
				}else{				
					$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Unexpected error occrued !</span>";	
					redirect_to('index.php?cntrl=users&view=users');
				}
				
			}
		break;
	
		case "activated":			
			if ($_GET['code'] != $_SESSION['random_no']){
				$_SESSION['flash']['warning'] = "Sorry ! cannot activate your account";
			}else{
				if ($user_reg->activation_success($_SESSION['msg_user_email'])){
					$_SESSION['flash']['notice'] = "<span style='color:#06f; font-size:11px;'>Great.... {$_SESSION['activated_uname']} , </span>Your account has been activated";				
				if ((isset($_SESSION['new_user_registered'])) && ($_SESSION['new_user_registered'] == true))
					unset($_SESSION['new_user_registered']);
				}
			}	
		break;
		
		case "login":
			if (isset($_SESSION['account_axpired']))
				unset($_SESSION['account_axpired']);
			if (isset($_SESSION['notActivated']))
				unset($_SESSION['notActivated']);
			if (isset($_SESSION['accountProblem']))
				unset($_SESSION['accountProblem']);	
			if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
				unset($_SESSION['loggedin']);					
			}
			if (isset($_SESSION['credit_limit'])){
				unset($_SESSION['credit_limit']);
			}
			
			$user_login = $login->login_authenticate($_POST['username'], $_POST['password']);
			$login->update_last_login($user_login['id']);
			$user_type = $user_login['user_type'];
			$_SESSION['user_type'] = $user_type;			
			if ($user_type != "S"){
				if (($user_login['success']) && (!$user_login['expired']) && (!$user_login['notActivated'])){
						$_SESSION['loggedin'] = $user_login['success'];
						$_SESSION['logged_user_id'] = $user_login['id'];
						$_SESSION['credit_limit'] = $user_login['credit_limit'];						
						$_SESSION['first_name'] = $user_login['first_name'];					
						$_SESSION['last_visited_page'] = $_SERVER['HTTP_REFERER'];
						redirect_to('index.php?cntrl=users&view=loggedin');			
				}else{
						$_SESSION['accountProblem'] = true;						
						if ($user_login['expired']){
							$_SESSION['account_axpired'] = true;
						}
						if ($user_login['notActivated']){
							$_SESSION['notActivated'] = true;
						}						
						flash_warning('<span style=\'color:#f00;\'>&nbsp;&nbsp;-------->&nbsp;&nbsp;error !</span>');						
						redirect_to('index.php?cntrl=users&view=loginError');			
				}	
			}else{
				if ($user_login['success']){
						$_SESSION['loggedin'] = $user_login['success'];
						$_SESSION['logged_user_id'] = $user_login['id'];
						$_SESSION['first_name'] = $user_login['first_name'];											
						$_SESSION['last_visited_page'] = $_SERVER['HTTP_REFERER'];
						redirect_to('index.php?cntrl=users&view=loggedin');	
				}
			}	
		break;
		
		case "loginError":
				$_SESSION['loggedin'] = false;		
				flash_warning('<span style=\'color:#f00;\'>&nbsp;&nbsp;-------->&nbsp;&nbsp;error !</span>');	
				header("Refresh: 2; url=".$_SERVER['HTTP_REFERER']);																						
		break;
		
		case "loggedin":
			if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
					
					flash_notice('<span style=\'color:#06f;\'>You have successfully logged in to the system</span>');			
					$view = "loggedin";
					if ((strstr($_SESSION['last_visited_page'], "clear")) || (strstr($_SESSION['last_visited_page'], "error"))){
						$lastVisitedPage = "index.php?cntrl=index&view=index";
					}else{
						$lastVisitedPage = $_SESSION['last_visited_page'];					
					}					
					header("Refresh: 3; url=".$lastVisitedPage);													
			}else{
					header("Location: http://localhost/drelb/index.php?cntrl=index&view=index");											
			}	
		break;

		case "clear":
				flash_notice('<span style=\'color:#06f;\'>You have successfully logged out from the the system</span>');			
				
				if (isset($_SESSION['loggedin'])){
					unset($_SESSION['loggedin']);
				}
				if (isset($_SESSION['logged_user_id'])){	
					unset($_SESSION['logged_user_id']);
				}							
				if (isset($_SESSION['first_name'])){
					unset($_SESSION['first_name']);		
				}
				if (isset($_SESSION['transactionAccpeted'])){
					unset($_SESSION['transactionAcceptedText']);			
					unset($_SESSION['transactionAccpeted']);									
				}							
				if (isset($_SESSION['transactionErrorCode'])){
					unset($_SESSION['transactionErrorCode']);
				}
				if (isset($_SESSION['user_type'])){
					unset($_SESSION['user_type']);
				}				
				if (isset($_SESSION['user_payment'])){
					unset($_SESSION['user_payment']);
				}				
				if (isset($_SESSION['amount_to_reduce'])){
					unset($_SESSION['amount_to_reduce']);
				}				
				if (isset($_SESSION['errors'])){
					unset($_SESSION['errors']);
				}				
				if (isset($_SESSION['user_validate_err_msg'])){
					unset($_SESSION['user_validate_err_msg']);
				}				
				if (isset($_SESSION['credit_limit'])){
					unset($_SESSION['credit_limit']);
				}				
				
		break;

		case "payments":
			
			if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
			
				if (isset($_POST['pay_1'])){
					$_SESSION['amount_to_reduce'] = 1;
				}elseif (isset($_POST['pay_1'])){
					$_SESSION['amount_to_reduce'] = 3;				
				}
				
				$security_question_and_answer = $user_get->get_user_security_question_answer($_SESSION['logged_user_id']);				
				
				$view = "payments";				
				if (isset($_POST['user_payment'])){
					$_SESSION['user_payment'] = $_POST['user_payment'];				
					$ccCorrectedInfo = $user_validate->validateUserPaymentInfo($_POST['user_payment']);					
					// By default, this sample code is designed to post to our test server for
					// developer accounts: https://test.authorize.net/gateway/transact.dll
					// for real accounts (even in test mode), please make sure that you are
					// posting to: https://secure.authorize.net/gateway/transact.dll
					$post_url = "https://test.authorize.net/gateway/transact.dll";
					
					$post_values = array(
						
						// the API Login ID and Transaction Key must be replaced with valid values
						"x_login"			=> "54PB5egZ",
						"x_tran_key"		=> "48V258vr55AE8tcg",
					
						"x_version"			=> "3.1",
						"x_delim_data"		=> "TRUE",
						"x_delim_char"		=> "|",
						"x_relay_response"	=> "FALSE",
					
						"x_type"			=> "AUTH_CAPTURE",
						"x_method"			=> "CC",
						"x_card_num"		=> $ccCorrectedInfo['ccNumber'],
						"x_exp_date"		=> $ccCorrectedInfo['expDate'],
					
						"x_amount"			=> $_SESSION['amount_to_reduce'],
					
						"x_first_name"		=> $_SESSION['first_name'],
						// Additional fields can be added here as outlined in the AIM integration
						// guide at: http://developer.authorize.net
					);
					// This section takes the input fields and converts them to the proper format
					// for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
					$post_string = "";
					foreach( $post_values as $key => $value )
						{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
					$post_string = rtrim( $post_string, "& " );
					
					// This sample code uses the CURL library for php to establish a connection,
					// submit the post, and record the response.
					// If you receive an error, you may want to ensure that you have the curl
					// library enabled in your php configuration
					$request = curl_init($post_url); // initiate curl object
					curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
					curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
					curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
					curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
					$post_response = curl_exec($request); // execute curl post and store results in $post_response
					// additional options may be required depending upon your server configuration
					// you can find documentation on curl options at http://www.php.net/curl_setopt
					curl_close ($request); // close curl object
					
					// This line takes the response and breaks it into an array using the specified delimiting character
					$response_array = explode($post_values["x_delim_char"],$post_response);
					// individual elements of the array could be accessed to read certain response
					// fields.  For example, response_array[0] would return the Response Code,
					// response_array[2] would return the Response Reason Code.
					// for a list of response fields, please review the AIM Implementation Guide
					if ($response_array[0] == 1){						
						$_SESSION['transactionAccpeted'] = true;
						$_SESSION['transactionAcceptedText'] = $response_array[3];
						
						list($path, $mov_no) = explode("mov=", $_SESSION['viewedMoviePath']);
						$mov_title_viewed = $user_get->get_user_viewed_movie_name($mov_no);
						$user_reg->notify_user_paid_movies($_SESSION['logged_user_id'], $mov_title_viewed);
						
						redirect_to(str_replace("/drelb/", "", $_SESSION['viewedMoviePath']));
					}else{
						$_SESSION['transactionAccpeted'] = false;					
						$_SESSION['transactionErrorCode'] = $response_array[0];
						redirect_to(str_replace("/drelb/", "", $_SESSION['viewedMoviePath']));						
					}
				}
			}else{
					header("Location: http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=index");											
			}	
		break;
		
		case "loginHelp":
			if (isset($_POST['send_mail_request'])){
				$_SESSION['loginHelp'] = $_POST['loginHelp'];	
				$required_fields = $user_validate->validate_user_login_help($_POST['loginHelp'], $_GET['subView']);
				
				$user_email = $required_fields['Email'];
				if ($_GET['subView'] == "uname"){
					$password = $required_fields['Password'];
					$username = $user_get->get_user_username($user_email);					
				}elseif ($_GET['subView'] == "pword"){
					$username = $required_fields['Username'];					
					$password = $user_get->get_user_password($user_email);
				}	
				$from_header =  "Your Username and Password from the account http://www.drelb.com"; 
				$from = USER_ACTIVATION_EMAIL;
				$contents = "Dear " . $user_firstname .",\n \n Here are the Account Details Username --->    {$username} \n \n Password ---->    {$password}\n \n ";
				$subject = "Your Account Details";
				if(!$email->send_email($subject, $from, $from_header, $contents,'', '', '', $user_email, '', '')){
					$_SESSION['user_validate_err_msg'] = "<span style=\'color:#ff0000; font-size:16px; font-weight:bold;\'>Email Send failed..</span>";
				}
				if ($_GET['subView'] == "uname"){
					$required = "Username";
				}elseif ($_GET['subView'] == "pword"){
					$required = "Password";					
				}
				$successMessage = "<span style='font-size:11px; color:#06f;'>Your {$required} has been send to your email. Please check...</span>";
				unset($_SESSION['loginHelp']);
				unset($_SESSION['errors']);
				unset($_SESSION['user_validate_err_msg']);				

				function js_redirect($url, $seconds=2){
				
					echo "<script language=\"JavaScript\">\n";
					echo "<!-- hide code from displaying on browsers with JS turned off\n\n";
					echo "function redirect() {\n";
					echo "window.location = \"" . $url . "\";\n";
					echo "}\n\n";
					echo "timer = setTimeout('redirect()', '" . ($seconds*1000) . "');\n\n";
					echo "-->\n";
					echo "</script>\n";
					
						return true;
				}
				
				js_redirect("http://www.drelb.com/index.php?cntrl=index&view=index&page=1", "3");	
			}
		break;

		case "viewProfile":
			$userCreditLimit = "$" . $_SESSION['credit_limit'];
			$numberOfMoviesWatched = $user_get->get_count_of_user_viewed_movies($_SESSION['logged_user_id']);
			$memberSince = substr($user_get->get_user_registered_date($_SESSION['logged_user_id']), 0, -3);
		break;
		
		case "pwChange":
			if (isset($_POST['changePW'])){
				$required_fields = $user_validate->validate_change_password_options($_POST['changePW'], $_SESSION['logged_user_id']);			
				if ($user_reg->change_user_password($_SESSION['logged_user_id'], $required_fields['new_password'])){
					$successMsg = "<span style='color:#06f; font-size:12px;'>Your Password has been changed</span>";
					if (isset($_SESSION['errors'])){
						unset($_SESSION['errors']);
						unset($_SESSION['user_validate_err_msg']);
					}
				}
			}	
		break;

	}

?>