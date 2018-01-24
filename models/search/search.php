<?php

class moviesSearch{

	/**
	 * Search by keyword
	 * @param String keyword
	 * @param Integer curr_page_no	 
	 * @Return Array search_result	 
	 */		
	function search_by_keyword($keyword, $curr_page_no = ""){
	
		$display_items = NO_OF_RECORDS_PER_PAGE;		

		if ($curr_page_no != NULL){
			if ($curr_page_no == 1){
				$start_no_sql = 0;
				$end_no_sql = $display_items;
			}else{							
				$start_no_sql = ($curr_page_no - 1) * $display_items;
				$end_no_sql = $display_items;				
			}
		}else{
			 $start_no_sql = 0;
			 $end_no_sql = $display_items;		
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				

		$query = "SELECT movies.id AS id, movies.movie_name AS title, movie_categories.genre AS genre, movies.thumbanail_image AS thumb_image, movies.hit_count AS hitCcount, movies.genre_id AS genre_id
					FROM movies, movie_categories
					WHERE movies.genre_id = movie_categories.genre_id
							AND movies.movie_name LIKE '".$keyword."%'" . $limit;
		$result = mysql_query($query);
		if ($result){	
			$search_result = array();
			$i=0;	
			while ($row = mysql_fetch_array($result)){
			
				$search_result[$i]['id'] = $row['id'];
				$search_result[$i]['title'] = $row['title'];
				$search_result[$i]['genre_id'] = $row['genre_id'];			
				$search_result[$i]['genre'] = $row['genre'];
				$search_result[$i]['thumb_image'] = $row['thumb_image'];
				$search_result[$i]['hit_count'] = $row['hitCcount'];						
				$i++;
			}
			return (count($search_result)>0) ? $search_result : NULL;
		}	
	}
	
	/**
	 * Search by Many parameters
	 * @param String Array searchParam
	 * @param Integer curr_page_no	 
	 * @Return Array searchedContent	 
	 */			
	function search_by_many_params($searchParam = NULL, $curr_page_no = ""){
	
		$display_items = NO_OF_RECORDS_PER_PAGE;		

		if ($curr_page_no != NULL){
			if ($curr_page_no == 1){
				$start_no_sql = 0;
				$end_no_sql = $display_items;
			}else{							
				$start_no_sql = ($curr_page_no - 1) * $display_items;
				$end_no_sql = $display_items;				
			}
		}else{
			 $start_no_sql = 0;
			 $end_no_sql = $display_items;		
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
	
		$whereCondition = "";
		if ($searchParam != NULL){
			if (is_array($searchParam)){				
				
				if ($searchParam['genre'] != ""){
					$whereCondition .= " AND movie_categories.genre LIKE '" .$searchParam['genre']."%'";
				}
				if ($searchParam['title'] != ""){
					$whereCondition .= " AND movies.movie_name LIKE '%".$searchParam['title']."%'";
				}
				if ($searchParam['description'] != ""){
					$whereCondition .= " AND movies.movie_description LIKE '%".$searchParam['description']."%'";
				}
				if (($searchParam['dateFrom'] != "") && ($searchParam['dateTo'] != "")){
					$whereCondition .= " AND movies.movie_published BETWEEN " . $searchParam['dateFrom'] . " AND " . $searchParam['dateTo'];
				}elseif (($searchParam['dateFrom'] != "") && ($searchParam['dateTo'] == "")){
					$whereCondition .= " AND movies.movie_published BETWEEN " . $searchParam['dateFrom'] . " AND " . date("y-m-d");				
				}elseif (($searchParam['dateFrom'] == "") && ($searchParam['dateTo'] != "")){
					$whereCondition .= " AND movies.movie_published BETWEEN " . date("y-m-d") . " AND " . $searchParam['dateTo'];								
				}else{
					$whereCondition .= "";
				}
			
				$query = "SELECT movies.id AS id, movies.movie_name AS title, movies.genre_id AS genre_id, movie_categories.genre AS genre, movies.thumbanail_image AS thumb_image, movies.hit_count AS hit_count
							FROM movies, movie_categories
							WHERE movies.genre_id = movie_categories.genre_id " . $whereCondition . $limit;		
			}
		}					
		$result = mysql_query($query);
		if ($result){
			$searchedContent = array();
			$i=0;
			while($row = mysql_fetch_array($result)){
				$searchedContent[$i]['id'] = $row['id'];
				$searchedContent[$i]['title'] = $row['title'];
				$searchedContent[$i]['genre'] = $row['genre'];
				$searchedContent[$i]['genre_id'] = $row['genre_id'];						
				$searchedContent[$i]['thumb_image'] = $row['thumb_image'];															
				$searchedContent[$i]['hit_count'] = $row['hit_count'];																				
				$i++;
			}
			return $searchedContent;
		}	
	}
	
	/**
	 * Search by Many parameters and return the count of search results
	 * @param String Array searchParam
	 * @Return Array element	 
	 */				
	function count_searched_by_many_params($searchParam = NULL){
	
		$whereCondition = "";
		if ($searchParam != NULL){
			if (is_array($searchParam)){				
				
				if ($searchParam['genre'] != ""){
					$whereCondition .= " AND movie_categories.genre LIKE '" .$searchParam['genre']."%'";
				}
				if ($searchParam['title'] != ""){
					$whereCondition .= " AND movies.movie_name LIKE '%".$searchParam['title']."%'";
				}
				if ($searchParam['description'] != ""){
					$whereCondition .= " AND movies.movie_description LIKE '%".$searchParam['description']."%'";
				}
				if (($searchParam['dateFrom'] != "") && ($searchParam['dateTo'] != "")){
					$whereCondition .= " AND movies.movie_published BETWEEN " . $searchParam['dateFrom'] . " AND " . $searchParam['dateTo'];
				}elseif (($searchParam['dateFrom'] != "") && ($searchParam['dateTo'] == "")){
					$whereCondition .= " AND movies.movie_published BETWEEN " . $searchParam['dateFrom'] . " AND " . date("y-m-d");				
				}elseif (($searchParam['dateFrom'] == "") && ($searchParam['dateTo'] != "")){
					$whereCondition .= " AND movies.movie_published BETWEEN " . date("y-m-d") . " AND " . $searchParam['dateTo'];								
				}else{
					$whereCondition .= "";
				}
				
				$query = "SELECT COUNT(*) AS num_of_movs
							FROM movies, movie_categories
							WHERE movies.genre_id = movie_categories.genre_id " . $whereCondition;		
				$result = mysql_query($query);			
				if ($result){ 				
					$row = mysql_fetch_array($result);		
					return $row['num_of_movs'];				
				}	
			}
		}					
		
	}
	
}
	
?>
