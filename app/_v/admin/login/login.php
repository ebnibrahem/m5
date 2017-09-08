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
                    <form method="post" action="<?= site ?>ajax/forget" class="ajaxForm" data-result="#echo" >
                        <legend><?= string('forget_password')?></legend>
                        <br>

                        <div class="form-group has-feedback">
                            <label for=""></label>
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input type="text" class="form-control" name="email" placeholder="<?= string('email')?>" required />
                        </div>


                        <div class="form-group has-feedback">
                            <div class="form-control-feedback"><i class="fa fa-android f_green"></i></div>
                            <input class="form-control" type="text" name="captcha" placeholder="<?= string('captcha')?>" required>

                            <label for=""><?= string('Captcha')?>: </label>
                            <img src="<?= url('_v/human.php') ?>" alt="captcha">
                        </div>

                        <input type="submit" name="forgetBtn" value="<?= string('forget_password')?>" class="btn btn-primary" />
                        <hr />
                        <center class="small">
                            <a href="<?= site.'login' ?>"><?= string('Back')?>   </a>
                        </center>
                    </form>
                <?php elseif ($this->form == "reset"): ?>
                    <form method="post" action="<?= url('login/do/reset/'.$this->string)?>" role="form" >
                        <legend>Forget Password: </legend>

                        <div class="form-group has-feedback">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input class="form-control" type="password" name="pass" placeholder="<?=string('new_password')?>" required />
                            <input type="hidden" name="page" value="<?=url('login')?>">
                        </div>

                        <br />
                        <input type="submit" name="resetBtn" value="OK" class="confirm btn btn-primary" />
                    </form>

                <?php else: ?>
                    <?php $action = !$this->action ? 'admin' : $this->action  ?>

                    <form action="<?= url( $action  )?>" method="POST" role="form" class="_caps">
                        <legend><?= string( $header_string )." :: ".string('login') ?></legend>

                        <div class="form-group alignR">
                            <label for=""><?=string('user_name')?> </label>
                            <input type="text" class="form-control" id="" name="user" autofocus required="required" placeholder="<?= string( $header_string )?>">
                        </div>

                        <div class="form-group alignR">
                            <label for=""><?=string('password')?></label>
                            <input type="password" class="form-control" id="" name="pass" required="required">
                        </div>

                        <button type="submit" name="loginBtn" value="doLogin" class="btn btn-primary"><?= string('Login')?></button>
                        <?= csrf_fields() ?>

                        <hr>
                        <!-- <a href="<?= url('login/do/forget') ?>"><?= string('forget_password')?></a> -->
                    </form>
                <?php endif; ?>

            </div>
        </div>

    </div>

</body>
</html>