<?php use M5\Library\Axe; ?>
<?php use M5\Library\Times; ?>
<?php use M5\MVC\Controller as C; ?>


<a href="<?= url('blogs/'.$blog['ID'].Axe::url( $blog['name'] ) ) ?>">
	<div class="optimize course">
		<div class="sh_t"></div>
		<div class="wrap">

			<div class="prz">
				<a class="f_white" href="<?= url('blogs/part/'.$blog['part_id'])?>"><?= $blog['partName']?></a>
				<?= ($blog['childName']) ? "- ".$blog['childName'] : "" ?>
			</div>

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

				<a class="course_read" href="<?= url('blogs/'.$blog['ID'].Axe::url( $blog['name'] ))?>"><?= string('read_more')?></a>
			</div>
		</div>
		<div class="sh_b"></div>
	</div>
</a>

<?php //pen::pa($beta); ?>
