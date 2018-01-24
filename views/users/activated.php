<?php
	$_SESSION['new_user_registered'] = true;
?>
<tr>
  <td class="con-up"></td>
</tr>
<tr>
  <td align="center" valign="top" class="con-middle">
    <img src="<?php echo $public_src;?>images/spacer.gif" width="1" height="20" />
  </td>
</tr>
<tr>
  <td align="center" valign="top" class="con-middle">
    <table width="513" border="0" cellspacing="0" cellpadding="0">
      <tr>
	<td width="23">&nbsp;</td>
	<td width="470" class="text_message">
		<?php
            if (isset($_SESSION['flash']['notice'])){
				echo $_SESSION['flash']['notice'];
			}elseif (isset($_SESSION['flash']['warning'])){
				echo $_SESSION['flash']['warning'];
			}
        ?>
	</td>
	<td width="20">&nbsp;</td>
      </tr>
      <tr>
	<td colspan="3" width="23">&nbsp;</td>
      </tr>                                                                  
    </table>
<tr>
  <td class="con-down">&nbsp;</td>
</tr>