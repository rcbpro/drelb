<?php
	if (isset($_GET['subView'])){
		switch($_GET['subView']){
		
			case "uname":
				$fieldname2 = "Password";
				$fieldname2Type = "password";				
				$submit_button = "Username";				
			break;
			
			case "pword":
				$fieldname2 = "Username";
				$fieldname2Type = "text";
				$submit_button = "Password";	
			break;
		}
		$fieldname1 = "First name";
		$fieldname1ForPost = "Firstname";		
		$fieldname3 = "Email";		
	}
		
	if (isset($_SESSION['errors'])){		
		foreach($_SESSION['errors'] as $err_name => $err_val){			
				
			switch($err_val){
			
				case "Firstname":
				case "This name does not exist !":
					$firstname_error = true;
				break;	

				case "Password":
				case "This Password is Incorrect !":
					if ($_GET['subView'] == "pword"){
						$usernameOrPasswordError = "password_error";
					}	
						$usernameOrPasswordError = true;
				break;	
				
				case "Email":
				case "This Email does not exist !":
					$email_error = true;
				break;
				
				case "This Username does not exist !":	
				case "Username":
					if ($_GET['subView'] == "uname"){
						$usernameOrPasswordError = "username_error";
					}					
					$usernameOrPasswordError = true;
				break;
			
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
                <td width="470" class="title">Login Help</td>
                <td width="20">&nbsp;</td>
	        </tr>
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                                                  
                </table>
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="23">&nbsp;</td>
				<td width="470" class="text11">To continue to help with Login please fill the below form.</td>
				<td width="20">&nbsp;</td>
			</tr>                      
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                            
                </table>                    
                <table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="30">&nbsp;</td>
				<td width="470">
					<form name="loginHelpForm" id="loginHelpForm" action="http://<?php echo  $_SERVER['HTTP_HOST'];?>/drelb/index.php?cntrl=users&view=loginHelp&subView=<?php echo $_GET['subView'];?>" method="post">
					<table width="470" border="0" cellspacing="3" cellpadding="0">
						<tr>
							<td width="140" align="left" valign="top" class="text12-para"><?php echo $fieldname1;?></td>
							<td width="330" align="left" valign="top">
								<input name="loginHelp[<?php echo $fieldname1ForPost;?>]" type="text" class="<?php if ($firstname_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="<?php echo $fieldname1ForPost;?>" value="<?php echo (isset($_SESSION['loginHelp'][$fieldname1ForPost])) ? $_SESSION['loginHelp'][$fieldname1ForPost] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para"><?php echo $fieldname2;?></td>
							<td width="330" align="left" valign="top">
								<input name="loginHelp[<?php echo $fieldname2;?>]" type="<?php echo $fieldname2Type;?>" class="<?php if ($usernameOrPasswordError) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="<?php echo $fieldname2;?>" value="<?php echo (isset($_SESSION['loginHelp'][$fieldname2])) ? $_SESSION['loginHelp'][$fieldname2] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para"><?php echo $fieldname3;?></td>
							<td width="330" align="left" valign="top">
								<input name="loginHelp[<?php echo $fieldname3;?>]" type="text" class="<?php if ($email_error) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="<?php echo $fieldname3;?>" value="<?php echo (isset($_SESSION['loginHelp'][$fieldname3])) ? $_SESSION['loginHelp'][$fieldname3] : '';?>" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">&nbsp;</td>
							<td width="330" align="left" valign="top">
								<input id="send_mail_request" class="btn-element-sub" type="submit" name="send_mail_request" value="Get <?php echo $submit_button;?>" style="width:125px;" />
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
						<?php if ($successMessage != ""):?>
                        <tr>
                            <td colspan="3"><?php echo $successMessage;?></td>
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