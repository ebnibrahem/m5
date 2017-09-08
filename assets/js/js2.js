$(document).ready(function ($) {

    /*css*/
    $("#wrapper").css({"min-height": $("aside").height() + "px"});

    /*### Smart Devices */

    /* flode asdie*/
    $(".aside_close").click(function () {
        $("aside").toggleClass('w0');
        $(".section").toggleClass('w100');
        $(".aside_open").fadeIn('fast').fadeOut('slow').fadeIn('fast');
        $(".aside_open").fadeIn('fast').fadeOut('slow').fadeIn('fast');
    });
    $(".aside_open").click(function () {
        $(this).fadeOut('fast');
        $("aside").removeClass('w0');
        $(".section").removeClass('w100');
    });

    $("#moreActions").click(function () {
        $("aside").toggleClass('aside');
    });


    var asideH = $("aside").height();

    $(".section").css('min-height', asideH);


    /**have_ul*/
    $(".have_ul").click(function() {
        $(this).css({'overflow': 'visible','height':'auto'});
    });


    $(".inboxShow").click(function() {
        $("#MIC_toast").addClass('showToast');

        var html =
        $(this).children('textarea').val();
        $("#MIC_toast .toast").html('<div style="text-align:right; padding:10px">'+html+'<div>');
        console.log(html);
    });



    /* interview gallery image */

    $("#albumViewBtn").click(function() {
        var album = $(".album").val();
        var ajax = $("body").attr('data-url')+'ajax/interviewGalleryImages';

        if(!album){
            $(".album").css("border","1px solid #F00").fadeOut().fadeIn();
        }else{

            $("#albumView span").html("working...");
            var array = album.split('\n');

            $.ajax({url:ajax,type:"POST",
                data:{
                    noti: 1,
                    text:array
                },
                success:function(result){
                    $("#albumView span").html(result);
                }});
        }

        $(".thumbnails").click(function(){
            $("#MIC_toast").fadeOut();

            var src = $(this).attr('src');
            $(".chooseFile").attr('src', src);
            $(".avatar").attr('value', src);

        });

    });



    $("#partRank").change(function() {

        var partRank =  $(this).val();

        if(partRank == "parent"){
            $("#childRank").addClass("hide");
        }else{
            $("#childRank").removeClass('hide');
        }

    });


    $("#print").click(function() {

        var htmlContent = $(".printable").html();

        $('html body').animate({
            top: 0},
            700);

        $("#toast_print").css('height', screen.height );
        
        $("#toast_print").show()
        $("#container").hide()
        $("#toast_print #print_body").html(htmlContent);
        var url = $("body").data("current_url");
        $("table").css('font-family', 'arial');
        $("article").css({'font-family': 'arial','border':"0"});
        $(".hide_in_print").remove();

       // window.open(url,'_blank');
        // alert("نسخة قابلة للطباعة");

    });


    


});


