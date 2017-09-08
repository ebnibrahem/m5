$(document).ready(function($) {
	var
	sh = screen.height,
	landHight =parseInt(sh);

	if( $("body").data('pageflag') == "index" ){
		$("#land").css({"height":landHight+"px"});
	}


	$("#bird").click(function () {
		$("html, body").animate({
			scrollTop: sh-200
		}, 700)

	});

	for (var i = 0; i <3; i++) {
		$("#bird .fa").fadeOut().fadeIn();
	}

	$("#bird").addClass("shadow").delay(600).queue(function(){
		$(this).removeClass("shadow").dequeue();
	});


	/*minmize header*/
	$(window).scroll(function() {
		var pin = $(this).scrollTop();

		if(pin > 100){
			$("#logo").addClass('logo');

		}else{
			$("#logo").removeClass('logo');
		}

	});

	/*moreActions*/
	$("#moreActions").css({"top":$("#moreActions").height()});
	$("#moreActions").click(function() {
		$("nav").toggleClass('nav_smart');
	});


	$(".bars").click(function(){
		$(this).toggleClass("bars2");
	});

    //more actions
    $(".bars").click(function (event) {
    	$("html, body").animate({
    		scrollTop: "0"
    	}, 700)
    	$(".novo").toggleClass('show_novo');
    });



    $(window).scroll(function() {
    	var pin = $(this).scrollTop();
    	if(pin > 600){
    		$("#scroll_up").css('right', '10px');
    	}else{
    		$("#scroll_up").css('right', '-100px');
    	}

		// console.log(pin)

	});

    $("#scroll_up").click(function() {
    	$("html, body").animate({
    		scrollTop: 0
    	}, 700)
    });


    var MIC_mode = $("#MIC_mode").css('display');
    var parentWidth = $('.slider').parent().width();
    if(MIC_mode != "table"){
		// /*jssor slider delete margin top*/
		$("#jssor_1").css({"top": "-20px"});
	}


	/*load more */
	$("#loadmore").click(function(){

		if($("#loadMoreCasheer").text()){

			var
			url = $("body").data("url")+"forms/loadMore",
			cond = $("#loadmore").data("cond"),
			casheer = parseInt($("#loadMoreCasheer").text() );

			//$("#loadmore").hide();
			//$(".loading").remove();
			$("#loadmore").after('<center><span class="loader"><i class="fa fa-spinner fa-spin f_base"></i></span></center>')

			$.ajax({
				url :url,
				type :"post",
				data :{"count":casheer,"cond":cond},
				success:function(e){
					$(".loader").remove();
					console.log(e);

					if(e =="end"){
						console.log("end of blog");
						$("#loadMoreCasheer").remove();
						$("#loadmore").html('<i class="fa fa-spinner"></i> نهاية النتائج');

					}else{
						$("#loadmore").before(e);
						$(".optimize img").each(function(){
							this.src = this.getAttribute('data-src');
						});

					}
				}
			});

			$("#loadMoreCasheer").text(Number(casheer+1));
		}

	});


	/*insert synchroniselly*/


});