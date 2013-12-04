function setEventsShoppingCart(){
	var elements = document.getElementsByClassName("itemAmount");
	for (var i = 0; i < elements.length;i++){
		elements[i].onblur=function () {itemChangeAmount(this)};
	}
	
	var elements = document.getElementsByClassName("cartRemove");
	for (var i = 0; i < elements.length;i++){
		elements[i].onclick=function () {removeFromCart(this)};
	}
}

function itemChangeAmount(obj){
	var amount = obj.value;
	var reg = /^\d+$/;
	var err = 'Alleen numerieke waardes A.U.B';
	//console.log(amount);
	if(!amount.match(reg)){
		displayError(err);
		return false;
	}else{
		removeError(err);
	}
	
	if(amount == 0){
			removeFromCart(obj);
			return false;	
		}
	
	
	
	var price = 100;
	var item =$(obj).parent().parent();
	var price=$(item).find(".itemPrice").text()
	var totalprice = parseInt(price) * parseInt(amount);
	$(obj).parent().parent().find(".itemTotalPrice").text(totalprice+",00");
	console.log(totalprice);
	//priceNode[0].innerHTML = price;
	//itemTotalPrice
	cartTotalAmount();
	
	$.post( "procces/changeAmount.php",{ item: $(item).attr('id'), amount:amount }, function( data ) {
	  console.log(data);
	});	
}


function cartTotalAmount(){
	var elements = document.getElementsByClassName("itemTotalPrice");
		
		var total = 0;
		for (var i = 0; i < elements.length;i++){
			price=$(elements[i]).text();
			total += parseInt(price);
		}
		$("#shoppingcartTotalPrice").text(total+",00");
}

function removeFromCart(obj){
	var parent=$(obj).parent().parent();
	var id= $(parent).attr('id');
	event.preventDefault();
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    	console.log(xmlhttp.responseText);
	    	var response = xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","procces/removeFromCart.php?id="+id,true);
	xmlhttp.send();
	
	$(parent).remove();
	cartTotalAmount();
	
}


