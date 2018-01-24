<?php

class movieCategories{

	/**
	 * Returns the movie categories
	 * return result resource
	 */
	function display_all_movie_categories(){
	
		$query = "SELECT * FROM movie_categories";
		$result = mysql_query($query);
		$mov_cats = array();
		if ($result){
			$i=0;
			while($row = mysql_fetch_array($result)){			
				$mov_cats[$i]['id'] = $row['genre_id'];
				$mov_cats[$i]['cat_name'] = $row['genre'];				
				$i++;
			}
			return $mov_cats;
		}
	}
	
}

?>