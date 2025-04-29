function Changefunction(value,type){
	
	if(type == "question" && value == 'image'){
		document.getElementById('text_for_question').style.display = "none";
		document.getElementById('image_for_question').style.display = "block";
    
	}else if (type  == "question" && value  == 'text'){
		document.getElementById('text_for_question').style.display = "block";
		document.getElementById('image_for_question').style.display = "none";
	}

	else if (type == "option1" && value == 'image'){
		document.getElementById('text_for_option1').style.display = "none";
		document.getElementById('image_for_option1').style.display = "block";
		document.getElementById('text_for_option2').style.display = "none";
		document.getElementById('image_for_option2').style.display = "block";
		document.getElementById('text_for_option3').style.display = "none";
		document.getElementById('image_for_option3').style.display = "block";
		document.getElementById('text_for_option4').style.display = "none";
		document.getElementById('image_for_option4').style.display = "block";
	
		
	}

	else if (type  == "option1" && value  == 'text'){
		document.getElementById('text_for_option1').style.display = "block";
		document.getElementById('image_for_option1').style.display = "none";
		document.getElementById('text_for_option2').style.display = "block";
		document.getElementById('image_for_option2').style.display = "none";
		document.getElementById('text_for_option3').style.display = "block";
		document.getElementById('image_for_option3').style.display = "none";
		document.getElementById('text_for_option4').style.display = "block";
		document.getElementById('image_for_option4').style.display = "none";
	
	}

	

	}





