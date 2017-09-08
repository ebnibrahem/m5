<?php use M5\Library\Axe; ?>

<div class="categorey course optimize ">
	<a href="<?= url('categories/'.$categorey['ID'].Axe::url( $categorey['name'] ) ) ?>">

		<div class="top_">
			<?php $ava = get_uploads("upload/records/".$categorey['BETA'],'file')[0]; ?>

			<img data-src="<?= !$ava ? NO_IMG : $ava?>" alt="<?= $categorey['name']?>">
			<br>
		</div>

		<div class="bottom_">
			<h2 class="f_base">
				<b> <?= $categorey['name']?> </b>
			</h2>
			<div class=" f_base ">
				<?= $categorey['name']?>
			</div>
			<div>
				<span data-key="1"></span>
			</div>

		</div>
	</a>
</div>