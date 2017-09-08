/**
 * check input fields
 */
 $(document).ready(function($) {

/**
 * check phone number
 */
 $("[type = 'tel'] ").focusout(function(event) {
 	var v =  $(this).val();
 	var msg = $(this).data('msg') ? 'type valid phone number' : $(this).data('msg');
 	if(v){
 		var result = v.match(/^[0-9]{7,14}$/);
 		if(!result){
 			$(this).focus().fadeOut().fadeIn('fast');
 			$(this).attr('style', 'border-color:#dd3333 !important');
 			$(this).parent('div').children('small').hide();
 			$(this).after('<small class="small _caps">'+msg+'</small>');
 		}else{
 			$(this).removeAttr('style');
 			$(this).parent('div').children('small').fadeOut();
 		}
 	}else{
 		$(this).removeAttr('style');
 		$(this).parent('div').children('small').fadeOut();
 	}

 });

 /** check email */
 $("[type = 'email'] ").focusout(function(event) {
 	var v =  $(this).val();
 	var msg = $(this).data('msg') ? 'type valid Email' : $(this).data('msg');
 	if(v){
 		var result = v.indexOf("@");
 		if(result < 0){
 			$(this).focus().fadeOut().fadeIn('fast');
 			$(this).attr('style', 'border-color:#dd3333 !important');
 			$(this).parent('div').children('small').hide();
 			$(this).after('<small class="small _caps">'+msg+'</small>');
 		}else{
 			$(this).removeAttr('style');
 			$(this).parent('div').children('small').fadeOut();
 		}
 	}else{
 		$(this).removeAttr('style');
 		$(this).parent('div').children('small').fadeOut();
 	}
 });


 /** check url */
 $("[type = 'url'] ").focusout(function(event) {
 	var v =  $(this).val();
 	var msg = !$(this).data('msg') ? 'type valid URL' : $(this).data('msg');

 	if(v){
 		result = v.match(/http[^\s]/m);

 		if(result === null){
 			$(this).focus().fadeOut().fadeIn('fast');
 			$(this).attr('style', 'border-color:#dd3333 !important');
 			$(this).parent('div').children('small').hide();
 			$(this).after('<small class="small _caps">'+msg+'</small>');
 		}else{
 			$(this).removeAttr('style');
 			$(this).parent('div').children('small').fadeOut();
 		}
 	}


 });


 /** check required name */
 $("[type = 'name'] ").focusout(function(event) {
 	var v =  $(this).val();
 	var msg = !$(this).data('msg') ? 'this input text required!' : $(this).data('msg');

 	v = v.trim();

 	if(!v){
 		$(this).val('');
 		$(this).focus().fadeOut().fadeIn('fast');
 		$(this).attr('style', 'border-color:#dd3333 !important');
 		$(this).parent('div').children('small').hide();
 		$(this).after('<small class="small _caps">'+msg+'</small>');
 	}else{
 		$(this).removeAttr('style');
 		$(this).parent('div').children('small').fadeOut();
 	}


 });


});//ready end