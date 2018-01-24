<?php
	if (isset($_SESSION['errors'])){		
		foreach($_SESSION['errors'] as $err_name => $err_val){			
				
			switch($err_val){
			
				case "current_password":
				case "Password Incorrect !":
					$currPasswordError = true;
				break;
				
				case "new_password":
				case "confirm_password":
				case "Passwords are not equal !":
					$newPasswordsError = true;				
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
	                        <td width="470" class="title">Change My Password</td>
	                        <td width="20">&nbsp;</td>
	        </tr>
        </table>
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                            
         </table>                    
         <table width="513" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="30">&nbsp;</td>
                <td width="470">
                    <table width="470" border="0" cellspacing="3" cellpadding="0">
                    	<form name="changePasswordForm" id="changePasswordForm" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/index.php?cntrl=users&view=pwChange" method="post">
                        <tr>
                            <td width="140" align="left" valign="top" class="text12-para">Current Password</td>
                            <td width="330" align="left" valign="top"><span style="color:#06f; font-size:11px;"><input type="password" name="changePW[current_password]" id="current_password" value="" class="<?php if ($currPasswordError) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" /></span></td>
                        </tr>
                        <tr>
                            <td width="140" align="left" valign="top" class="text12-para">New Password</td>
                            <td width="330" align="left" valign="top"><span style="color:#06f; font-size:11px;"><input type="password" name="changePW[new_password]" id="new_password" value="" class="<?php if ($newPasswordsError) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" /></span></td>
                        </tr>
                        <tr>
                            <td width="140" align="left" valign="top" class="text12-para">Confirm Password</td>
                            <td width="330" align="left" valign="top"><span style="color:#06f; font-size:11px;"><input type="password" name="changePW[confirm_password]" id="confirm_password" value="" class="<?php if ($newPasswordsError) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" /></span></td>
                        </tr>
                        <tr>
                            <td width="140" align="left" valign="top" class="text12-para">&nbsp;</td>                        
                            <td width="440" align="left" valign="top"><input type="submit" name="changePassword" style="width:120px;" id="changePassword" value="Change Password" class="btn-element-sub" /></td>
                        </tr>
                        <tr>
                        	<td colspan="2">&nbsp;</td>
                        </tr>                                                                                           
						<?php if (isset($_SESSION['user_validate_err_msg'])):?>
                        <tr>
                            <td colspan="3"><?php echo $_SESSION['user_validate_err_msg'];?></td>
                        </tr>        
                        <?php endif;?>                                                
						<?php if (isset($successMsg)):?>
                        <tr>
                            <td colspan="3"><?php echo $successMsg;?></td>
                        </tr>        
                        <?php endif;?>                                                                        
                        </form>
                    </table>
                </td>
            </tr>
        </table>
        </td>
</tr>
<tr>
	<td class="con-down">&nbsp;</td>
</tr>    