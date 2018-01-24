                  <tr>
                    <td class="con-up"></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top" class="con-middle">&nbsp;</td>
                  </tr>                  
				<tr>
                    <td align="center" valign="top" class="con-middle">
                    	<table width="513" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30">&nbsp;</td>
                        <td width="468"><table width="468" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" valign="top"><div class="thumbnails">
	                           <ul>
                            	<?php if ($cur_mov_no <= $last_mov_number): ?>
                                	<span style="font-size:12px; color:#06f;">Movie : </span><span class="mov_title"><?php echo $selected_movie['movie_name']; ?></span><br /><br />
                                <?php else:?>
                                <span style="color:#f00; font-size:12px;">No movie details found in this page : This movie number does not exist !</span>                                                                
                                <?php endif;?>
                              </ul>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top">
                            	<?php if ($cur_mov_no <= $last_mov_number):?>
									<?php if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true)): ?>  
                                          <?php if ($_SESSION['transactionAccpeted'] != true):?>                                                                                                                                                                                                                                                                          		
                                                <img src="<?php echo $img_file_path; ?>" class="mov_large_img" />
                                           <?php elseif ($_SESSION['transactionAccpeted'] == true):?>     
                                                <?php echo $embedVideoHtml;?>
                       				 	   <?php endif;?>
                                     <?php else:?>
                                                <img src="<?php echo $img_file_path; ?>" class="mov_large_img" />
                                     <?php endif;?>                                                           
                                                <br /><br />                                
                                                <span style="font-size:12px; color:#06f;">Genre : </span><span class="mov_title"><?php echo $selected_movie['genre']; ?></span>                                                              
                                <?php else:?>
                                                <br />                            
                                                <span style="color:#06f; font-size:12px;"><a href="<?php echo WEBSITE;?>" class="return_index">Return to the Main Page</a></span><br />                                
                                <?php endif;?>                                
                            </td>
                          </tr>                          
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>
                          </tr>                                                                              
                          <tr>
                            <td align="center" valign="top" style="text-align:left;">
                            	<?php if ($cur_mov_no <= $last_mov_number):?>                            
                                <span style="font-size:12px; color:#06f;">Description : </span><br /><span class="mov_title" style="color:#000000 !important;"><?php echo $selected_movie['movie_description']; ?></span><br /><br />                                                                                          
								<?php endif;?>                                
                            </td>
                          </tr>  
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>
                          </tr> 
                          <?php if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true)): ?>  
							  <?php if ($_SESSION['transactionAccpeted'] != true):?>                                                                                                                                                                                                                                
                          <tr>
                            <td align="center" valign="top">
								<?php if ((isset($allowdCreditMessage)) && ($allowdCreditMessage == "")):?>                            
                            	<form name="movie_payments" id="movie_payments" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/index.php?cntrl=users&view=payments" method="post">
                                	<?php if ($mov_type == "flv"):?>
	                            	<input type="submit" value="Pay $1" id="pay_1" name="pay_1" class="btn-element-pay-download" />
                                    <?php else:?>
	                            	<input type="submit" value="Pay $3" id="pay_3" name="pay_3" class="btn-element-pay-download" />
                                    <?php endif;?>                                    
                                </form>
                                <br />
                                <?php echo (isset($successMessage)) ? $successMessage : "";?>
                                <?php endif;?>
                            </td>
                          </tr>        
                          <tr>
                            <td align="center" valign="top" class="mov_title" style="color:#f00;">
                            	<?php
									if ((isset($allowdCreditMessage)) && ($allowdCreditMessage != "")){
										echo $allowdCreditMessage;
									}
								?>
                            </td>
                          </tr>                                                                                                   
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>
                          </tr>                                                                                                                             
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>
                          </tr>                                                                         
                          		<?php endif;?>                   
                          <?php endif;?>  
						  <?php if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == false)): ?>                                                                                                                                                                                     
                          <?php if ($_SESSION['transactionAccpeted'] != true):?>
                          <tr>
                            <td align="center" valign="top" style="text-align:left; color:#f00;" class="mov_title">
<pre style="font-size:12px !important;">                            
Few things for your attention : 

* This above picture is just a screenshot of the original video
* To download this you need to pay $1 or $3<br /> with our payment processing system
* If you paid the money then this movie screenshot will be <br />  replaced with the original video (unlocked) lets you download it
<?php if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == false)):?>
* You have n't logged in to the system - <br />  Please login to pay the cash if you have
<?php endif;?>
* Pay and Download button should be appeared if you have money
</pre>
                            </td>
                          </tr>  
                          <?php endif;?>                                                
                          <?php elseif ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true)):?>   
	                          <?php if ($_SESSION['transactionAccpeted'] == true):?>                                                                 
                          <tr>
                            <td align="center" valign="top" class="mov_title">
								<?php echo $_SESSION['transactionAcceptedText'];?>
                                <br /><?php echo $_SESSION['first_name'];?> : Now you can watch the above movie.... <br /><span style="color:#06f;">Thanks...and Enjoy</span>
                            </td>                          
                          </tr>                                                                                                               
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>                          
                          </tr>                                                                  
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>                          
                          </tr>                                                                                            
    	                      <?php elseif (isset($_SESSION['transactionErrorCode'])):?>
                          <tr>
                            <td align="center" valign="top" class="mov_title">
                                <br /><span style="color:#FF0000">Sorry&nbsp;</span><?php echo $_SESSION['first_name'];?>&nbsp;: The above Transaction has been declined.<br /> Check your account balance with your credit card.<br /><span style="color:#06f;">Thanks..Come Back again.</span>
                            </td>                          
                          </tr>                                                                                                               
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>                          
                          </tr>                                                                  
                          <tr>
                            <td align="center" valign="top">&nbsp;</td>                          
                          </tr>                                                                                                                          
	                          <?php endif;?>                             
                          <?php endif;?>                          
                        </table></td>
                        <td width="15">&nbsp;</td>
                      </tr>
                    </table>
                    </td>
                    </tr>
                  <tr>
                    <td class="con-down">&nbsp;</td>
                  </tr>                    