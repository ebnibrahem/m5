<br>

</div><!--#wrapper-->
<footer>
	<div class="footer">
		<div class="row __">

			<content class="col-md-3 col-xs-12">

				<div class="alignR optimize">
					<br>
					<br>

					<?php $categories = $data['categories'] ;?>
					<?php if ($categories) :?>

						<?php foreach ($categories as $part) : ?>
							<li>
								<a href="<?= url('blogs/part/'.$part['ID'].M5\Library\Axe::url($part['name'])) ?>">
									<img class="radiused" src="<?= LOADING ?>" data-src="<?= $part['ava'] ?>" alt="<?= $part['name'] ?>" width="70" />
									<b class="bold"><?= $part['name']  ?></b>
								</a>
							</li>
						<?php endforeach ?>

					<?php endif ?>

				</div>

			</content>


			<content class="col-md-6 col-xs-12">
				<div class="optimize center">
					<a href="<?= url()?>">
						<img data-src="<?= LOGO ?>" alt="<?=site_name?>" >
					</a>
					<br>
					<?= site_tel ?>
				</div>
				<br>
				<div class="center">

					<br>
					<ul class="ul">
						<li><a href="<?= url('blogs') ?>"> <i class="fa fa-send vsmall f_base"></i> <?=str('blogs')?></a></li>

						<li><a href="<?= url('pages/about') ?>"> <i class="fa fa-question vsmall f_base"></i> <?=str('about')?></a></li>

						<li><a href="<?= url('pages/contact') ?>"> <i class="fa fa-envelope vsmall f_base"></i> <?=str('contact')?></a></li>

						<li><a href="<?= url('pages/term-of-use') ?>"> <i class="fa fa-envelope vsmall f_base"></i> <?=str('tos')?></a></li>

						<li><a href="<?= url().'Sitemap.xml' ?>"> <i class="fa fa-rss vsmall f_base"></i>RSS</a></li>
					</ul>
				</div>

			</content>

			<content class="col-md-3 col-xs-12">
				<br>
				<br>
				<div class="alignL">

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

			</content>


		</div>
	</div>
</footer>

<!-- rights -->
<div id="rights">
	<?= str('rights')."&trade;".site_name. " - ".date("Y")?>
	<div style="float: left"><a class="f_blue" href =http://facebook.com/mis7amezooo>make by MIC </a></div>
</div>

<div id="scroll_up" class="arrow_cyr">
	<i class="fa fa-angle-up"></i>
</div>

</div><!--MIC_SITE-->

</body>
</html>
