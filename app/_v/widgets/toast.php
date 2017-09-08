<?php use M5\Library\Session; ?>


<?php $msg = session::getWink("toast",false);?>

<div id="MIC_toast" class="scrollbar <?=!$msg ? '' :'showToast' ?>" >
    <div id="MIC_toast_w">
        <div id="MIC_toast_hd" class="hintX" title="ESC">
            <div id="MIC_toast_close"><i class="fa fa-remove"></i></div>
        </div>
        <div id="MIC_toast_msg">
            <span class="toast"></span>
            <?php
            if($msg){
                if(is_array($msg) == "1")
                    pen::pa($msg);
                else
                    session::getWink("toast");
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('body').bind("keypress keydown ",function(e){
            if(e.which == 13 || e.which == 27){
                $("#MIC_toast").removeClass('showToast');
            }
        });
        $("#MIC_toast_close").click(function() {
            $("#MIC_toast").removeClass('showToast');            
        });

//toast core
var screenHeight = $(window).height();
$("#MIC_toast_msg").css('max-height', (screenHeight/2)+200 +'px');

$("#MIC_toast").hover(function() {
    $("html,body").animate({scrollTop:0},400);
});


})
</script>