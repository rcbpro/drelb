<?php

class moviesXML_Creator{

	function createMoviesXML(){

		$query = "select movie_name FROM movies";
		$result = mysql_query($query);
		if ($result){
		
			$file_handle = fopen('./public/xml/moviesSearch.xml','w');			
			$xmlPacket = "<?xml version='1.0'?>\n";			
			
			$xmlPacket .="<choices>";
			
			while($row = mysql_fetch_array($result)){

				$xmlPacket .= "\n<title>".$row['movie_name']."</title>\n";
			}
			$xmlPacket .= '</choices>';
		}else{
			$xmlPacket = "<?xml version='1.0'?><choices></choices>";
		}

		fwrite($file_handle,$xmlPacket);
		fclose($file_handle); 
		
	}			

	function readMoviesSuggestXML(){

		$xmlFile = simplexml_load_file("./public/xml/moviesSearch.xml") or die("cannot load the xml file");
		return (count($xmlFile) > 0) ? true : false;
	}
	
}

?>