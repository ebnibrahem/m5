<div class="block b1 bb">
	<div class="line"> <b><?= (!$_GET['page']) ? ($key+1) : ( ($_GET['page']-1)*10) +$key ?></b></div>
	<div class="line">#<?= $blog['ID']?></div>
	<div class="line">
		<a href="<?= url('blogs/'.$blog['ID']) ?>">
			<?= $blog['name'] ?>
		</a>
	</div>
	<div class="line"><em><a href="<?= url('blogs/part/'.$blog['part_id']) ?>"><?= $blog['partName']?></a></em></div>
	<div class="line">
		<?= $blog['c_at'] ?>
	</div>
</div>