<?php
	if (isset($_SESSION['user_prof'])){
		unset($_SESSION['user_prof']);
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
                <td width="470" class="title">Login Success</td>
                <td width="20">&nbsp;</td>
	        </tr>
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                                                  
        </table>
		<table width="513" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="23">&nbsp;</td>
				<td width="470" class="text11" style="text-align:center;">
                	<?php if (isset($_SESSION['flash']['notice'])){
						echo $_SESSION['flash']['notice'];
					}
					?>
                </td>
			</tr>                              
            <tr>
				<td width="20">&nbsp;</td>
				<td width="23" class="text11" style="text-align:center;">You will be redirected to the last visited page : If not click <a href="<?php 				
																							if (isset($_SESSION['last_visited_page'])){ 
																								if ((strpos($_SESSION['last_visited_page'], "clear")) || (strstr($_SESSION['last_visited_page'], "error"))){	
																									echo "http://{$_SERVER['HTTP_HOST']}/drelb/";
																								}else{
																									echo $_SESSION['last_visited_page'];
																								}	
																							}	
																							?>">here</a> to go to that page.</td>
				<td width="23">&nbsp;</td>                            
            </tr>
			<tr>
				<td width="23">&nbsp;</td>
				<td width="470" class="text11" style="text-align:center;">Click <a href="<?php echo "http://".$_SERVER['HTTP_HOST'].'/drelb/';?>">here</a> to return to the index...</td>
				<td width="20">&nbsp;</td>            
			</tr>                             
			<tr>
				<td colspan="3" width="23">&nbsp;</td>
			</tr>                                                                              
     	</table>                    
     </td>
</tr>
<tr>
	<td class="con-down">&nbsp;</td>
</tr>    