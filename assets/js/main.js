/**
* this file shared between admin panel and user site
*/

    /**
      * Return response as string. you can handle it.
      * @return {json}
      */
      function submitFormWithAjax(form) {
        var form = $(form);
        var ret = false;
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: (form.attr('method')),
            datatype: 'json',
            success: function( data, status, xhttp) {
             // data will be true or false if you returned a json bool
             ret = data;
         },
        async: false // this is generally bad, it will lock up your browser while it returns, but the only way to fit it into your pattern.
    });
        return ret;
    }

    $(document).ready(function(e) {
        /* are you sure to do this action*/
        $(".confirm").click(function () {
            var msg = $(this).data('confirm'),
            m = window.confirm( !msg ? "Are You Sure ??" : msg);

            if (m == "1")
            {
                return true;
            } else
            {
                console.log('Operation Cancelled');
                return false;
            }
        });

        /*selec/disselet*/
        $('.mark').click(function () {
            if ($('.multy').prop('checked'))
            {
                $('.multy').prop('checked', false);
            } else {
                $('.multy').prop('checked', 'checked');
            }
        });

        /** select all **/
        $(".selectAll").click(function(){
            $(this).select();
        });

        /*colud and make rain */
        $(".rain").click(function () {
            $(this).parent('.cloud').children('.water').slideToggle();
            $(this).parent('.cloud').children('.thewater').slideToggle();
        });

        $(".rain *:first").before('<span class="tgl"><i class="fa fa-angle-down"></i></span>');


        /**** hint **/
        $(".hint").mousemove(function (e) {
            var hint = $(this).data("hint");
        // var py = e.pageY+15;
        var py = 30;
        var px = e.pageX;
        var mode = $("#MIC_mode").css("display");

        if(mode == "table"){

        }else{
            $(".hinter").remove();
            var cssPosition = $(this).css('position');
            if(cssPosition == "static"){
                $(this).before('<div class="hinter">' + hint + '</div>');
                $(".hinter").css({"left": px,"top":py+"px"});
            }else{
                console.log(cssPosition);
                $(this).attr('title', hint);
            }

        }
    });

        $(".hint").mouseout(function () {
            $(".hinter").remove();
        });


        $(".goBack").click(function goBack() {
            window.history.back()
        });

        /*show image in full mode  */
        $(".viewPhoto").click(function(){
            _top0();
            var src = $(this).attr('src');
            $("#MIC_toast span").html('<img src="'+src+'" all="'+src+'" width=95% />');
        });


        /*optimize images */
        $(".optimize img").each(function(){
            this.src = this.getAttribute('data-src');
        });

        /*optimize bg images*/
        $(".optimize_bg ._bg").each(function(){
            $(this).attr({
                style: $(this).attr('data-style')
            });
        });

    /*
    $(".casheer").each(function(){
        var text = $(this).data('casheer');
        $(this).text(text);

    });*/

    /*use MIC_toast to view images that uploaded in library */
    $(".chooseFile").click(function() {
        _top0();
        $("#MIC_toast").addClass('showToast');

        /*get Ajax data*/
        var attach = $("body").data('url')+"admin/ajax/library";

        $("MIC_toast span").text("..Loading..");

        $.ajax({url:attach,type:"POST",
            data:{
                noti: 1
            },
            success:function(result){
                $("#MIC_toast .toast").html(result);
            }});
        /* console.log(attach);*/

    });

    /**
     * send post http request by ajax.
     *
     */
     $(".ajax_http").click(function(event) {

        /*get Ajax data*/
        var url = $(this).data('url');
        var result = $(this).data('result');

        $.post(url,
        {
            ajax_http: 1,
        },
        function(data, status){
            $(result).html(data);
        });
    });

    /***boom decreasing parameter to hide
    * releted with page::go_to('','',true) function
    **/
    var c = $("#boom").data('count');
    var boom = setInterval(function(){
        c--;
        $("#boom span").html("<i class='fa fa-clock-o'><i/>"+c);
        if(c == "0"){
            clearInterval(boom);
            $("#boom span").html("<i class='fa fa-spinner fa-spin'><i/>");
        }
    },1000);


    /*optimize check box */
    /*must create .cked,.uncked class  */

    $("._btn").click(function() {
        $(this).parent(".role").children('.cked').show();

        $(this).parent(".role").children('._hdn')
        .attr({"value":"on"});

        $(this).hide();
    });

    /*$("input:checkbox") */

    $(".cked").click(function() {
        $(this).hide();
        $(this).parent(".role").children('input')
        .attr({"value":"off"});

        $(this).parent(".role").children('._btn').show();
    });

    /*ajaxForm */
    $(".ajaxForm").submit(function (e) {
        e.preventDefault();
        /*tinyMCE.triggerSave(); */

        var
        form = $(this),
        action = form.attr("action"),
        method = form.attr("method"),
        result = form.attr("data-result"),
        debug = form.attr("data-console"),
        data = form.serialize();

        $(".loading").remove();
        $(this).after('<center><span class="loading"><i class="fa fa-spinner fa-spin"></i></span></center>')

        $.ajax({
            "url": action,
            "type": method,
            "data": new FormData( this ),
            processData: false,
            contentType: false
            ,
            success:function (e) {
                $(".loading").remove();

                if(result == "toast"){
                    _top0('ttheme_mama');
                    $("#MIC_toast span").html(e);
                }else{
                    $(result).html('<center>'+e+'</center>');
                    debug ? console.log(strip_tags(e)) : "";
                    console.log(debug)
                }
            }
        });
    });

    function _top0(style=''){
        $("html,body").animate({scrollTop:0}, 400);
        $("#MIC_toast").addClass('showToast');
        $("#MIC_toast").addClass(style);
    }

    function strip_tags(text){
        var regex = /(<([^>]+)>)/ig
        var body = text;
        var result = body.replace(regex, "");
        return result;
    }


    /*pin something */
    $(".pin").click(function(){
        var pin = $(this).data("pin"),
        action = $("body").data("url")+"ajax/pin";


        $.ajax({
            "url": action,
            "type": "post",
            "data": {"pin":pin},
            success:function (e) {
                console.log(e);
            }
        });
    });


    $(".showPassword").click(function() {
        $(this).parent('form').children('input:password').attr('type', 'text');
    });

    /*select optimize */
    /*$("select").after('<span class="fa fa-angle-down selectArrow"></span>') */

    /*ul */
    $(".ul").click(function() {
        $(this).children('ul').slideToggle();
        $(".dropList").slideToggle();
    });


    /* show images where choosed */
    $(".file").change(function(){
        readURL(this);
    });

    function readURL(input) {


        if (input.files && input.files[0]) {
            var reader = new FileReader();

            /*$('.blah').html(''); */
            var fSize = (input.files[0].size)/1024/1024;
            fSize = fSize.toFixed(2);
            var d =  input.files[0].name  +'<br />'+  fSize +' MB';
            $('.blah').html( $('.blah').html() + d+"<hr />");

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }

    }


    /** Bootstrp optimize*/

    /*not need input-controll class just .form-group Wrapper*/
    $(".form-group").each(function(){
        $(this).children('input,textarea,select').addClass('form-control');
        $(this).children('input:checkbox').removeClass('form-control');
    });

    /* show waiting messge in toast */
    $(".set_toast_msg").click(function(e) {
        /* e.preventDefault(); */

        var
        loading_msg =  $(this).attr("data-msg"),
        theme       =  $(this).attr("data-theme");

        loading_msg =  !loading_msg ? 'جاري معالجة الطلب ' : loading_msg;

        $("#MIC_toast").addClass("showToast");
        $("#MIC_toast span").html('<div class="loader"><span class=""><i class="fa fa-spinner fa-spin"></i>'+loading_msg+'</span></div>');
    });



    /*upload file synch*/
    /*
    * <form class="upload_file" action="<?= url('forms/upload')?>" data-redirect="redirect" enctype="multipart/form-data">
    *  <input type="file" name="images[]" id="">
    * <div class="process"></div>
    * <span class="console"></span>
    * <span class="view"></span>
    * </form>
    */

    $(".upload_file").change(function(event) {

        var
        form = $(this),
        action = form.attr("action"),
        redirect = form.attr("data-redirect"),
        method = "POST",
        result = form.attr("data-result"),
        loading_msg =  form.attr("data-loading_msg"),
        loading_msg = !loading_msg ? 'جاري معالجة الطلب ' : loading_msg,
        theme = form.attr("data-theme"),
        data = form.serialize();

        $.ajax({
            "url": action,
            "type": method,
            "data": new FormData( this ),
            processData: false,
            contentType: false,

            xhr: function(){
                /* get the native XmlHttpRequest object*/
                var xhr = $.ajaxSettings.xhr() ;
                form.children(".process").text("0%");
                form.children(".process").css({'background-size': "0% 30px"});

                /* set the onprogress event handler*/
                xhr.upload.onprogress = function(event){
                    var loaded = event.loaded;
                    var total = event.total;
                    var precent = Math.round( (loaded/total)*100 );

                    form.children(".process").css({'border':'1px solid #DDD', 'background-size': precent+"% 30px"});
                    form.children(".process").text(precent+"%");

                };

                /* set the onload event handler*/
                xhr.upload.onload = function(){
                    console.log('loading');
                };

                /* return the customized object*/
                return xhr ;
            },
            success:function (e) {
                form.children(".console").html(e);

                /*referesh*/
                if(redirect)
                    window.location.assign( redirect )

            }
        });
    });


    /**
     * Delete img smoothly
     *
     * FORMAT: surround by div tag
     *<button type="button" id="del_img"  data-folder="_blogs" data-del="<?='upload/ads/'.$temp_view['BETA'].'/'.basename($img)?>" class="del_img btn vsmall b_red f_white confirm _caps"><?= string('delete')?></button>
     *
     */
     $(".del_img").click(function() {
        var t = $(this).data('del');
        var folder = $(this).data('folder');

        $(this).parent('div').remove();

        var url = $("body").data("url") + "admin/ajax/del_image";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                file: t,
                folder: folder
            },
            success: function (e) {
                console.log(e);
            }
        })

    });

     /*insert synchroniselly*/
     $(".synch").bind("click change focusout",function(){
        var
        url = $("body").data("url")+"forms/synch",
        re = $("body").data("url")+"ads/"+$("#adsBtnApproved").data("ads_id"),
        fld_name = $(this).data('synch_name'),
        fld_value = !$(this).data('synch_value') ? $(this).val() : $(this).data('synch_value');

        if(fld_value){
            $.ajax({
                url: url,
                type: 'post',
                data: {'name': fld_name, 'value':fld_value},
            })
            .done(function(e) {
                /*adsBtnApproved*/
                if(e == "complete"){
                    window.location.assign( re )
                    console.log(re)
                }
                console.log("done" +e)

            });
        }

    });


     /* Dynamic Drop list [select-option-list] */
     $(".select_pc").bind("change keyup", function() {

        var
        url = $("body").data("url")+"forms/select_pc",
        cond = $("#loadmore").data("cond"),
        parent = $(this).val(),
        child_flag = $(this).data("child_flag");
        fetch_flag = !$(this).data("fetch_flag") ? 'db' : $(this).data("fetch_flag");

        $("#"+child_flag).html('<div class="fa fa-spinner fa-spin"></div>')
        $.ajax({
            url: url,
            type: 'POST',
            data: {partent_value:parent, tbl:'tree', fetch_flag:fetch_flag,  },
        })
        .done(function(e) {
            $("#"+child_flag).removeClass('label-info')
            $("#"+child_flag).removeClass('label')
            $("#"+child_flag).html(e)
            // console.log(e)
        })

    });

     /** Dynamic list: Get child of current tag
     * pass data as json object: data-ajax='{"val":<?= $part['ID'] ?>,"result_tag":"result_tag"}'
     */
     $(".dom_pc").bind("click hover", function() {

        var dom =  $(this).data('ajax');

        var
        url = $("body").data("url")+"forms/select_pc",
        cond = $("#loadmore").data("cond"),
        parent = dom.val,
        result_tag = dom.result_tag;
        fetch_flag = !$(this).data("fetch_flag") ? 'db' : $(this).data("fetch_flag");

        $("#"+result_tag).html('<div class="fa fa-spinner fa-spin"></div>')
        $.ajax({
            url: url,
            type: 'POST',
            data: {partent_value:parent, tbl:'tree', fetch_flag:fetch_flag, tag:"li"  },
        })
        .done(function(e) {
            $("#"+result_tag).removeClass('label-info')
            $("#"+result_tag).removeClass('label')
            $("#"+result_tag).html(e)
            // console.log(e)
        })

    });

     /* Dynamic Live select */
     $(".select_pc_live ").each(function(){
        $(this).parent("div").addClass('center');

        var
        child_flag = $(this).data("child_flag"),
        fetch_flag = $(this).data("fetch_flag");

        $("#"+child_flag).html('<div class="fa fa-spinner fa-spin"></div>'+fetch_flag)

    });


     /* Show All tooltips */
     $('[data-toggle="tooltip"]').tooltip();

    /**
     * MIC_toast
     * @param  {String} style :class name
     * @param  {boolean} top :  make body top :0
     * @return {void}
     */
     function toasting(style='',top=null){

        $("#MIC_toast").addClass(style);
        $("#MIC_toast").addClass('showToast');

        if(top){
            $("html,body").animate({scrollTop:0}, 400);
        }

    }

    /**
     * put html content to toast.
     *
     */
     $(".popup").click(function(event) {
        toasting("ttheme_mama");
        $("#MIC_toast").addClass('showToast');
        dom = "#"+$(this).data('popup');


        $("#MIC_toast .toast").html( $(dom).html() );
    });


     $(document).on('submit', '.ajax_http_form', function (){
        event.preventDefault();

        var
        form = $(this),
        action = form.attr("action"),
        method = form.attr("method"),
        result = form.attr("data-result"),
        debug = form.attr("data-console"),
        data = form.serialize();

        $(".loading").remove();
        $(this).after('<center><span class="loading"><i class="fa fa-spinner fa-spin"></i></span></center>')

        $.ajax({
            "url": action,
            "type": method,
            "data": new FormData( this ),
            processData: false,
            contentType: false
            ,
            success:function (e) {
                $(".loading").remove();
                toasting('ttheme_mama');

                $(result).html('<center>'+e+'</center>');
                debug ? console.log(strip_tags(e)) : "";
                console.log(debug)
            }
        });

    })

     /* horizontal tabs*/
     $(".tabs_item").click(function(event) {

        var current_url =$("body").data("url")+$("body").data('pageflag');
        var tab = $(this).data('tab');

        history.pushState('', '', current_url+"?tab="+tab);

        /* Highlighting*/
        $(".tabs_item").removeClass('b_gray');
        $(this).addClass('b_gray');

        $(".tabContent").addClass("hide");

        var selected_tab = "#"+tab;
        $(selected_tab).removeClass("hide");

    });

     /* add class after time */
     $(".addClassAfter").each(function() {

        var t = $(this).data('time');
        var style =  $(this).data('class');

        $(this).delay(t).queue(function () {
            $(this).addClass(style);
        });


    });



 });
