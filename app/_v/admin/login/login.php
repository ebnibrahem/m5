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
    <a href="<?= url('admin/index/do/forget') ?>"><?= string('forget_password')?></a>
</form>