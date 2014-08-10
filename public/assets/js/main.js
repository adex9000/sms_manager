$(document).ready(function(){

// Message counter
var message_start = 0;
var sms_start = 1;
$('#message_count').html(message_start);
$('#sms_count').html(sms_start);

$('#sms_message').keyup(function() {
  var character_count = $('#sms_message').val().length;
  var character_max = message_start + character_count;

  $('#message_count').html(character_max);

  if(character_count >= 160){
  	var sms_page_count = Math.floor(character_count / 160);
  	if(sms_page_count === 0){
	  	sms_start = 1;
  	} else if(sms_page_count === 1){
  		sms_start = 2;
  	} else if(sms_page_count === 2){
  		sms_start = 3;
  	} else if(sms_page_count === 3){
  		sms_start = 4;
  	} else if(sms_page_count === 4){
  		sms_start = 5;
  	} else if(sms_page_count === 5){
  		sms_start = 6;
  	} 
  	$('#sms_count').html(sms_start);
  } else {
  	sms_start = 1;
  	$('#sms_count').html(sms_start);
  }
  

});


});