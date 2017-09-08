<?php
use M5\MVC\App;
use M5\MVC\Config;
use M5\Library\Page;
use M5\Library\Session;
?>

<?php require _WID.'_head.php'; ?>

<body data-url="<?= URL ?>" data-pageFlag="<?= APP::getRouter()->getController(); ?>" data-current_url="<?= page::url() ?>">

	<?php require view() . 'widgets/cdn_js.php'; ?>
	<script src="<?= assets('js/js.js'.CACHE_VAR) ?>"></script>

	<style type="text/css">
		<?php if ($data['bg']): ?>
		#land{
			background: url(<?=$data['bg']?>);
			background-repeat: no-repeat;
			background-repeat: no-repeat;
			background-position: 100% 0%;
			background-size: 100%;
		}
	<?php endif;?>

</style>

<?= $this->jsCode?>

<div id="MIC_SITE" data-doc="website wrapper" class="">
	<div id="MIC_mode"></div>

	<div id="moreActionsBars" >
		<div class="bars <?php if(session::get("bars") ) echo 'bars2'?>" >
			<i></i>
			<i></i>
			<i></i>
		</div>
	</div>
	<div id="header-top">

		<header class="header show <?= APP::getRouter()->getController() == "Index" ? "" : "showX" ?> ">
			<div class="row __">

				<content class="col-md-3 col-xs-6">

					<div class="alignR">
						<div class="optimize" id="logo">
							<a href="<?= url()?>">
								<img data-src="<?= LOGO ?>" alt="<?=site_name?>" width="150">
							</a>
						</div>

					</div>

				</content>


				<content class="col-md-6 col-xs-6">
					<div class="center novo">

						<br>
						<ul class="inline-ul _18">
							<?php if (Session::get("login")): ?>
								<li class=""><a class="f_white" href="<?= url('profile') ?>"> <i class="fa fa-user-o  vsmall "></i> <?=Session::get("userName")?></a></li>

								<li class=""><a class="f_white" href="<?= url('cv') ?>"> <i class="fa fa-send-o  vsmall "></i> <?=str("cves")?></a></li>

								<li class=""><a class="f_white confirm" data-confirm="هل تريد تسجيل الخروج؟" href="<?=url('account?do=logout')?>"><i class="fa fa-power-off"></i> <?=str('logout')?></a>
								</li>

							<?php else: ?>
								<li><a href="<?= url('blogs') ?>"> <i class="fa fa-send vsmall f_base"></i> <?=str('blogs')?></a></li>

								<li><a href="<?= url('categories') ?>"> <i class="fa fa-bookmark vsmall f_base"></i> <?=str('categories')?></a></li>

								<li><a href="<?= url('pages/about') ?>"> <i class="fa fa-question vsmall f_base"></i> <?=str('about')?></a></li>


								<li><a href="<?= url('pages/contact') ?>"> <i class="fa fa-envelope vsmall f_base"></i> <?=str('contact')?></a></li>
							<?php endif ?>

						</ul>
					</div>

				</content>

				<content class="col-md-3 col-xs-6 hidden-xs">
					<br>
					<div class="alignL">

						<ul class="inline-ul">
							<?php //pa($data['sn']) ?>

							<?php if($data['sn']) extract($data['sn']) ?>
							<?php if($ista): ?>
								<li class="rounded" ><a  href="<?= $ista ?>"><i class="fa fa-instagram "></i></a></li>
							<?php endif;?>

							<?php if($yt): ?>
								<li class="rounded" ><a  href="<?= $yt ?>"><i class="fa fa-youtube "></i></a></li>
							<?php endif;?>

							<?php if($gp): ?>
								<li class="rounded" ><a  href="<?= $gp ?>"><i class="fa fa-google "></i></a></li>
							<?php endif;?>

							<?php if($tw): ?>
								<li class="rounded" ><a  href="<?= $tw ?>"><i class="fa fa-twitter"></i></a></li>
							<?php endif;?>

							<?php if($fb): ?>
								<li class="rounded" ><a  href="<?= $fb?>"><i class="fa fa-facebook"></i></a></li>
							<?php endif;?>
						</ul>
					</div>

				</content>
			</div>
		</header>
	</div>

	<div class="scrooldown" id="bird">
		<div ><i class="fa fa-chevron-down"></i></div>
	</div>


	<?php require view('forms/form_search.php'); ?>

	<section id="wrapper" class="__">
		<?php if (APP::getRouter()->getController() != "Index"): ?>
			<?php require _WID.'_bread.php'; ?>
		<?php endif;?>