 <?php
 use M5\MVC\config;
 use M5\MVC\App;
 use M5\MVC\page;
 ?>

 <form method="post" action="<?= url('admin/index/reset/'.$this->string)?>" class="ajaxForm" data-result="#echo"  >

 	<legend>Forget Password: </legend>

 	<div class="form-group has-feedback">
 		<span class="fa fa-key form-control-feedback"></span>
 		<input class="form-control" type="password" name="pass" placeholder="<?=string('new_password')?>" required />
 		<input type="hidden" name="page" value="<?=url('login')?>">
 	</div>

 	<br />
 	<input type="submit" name="resetBtn" value="OK" class="confirm btn btn-primary" />
 </form>

 <hr />
 <center class="small">
 	<a class="" href="<?= url("admin")?>"><i class="fa fa-arrow-left"></i><?= string('Back')?>   </a>
 </center>