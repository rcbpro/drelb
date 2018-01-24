function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=600,top=150,left=450');
	if (window.focus) {newwindow.focus()}
	document.form.submit();
}

function redirect_for_search(){
	
	if (document.getElementById('searchField').value != ""){
		location.href = "http://chamaraintesting.x10hosting.com/index.php?cntrl=index&view=search&page=1&query=" + document.getElementById('searchField').value;	
	}else{
		location.href = "http://chamaraintesting.x10hosting.com/";				
	}	
}

function redirect_for_advance_search(){

	var qString = "";
	var qG = "";
	var qT = "";
	var qD = "";
	var qDF = "";
	var qDT = "";	
	
	if (document.getElementById('genre').options[document.getElementById('genre').selectedIndex].value != 0){
		qString = "qG=" + document.getElementById('genre').options[document.getElementById('genre').selectedIndex].text;		
	}
	
	if (document.getElementById('title').value != ""){
		
			if (document.getElementById('genre').options[document.getElementById('genre').selectedIndex].value != 0){
				qG = document.getElementById('genre').options[document.getElementById('genre').selectedIndex].text;	
			}else{
				qG = "";					
			}
			qString = "qG=" + qG
						 	 + "&qT=" + document.getElementById('title').value;				
	}
	
	if (document.getElementById('description').value != ""){
		
			if (document.getElementById('genre').options[document.getElementById('genre').selectedIndex].value != 0){
				qG = document.getElementById('genre').options[document.getElementById('genre').selectedIndex].text;	
			}else{
				qG = "";					
			}
			qString = "qG=" + qG
						 	 + "&qT=" + document.getElementById('title').value
							 + "&qD=" + document.getElementById('description').value;				
	}
	if ((document.getElementById('date_from').value != "") && (document.getElementById('date_to').value != "")){

			if (document.getElementById('genre').options[document.getElementById('genre').selectedIndex].value != 0){
				qG = document.getElementById('genre').options[document.getElementById('genre').selectedIndex].text;	
			}else{
				qG = "";					
			}
			qString = "qG=" + qG
						 	 + "&qT=" + document.getElementById('title').value
							 + "&qD=" + document.getElementById('description').value
							 + "&qDF=" + document.getElementById('date_from').value
 							 + "&qDT=" + document.getElementById('date_to').value;				
	}
	if ((document.getElementById('date_from').value == "") && (document.getElementById('date_to').value != "")){
		
			if (document.getElementById('genre').options[document.getElementById('genre').selectedIndex].value != 0){
				qG = document.getElementById('genre').options[document.getElementById('genre').selectedIndex].text;	
			}else{
				qG = "";					
			}		
			qString = "qG=" + qG
						 	 + "&qT=" + document.getElementById('title').value
							 + "&qD=" + document.getElementById('description').value
							 + "&qDF=" + "&qDT=" + document.getElementById('date_to').value;				
	}
	if ((document.getElementById('date_from').value != "") && (document.getElementById('date_to').value == "")){
		
			if (document.getElementById('genre').options[document.getElementById('genre').selectedIndex].value != 0){
				qG = document.getElementById('genre').options[document.getElementById('genre').selectedIndex].text;	
			}else{
				qG = "";					
			}		
			qString = "qG=" + qG
						 	 + "&qT=" + document.getElementById('title').value
							 + "&qD=" + document.getElementById('description').value
							 + "&qDF=" + document.getElementById('date_from').value + "&qDT";				
	}

	if (qString != ""){
		location.href = "http://chamaraintesting.x10hosting.com/index.php?cntrl=index&view=advanceSearch&page=1&" + qString;																		
	}else{
		location.href = "http://chamaraintesting.x10hosting.com/index.php?cntrl=index&view=advanceSearch";							
	}
}