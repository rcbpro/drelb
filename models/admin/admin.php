<?php

	class Admin_Functions{
		
		function addMovie($movieInputParam){
			
			$query = sprintf("INSERT INTO movies SET 
												movie_name = '%s',
												genre_id = '%s',
												movie_description = '%s',
												movie_published	= '%s',
												movie_uploaded = NOW(),
												hit_count = 0",
												$movieInputParam['movie_Title'],
												$movieInputParam['movie_genre'],
												$movieInputParam['movie_description'],
												$movieInputParam['movie_released_date']
							);
				$result = mysql_query($query);								
				if (mysql_affected_rows() > 0){
					return mysql_insert_id();
				}else{
					return false;
				}
		}
		
		function updateMovie($id, $mov_type, $mov_file_name, $img_file_name){
			
			$query = sprintf("UPDATE movies SET 
										movie_type = '%s',
										movie_file_name = '%s',
										thumbanail_image = '%s' 
										WHERE id = '%s'",
										mysql_real_escape_string($mov_type),
										mysql_real_escape_string($mov_file_name),
										mysql_real_escape_string($img_file_name),
										mysql_real_escape_string($id)
							);
			$result = mysql_query($query);				
			if (mysql_affected_rows() > 0){
				return true;
			}else{
				return false;
			}
		}
		
		function destroy($dir){
		
			$mydir = opendir($dir);
				while(false !== ($file = readdir($mydir))){
					if($file != "." && $file != ".."){
						chmod($dir.$file, 0777);
						if(is_dir($dir.$file)){
							chdir('.');
							$this->destroy($dir.$file.'/');
							rmdir($dir.$file);
						}else{
							unlink($dir.$file);
						}	
					}
				}
				closedir($mydir);		
		}
		
		function get_movie_details_for_preview($movId = ""){
		
			if ($movId != ""){
				$query = sprintf("SELECT movies.id AS id, 
										movies.movie_name AS title,
										movies.genre_id AS genre_id,
										movies.movie_description AS description,
										movies.thumbanail_image AS thumbanail_image,
										movies.movie_published AS date_published, 
										movies.movie_file_name AS movie_file_name, 
										movies.movie_type AS movie_type, 																				
										movie_categories.genre AS genre 
										FROM movies, movie_categories 
										WHERE id = '%s' 
										AND movies.genre_id = movie_categories.genre_id",
										mysql_real_escape_string($movId)
								);
				$result = mysql_query($query);
				if ($result){ 
					while ($row = mysql_fetch_array($result)){		
						$mov_info['id'] = $row['id'];				
						$mov_info['title'] = $row['title'];
						$mov_info['genre_id'] = $row['genre_id'];										
						$mov_info['genre'] = $row['genre'];
						$mov_info['description'] = $row['description'];
						$mov_info['date_published'] = $row['date_published'];
						$mov_info['thumbanail_image'] = $row['thumbanail_image']; 					
						$mov_info['movie_file_name'] = $row['movie_file_name'];
						$mov_info['movie_type'] = $row['movie_type'];					
					}
				return $mov_info;
				}
			}	
		}
		
		function editMovie($id, $movie_description, $published_date){
		
			$query = sprintf("UPDATE movies SET 
										movie_description = '%s',
										movie_published = '%s'
								WHERE id = '%s'",
										mysql_real_escape_string($movie_description),
										mysql_real_escape_string($published_date),
										mysql_real_escape_string($id)
							);
			$result = mysql_query($query);				
			if (mysql_affected_rows() > 0){
				return true;
			}else{
				return false;
			}			
		}
		
		function delete_movie($movNo){
			
			if ($movNo != ""){			 
				$movNo = (int) $movNo;
				$query = "DELETE movies.* FROM movies WHERE id = {$movNo}";
			}	
			$result = mysql_query($query) or die(mysql_error());
			return (mysql_affected_rows()>0) ? true : false;			
		}		
		
		function add_new_admin_user($newAdminUserParam){
			
			$query = sprintf("INSERT INTO admin SET 
												admin_name = '%s',
												password = '%s'",
												$newAdminUserParam['newname'],
												$newAdminUserParam['password']
							);
			$result = mysql_query($query);
			if (mysql_affected_rows() > 0){
				return true;
			}else{
				return false;
			}	
		}
		
	}
?>
