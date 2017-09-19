<?php
use M5\MVC\config;
use M5\MVC\App;
use M5\MVC\page;
?>

<?php $form = $this->forget_form ?>

<?php if ($form == "question"): ?>
    answer question form
    <form action="">

    </form>
<?php else: ?>
    <form method="post" action="<?= url('admin/index/forget') ?>" class="ajaxForm" data-result="#echo" >

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
            <img src="<?= url('app/_v/human.php') ?>" alt="captcha">
        </div>

        <input type="submit" name="forgetBtn" value="<?= string('forget_password')?>" class="btn btn-primary" />
    </form>
<?php endif ?>

<hr />
<center class="small">
    <a class="" href="<?= url("admin")?>"><i class="fa fa-arrow-left"></i><?= string('Back')?>   </a>
</center>