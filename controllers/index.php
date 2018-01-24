<?php

	include(MODEL_PATH.$controller.DS.'movie_index.php');
	include(MODEL_PATH."users".DS.'user_pro.php');	
	include(MODEL_PATH."users".DS.'user_get.php');		
	include(MODEL_PATH.DS.'pagination.php');			
	include(MODEL_PATH.DS.'search/search.php');		

	$db = new Database();
	global $settings;
	$db->db_connect($settings);
	$pagination = new Pagination();	
	$mov_index = new Movies();	
	$moviesSearch = new moviesSearch();
	$user_Profiles = new User_reg();	
	$user_Get = new Get_User();		
	
	if (strstr($_SERVER['QUERY_STRING'],"mov")){
		$view = "details";	
	}	

	switch ($view){
		
		case "index":				
			$all_movies = array();
			$filter_by = "";
			$path = $_SERVER['REQUEST_URI'];

			$temp_case_1 = "";
			$temp_cur_page_1 = "";
			$temp_case_2 = "";			
			$temp_cur_page_2 = "";
			$temp_case_3 = "";			
			$temp_cur_page_3 = "";			 
			$temp_case_4 = "";
			$temp_case_5 = "";
			$temp_case_6 = "";
			$temp_case_7 = "";
			
			if (isset($_GET['genre_id'])){
				$tot_no_pages = ceil(($mov_index->count_num_of_movies($_GET['genre_id'])/NO_OF_RECORDS_PER_PAGE));						
			}elseif (isset($_GET['letter'])){				
				$tot_no_pages = ceil(($mov_index->count_num_of_movies_by_letter_name($_GET['letter'])/NO_OF_RECORDS_PER_PAGE));									
			}elseif ((isset($_GET['qG'])) || (isset($_GET['qT'])) || (isset($_GET['qD'])) || (isset($_GET['qDF'])) || (isset($_GET['qDT']))){
				$advSearchParams = array();						
				$advSearchParams['title'] = (isset($_GET['qT'])) ? $_GET['qT'] : "";
				$advSearchParams['genre'] = (isset($_GET['qG'])) ? $_GET['qG'] : "";
				$advSearchParams['description'] = (isset($_GET['qD'])) ? $_GET['qD'] : "";
				$advSearchParams['dateFrom'] = (isset($_GET['qDF'])) ? $_GET['qDF'] : "";
				$advSearchParams['dateTo'] = (isset($_GET['qDT'])) ? $_GET['qDT'] : "";												
				$adv_tot_records = $moviesSearch->count_searched_by_many_params($advSearchParams);										
				$tot_no_pages = ceil(($adv_tot_records/NO_OF_RECORDS_PER_PAGE));						
			}else{
				$tot_no_pages = ceil(($mov_index->count_num_of_movies()/NO_OF_RECORDS_PER_PAGE));			
			}	

			if (isset($_GET['genre_id'])){			
				$temp_case_1 = $path;		
			}elseif (isset($_GET['letter'])){
				$temp_case_2 = $path;
			}else if (isset($_GET['query'])){
				$temp_case_4 = $path;									
			}elseif ((isset($_GET['qG'])) || (isset($_GET['qT'])) || (isset($_GET['qD'])) || (isset($_GET['qDF'])) || (isset($_GET['qDT']))){
				$temp_case_5 = $path;									
			}else if (isset($_GET['mov'])){
				$temp_case_6 = $path;					
			}else{							
				if (isset($_GET['page'])){
					$cur_page = $_GET['page'];
				}else{
					$cur_page = 1;					
				}
			}

			switch($path){
			
				case $temp_case_1:				
					$path = "http://".$_SERVER['HTTP_HOST']."/drelb/index.php?cntrl=index&view=index&page=".$_GET['page']."&genre_id=".$_GET['genre_id'];
					if (isset($_GET['page'])){
						$cur_page = $_GET['page'];			
					}else{
						$cur_page = 1;								
					}	
				break;								

				case $temp_case_2:
					$path = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=index&page=".$_GET['page']."&letter=".$_GET['letter'];
					if (isset($_GET['page'])){
						$cur_page = $_GET['page'];			
					}else{
						$cur_page = 1;								
					}	
				break;
				
				case $temp_case_3:
					$path = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=index";
					if (isset($_GET['page'])){
						$cur_page = $_GET['page'];			
					}else{
						$cur_page = 1;								
					}	
				break;

				case $temp_case_4:
					if (isset($_GET['page'])){
						$cur_page = $_GET['page'];			
					}else{
						$cur_page = 1;								
					}	
					$path = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=search&page=".$_GET['page']."&query=".$_GET['query'];
				break;
				
				case $temp_case_5:
					$qT = (isset($_GET['qT'])) ? $_GET['qT'] : "";
					$qG = (isset($_GET['qG'])) ? $_GET['qG'] : "";
					$qD = (isset($_GET['qD'])) ? $_GET['qD'] : "";
					$qDF = (isset($_GET['qDF'])) ? $_GET['qDF'] : "";
					$qDT = (isset($_GET['qDT'])) ? $_GET['qDT'] : "";																	
					if (isset($_GET['page'])){
						$cur_page = $_GET['page'];			
					}else{
						$cur_page = 1;								
					}	
					$path = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=advanceSearch&page=".$cur_page."&qG=".$qG."&qT=".$qT."&qD=".$qD."&qDF=".$qDF."&qDT=".$qDT;
				break;
				
				case $temp_case_6:
					$path = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=index&mov=".$_GET['mov'];
					$cur_page = $temp_cur_page_5;														
				break;
				
				default:
					$path = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=index&page=".$cur_page;					
				break;				

			}
			
			// Got the all movies from the database
			$all_movies = $mov_index->display_all_movies($cur_page, $mov_index->count_num_of_movies(), $filter_by);
			
			if (isset($_GET['genre_id'])){
				$cur_page = $_GET['page'];										
				$all_movies = $mov_index->display_movies_by_categories($_GET['genre_id'], $cur_page);						
			}			
			if (isset($_GET['letter'])){
				$cur_page = $_GET['page'];										
				$all_movies = $mov_index->display_movies_by_lette_name($_GET['letter'], $cur_page);						
			}		
			
			// Merging with the all movies array
            $count = count($all_movies);			
			$i = 0;
			while ($count > 0){			
			
				// Modified movie paths
				$modified_img_path = "";
				$oldLetters = array();
				$oldLetters = str_split($all_movies[$i]['genre']);
				$newLetters = array_reverse($oldLetters);
				foreach($newLetters as $letter){ $modified_img_path .= $letter."/"; }
				$img_file_path = "http://{$_SERVER['HTTP_HOST']}/drelb/uploaded/".$all_movies[$i]['genre_id']."/".$modified_img_path."image/".$all_movies[$i]['id']."/"."thumb_".$all_movies[$i]['id']."_".$all_movies[$i]['thumbanail_image'];			
				$img_paths = array('img_path' => $img_file_path);						
			
				$all_movies_with_img_paths[$i] = array_merge($all_movies[$i], $img_paths);				
                $i++;
				$count--;
			}		
			
			$pagination = $pagination->generate_pagination("movies", NO_OF_RECORDS_PER_PAGE, $path, $cur_page);
			$page_message = "Page " . $cur_page . " of " . $tot_no_pages;			
			$ex_path_for_movie = $_SERVER['REQUEST_URI'];
			if (($ex_path_for_movie == "/drelb/") || ($ex_path_for_movie == "/drelb/index.php")){
				$ex_path_for_movie = "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=index";
			}
			
		break;
		
		case "details":
			if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){		
				$_SESSION['credit_limit'] = $user_Get->get_user_updated_credit_limit($_SESSION['logged_user_id']);
			}	
			
			if (isset($_POST['addFunds'])){
				$creditAmount = 0.00;
				if ((isset($_POST['addFundsAmount'])) && ($_POST['addFundsAmount'] != "Add Credits")){
					$creditAmount = $_POST['addFundsAmount'];				
				}			
				if ((isset($_POST['addOtherFundsAmount'])) && ($_POST['addOtherFundsAmount'] != "Other Amount")){
					$creditAmount = $_POST['addOtherFundsAmount'];
				}				
				
				if ($creditAmount == 0.00){
					$errorMessage = "<span style='color:#f00; font-weight:bold;'>Credits required to add !</span>";						
				}else{
					if ($user_Profiles->update_credit_limit($_SESSION['logged_user_id'], $creditAmount)){
						$successMessage = "<span style='color:#06f; font-weight:bold; font-size:11px;'>$".$creditAmount." added to Your Account.</span>";						
						$_SESSION['credit_limit'] = $user_Get->get_user_updated_credit_limit($_SESSION['logged_user_id']);
					}
				}
			}
		
			if (@$_SESSION['transactionAccpeted'] != true){
				unset($_SESSION['transactionAcceptedText']);			
				$_SESSION['transactionAccpeted'] = false;									
			}else{	
				$_SESSION['transactionAccpeted'] = true;
			}
			if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
				if ($_SESSION['credit_limit'] <= 1.00){
					$allowdCreditMessage = "You do not have enough credits donated with the system for<br />pay this movie : Please recharge your account with credits and come back. Thanks.";
				}else{
					$allowdCreditMessage = "";
				}
			}
			$tot_of_movs = $mov_index->count_num_of_movies();			
			$last_mov_number = $mov_index->get_the_last_movie_number();
			$cur_mov_no = $_GET['mov'];			
			$selected_movie = $mov_index->display_movie_info($cur_mov_no); 
			$mov_type = $selected_movie['movie_type'];
			$modified_movie_path = "";
			$modified_img_path = "";			
			$oldLetters = array();
			$oldLetters = str_split($selected_movie['genre']);
			$newLetters = array_reverse($oldLetters);
			foreach($newLetters as $letter){ $modified_movie_path .= $letter."/"; }
			foreach($newLetters as $letter){ $modified_img_path .= $letter."/"; }			
			$mov_file_path = "http://{$_SERVER['HTTP_HOST']}/drelb/uploaded/".$selected_movie['genre_id']."/".$modified_movie_path."media/".$selected_movie['id']."/".$selected_movie['id']."_".$selected_movie['movie_file_name'];			
			$img_file_path = "http://{$_SERVER['HTTP_HOST']}/drelb/uploaded/".$selected_movie['genre_id']."/".$modified_img_path."image/".$selected_movie['id']."/"."medium_".$selected_movie['id']."_".$selected_movie['thumbanail_image'];						
			$embedVideoHtml = "";

			switch($mov_type){
				
				case "flv":

				 $embedVideoHtml = "<object id=\"player\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" name=\"player\" width=\"328\" height=\"200\">
										<param name=\"movie\" value=\"http://localhost/drelb/uploaded/player-viral.swf\" />
										<param name=\"allowfullscreen\" value=\"true\" />
										<param name=\"allowscriptaccess\" value=\"always\" />
										<param name=\"flashvars\" value=\"file={$mov_file_path}&image={$img_file_path}\" />
										<embed
											type=\"application/x-shockwave-flash\"
											id=\"player2\"
											name=\"player2\"
											src=\"http://localhost/drelb/uploaded/player-viral.swf\" 
											width=\"328\" 
											height=\"200\"
											allowscriptaccess=\"always\" 
											allowfullscreen=\"true\"
											flashvars=\"file={$mov_file_path}&image={$img_file_path}\" 
										/>
									</object>";                                                                                  				
				break;
				
				case "mov":
				
					$embedVideoHtml	= "<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" height=\"256\" width=\"320\">
									   		<param name=\"".$mov_file_path."\" value=\"".$mov_file_path."\">
											<param name=\"autoplay\" value=\"true\">
											<param name=\"type\" value=\"video/quicktime\" height=\"256\" width=\"320\">
											<embed src=\"".$mov_file_path."\" height=\"256\" width=\"320\" autoplay=\"true\" type=\"video/quicktime\" pluginspage=\"http://www.apple.com/quicktime/download/\">
										</object>";		
				break;
				
				case "divx":
				
					$embedVideoHtml	= "<object classid=\"clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616\" width=\"320\" height=\"260\" codebase=\"http://go.divx.com/plugin/DivXBrowserPlugin.cab\">   
   									   		<param name=\"".$mov_file_path."\" value=\"".$mov_file_path."\"/>   
										   	<embed type=\"video/divx\" src=\"".$mov_file_path."\" width=\"320\" height=\"260\" pluginspage=\"http://go.divx.com/plugin/download/\">   
    										</embed>   
										</object>";  				
				break;

			}	
			
			if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){					
				if ($_SESSION['transactionAccpeted'] == true){
					if (isset($_SESSION['amount_to_reduce'])){
						$user_Profiles->reduce_current_user_credits($_SESSION['logged_user_id'], $_SESSION['amount_to_reduce']);
						unset($_SESSION['amount_to_reduce']);
					}	
				}	
			}	
			
			$_SESSION['viewedMoviePath'] = $_SERVER['REQUEST_URI'];
		break;
		
		case "search":
			if (isset($_GET['page'])){
				$current_page = $_GET['page'];									
			}else{
				$current_page = 1;									
			}
			$searchedContent = $moviesSearch->search_by_keyword($_GET['query'], $current_page);
			
			// Merging with the all movies array
            $count = count($searchedContent);			
			$i = 0;
			while ($count > 0){			
			
				// Modified movie paths
				$modified_img_path = "";
				$oldLetters = array();
				$oldLetters = str_split($searchedContent[$i]['genre']);
				$newLetters = array_reverse($oldLetters);
				foreach($newLetters as $letter){ $modified_img_path .= $letter."/"; }
				$img_file_path = "http://{$_SERVER['HTTP_HOST']}/drelb/uploaded/".$searchedContent[$i]['genre_id']."/".$modified_img_path."image/".$searchedContent[$i]['id']."/"."thumb_".$searchedContent[$i]['id']."_".$searchedContent[$i]['thumb_image'];			
				$img_paths = array('img_path' => $img_file_path);						
			
				$searchedContent_with_img_paths[$i] = array_merge($searchedContent[$i], $img_paths);				
                $i++;
				$count--;
			}				
			
			$tot_records = $mov_index->count_num_of_movies_by_letter_name($_GET['query']);
			$pagination = $pagination->generate_pagination("movies", NO_OF_RECORDS_PER_PAGE, "http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=search&page=".$current_page."&query=".$_GET['query'], $current_page);			
			if ($searchedContent == NULL){
				$totPages = 0;
				$searchResultMsg = "No results found";
			}else{
				$totPages = ceil($tot_records/NO_OF_RECORDS_PER_PAGE);
				$page_message = "Page " . $current_page . " of " . $totPages;				
					if ($tot_records == 1){
						$tmpMsg1 = "is";
						$tmpMsg2 = "result";						
					}else{						
						$tmpMsg1 = "are";
						$tmpMsg2 = "results";						
					}
					$searchResultMsg = "There {$tmpMsg1} " . $tot_records . " {$tmpMsg2}";				
			}	
			$view = "search_results";			
		break;
	
		case "advanceSearch":
			global $movieCategories;
			$mov_cat_menu = $movieCategories->display_all_movie_categories();				    
			if ((isset($_GET['qG'])) || (isset($_GET['qT'])) || (isset($_GET['qD'])) || (isset($_GET['qDF'])) || (isset($_GET['qDT']))){
				$advSearchParams = array();						
				$advSearchParams['title'] = (isset($_GET['qT'])) ? $_GET['qT'] : "";
				$advSearchParams['genre'] = (isset($_GET['qG'])) ? $_GET['qG'] : "";
				$advSearchParams['description'] = (isset($_GET['qD'])) ? $_GET['qD'] : "";
				$advSearchParams['dateFrom'] = (isset($_GET['qDF'])) ? $_GET['qDF'] : "";
				$advSearchParams['dateTo'] = (isset($_GET['qDT'])) ? $_GET['qDT'] : "";												
				$tot_records = $moviesSearch->count_searched_by_many_params($advSearchParams);	
				$totPages = ceil($tot_records/NO_OF_RECORDS_PER_PAGE);
				if (isset($_GET['page'])){
					$current_page = $_GET['page'];					
				}else{
					$current_page = 1;				
				}
				$searchedContent = $moviesSearch->search_by_many_params($advSearchParams, $current_page);							
				
				// Merging with the all movies array
				$count = count($searchedContent);			
				$i = 0;
				while ($count > 0){			
				
					// Modified movie paths
					$modified_img_path = "";
					$oldLetters = array();
					$oldLetters = str_split($searchedContent[$i]['genre']);
					$newLetters = array_reverse($oldLetters);
					foreach($newLetters as $letter){ $modified_img_path .= $letter."/"; }
					$img_file_path = "http://{$_SERVER['HTTP_HOST']}/drelb/uploaded/".$searchedContent[$i]['genre_id']."/".$modified_img_path."image/".$searchedContent[$i]['id']."/"."thumb_".$searchedContent[$i]['id']."_".$searchedContent[$i]['thumb_image'];			
					$img_paths = array('img_path' => $img_file_path);						
				
					$searchedContent_with_img_paths[$i] = array_merge($searchedContent[$i], $img_paths);				
					$i++;
					$count--;
				}				
				
				$pagination = $pagination->generate_pagination("movies", 
													NO_OF_RECORDS_PER_PAGE, 
													"http://{$_SERVER['HTTP_HOST']}/drelb/index.php?cntrl=index&view=advanceSearch&page=".$current_page."&qG=".$advSearchParams['genre']
														."&qT=".$advSearchParams['title']."&qD=".$advSearchParams['description']
														."&qDF=".$advSearchParams['dateFrom']."&qDT=".$advSearchParams['dateTo'], 
													$current_page);			
				if ($searchedContent == NULL){
					$totPages = 0;
					$searchResultMsg = "No results found";
				}else{
					$totPages = ceil($tot_records/NO_OF_RECORDS_PER_PAGE);
					$page_message = "Page " . $current_page . " of " . $totPages;				
					if ($tot_records == 1){
						$tmpMsg1 = "is";
						$tmpMsg2 = "result";						
					}else{						
						$tmpMsg1 = "are";
						$tmpMsg2 = "results";						
					}
					$searchResultMsg = "There {$tmpMsg1} " . $tot_records . " {$tmpMsg2}";				
				}									
				$view = "search_results";				
			}	
		break;			
	}

?>