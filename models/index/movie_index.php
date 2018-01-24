<?php

class Movies{

	/**
	 * Display All movies in the Index Page
	 * return result resource
	 */
	function display_all_movies($curr_page_no = NULL, $num_of_records, $filter_by = "", $controller = ""){				
		
		$display_items = ($controller != "admin") ? NO_OF_RECORDS_PER_PAGE : 14;				

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
		$all_movies = array();
		$query = "SELECT * FROM movies ORDER BY Rand() {$limit}";
		$result = mysql_query($query);
		if ($result){
			$i = 0;
			while($row = mysql_fetch_array($result)){
				$all_movies[$i]['id'] = $row['id'];
				$all_movies[$i]['movie_name'] = $row['movie_name'];
				$all_movies[$i]['genre_id'] = $row['genre_id'];
				$all_movies[$i]['thumbanail_image'] = $row['thumbanail_image'];
				$all_movies[$i]['movie_description'] = $row['movie_description'];																
				$all_movies[$i]['genre'] = $this->get_genre_name($row['genre_id']);																								
				$all_movies[$i]['movie_uploaded'] = $row['movie_uploaded'];																												
				$all_movies[$i]['hit_count'] = $row['hit_count'];																				
				$i++;
			}
			return $all_movies;
		}
	}

	/**
	 * Return num of movies in the database
	 * return Integer num_of_movies
	 */	
	function count_num_of_movies($condition = ""){
	
		$where = "";
		if ($condition != ""){
			$where = " WHERE genre_id = " . $condition;
		}
		$query = "SELECT COUNT(*) AS num_of_movs FROM movies {$where}";//die($query);
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);		
		return $row['num_of_movs'];;
	}

	/**
	 * Return details for the selected movie
	 * @param $mov_id
	 * return Array mov_info
	 */		
	function display_movie_info($mov_id){
		
		$query = sprintf("SELECT * FROM movies WHERE id = '%s'", mysql_real_escape_string($mov_id));
		$result = mysql_query($query);
		$mov_info = array();
		if ($result){
			while ($row = mysql_fetch_array($result)){		
				$mov_info['id'] = $row['id'];					
				$mov_info['movie_name'] = $row['movie_name'];
				$mov_info['genre_id'] = $row['genre_id'];
				$mov_info['genre'] = $this->get_genre_name($row['genre_id']);
				$mov_info['movie_description'] = $row['movie_description'];
				$mov_info['thumbanail_image'] = $row['thumbanail_image'];												
				$mov_info['movie_type'] = $row['movie_type'];												
				$mov_info['movie_file_name'] = $row['movie_file_name'];																				
				$mov_info['hit_count'] = $row['hit_count'];												
			}
			$this->update_hit_count($mov_info['hit_count'], $mov_info['id']);
			return $mov_info;
		}
	}
	
	/**
	 * Returns movie genre 
	 * @param $genre_id
	 * return String genre_name
	 */		
	function get_genre_name($genre_id){
	
		$query = sprintf("SELECT genre FROM movie_categories WHERE genre_id = '%s'", mysql_real_escape_string($genre_id));
		$result = mysql_query($query);
		if ($result){
			$row = mysql_fetch_array($result);
			return $row['genre'];
		}
	}
	
	/**
	 * Display movies related to the movie genres
	 * return result resource
	 */
	function display_movies_by_categories($cat_id, $curr_page_no){
		
		$display_items = NO_OF_RECORDS_PER_PAGE;		

		if ($curr_page_no != NULL){
			if ($curr_page_no == 1){
				$start_no_sql = 1;
				$end_no_sql = $display_items;
			}else{							
				$start_no_sql = ($curr_page_no - 1) * $display_items;
				$end_no_sql = $display_items;				
			}
		}else{
			 $start_no_sql = 1;
			 $end_no_sql = $display_items;		
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";					
		
		if ($this->count_num_of_movies($cat_id) < $display_items){
			$limit = "";					
		}		

		$query = sprintf("SELECT * FROM movies WHERE genre_id = '%s' {$limit}", mysql_real_escape_string($cat_id));
		$result = mysql_query($query);
		$movies_by_cat = array();
		if ($result){
			$i=0;
			while($row = mysql_fetch_array($result)){
				$movies_by_cat[$i]['id'] = $row['id'];
				$movies_by_cat[$i]['movie_name'] = $row['movie_name'];
				$movies_by_cat[$i]['genre_id'] = $row['genre_id'];
				$movies_by_cat[$i]['thumbanail_image'] = $row['thumbanail_image'];
				$movies_by_cat[$i]['movie_description'] = $row['movie_description'];																
				$movies_by_cat[$i]['genre'] = $this->get_genre_name($row['genre_id']);																								
				$movies_by_cat[$i]['hit_count'] = $row['hit_count'];																				
				$i++;
			}
			return $movies_by_cat;
		}
	}
	
	/**
	 * Update the Hit Count each time the movie visit
	 */
	function update_hit_count($hit_count, $id){
		
		$hit_count += 1;
		$query = sprintf("UPDATE movies 
									SET hit_count = '%s'
									WHERE id = '%s'", 
										mysql_real_escape_string($hit_count),
										mysql_real_escape_string($id));
		$result = mysql_query($query) or die(mysql_error());
	}	
	
	/**
	 * Display movies related to the movie genres
	 * return result resource
	 */
	function display_movies_by_lette_name($letter, $curr_page_no){
		
		$display_items = NO_OF_RECORDS_PER_PAGE;		
		
		if ($curr_page_no != NULL){
			if ($curr_page_no == 1){
				$start_no_sql = 1;
				$end_no_sql = $display_items;
			}else{							
				$start_no_sql = ($curr_page_no - 1) * $display_items;
				$end_no_sql = $display_items;				
			}
		}else{
			 $start_no_sql = 1;
			 $end_no_sql = $display_items;		
		}
		$limit = " Limit {$start_no_sql}, {$end_no_sql}";					
		if ($this->count_num_of_movies_by_letter_name($letter) < $display_items){
			$limit = "";					
		}	
		$query = "SELECT * FROM movies WHERE movie_name LIKE '" . $letter . "%' {$limit}";
		$result = mysql_query($query);
		$movies_by_letter = array();
		if ($result){
			$i=0;
			while($row = mysql_fetch_array($result)){
				$movies_by_letter[$i]['id'] = $row['id'];
				$movies_by_letter[$i]['movie_name'] = $row['movie_name'];
				$movies_by_letter[$i]['genre_id'] = $row['genre_id'];
				$movies_by_letter[$i]['thumbanail_image'] = $row['thumbanail_image'];
				$movies_by_letter[$i]['movie_description'] = $row['movie_description'];																
				$movies_by_letter[$i]['genre'] = $this->get_genre_name($row['genre_id']);																								
				$movies_by_letter[$i]['hit_count'] = $row['hit_count'];																				
				$i++;
			}
			return $movies_by_letter;
		}
	}
	
	/**
	 * Return num of movies in the database
	 * return Integer num_of_movies
	 */	
	function count_num_of_movies_by_letter_name($string){
	
		if ($string != ""){
			if (is_string($string)){
				$query = "SELECT COUNT(*) AS num_of_movs FROM movies WHERE movie_name LIKE '" . $string . "%'";				
				$result = mysql_query($query);
				if ($result) $row = mysql_fetch_array($result);		
				return $row['num_of_movs'];				
			}	
		}
	}
	
	/**
	 * Keep a track of the movies on users have downloaded : If any user search for a movie that is downloaded before we can alert on it.
	 * return a message containing whether previously downloaded or not
	 * @param $user_id
	 * @param $movie_name	 
	 * return String message
	 */	
	function previously_downloaded_or_not($user_id, $movie_name){
		
		$query = sprintf("SELECT * FROM movies_downloaded WHERE user_id = '%S' AND downloaded_movie = '%s'", 
									mysql_real_escape_string($user_id),
									mysql_real_escape_string($movie_name));
		$result = mysql_query($query);								
		if (mysql_num_rows($result)>0){
			$query = sprintf("INSERT INTO movies_downloaded user_id = '%s', downloaded_movie = '%s'", 
									mysql_real_escape_string($user_id), 
									mysql_real_escape_string($movie_name));
			$result = mysql_query($query);									
			$message = "";			
		}else{
			$message = "You have downloaded this movie at least once..";
		}
		return $message;
	}
	
	function get_the_last_movie_number(){
	
		$query = "SELECT MAX(id) AS maxId FROM movies";
		$result = mysql_query($query);
		if ($result) $row = mysql_fetch_array($result);
		return $row['maxId'];
	}
	
	
}

?>