<?php

	/** Redirect  to the address
	 *  @param String address
	 *  returun redirect
	 */
	function redirect_to($address){
		
		header('Location:'.WEBSITE.$address);
		exit;
	}
	
	/** Creates warnings for errors
	 *  @param String msg
	 *  return bool
	 */
	function flash_warning($msg){
	
		if (!$msg){ return false; }
		if (is_array($msg)){
			foreach($msg as $key => $value){ $_SESSION[$key] = $value; }			
		}else{
			$_SESSION['flash']['warning'] = $msg; 
		}	
		return true; 
	}
	
	/** Creates warnings for errors
	 *  @param String msg
	 *  return bool
	 */
	function flash_notice($msg){
	
		if (!$msg){ return false; }
		if (is_array($msg)){ 
			foreach($msg as $key => $value){ $_SESSION[$key] = $value; }
		}else{
			$_SESSION['flash']['notice'] = $msg;		
		}	
		return true;
	}

	/** Check for user session availability : if not found redirect to new
	 *  return bool or redirect
	 */
	function check_authentication(){
	 
	 	if ($_SESSION['user']){			
			return true;
		}else{
			redirect_to('/sessions/new');
		}
	}
	
	/*----------------------------------------------------------------------------------
	 createThumb($source_path, $output_path, $width, $height, $canvas_resize, $bg_color)
	
	 $source_path - path to image including file name
	 $output_path - path to save thumb including file name
	 $width, $height - width and height of thumbs
	 $canvas_resize - true if resize canvas else false (if true give a background color
	 $bg_color - color in hex without '#' to fill canvas if doing canvas resize (eg. 'ffffff')
	
	------------------------------------------------------------------------------------
	 This function will return the header of featured products for the given shop
	----------------------------------------------------------------------------------*/
		
	function createThumb($source_path, $output_path, $width, $height, $canvas_resize, $bg_color){

		// create phpThumb object
		$phpThumb = new phpThumb();
		
		$capture_raw_data = false; // set to true to insert to database rather than render to screen or file
		
		// this is very important when using a single object to process multiple images
		$phpThumb->resetObject();
	
		// set data source -- do this first, any settings must be made AFTER this call
		$phpThumb->setSourceFilename($source_path); 
		
		$thumbnail_width = $width; // set width
		$thumbnail_height = $height; // set height
		
		$phpThumb->setParameter('w', $thumbnail_width);
		$phpThumb->setParameter('h', $thumbnail_height);
		
		if($canvas_resize){
			$phpThumb->setParameter('far', 1);
			$phpThumb->setParameter('bg', $bg_color);
		}
		
		$phpThumb->setParameter('config_output_format', 'jpeg');
		$phpThumb->setParameter('config_imagemagick_path', '/usr/local/bin/convert');
		
		//$output_filename = './thumbnails/'.basename($_FILES['userfile']['name']).'_'.$thumbnail_width.'.'.$phpThumb->config_output_format;
		$output_filename = $output_path;
		
		if ($phpThumb->GenerateThumbnail()){ 
			// this line is VERY important, do not remove it!
			$output_size_x = ImageSX($phpThumb->gdimg_output);
			$output_size_y = ImageSY($phpThumb->gdimg_output);
			if ($phpThumb->RenderToFile($output_filename)){
				return true;
			} 
		}else{
			return false;
		}
	}
	

?>