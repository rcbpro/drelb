<?php 
		/*
		if (isset($_SESSION['errors'])){		
		
			foreach($_SESSION['errors'] as $err_name => $err_val){
				switch($err_val){
				
					case "creditCardNumber":
					case "Invalid Credit Card Number":
						$ccnumberError = true;
					break;	
					
					case "expiryDate":
					case "Credit Card Expired":					
						$expDateNotPresent = true;
					break;	
					
					case "creditCardType":
						$ccTypeNotPresent = true;
					break;	
					
					case "security_answer":
						$ccnumberSecAnswerError = true;
					break;
					
				}
			}		
		}
		*/
?>
<tr>
	<td class="con-up"><!-- --></td>
</tr>
<tr>
	<td align="center" valign="top" class="con-middle">
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
	                        <td width="23">&nbsp;</td>
	                        <td width="470" class="title">Your Payment Informations</td>
	                        <td width="20">&nbsp;</td>
	        </tr>
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                                                  
                </table>
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<!--<tr>
				<td width="23">&nbsp;</td>
				<td width="470" class="text11">Please fill the following fields in order to complete your transaction.</td>
				<td width="20">&nbsp;</td>
			</tr>-->                      
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                            
                </table>                    
                <table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="30">&nbsp;</td>
				<td width="470">
					<!--<form name="user_reg" id="user_reg" action="http://<?php //echo  $_SERVER['HTTP_HOST'];?>/drelb/index.php?cntrl=users&view=payments" method="post">-->
					<table width="470" border="0" cellspacing="3" cellpadding="0">  
                    <?php
                         echo $_SESSION['viewedMoviePath'];
						// Print the Amount and Description to the screen.
						echo "Amount: $ $amount <br /><br />";
						//echo "Description: $description <br />";
						
						// Create the HTML form containing necessary SIM post values
						echo "<FORM method='post' action='$url' >";
						// Additional fields can be added here as outlined in the SIM integration guide
						// at: http://developer.authorize.net
						echo "	<INPUT type='hidden' name='x_login' value='$loginID' />";
						echo "	<INPUT type='hidden' name='x_amount' value='$amount' />";
						//echo "	<INPUT type='hidden' name='x_description' value='$description' />";
						echo "	<INPUT type='hidden' name='x_invoice_num' value='$invoice' />";
						echo "	<INPUT type='hidden' name='x_fp_sequence' value='$sequence' />";
						echo "	<INPUT type='hidden' name='x_fp_timestamp' value='$timeStamp' />";
						echo "	<INPUT type='hidden' name='x_fp_hash' value='$fingerprint' />";
						echo "	<INPUT type='hidden' name='x_test_request' value='$testMode' />";
						echo "	<INPUT type='hidden' name='x_show_form' value='PAYMENT_FORM' />";
						//echo "	<input type='submit' value='$label' />";
						echo "  <input type='hidden' name='x_receipt_link_method' value='link' />";
						echo "  <input type='hidden' name='x_receipt_link_text' value='Return to our online store' />";
						echo "  <input type='hidden' name='x_receipt_link_URL' value='http://www.drelb.com' />";
						echo "  <input type='hidden' name='x_relay_response' value='TRUE' />";
						echo "  <input type='hidden' name='x_relay_url' value=http://www.drelb.com/index.php?cntrl=users&view=payments' />";
						echo "  <input type='submit' value='Click here for the secure payment' class='btn-element-sub' style='width:175px;' />";
						echo "  </FORM>";
						              
				?>
						<!--<tr>
							<td width="140" align="left" valign="top" class="text12-para">Credit Card Type</td>
							<td width="330" align="left" valign="top">
                            	<select name="user_payment[creditCardType]" id="creditCardType" class="<?php //if ($ccTypeNotPresent) { echo "dd-element_error"; } else { echo "dd-element"; }?>" style="width:134px;">
                                	<option value="">Select Card Type</option>
                                	<option value="American Express" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "American Express")) ? "selected" : ""; ?>>American Express</option>
                                	<option value="Diners Club Carte Blanche" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Diners Club Carte Blanche")) ? "selected" : ""; ?>>Diners Club Carte Blanche</option>
                                	<option value="Diners Club" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Diners Club")) ? "selected" : ""; ?>>Diners Club</option>
                                	<option value="Discover" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Discover")) ? "selected" : ""; ?>>Discover</option>
                                	<option value="JCB" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "JCB")) ? "selected" : ""; ?>>JCB</option>
                                	<option value="Maestro" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Maestro")) ? "selected" : ""; ?>>Maestro</option>
                                	<option value="MasterCard" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "MasterCard")) ? "selected" : ""; ?>>MasterCard</option>                                                                        
                                	<option value="Solo" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Solo")) ? "selected" : ""; ?>>Solo</option>                                    
                                	<option value="Switch" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Switch")) ? "selected" : ""; ?>>Switch</option>                                    
                                	<option value="Visa" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Visa")) ? "selected" : ""; ?>>Visa</option>                                    
                                	<option value="Visa Electron" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "Visa Electron")) ? "selected" : ""; ?>>Visa Electron</option>                                                                                                                                                
                                	<option value="LaserCard" <?php //echo (isset($_SESSION['user_payment']['creditCardType']) && ($_SESSION['user_payment']['creditCardType'] == "LaserCard")) ? "selected" : ""; ?>>LaserCard</option>                                                                                                                                                
                                </select>
							</td>
						</tr>                    
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Credit Card Number</td>
							<td width="330" align="left" valign="top">
								<input name="user_payment[creditCardNumber]" type="text" class="<?php //if ($ccnumberError) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="ccnumber" value="" />
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">Expiry Date</td>
							<td width="330" align="left" valign="top">
								<input name="user_payment[expiryDate]" type="text" class="<?php //if ($expDateNotPresent) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="exp_date" value="<?php //echo (isset($_SESSION['user_payment']['creditCardNumber'])) ? $_SESSION['user_payment']['expiryDate'] : '';?>" />
								<script type="text/javascript">
                                      var cal = Calendar.setup({
                                          onSelect: function(cal) { cal.hide() }
                                      });
                                      cal.manageFields("exp_date", "exp_date", "%Y-%m-%d");
                                </script>                                                                
							</td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para" colspan="2" style="color:#06f;"><?php //echo $security_question_and_answer['security_question'];?></td>
						</tr>                                            
						<tr>
                        	<td width="140" align="left" valign="top" class="text12-para">Your Answer</td>
							<td width="330" valign="top" align="left">
								<input name="user_payment[security_answer]" type="text" class="<?php //if ($ccnumberSecAnswerError) { echo "error_field_uname"; } else { echo "input-element-uname"; }?>" id="security_answer" value="" />
							</td>
						</tr>
						<tr>
                        	<td width="140" align="left" valign="top" class="text12-para" colspan="2" style="font-size:11px; color:#06f;">
                            	* Important : This was the question asked from you when the time you registered with the system. Please make sure to answer correctly.
                                Your answer will help to verify the actual owner of the credit card number you entered.
                            </td>
						</tr>
						<tr>
							<td width="140" align="left" valign="top" class="text12-para">&nbsp;</td>
							<td width="330" align="left" valign="top">
								<input id="submit_cc_info" class="btn-element-sub" type="submit" name="submit_cc_info" value="proceed" />
							</td>
						</tr>-->
						<?php //if (isset($_SESSION['user_validate_err_msg'])):?>
                        <!--<tr>
                            <td colspan="3"><?php //echo $_SESSION['user_validate_err_msg'];?></td>
                        </tr>        -->
                        <?php //endif;?>                        
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