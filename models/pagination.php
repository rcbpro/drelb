<?php

class Pagination{

	var $pagination = "";

	function generate_pagination($tbl_name, $limit, $path, $page){

		$condition = "";
		$tmp_condition = "";
		
		if (isset($_GET['genre_id'])){
			$condition = " WHERE genre_id = " . $_GET['genre_id'];
		}
		if (isset($_GET['letter'])){
			$condition = " WHERE movie_name LIKE '" . $_GET['letter'] . "%'";
		}		
		if (isset($_GET['query'])){
			$condition = " WHERE movie_name LIKE '" . $_GET['query'] . "%'";
		}				
		if ((isset($_GET['qG'])) && ($_GET['qG'] != "")){
			global $movieCategories;		
			$movCats = $movieCategories->display_all_movie_categories();
			for($i=0; $i<count($movCats); $i++){
				if (stristr($movCats[$i]['cat_name'], trim(strtolower($_GET['qG'])))){
					$tmp_condition .= " genre_id = " .$movCats[$i]['id'];					
					break;
				}
			}
		}
		if ((isset($_GET['qT'])) && ($_GET['qT'] != "")){
			if ((isset($_GET['qG'])) && ($_GET['qG'] != "")){		
				$and = " AND ";
			}else{
				$and = "";				
			}
			$tmp_condition .= "{$and}movie_name LIKE '".$_GET['qT']."%'";
		}
		if ((isset($_GET['qD'])) && ($_GET['qD'] != "")){
			if (((isset($_GET['qT'])) && ($_GET['qT'] != "")) || ((isset($_GET['qG'])) && ($_GET['qG'] != ""))){
				$and = " AND ";			
			}else{
				$and = "";				
			}				
			$tmp_condition .= "{$and}movie_description LIKE '".$_GET['qD']."%'";
		}
		if (((isset($_GET['qDF'])) && ($_GET['qDF'] != "")) && ((isset($_GET['qDF'])) && ($_GET['qDF'] != ""))){
			$tmp_condition .= " AND movie_published BETWEEN " . $_GET['qDF'] . " AND " . $_GET['qDT'];
		}elseif (((isset($_GET['qDF'])) && ($_GET['qDF'] != "")) && ((isset($_GET['qDF'])) && ($_GET['qDF'] == ""))){
			$tmp_condition .= " AND movie_published BETWEEN " . $_GET['qDF'] . " AND " . date("y-m-d");				
		}elseif (((isset($_GET['qDF'])) && ($_GET['qDF'] == "")) && ((isset($_GET['qDF'])) && ($_GET['qDF'] != ""))){
			$tmp_condition .= " AND movie_published BETWEEN " . date("y-m-d") . " AND " . $_GET['qDT'];								
		}else{
			$tmp_condition .= "";
		}		
	
		if ($tmp_condition != ""){
			$condition .= " WHERE {$tmp_condition}";
		}
		$query = "SELECT COUNT(*) as num FROM {$tbl_name} {$condition}"; 
		$result = mysql_query($query);
		if ($result)
			$total_records = mysql_fetch_array($result);
		$total_records = $total_records['num'];
		$adjacents = "2";		
		
		if ($page == 0){ $page = 1; }
		$prev = $page - 1;
		$next = $page + 1;
		@$lastpage = ceil($total_records/$limit);
		$lpm1 = $lastpage - 1;

		if($lastpage >= 1){ $this->pagination .= "<div class='pagination'>"; }
		if ($page > 1){ 
			if (isset($_GET['genre_id'])){
				$prev_path = str_replace("&page=".$_GET['page'], "&page=".$prev, $path);
				$this->pagination.= "<a href='".$prev_path."'>previous &#187;</a>";                    					
			}elseif (isset($_GET['letter'])){
				$prev_path = str_replace("&page=".$_GET['page'], "&page=".$prev, $path);
				$this->pagination.= "<a href='".$prev_path."'>previous &#187;</a>";                    					
			}elseif (isset($_GET['query'])){
				$prev_path = str_replace("&page=".$_GET['page'], "&page=".$prev, $path);
				$this->pagination.= "<a href='".$prev_path."'>previous &#187;</a>";                    					
			}elseif (isset($_GET['qG'])){
				$prev_path = str_replace("&page=".$_GET['page'], "&page=".$prev, $path);
				$this->pagination.= "<a href='".$prev_path."'>previous &#187;</a>";                    					
			}elseif (($path == "admin/index") || ($path == "admin/index/")){									
				$this->pagination.= "<a href='?page=".$prev."'>&#171; previous</a>";																											
			}else{
				if (isset($_GET['page'])){			
					$prev_path = str_replace("&page=".$_GET['page'], "&page=".$prev, $path);						
				}else{
					$prev_path = $path."&page=".$prev;											
				}	
					$this->pagination.= "<a href='".$prev_path."'>&#171; previous</a>";																							
			}	
		}else{
			$this->pagination.= "<span class='disabled'>&#171; previous</span>";    
		}
						
		if ($lastpage < 7 + ($adjacents * 2)){ 
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page){
					$this->pagination.= "<span class='current'>$counter</span>";
				}else{
					if (isset($_GET['genre_id'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['letter'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['query'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																	
					}elseif (isset($_GET['qG'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);		
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";												
					}elseif (($path == "admin/index") || ($path == "admin/index/")){					
						$this->pagination.= "<a href='?page=".$counter."'>$counter</a>";																							
					}else{
						if (isset($_GET['page'])){
							$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);													
						}else{
							$counter_path = $path."&page=".$counter;																										;																				
						}
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																							
					}	
				}
			}
		}elseif($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents * 2)){
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if ($counter == $page){
						$this->pagination.= "<span class='current'>$counter</span>";
				}else{
					if (isset($_GET['genre_id'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['letter'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['query'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																	
					}elseif (isset($_GET['qG'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);		
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";												
					}elseif (($path == "admin/index") || ($path == "admin/index/")){					
						$this->pagination.= "<a href='?page=".$counter."'>$counter</a>";																							
					}else{
						if (isset($_GET['page'])){
							$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);													
						}else{
							$counter_path = $path."&page=".$counter;																										;																				
						}
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																							
					}	
				}
					$this->pagination.= "...";
					$this->pagination.= "<a href='".$path."$lpm1'>$lpm1</a>";
					$this->pagination.= "<a href='".$path."$lastpage'>$lastpage</a>";        
				}
			}	
		}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
			$this->pagination.= "<a href='".$path."1'>1</a>";
			$this->pagination.= "<a href='".$path."2'>2</a>";
			$this->pagination.= "...";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
				if ($counter == $page){
					$this->pagination.= "<span class='current'>$counter</span>";
				}else{
					if (isset($_GET['genre_id'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['letter'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['query'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																	
					}elseif (isset($_GET['qG'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);		
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";												
					}elseif (($path == "admin/index") || ($path == "admin/index/")){					
						$this->pagination.= "<a href='?page=".$counter."'>$counter</a>";																							
					}else{
						if (isset($_GET['page'])){
							$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);													
						}else{
							$counter_path = $path."&page=".$counter;																										;																				
						}
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																							
					}	
				}
			}
		$this->pagination.= "..";
		$this->pagination.= "<a href='".$path."$lpm1'>$lpm1</a>";
		$this->pagination.= "<a href='".$path."$lastpage'>$lastpage</a>";        
		}else{
			$this->pagination.= "<a href='".$path."1'>1</a>";
			$this->pagination.= "<a href='".$path."2'>2</a>";
			$this->pagination.= "..";
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
				if ($counter == $page){
					$this->pagination.= "<span class='current'>$counter</span>";
				}else{
					if (isset($_GET['genre_id'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['letter'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";                    					
					}elseif (isset($_GET['query'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																	
					}elseif (isset($_GET['qG'])){
						$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);		
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";												
					}elseif (($path == "admin/index") || ($path == "admin/index/")){					
						$this->pagination.= "<a href='?page=".$counter."'>$counter</a>";																							
					}else{
						if (isset($_GET['page'])){
							$counter_path = str_replace("&page=".$_GET['page'], "&page=".$counter, $path);													
						}else{
							$counter_path = $path."&page=".$counter;																										;																				
						}
						$this->pagination.= "<a href='".$counter_path."'>$counter</a>";																							
					}	
				}
			}
		}

		if ($page < $counter - 1){
			if (isset($_GET['genre_id'])){
				$next_path = str_replace("&page=".$_GET['page'], "&page=".$next, $path);
				$this->pagination.= "<a href='".$next_path."'>next &#187;</a>";                    					
			}elseif (isset($_GET['letter'])){
				$next_path = str_replace("&page=".$_GET['page'], "&page=".$next, $path);
				$this->pagination.= "<a href='".$next_path."'>next &#187;</a>";                    					
			}elseif (isset($_GET['query'])){
				$next_path = str_replace("&page=".$_GET['page'], "&page=".$next, $path);
				$this->pagination.= "<a href='".$next_path."'>next &#187;</a>";                    						
			}elseif (isset($_GET['qG'])){
				$next_path = str_replace("&page=".$_GET['page'], "&page=".$next, $path);
				$this->pagination.= "<a href='".$next_path."'>next &#187;</a>";                    						
			}elseif (($path == "admin/index") || ($path == "admin/index/")){					
				$this->pagination.= "<a href='?page=".$next."'>next &#187;</a>";																							
			}else{
				if (isset($_GET['page'])){
					$next_path = str_replace("&page=".$_GET['page'], "&page=".$next, $path);										
				}else{
					$next_path = $path."&page=".$next;																				
				}
				$this->pagination.= "<a href='".$next_path."'>next &#187;</a>";																							
			}	
		}else{
			$this->pagination.= "<span class='disabled'>next &#187;</span>";
			$this->pagination.= "</div>\n";        
		}
	
	
		return $this->pagination;
	}	

}
?>