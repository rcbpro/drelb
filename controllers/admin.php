<?php

	include(MODEL_PATH."index".DS.'movie_index.php');
	include(MODEL_PATH."admin".DS.'admin.php');	
	include(MODEL_PATH."users".DS.'user_validate.php');	
	include(MODEL_PATH.DS.'pagination.php');					

	$db = new Database();
	global $settings;
	$db->db_connect($settings);
	$pagination = new Pagination();	
	$mov_index = new Movies();	
	$user_validate = new User_validate();	
	$adminFun = new Admin_Functions();

	if (($_GET['view'] == "index") || ($_GET['view'] == "edit")){
		if ((isset($_SESSION['errors'])) || (isset($_SESSION['user_validate_err_msg']))){
			unset($_SESSION['errors']);
			unset($_SESSION['user_validate_err_msg']);											
		}
	}

	switch ($view){
		
		case "index":	
			$all_movies = array();
			$filter_by = "";
			$path = str_replace('/'.APP_ROOT.'/', '', $_SERVER['REQUEST_URI']);
			$tot_no_pages = ceil(($mov_index->count_num_of_movies()/DISPLAY_LIMIT_FOR_ADMIN));						
			if (($path == "admin/index") || ($path == "admin/index/")){
				$cur_page = 1;									
			}
			if (isset($_GET['page'])){
				$path = str_replace("?page=".$_GET['page'], "", $path);
				$cur_page = $_GET['page'];
				$tempCase1 = $path;
			}
			
			$all_movies = $mov_index->display_all_movies($cur_page, $mov_index->count_num_of_movies(), $filter_by, $controller);
			$pagination = $pagination->generate_pagination("movies", 14, $path, $cur_page);
			$page_message = "Page " . $cur_page . " of " . $tot_no_pages;
			if (!isset($_GET['page'])){
				$start_record_no = 1;						
			}else if ($_GET['page'] == 1){
				$start_record_no = 1;			
			}else if ($_GET['page'] == 2){
				$start_record_no = DISPLAY_LIMIT_FOR_ADMIN + 1;							
			}else{
				$start_record_no = (DISPLAY_LIMIT_FOR_ADMIN * ($_GET['page']-1)) + 1;											
			}
			
			if ((isset($_GET['action'])) && ($_GET['action'] == "delete")){
				$movInfo = $adminFun->get_movie_details_for_preview((isset($_GET['mov'])) ? $_GET['mov'] : "");						
				if ($adminFun->delete_movie(($_GET['mov']) ? $_GET['mov'] : "")){
					$oldLetters = array();
					$oldLetters = str_split($movInfo['genre']);
					$newLetters = array_reverse($oldLetters);
					foreach($newLetters as $letter){ $modified_movie_path .= $letter."/"; }
					$img_file_path_to_delete = $_SERVER['DOCUMENT_ROOT']."drelb/uploaded/".$movInfo['genre_id']."/".$modified_movie_path."image/".$movInfo['id'];									
					$mov_file_path_to_delete = $_SERVER['DOCUMENT_ROOT']."drelb/uploaded/".$movInfo['genre_id']."/".$modified_movie_path."media/".$movInfo['id'];													
					if (file_exists($img_file_path_to_delete)){	
						$adminFun->destroy($img_file_path_to_delete);
					}			
					if (file_exists($mov_file_path_to_delete)){	
						$adminFun->destroy($mov_file_path_to_delete);
					}							
					redirect_to('admin.php?cntrl=admin&view=index&page='.$_GET['page']);
				}
			}
		break;
		
		case "add":	

			global $movieCategories;
			$mov_cat_menu = $movieCategories->display_all_movie_categories();				    
				
				if (isset($_POST['admin'])){

					if (isset($_POST['previewHandler'])){

						if ((isset($_SESSION['adminMovAdd'])) && (isset($_SESSION['preview_image_path']))){
						
							$adminFun->destroy($_SERVER['DOCUMENT_ROOT'].'drelb/previewHandler/');
							unset($_SESSION['preview_image_path']);		
							unset($_SESSION['adminMovAdd']);		
						}
						
						$_SESSION['adminMovAdd'] = $_POST['admin'];	
										
						$file_name_without_ext = substr(basename($_FILES['imageInput']['name']), 0, -4);
						$destination_path = $_SERVER['DOCUMENT_ROOT']."drelb/previewHandler/".$file_name_without_ext."/";				
						if (!file_exists($destination_path)){	
							mkdir($destination_path,0777, true);							
						}			
						if (move_uploaded_file($_FILES['imageInput']['tmp_name'], $destination_path."/".$_FILES['imageInput']['name'])){
							$_SESSION['preview_image_path'] = "http://".$_SERVER['HTTP_HOST']."/drelb/previewHandler/".$file_name_without_ext."/".$_FILES['imageInput']['name'];
						}				
					}
					
					if (isset($_POST['newMovieAdd'])){
					
						$_SESSION['adminMovAdd'] = $_POST['admin'];	
						
						$required_fields = $user_validate->validateAdminInput($_POST['admin']);						
						
							if ($generated_new_id = $adminFun->addMovie($required_fields)){
								$genre_name = $mov_index->get_genre_name($required_fields['movie_genre']);
								$modified_movie_path = "";
								$oldLetters = array();
								$oldLetters = str_split($genre_name);
								$newLetters = array_reverse($oldLetters);
								foreach($newLetters as $letter){ $modified_movie_path .= $letter."/"; }
								$mov_file_path = $_SERVER['DOCUMENT_ROOT']."drelb/"."uploaded/".$required_fields['movie_genre']."/".$modified_movie_path."media/";
								$img_file_path = $_SERVER['DOCUMENT_ROOT']."drelb/"."uploaded/".$required_fields['movie_genre']."/".$modified_movie_path."image/";						
								
								if ((!file_exists($mov_file_path . $generated_new_id)) && (!file_exists($img_file_path . $generated_new_id))){
									mkdir($mov_file_path . $generated_new_id,0777, true);
									mkdir($img_file_path . $generated_new_id,0777, true);							
								}			
		
								if ((move_uploaded_file($_FILES['movieInput']['tmp_name'], 
									$mov_file_path . $generated_new_id . "/" . $generated_new_id."_".basename($_FILES['movieInput']['name']))) &&
									(move_uploaded_file($_FILES['imageInput']['tmp_name'], 
									$img_file_path . $generated_new_id . "/" . $generated_new_id."_".basename($_FILES['imageInput']['name'])))){
		
										if ($adminFun->updateMovie(	$generated_new_id, substr(basename($_FILES['movieInput']['name']), -3), basename($_FILES['movieInput']['name']), basename($_FILES['imageInput']['name']) )){
		
											$medium_width = 432;
											$medium_height = 243;			
											createThumb($img_file_path . $generated_new_id . "/" . $generated_new_id . "_" . basename($_FILES['imageInput']['name']), 
														$img_file_path . $generated_new_id . "/" . "medium_" . $generated_new_id . "_" . basename($_FILES['imageInput']['name']), 
														$medium_width, $medium_height, true, "ffffff");
											
											$thumb_width = 132;
											$thumb_height = 73;									
											createThumb($img_file_path . $generated_new_id . "/" .$generated_new_id."_".basename($_FILES['imageInput']['name']), 
														$img_file_path . $generated_new_id . "/" . "thumb_" .$generated_new_id."_".basename($_FILES['imageInput']['name']), 
														$thumb_width, $thumb_height, true, "ffffff");
														
											unset($_SESSION['adminMovAdd']);
											unset($_SESSION['preview']);											
											unset($_SESSION['errors']);
											unset($_SESSION['user_validate_err_msg']);
											redirect_to('admin.php?cntrl=admin&view=add');																												
										}else{								
											$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Images Creation failed !</span>";	
											redirect_to('admin.php?cntrl=admin&view=add');					
										}				
								}else{
										$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Movie and Image upload failed !</span>";	
										redirect_to('admin.php?cntrl=admin&view=add');					
								}
							}else{
								$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Unexpected error occrued !</span>";	
								redirect_to('admin.php?cntrl=admin&view=add');					
							}
						}						
				}

		break;

		case "edit":

			$bigErrorMessage = "";
			$movNo = (isset($_GET['mov'])) ? $_GET['mov'] : "";
			$movInfo = $adminFun->get_movie_details_for_preview($movNo);
			$_SESSION['adminEdit']['movie_type'] = $movInfo['movie_type'];
			$_SESSION['adminEdit']['movie_file_name'] = $movInfo['movie_file_name'];
			$_SESSION['redirect_page'] = (isset($_GET['page'])) ? $_GET['page'] : "";

			// If isset $_POST['adminEdit']
			if (isset($_POST['existMovieEdit'])){
				$_SESSION['adminEdit']['movie_description'] = $_POST['adminEdit']['movie_description'];
				$_SESSION['adminEdit']['movie_released_date'] = $_POST['adminEdit']['movie_released_date'];				
				
				$required_fields = $user_validate->validateAdminInputForEdit($_POST['adminEdit'], $movInfo['id']);						
				
				if ($adminFun->editMovie($movInfo['id'], $_SESSION['adminEdit']['movie_description'], $_SESSION['adminEdit']['movie_released_date'])){

					$modified_movie_path = "";
					$oldLetters = array();
					$oldLetters = str_split($movInfo['genre']);
					$newLetters = array_reverse($oldLetters);
					foreach($newLetters as $letter){ $modified_movie_path .= $letter."/"; }
					$img_file_path = $_SERVER['DOCUMENT_ROOT']."drelb/uploaded/".$movInfo['genre_id']."/".$modified_movie_path."image/";						

					if (file_exists($img_file_path . $movInfo['id']."/".$movInfo['id']."_".$movInfo['thumbanail_image'])){
						$adminFun->destroy($img_file_path . $movInfo['id']."/");					
						mkdir($img_file_path . $movInfo['id'],0777, true);							
					}			

					if (move_uploaded_file($_FILES['imageInput']['tmp_name'], 
						$img_file_path . $movInfo['id'] . "/" . $movInfo['id']."_".basename($_FILES['imageInput']['name']))){

							if ($adminFun->updateMovie(	$movInfo['id'], $_SESSION['adminEdit']['movie_type'], $_SESSION['adminEdit']['movie_file_name'], basename($_FILES['imageInput']['name']) )){

								$medium_width = 432;
								$medium_height = 243;			
								createThumb($img_file_path . $movInfo['id'] . "/" . $movInfo['id'] . "_" . basename($_FILES['imageInput']['name']), 
											$img_file_path . $movInfo['id'] . "/" . "medium_" . $movInfo['id'] . "_" . basename($_FILES['imageInput']['name']), 
											$medium_width, $medium_height, true, "ffffff");
								
								$thumb_width = 132;
								$thumb_height = 73;									
								createThumb($img_file_path . $movInfo['id'] . "/" .$movInfo['id']."_".basename($_FILES['imageInput']['name']), 
											$img_file_path . $movInfo['id'] . "/" . "thumb_" .$movInfo['id']."_".basename($_FILES['imageInput']['name']), 
											$thumb_width, $thumb_height, true, "ffffff");
								unset($_SESSION['adminEdit']);
								unset($_SESSION['preview']);											
								unset($_SESSION['errors']);
								unset($_SESSION['user_validate_err_msg']);

								redirect_to('admin.php?cntrl=admin&view=index&page='.$_SESSION['redirect_page']);																												
							}else{								
								$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Images Creation failed !</span>";	
								redirect_to('admin.php?cntrl=admin&view=edit&mov='.$movInfo['id']);					
							}				
					}else{
							$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Image upload failed !</span>";	
							redirect_to('admin.php?cntrl=admin&view=edit&mov='.$movInfo['id']);					
					}
				}else{
					$_SESSION['user_validate_err_msg'] = "<span style=\'color:#f00;\'>Unexpected error occrued !</span>";	
					redirect_to('admin.php?cntrl=admin&view=edit&mov='.$movInfo['id']);					
				}				
				
			}elseif (isset($_POST['previewHandler'])){

				if ((isset($_SESSION['adminEdit'])) && (isset($_SESSION['preview_image_path']))){
				
					$adminFun->destroy($_SERVER['DOCUMENT_ROOT'].'drelb/previewHandler/');
					unset($_SESSION['preview_image_path']);		
					unset($_SESSION['adminMovAdd']);		
				}
				
				if (isset($_POST['adminEdit'])){
				
					$_SESSION['adminEdit'] = $_POST['adminEdit'];	
					$_SESSION['adminEdit']['movie_Title'] = $movInfo['title'];
					$_SESSION['adminEdit']['movie_genre'] = $movInfo['genre'];
									
					if (($movInfo['description'] != $_POST['adminEdit']['movie_description']) ||
							($movInfo['date_published'] != $_POST['adminEdit']['movie_released_date'])){				
						
						$_SESSION['adminEdit']['movie_description'] = $_POST['adminEdit']['movie_description'];	
						$file_name_without_ext = substr(basename($_FILES['imageInput']['name']), 0, -4);
						$destination_path = $_SERVER['DOCUMENT_ROOT']."drelb/previewHandler/".$file_name_without_ext."/";				
						if (!file_exists($destination_path)){	
							mkdir($destination_path,0777, true);							
						}			
						if (move_uploaded_file($_FILES['imageInput']['tmp_name'], $destination_path."/".$_FILES['imageInput']['name'])){
							$_SESSION['preview_image_path'] = "http://".$_SERVER['HTTP_HOST']."/drelb/previewHandler/".$file_name_without_ext."/".$_FILES['imageInput']['name'];
						}				
					
					}else{
					
						$modified_img_path = "";
						$oldLetters = array();
						$oldLetters = str_split($movInfo['genre']);
						$newLetters = array_reverse($oldLetters);
						foreach($newLetters as $letter){ $modified_img_path .= $letter."/"; }			
						$imageFilePath = "http://" . $_SERVER['HTTP_HOST'] . "/drelb/uploaded/" . $movInfo['genre_id'] . "/" . $modified_img_path . "image/" . $movInfo['id'] . "/". $movInfo['id'] . "_" . $movInfo['thumbanail_image'];									
						$_SESSION['preview_image_path'] = $imageFilePath;						
					}	
				}	
				
			}elseif (!isset($_GET['mov'])){

				$bigErrorMessage = "<span style='color:#f00; font-size:14px;'>No Movies Selected</span>";
			}else{
			
				$_SESSION['adminEdit']['movie_description'] = $movInfo['description'];			
				$_SESSION['adminEdit']['movie_released_date'] = $movInfo['date_published'];							
				$modified_img_path = "";
				$oldLetters = array();
				$oldLetters = str_split($movInfo['genre']);
				$newLetters = array_reverse($oldLetters);
				foreach($newLetters as $letter){ $modified_img_path .= $letter."/"; }			
				$imageFilePath = "http://" . $_SERVER['HTTP_HOST'] . "/drelb/uploaded/" . $movInfo['genre_id'] . "/" . $modified_img_path . "image/" . $movInfo['id'] . "/". $movInfo['id'] . "_" . $movInfo['thumbanail_image'];				
			}
			// end if

		break;
		
		case "newadminuser":
			if (isset($_POST['newadmin'])){
				$_SESSION['newadmin'] = $_POST['newadmin'];							
				$required_fields = $user_validate->validateAdminInputForNewAdmin($_POST['newadmin']);						
				
				if ($adminFun->add_new_admin_user($required_fields)){
					$addAdminUserMsg = "<span style='color:#06f; font-size:12px;'>New Admin User added to the system</span>";
				}else{
					$addAdminUserMsg = "";					
				}
				
			if (isset($_SESSION['newadmin'])) unset($_SESSION['newadmin']);

			function js_redirect($url, $seconds=2){
			
				echo "<script language=\"JavaScript\">\n";
				echo "<!-- hide code from displaying on browsers with JS turned off\n\n";
				echo "function redirect() {\n";
				echo "window.location = \"" . $url . "\";\n";
				echo "}\n\n";
				echo "timer = setTimeout('redirect()', '" . ($seconds*1000) . "');\n\n";
				echo "-->\n";
				echo "</script>\n";
				
					return true;
			}
			
				js_redirect("http://localhost/drelb/admin.php?cntrl=admin&view=add", "2");	
			}			

		break;
	
	}

?>