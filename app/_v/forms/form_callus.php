<?php use M5\Library\Page; ?>

<form class="optimize ajaxForm " action="<?=url().'forms/callus'?>" method ="post" data-result="#console"  >

	<div class="row">
		<content class="col-md-6 col-sm-12">
			<div class="form-group">
				<label for="">&nbsp;</label>
				<input type="text" name="subject" placeholder="موضوع الرسالة">
			</div>
		</content>
		<content class="col-md-6 col-sm-12">
			<div class="form-group">
				<label for="">&nbsp;</label>
				<input type="text" name="email" placeholder="البريد الالكتروني">
			</div>
		</content>
	</div>

	<div class="form-group">
		<textarea name="msg" rows="5" placeholder="فحو الرسالة" class="form-control"></textarea>
	</div>

	<br>
	<div class="row">
		<content class="col-md-6 col-sm-12">
			<div class="form-group alignR form-inline">
				<img style="margin:auto; border-radius:3px" data-src="<?=URL('app/_v/')?>human.php" alt="Captcha">
				<input type="text" name="captcha" placeholder="رمز التحقق" autocomplete="off" style="width:200px">
			</div>
		</content>
		<content class="col-md-6 col-sm-12">
			<div class="form-group alignR">
				<input type="submit" name="callus_btn" class="btn btn-primary auto_margin"  value="<?=s('send')?>"><br />
			</div>
		</content>
	</div>

	<span id="console"></span>
</form>
