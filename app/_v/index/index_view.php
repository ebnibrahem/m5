<?php use M5\MVC\Shared as C; ?>


<div id="content">


	<div class="center">

		<?php $categories = $data['categories'] ;?>
		<div class="kht">
			<h1 class="f_base _22"><?= str("categories") ?> </h1>
			<div class="line">
				<b></b>
				<b><i class="fa fa-sitemap"></i></b>
				<b></b>
			</div>
		</div>
		<?php if ($categories) :?>

			<?php foreach ($categories as $part) : ?>
				<div class="profile optimize">
					<a href="<?= url('blogs/part/'.$part['ID'].M5\Library\Axe::url($part['name'])) ?>">
						<div class="head"></div>
						<div class="avatar">
							<img src="<?= LOADING ?>" data-src="<?= $part['ava'] ?>" alt="<?= $part['name']  ?>">

						</div>
						<h2 class="bold"><?= $part['name']  ?> <im class="small"><?=$part['total'] ?></im></h2>
					</a>
				</div>
			<?php endforeach ?>

		<?php endif ?>
	</div>


	<div id="blogs_last" class="center">

		<div class="kht">
			<h1 class="f_base _22"><?= str("last_records") ?> </h1>
			<div class="line">
				<b></b>
				<b><i class="fa fa-fire"></i></b>
				<b></b>
			</div>
		</div>

		<?php //pa ($data['blogs_last']) ?>

		<?php if ($data['blogs_last']): ?>
			<?php foreach ($data['blogs_last'] as $key => $blog): ?>
				<?php if ($blog['name']): ?>
					<?php require view().'blogs/thumbnail.php';?>
				<?php endif ?>
			<?php endforeach ?>

			<div class="center">
				<div id="loadmore" class="btn87" data-cond="<?=$this->cond?>">
					<i class="fa fa-spinner"></i> <?= str('loadmore')?>
				</div>
			</div>
			<span id="loadMoreCasheer" class="hide">2</span>
		<?php endif ?>

	</div>


	<div id="about" class="center">

		<div class="kht">
			<h1 class="f_base _22"><?= str("aboutus") ?> </h1>
			<div class="line">
				<b></b>
				<b><i class="fa fa-globe"></i></b>
				<b></b>
			</div>
		</div>

		<div class="read_text">
			<?=site_description?>
		</div>

	</div>

	<div id="contact" class="center">

		<div class="kht">
			<h1 class="f_base _22"><?= str("contact") ?> </h1>
			<div class="line">
				<b></b>
				<b><i class="fa fa-envelope"></i></b>
				<b></b>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="ads-block pd10"  style="height:auto;">
					<?php require view('forms/form_callus.php');?>

				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">

				<div class="ads-block pd10 b_gray"  style="height: 90px">
					<br>

					<ul>
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

				<div class="center"><i class="fa fa-whatsapp"></i><?=site_tel?></div>



			</div>
		</div>

	</div>

	<br>
	<br>
	<br>
	<br>

</div> <!--./content-->