<?php
	if (isset($_SESSION['errors'])){
		foreach($_SESSION['errors'] as $err_name => $err_val){
			switch($err_val){
			
				case "newname":
					$inputNewName = true;
				break;	
				
				case "password":
					$inputPasswordError = true;
				break;	

				case "confirmpassword":
				case "Passwords are not same":				
					$inputConfrimPassword = true;
				break;	
				
			}
		}		
	}
?>
<form name="adminContentAdd" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=newadminuser" enctype="multipart/form-data" method="post">
<div id="leftSide" class="defaultFont">
	<div id="titleInputDiv">
    	Admin name <input type="text" name="newadmin[newname]" id="adminname" class="<?php if ($inputNewName) { echo "error_field_uname"; } else { echo "adminInput"; }?>" value="<?php echo (isset($_SESSION['newadmin']['newname'])) ? $_SESSION['newadmin']['newname'] : '';?>" style="margin-left:57px; width:250px;" />
    </div>	
	<div id="titleInputDiv">
    	Password <input type="password" name="newadmin[password]" id="adminpassword" class="<?php if ($inputPasswordError) { echo "error_field_uname"; } else { echo "adminInput"; }?>" value="" style="margin-left:75px; width:250px;" />
    </div>	
	<div id="titleInputDiv">
    	Confirm Password <input type="password" name="newadmin[confirmpassword]" id="adminconfirmpassword" class="<?php if ($inputConfrimPassword) { echo "error_field_uname"; } else { echo "adminInput"; }?>" value="" style="margin-left:25px; width:250px;" />
    </div>	    
	<div id="titleInputDiv">
    	<input type="submit" name="New Admin User" id="newadminuser" class="btn-element-sub" value="Add New Admin User" style="margin-left:25px; width:250px;" />
    </div>	        
</div>
<div id="rightSide" class="defaultFont">
    <div id="validateErrorMessagesDiv"> 
	<?php if (isset($_SESSION['user_validate_err_msg'])):?>
        <?php echo $_SESSION['user_validate_err_msg'];?>
    <?php elseif ($addAdminUserMsg != ""):?>                        
        <?php echo $addAdminUserMsg;?>
    <?php endif;?>        
    </div>
</div>
</form>                                                                