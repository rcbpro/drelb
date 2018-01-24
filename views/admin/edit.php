<?php
if ($bigErrorMessage == ""){
	if (isset($_SESSION['errors'])){
		foreach($_SESSION['errors'] as $err_name => $err_val){
			switch($err_val){
			
				case "movie_description":
					$inputDescError = true;
				break;	

				case "movie_released_date":
					$inputDateRelError = true;
				break;	
				
				case "imageFileNotExist":
					$imageFileNotExistError = true;
				break;
				
			}
		}		
	}
?>
<form name="adminContentAdd" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=edit&mov=<?php echo $movInfo['id'];?>&page=<?php echo $_GET['page'];?>" enctype="multipart/form-data" method="post">
<div id="leftSide" class="defaultFont">
	<div id="titleInputDiv">
    	Title <span style="color:#06f; font-weight:bold; font-size:12px; margin-left:50px; background-color:#FFFFFF;"><?php echo $movInfo['title'];?></span>
    </div>	
	<div id="genreInputDiv">
    	Genre <span style="color:#06f; font-weight:bold; font-size:12px; margin-left:40px; background-color:#FFFFFF;"><?php echo $movInfo['genre'];?></span>
    </div>	    
	<div id="descInputDiv">
    	<div id="subDivDescInput">Description</div>
        <div id="subDivDescInput2"><textarea name="adminEdit[movie_description]" id="descInput" class="<?php if ($inputDescError) { echo "error_field_uname"; } else { echo "adminInput"; }?>" style="width:390px; height:250px; margin-left:3px;"><?php echo (isset($_POST['adminEdit'])) ? $_SESSION['adminEdit']['movie_description'] : $movInfo['description'];?></textarea></div>
    </div>	    
	<div id="dateReleasedInputDiv">
    	Date<br />Released <input type="text" name="adminEdit[movie_released_date]" id="dateReleasedInput" class="<?php if ($inputDateRelError) { echo "error_field_uname"; } else { echo "adminInput"; }?>" value="<?php echo (isset($_POST['adminEdit'])) ? $_SESSION['adminEdit']['movie_released_date'] : $movInfo['date_published'];?>" style="margin-left:22px; width:150px;" />
		<script type="text/javascript">
              var cal = Calendar.setup({
                  onSelect: function(cal) { cal.hide() }
              });
              cal.manageFields("dateReleasedInput", "dateReleasedInput", "%Y-%m-%d");
        </script>                                                                                    
    </div>	    
    <div id="divHeight"><!-- --></div>
    <div id="importantNoteDiv">
    	<pre>
* Important :
            - Allowed image file types are : jpg/jpeg, png, gif.
            - Allowed maximum image file size is up to 1000 MB
		</pre>                    
    </div>
</div>
<div id="rightSide" class="defaultFont">
	<div id="titleInputDiv">
		Upload a Different Preview Image <input type="file" name="imageInput" id="imageInput" class="<?php if ($imageFileNotExistError) echo "filesErrorIndicate";?>" style="margin-left:15px;" />
    </div>    
	<div id="titleInputDiv" style="height:75px;">
		<input type="submit" name="existMovieEdit" id="existMovieEdit" style="margin-left:120px; margin-top:30px; width:175px;" class="btn-element-sign-up" value="Upload and Edit Movie Details" />
        <input type="submit" name="previewHandler" id="previewHandler" value="Preview" class="btn-element-sign-up" 
        						style="margin-left:20px; margin-top:30px; width:75px;" onclick="return popitup('http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/views/admin/preview.php')" />
    </div>
    <div id="integratedImagePreview">
    	Preview Image<br /><br />
        <img src="<?php echo $imageFilePath;?>" id="attachedImageFile" name="attachedImageFile" />
    </div>
    <div id="validateErrorMessagesDiv"> 
	<?php if (isset($_SESSION['user_validate_err_msg'])):?>
        <?php echo $_SESSION['user_validate_err_msg'];?>
    <?php endif;?>                        
    </div>
</div>
</form> 
<?php }else{?>
<div id="pageMesgDiv" class="defaultFont">
</div>
<div id="moviesTableDiv">
    <div id="moviesTableContentList" class="defaultFont"> 
        <div id="movNotExistError">
            <span style="color:#f00;">No movies found in this page : This page dose not exist !</span>                                
            <span style="color:#06f; font-size:12px;"><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=index&page=1" class="return_index">Return to the Main Page</a></span>                                                
        </div>    
    </div>
</div>
<div id="paginationDiv">
</div>                                                               
<?php }?>