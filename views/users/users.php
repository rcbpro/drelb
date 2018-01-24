<?php
	if (strstr($_SERVER['REQUEST_URI'], 'edit')){
		$form_url = 'update';
		$submit_button = array('name' => 'user[update]', 'value' => 'update');
	}else{
		$form_url = 'create';	
		$submit_button = array('name' => 'user[register]', 'value' => 'register');		
	}
	
	if (isset($_SESSION['new_user_registered']))
		unset($_SESSION['new_user_registered']);

	if (isset($_SESSION['flash']['notice']))
		unset($_SESSION['flash']['notice']);
	
	if (isset($_SESSION['errors'])){		
		foreach($_SESSION['errors'] as $err_name => $err_val){
			switch($err_val){
			
				case "firstname":
					$firstname_error = true;
				break;	

				case "lastname":
					$lastname_error = true;
				break;	
			
				case "username":
				case "username exist":
				case "Username dose not meet the minimun length":
					$user_name_error = true;
				break;	
				
				case "password":
				case "Password dose not meet the minimun length":
					$password_error = true;
				break;	

				case "confirm_password":
				case "Passwords not equal":
					$confirm_password_error = true;
				break;	

				case "security_question":
					$sec_question_error	= true;			
				break;

				case "security_answer":
					$sec_answer_error = true;
				break;

				case "allowd_credits":
				case "Entered value for credits are not in currency type":
					$allowd_credits_error = true;
				break;
/*
				case "date_of_birth":
					$dateOfBirth_error = true;
				break;	

				case "gender":
					$gender_error = true;
				break;					
*/
				case "email":
				case "Invalid email":
				case "email exist":
					$email_error = true;
				break;	
/*
				case "security_code":
				case "captcha":
					$captcha_error = true;
				break;	*/
			}
		}		
	}
?>
<tr>
	<td class="con-up"><!-- --></td>
</tr>
<tr>
	<td align="center" valign="top" class="con-middle">
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
	                        <td width="23">&nbsp;</td>
	                        <td width="470" class="title">Register</td>
	                        <td width="20">&nbsp;</td>
	        </tr>
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                                                  
                </table>
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="23">&nbsp;</td>
				<td width="470" class="text11">To create an account, please fill in the following information. If you are already registered, then please login.</td>
				<td width="20">&nbsp;</td>
			</tr>                      
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                                                    
			<tr>
            	<td>&nbsp;</td>
				<td colspan="2" width="23"><span style="font-size:9px; color:#f00;">* All fields are required...</span></td>
			</tr>                                            
                </table>                    
                <table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="30">&nbsp;</td>
				<td width="470">
					<form name="user_reg" id="user_reg" action="http://<?php echo  $_SERVER['HTTP_HOST'];?>/drelb/index.php?cntrl=users&view=create" method="post">
					<table width="470" border="0" cellspacing="3" cellpadding="0">
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">First name</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[firstname]" type="text" class="<?php if ($firstname_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="firstname" value="<?php echo (isset($_SESSION['user_prof']['firstname'])) ? $_SESSION['user_prof']['firstname'] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Last Name</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[lastname]" type="text" class="<?php if ($lastname_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="lastname" value="<?php echo (isset($_SESSION['user_prof']['lastname'])) ? $_SESSION['user_prof']['lastname'] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Enter User Name</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[username]" type="text" 
                                class="<?php if ($user_name_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" 
                                id="username" value="<?php if (isset($_SESSION['user_prof']['username'])){
																echo $_SESSION['user_prof']['username'];
															}else if(isset($_POST['user_prof']['username'])){
																echo $_POST['user_prof']['username'];
															}else{
																echo "";
															}
													?>" />	
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Enter Password</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[password]" type="password" class="<?php if ($password_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="password_reg" value="<?php echo (isset($_SESSION['user_prof']['password'])) ? $_SESSION['user_prof']['password'] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Confirm Password</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[confirm_password]" type="password" class="<?php if ($confirm_password_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="conf_password" value="<?php echo (isset($_SESSION['user_prof']['confirm_password'])) ? $_SESSION['user_prof']['confirm_password'] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Security Question</td>
							<td width="330" align="left" valign="top">
								<select name="user_prof[security_question]" class="<?php if ($sec_question_error) { echo "dd-element_error"; } else { echo "dd-element"; }?>" id="sec_question_error" style="width:300px !important;">                                	                                
									<option value="">Select Security Question</option>
									<option <?php echo ((isset($_SESSION['user_prof']['security_question'])) && ($_SESSION['user_prof']['security_question'] == "What was your childhood nickname ?")) ? "selected" : "";?> value="What was your childhood nickname?">What was your childhood nickname ?</option>
									<option <?php echo ((isset($_SESSION['user_prof']['security_question'])) && ($_SESSION['user_prof']['security_question'] == "What is the name of your favorite childhood friend ?")) ? "selected" : "";?> value="What is the name of your favorite childhood friend ?">What is the name of your favorite childhood friend ?</option>
									<option <?php echo ((isset($_SESSION['user_prof']['security_question'])) && ($_SESSION['user_prof']['security_question'] == "What was the last name of your third grade teacher ?")) ? "selected" : "";?> value="What was the last name of your third grade teacher ?">What was the last name of your third grade teacher ?</option>
									<option <?php echo ((isset($_SESSION['user_prof']['security_question'])) && ($_SESSION['user_prof']['security_question'] == "What school did you attend for sixth grade ?")) ? "selected" : "";?> value="What school did you attend for sixth grade ?">What school did you attend for sixth grade ?</option>
									<option <?php echo ((isset($_SESSION['user_prof']['security_question'])) && ($_SESSION['user_prof']['security_question'] == "What street did you live on in third grade ?")) ? "selected" : "";?> value="What street did you live on in third grade ?">What street did you live on in third grade ?</option>
									<option <?php echo ((isset($_SESSION['user_prof']['security_question'])) && ($_SESSION['user_prof']['security_question'] == "What was the name of your first stuffed animal ?")) ? "selected" : "";?> value="What was the name of your first stuffed animal ?">What was the name of your first stuffed animal ?</option>                                                                                                                                                
								</select>                            
							</td>
						</tr>                                                
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Answer</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[security_answer]" type="text" class="<?php if ($sec_answer_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="security_answer" value="<?php echo (isset($_SESSION['user_prof']['security_answer'])) ? $_SESSION['user_prof']['security_answer'] : '';?>" />
							</td>
						</tr>                        
						<tr>
							<td width="140" align="left" valign="top" class="text12-para" style="padding-top:2px;">Credits Limit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#c95b00;">$</span></td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[allowd_credits]" type="text" class="<?php if ($allowd_credits_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="allowd_credits" value="<?php echo (isset($_SESSION['user_prof']['allowd_credits'])) ? $_SESSION['user_prof']['allowd_credits'] : '';?>" />
							</td>
						</tr>                                                
						<tr>
							<td width="140" align="left" valign="top" class="text12-para" colspan="2"><span style="font-size:11px; font-weight:bold; color:#f00;">* Important :  Please make sure that the credit amount you entered in the above field should exist in your credit balance in your credit card. If not the transaction will not be processed.</span></td>
						</tr>                                                
						<!--<tr>
							<td width="140" align="left" valign="top" class="text12-para">Date of Birth</td>                              
							<td width="330" align="left" valign="top">
			    				<input type="text" size="30" name="user_prof[date_of_birth]" id="date_of_birth" class="<?php //if ($dateOfBirth_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" value="<?php //echo (isset($_SESSION['user_prof']['date_of_birth'])) ? $_SESSION['user_prof']['date_of_birth'] : '';?>" />                            
								<script type="text/javascript">
                                      var cal = Calendar.setup({
                                          onSelect: function(cal) { cal.hide() }
                                      });
                                      cal.manageFields("date_of_birth", "date_of_birth", "%Y-%m-%d");
                                </script>                                
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Gender</td>
							<td width="330" align="left" valign="top">
								<select name="user_prof[gender]" class="<?php //if ($gender_error) { echo "dd-element_error"; } else { echo "dd-element"; }?>" id="gender" style="width:115px !important;">                                	                                
									<option value="">Select gender</option>
									<option <?php //echo ((isset($_SESSION['user_prof']['gender'])) && ($_SESSION['user_prof']['gender'] == "male")) ? "selected" : "";?> value="male">Male</option>
									<option <?php //echo ((isset($_SESSION['user_prof']['gender'])) && ($_SESSION['user_prof']['gender'] == "female")) ? "selected" : "";?> value="female">Female</option>
								</select>
							</td>
						</tr>-->
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Email Address</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[email]" type="text" 
                                class="<?php if ($email_error) { echo "error_field_email"; } else { echo "input-element-email"; }?>" 
                                id="email" 
                                value="<?php 
											if (isset($_SESSION['user_prof']['email'])){
												echo $_SESSION['user_prof']['email'];
											}else if(isset($_POST['user_prof']['email'])){
												echo $_POST['user_prof']['email'];
											}else{
												echo "";
											}
										?>" />
							</td>
						</tr>
						<!--<tr>
							<td width="140" align="left" valign="top" class="text12-para">&nbsp;</td>
							<td width="330" align="left" valign="top">
									<img id="captcha" src="./lib/CaptchaSecurityImages.php?width=100&height=40&characters=5" /><span style="color:#f00; font-size:11px;">* Case Sensitive</span>                                                                    
							</td>
						</tr>     
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">&nbsp;</td>
							<td width="330" align="left" valign="top">
                            		<a href="" class="searchLink" onclick="document.getElementById('captcha').src = './lib/CaptchaSecurityImages.php?width=100&height=40&characters=5">Try Different Image</a>
							</td>
						</tr>                             
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Security Code</td>
							<td width="330" align="left" valign="top">
								<input name="user_prof[security_code]" type="text" id="security_code" class="<?php //if ($captcha_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" />
							</td>
						</tr>-->                                                
                        <tr>
                        	<td colspan="2">&nbsp;</td>
                        </tr>                                                                   
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">&nbsp;</td>
							<td width="330" align="left" valign="top">
								<input id="new_user_submit" class="btn-element-sub" type="submit" name="user[register]" value="register" />
							</td>
						</tr>
                        <tr>
                        	<td colspan="2">&nbsp;</td>
                        </tr>                                                                   
						<?php if (isset($_SESSION['user_validate_err_msg'])):?>
                        <tr>
                            <td colspan="3"><?php echo $_SESSION['user_validate_err_msg'];?></td>
                        </tr>        
                        <?php endif;?>                        
					</table>
					</form>
				</td>
				<td>&nbsp;</td>
				<td></td><td width="15">&nbsp;</td>
			</tr>
                </table>
        </td>
</tr>
<tr>
	<td class="con-down">&nbsp;</td>
</tr>    