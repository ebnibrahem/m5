<?php use M5\Library\Page; ?>

<div id="content">
	<?php //pa( $data['application'] ); ?>
	<?php //pa( $data["records"] ); ?>


	<?php $_GET['tab'] = !$_GET['tab'] ? 'application' : $_GET['tab']?>

	<div id="tabs">
		<ul class="inline-ul">
			<li class="tabs_item" data-tab="application" ><?=s('mic')?></li>
			<li class="tabs_item" data-tab="security"><?=s('security')?></li>
		</ul>
	</div>
	<div class="hr b_base br"></div>

	<div id="application" class="tabContent <?=$_GET['tab'] != "application" ? 'hide' : ''?>">
		<?php $application = $data['application']  ?>
		<form method="post" action="<?=url('admin/').'mic'?>" role="form" enctype="multipart/form-data">

			<div class="ib b40 mleft10 <?php if($st =="1") echo selected?> ">

				<div class="form-group">
					<label><i class="fa fa-globe"></i> <?= str("Name")?>  </label><br />
					<input class="form-control" type="text" name="name" value="<?= $application['name']?>">
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
					<input class="form-control" type="text" name="email" value="<?= $application['email']?>" class="asURL">
				</div>

				<div class="form-group">
					<label><i class="fa fa-envelope-o"></i> <?= str("tel")?> </label><br />
					<input class="form-control" type="text" name="tel" value="<?= $application['tel']?>" class="asURL">
				</div>

			</div>

			<div class="ib b40">

				<legend>Seo : </legend>

				<div class="form-group">
					<label><i class="fa fa-info-circle"></i> <?= str("Keywords")?>: </label><br />
					<textarea class="form-control" name="keywords"><?= $application['keywords']?></textarea>

				</div>

				<div class="form-group">
					<label><i class="fa fa-book"></i> <?= str("Description")?></label><br />
					<textarea class="form-control" name="description" style="width:88%"><?= $application['description']?></textarea>
				</div>

				<br />
				<br />
				<input type="submit" class="btn btn-primary" name="micUpdateBtn" value="<?= string('update') ?>">
				<input type="hidden" name="page" value="<?=M5\Library\page::url()?>" class="b_green">
			</div>
		</form>
	</div>

	<div id="security" class="tabContent <?=$_GET['tab'] != "security" ? 'hide' : ''?>">

		<section class="row" data-doc="1">
			<content class="col-md-6 col-xs-12 ">

				<form action="<?=url('admin/setting')?>" method="post" class="b90 auto_margin form-inline">

					<h5> <label for=""><i class="fa fa-hashtag vsmall"></i> استرجاع بيانات الدخول : </label> </h5>
					<a name="forget_aproach"></a>
					<?php $forget_aproach = $data['forget_aproach'] ?>

					<div class="form-group b60">
						<select name="forget_aproach" class="form-control b100">
							<option value="email" >الايميل - افتراضي </option>
							<option value="question" <?= $forget_aproach == "question" ? 'selected' : ''?> >سؤال الامان</option>
						</select>
					</div>

					<div class="form-group">
						<input type="submit" value="<?= str('customize')?>" name="forget_aproachBtnAdd" class="btn btn-primary auto_margin">
						<input type="hidden" name="page" value="<?=Page::url()?>#forget_aproach">
					</div>
				</div>
			</form>
		</content>

		<content class="col-md-6 col-xs-12 ">

		</content>
	</div>

</div>