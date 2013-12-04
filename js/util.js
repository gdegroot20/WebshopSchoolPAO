var errors = new Array();
function displayError(error){
	
	
	if(!$('#error').attr('id')){
		$('#content').prepend('<div id="error"></div>')
	}
	
	if($.inArray(error, errors) == -1){
		errors.push(error);
		$('#error').html($('#error').html() + error +'<br />');
	}
		
}

function removeError(error){
	var index =$.inArray(error, errors);
	if(index >= 0){
		errors.splice(index);
	}
	
	if(errors.length > 0){
		if($('#error').attr('id')){
			$('#error').html('');
			for(var i = 0 ; i < errors.length; i++){
				$('#error').html($('#error').html() + errors[i]);
			}
		}
	}else{
		if($('#error').attr('id')){
			$('#error').remove()
		}
	}
	
	
}
