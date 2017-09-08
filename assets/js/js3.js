$(document).ready(function($) {

	$(".topicAva img").click(function(){
		$("#MIC_toast").fadeOut();

		var src = $(this).attr('src');
		$(".chooseFile").attr('src', src);
		$(".avatar").attr('value', src);
	});

	/*hide toast when click upload more button*/
	$(".flag").click(function(event) {
		$("#MIC_toast").removeClass('showToast');
	});


	/**/
	$(".sub_folder").click(function(event) {
		var href = $(this).data('href');
		$("#main_wrapper").slideUp();

		$("#sub_wrapper").removeClass('hide');
		$("#sub_wrapper span").text(href);

		console.log(href);

		    //get Ajax data
		    var attach = $("body").data('url')+"admin/ajax/library/"+href;
		    $.ajax({url:attach,type:"POST",
		    	data:{
		    		noti: 1
		    	},
		    	success:function(result){
		    		$("#sub_wrapper span").html(result);
		    	}});
		    console.log(attach);
		});

	$("#ajax_back").click(function(event) {
		$("#main_wrapper").slideDown();
		$("#sub_wrapper").addClass('hide');
	});

});