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
        		<td width="468">
                	<table width="468" border="0" cellspacing="0" cellpadding="0">
          				<tr>
            				<td align="center" valign="top"></td>
          				</tr>
          				<tr>
            				<td align="center" valign="top">
                            	<div id="advSearchPanel">
				                	<table border="0" cellspacing="0" cellpadding="0">                                
                                    	<form name="advSearch" id="advSearch" action="" method="post">
                                    	<tr>
                                        	<td><span class="defaultText">Genre</span></td>
                                        	<td><select name="genre" id="genre" class="dd-element" style="width:120px;">
                                            			<option value="0">Select the Genre</option>
                                            		<?php
														for($i=0; $i<count($mov_cat_menu); $i++){
															echo "<option value='". $mov_cat_menu[$i]['id'] . "'>". $mov_cat_menu[$i]['cat_name'] . "</option>";
														}
													?>
                                                </select>
                                            </td>                                            
                                        </tr>
                                    	<tr>
                                        	<td colspan="2">&nbsp;</td>
                                        </tr>                                        
                                    	<tr>
                                        	<td><span class="defaultText">Movie Title</span></td>
                                        	<td><input type="text" name="title" id="title" value="" class="input-element" /></td>                                            
                                        </tr>                                        
                                    	<tr>
                                        	<td colspan="2">&nbsp;</td>
                                        </tr>                                                                                
                                    	<tr>
                                        	<td><span class="defaultText">Short Description</span></td>
                                        	<td><input type="text" name="description" id="description" value="" class="input-element" /></td>                                            
                                        </tr>                                                                                
                                    	<tr>
                                        	<td colspan="2">&nbsp;</td>
                                        </tr>                                                                                
                                    	<tr>
                                        	<td><input type="text" name="date_from" id="date_from" value="" class="input-element" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>                                            
                                        	<td><input type="text" name="date_to" id="date_to" value="" class="input-element" />
												<script type="text/javascript">
                                                      var cal = Calendar.setup({
                                                          onSelect: function(cal) { cal.hide() }
                                                      });
                                                      cal.manageFields("date_from", "date_from", "%Y-%m-%d");
                                                      cal.manageFields("date_to", "date_to", "%Y-%m-%d");													  
                                                </script>                                                                            
                                            </td>                                            
                                        </tr>                                   
                                    	<tr>
                                        	<td colspan="2">&nbsp;</td>
                                        </tr>                                                                                                                        
                                    	<tr>
                                        	<td colspan="2" align="center"><span class="defaultText">Movie Published Date between</span></td>
                                        </tr>                                                                                                
                                    	<tr>
                                        	<td colspan="2">&nbsp;</td>
                                        </tr>                                                                                                                                                                
                                    	<tr>
                                        	<td>&nbsp;</td>
                                        	<td align="right"><input type="button" name="advSearch" id="advSearch" value="Search" class="btn-element-sign-up" onclick="redirect_for_advance_search();" /></td>
                                        </tr> 
                                        </form>                                                                                                                                                                                                                               
									</table>                                                                        
                                </div>            
                            </td>
          				</tr>                          
          				<tr>
            				<td align="center" valign="top">&nbsp;</td>
          				</tr>                                                    
        			</table>
              	</td>
        		<td width="15">&nbsp;</td>
      		</tr>
    	</table>
    </td>
</tr>
<tr>
    <td class="con-down">&nbsp;</td>
</tr>                    