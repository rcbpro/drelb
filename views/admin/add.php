<?php
	if (isset($_SESSION['errors'])){
		foreach($_SESSION['errors'] as $err_name => $err_val){
			switch($err_val){
			
				case "movie_Title":
					$inputTitleError = true;
				break;	
				
				case "movie_genre":
					$inputGenreError = true;
				break;	

				case "movie_description":
					$inputDescError = true;
				break;	

				case "movie_released_date":
					$inputDateRelError = true;
				break;	
				
				case "movFileNotExist":
					$mediaFileNotExistError = true;
				break;

				case "imageFileNotExist":
					$imageFileNotExistError = true;
				break;
				
			}
		}		
	}
?>
<form name="adminContentAdd" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=add" enctype="multipart/form-data" method="post">
<div id="leftSide" class="defaultFont">
	<div id="titleInputDiv">
    	Title <input type="text" name="admin[movie_Title]" id="titleInput" class="<?php if ($inputTitleError) { echo "error_field_uname"; } else { echo "adminInput"; }?>" value="<?php echo (isset($_SESSION['adminMovAdd']['movie_Title'])) ? $_SESSION['adminMovAdd']['movie_Title'] : '';?>" style="margin-left:50px; width:250px;" />
    </div>	
	<div id="genreInputDiv">
    	Genre 
		<select name="admin[movie_genre]" id="genreInput" class="<?php if ($inputGenreError) { echo "dd-element_error"; } else { echo "dd-element"; }?>" style="margin-left:40px; width:150px;">
        	<option value="">Select the Genre</option>
            	<?php
					for($i=0; $i<count($mov_cat_menu); $i++){
						if ($_SESSION['adminMovAdd']['movie_genre'] == $mov_cat_menu[$i]['id']){
							$selected = "selected";
						}else{
							$selected = "";							
						}
				?>	
						<option value="<?php echo $mov_cat_menu[$i]['id'];?>" <?php echo $selected;?>><?php echo $mov_cat_menu[$i]['cat_name'];?></option>
                <?php        
					}
				?>
        </select>        
    </div>	    
	<div id="descInputDiv">
    	<div id="subDivDescInput">Description</div>
        <div id="subDivDescInput2"><textarea name="admin[movie_description]" id="descInput" class="<?php if ($inputDescError) { echo "error_field_uname"; } else { echo "adminInput"; }?>" style="width:390px; height:250px; margin-left:3px;"><?php echo (isset($_SESSION['adminMovAdd']['movie_description'])) ? $_SESSION['adminMovAdd']['movie_description'] : '';?></textarea></div>
    </div>	    
	<div id="dateReleasedInputDiv">
    	Date<br />Released <input type="text" name="admin[movie_released_date]" id="dateReleasedInput" class="<?php if ($inputDateRelError) { echo "error_field_uname"; } else { echo "adminInput"; }?>" value="<?php echo (isset($_SESSION['adminMovAdd']['movie_released_date'])) ? $_SESSION['adminMovAdd']['movie_released_date'] : '';?>" style="margin-left:22px; width:150px;" />
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
            - Allowed media file types are mov, flv, divx.
            - Allowed maximum media/image file size is up to 1000 MB
		</pre>                    
    </div>
</div>
<div id="rightSide" class="defaultFont">
	<div id="titleInputDiv">
		Movie Image to Upload <input type="file" name="imageInput" id="imageInput" class="<?php if ($imageFileNotExistError) echo "filesErrorIndicate";?>" style="margin-left:50px;" />
    </div>    
	<div id="titleInputDiv">
		Movie file to Upload <input type="file" name="movieInput" id="movieInput" class="<?php if ($mediaFileNotExistError) echo "filesErrorIndicate";?>" style="margin-left:70px;" />
    </div>        
	<div id="titleInputDiv" style="height:75px;">
		<input type="submit" name="newMovieAdd" id="newMovieAdd" style="margin-left:120px; margin-top:30px; width:150px;" class="btn-element-sign-up" value="Upload and Add Movie" />
        <input type="submit" name="previewHandler" id="previewHandler" value="Preview" class="btn-element-sign-up" 
        						style="margin-left:20px; margin-top:30px; width:75px;" onclick="return popitup('http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/views/admin/preview.php')" />
    </div>
    <div id="validateErrorMessagesDiv"> 
	<?php if (isset($_SESSION['user_validate_err_msg'])):?>
        <?php echo $_SESSION['user_validate_err_msg'];?>
    <?php endif;?>                        
    </div>
</div>
</form>                                                                