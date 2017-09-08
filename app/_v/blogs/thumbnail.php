<?php use M5\Library\Axe; ?>
<?php use M5\Library\Times; ?>
<?php use M5\MVC\Controller as C; ?>


<a href="<?= url('blogs/'.$blog['ID'].Axe::url( $blog['name'] ) ) ?>">
	<div class="optimize course">

		<div class="prz"><?= $blog['partName']?></div>
		<div class="top_">
			<?php $ava = get_uploads("upload/blogs/".$blog['BETA'],'file')[0]; ?>

			<img data-src="<?= !$ava ? NO_IMG : $ava?>" alt="<?= $blog['name']?>">
			<br>
		</div>

		<div class="bottom_">
			<h2 class="f_beta">
				<?= $blog['name']?>
			</h2>

			<h6 class=""> <?= $blog['authorName']?> |  <?= date_echo($blog['c_at'],'D, d - m - Y') ?></h6>

			<div>
				<a class="b_base f_white btn vsmall _capss" href="<?= url('blogs/'.$blog['ID'].Axe::url( $blog['name'] ))?>"><?= string('read_more')?></a>
				<span data-key="<?= $key+1?>"></span>
			</div>


		</div>

	</div>
</a>

<?php //pen::pa($beta); ?>
