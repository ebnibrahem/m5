/**
* this file ad-hoc to Cpanel
*/
$(document).ready(function (e) {
	var mode = $("#MIC_mode").css("display");

    //###########################################
    // Admin Cpanel aside menu handler
    //###########################################

    $("aside li").click(function () {
    	$("aside li ul").slideUp();
    	$(this).children("ul").slideToggle();
    });
    $("aside").mouseleave(function () {
    	$("aside li ul").slideUp();
    });

    if (mode != "table") {
        /** close aside **/
        $(".aside_close").click(function () {
            //save status
            var url = $("body").data("url") + "admin/ajax/aside_menu";
            $.ajax({
            	url: url,
            	type: "POST",
            	data: {
            		session: 1
            	},
            	success: function (e) {
            		console.log(e);
            	}
            })
        });

        /** open aside **/
        $(".aside_open").click(function () {

            $("aside").css('width','17%');
            
            //save status
            var url = $("body").data("url") + "admin/ajax/aside_menu";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                  session: 0
              },
              success: function (e) {
                  console.log(e);
              }
          })
        });


    } else {
        //in responsive environment
    }

    $("#moreActions").click(function () {
    	$("aside").toggleClass("showAside");
    });



    /*colorpanel*/
    $("[name = 'color[]']").each(function() {
    	$(this).css('background', $(this).val() );        
    });

    $("[name = 'color[]']").on("keyup focus",function(event) {
    	$(this).css('background', $(this).val() );
    });

    $(".colorpanelKey").click(function() {
    	$("#colorpanel").toggleClass('colorpanelTgl');
    });
    $("body").click(function() {
    	$("#colorpanel").removeClass('colorpanelTgl');
    });

    $("#colorpanel").click(function(event) {
    	event.stopPropagation();
    });
});