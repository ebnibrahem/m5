<div id="content">

	<div id="tabs">
		<ul class="inline-ul">
			<li class="tabs_item" data-tab="mic" ><?=s('mic')?></li>
			<li class="tabs_item" data-tab="security"><?=s('security')?></li>
		</ul>
	</div>
	<div class="hr b_base br"></div>


	<?php $record = $data['record'] ?>

	<?php //pa($record) ?>

	<form method="post" action="<?=url('admin/').'mic'?>" role="form" enctype="multipart/form-data">

		<div class="ib b40 mleft10 <?php if($st =="1") echo selected?> ">

			<div class="form-group">
				<label><i class="fa fa-globe"></i> <?= str("Name")?>  </label><br />
				<input class="form-control" type="text" name="name" value="<?= $record['name']?>">
			</div>

			<div class="form-group">
				<label><i class="fa fa-photo"></i> <?= str("LOGO")?> </label><br />
				<input class="form-control" type="file" name="logo[]" class="hint" data-hint="تغيير">

				<input type="checkbox" name="changeLogoFlag" id="changeLogoFlag">
				<label for="changeLogoFlag"><?= str('change') ?></label><br>
				<br />

				<img src="<?=LOGO?>" width="100"><br>

			</div>

			<div class="form-group">
				<label><i class="fa fa-envelope-o"></i> <?= str("Email")?> </label><br />
				<input class="form-control" type="text" name="email" value="<?= $record['email']?>" class="asURL">
			</div>

			<div class="form-group">
				<label><i class="fa fa-envelope-o"></i> <?= str("tel")?> </label><br />
				<input class="form-control" type="text" name="tel" value="<?= $record['tel']?>" class="asURL">
			</div>

		</div>

		<div class="ib b40">

			<legend>Seo : </legend>

			<div class="form-group">
				<label><i class="fa fa-info-circle"></i> <?= str("Keywords")?>: </label><br />
				<textarea class="form-control" name="keywords"><?= $record['keywords']?></textarea>

			</div>

			<div class="form-group">
				<label><i class="fa fa-book"></i> <?= str("Description")?></label><br />
				<textarea class="form-control" name="description" style="width:88%"><?= $record['description']?></textarea>
			</div>

			<br />
			<br />
			<input type="submit" class="btn btn-primary" name="micUpdateBtn" value="<?= string('update') ?>">
			<input type="hidden" name="page" value="<?=M5\Library\page::url()?>" class="b_green">
		</div>

	</form>


</div>