<?php
use M5\MVC\config;
use M5\MVC\App;

// if(M5\Library\Session::get("login2") && APP::getRouter()->getController() == "" ){
//     M5\Library\Page::location(url().'admin/cp','exit');
// }

?>
<?php $header_string = !$this->header_string ? str('Administration') : $this->header_string  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= str("login")." ".str( $header_string ) ?></title>
    <link rel="stylesheet" href="<?= assets('css/default.css?' . uniqid()) ?> ">

    <?php require view('widgets/cdn_css.php'); ?>

    <link rel="stylesheet" href="<?= assets('css/admin.css?' . uniqid()) ?> ">

    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="background-color:#ccc;color:#272727">
    <?php require view('widgets/cdn_js.php'); ?>
    <script src="<?= assets('js/js2.js?' . uniqid()) ?>"></script>

    <?php if(M5\Library\Session::getWink("msg",false) || M5\Library\Session::getWink("alert",false) ):?>
        <script type="text/javascript">

            $(document).ready(function($) {
                $(".panel").animate({"margin-left": "-100px"},500);
                $(".panel").animate({"margin-left": "0"},200);
                $(".panel").animate({"margin-left": "-99px"},200);
                $(".panel").animate({"margin-left": "0"},200);
            });

        </script>
    <?php endif?>


    <div class=" center">

        <?php //pa($this) ?>

        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="panel panel-default p480">
            <img src="<?= LOGO?>" alt="" style="border-bottom: 4px solid red" width="90">
            <div id="echo"></div>
            <?= M5\library\Session::getWink("msg") ?>

            <div class="panel-body">

                <?php if ($this->form == "forget"): ?>
                    <?php require view('admin/login/forget.php');?>
                <?php elseif ($this->form == "reset"): ?>
                    <?php require view('admin/login/reset.php');?>
                <?php else: ?>
                    <?php $action = !$this->action ? 'admin' : $this->action  ?>
                    <?php require view('admin/login/login.php');?>
                <?php endif; ?>

            </div>
        </div>

    </div>

</body>
</html>