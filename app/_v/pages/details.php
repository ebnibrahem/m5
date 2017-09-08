<?php use M5\Library\Axe; ?>

<div id="details" class="center">
	<?php $record = !$record ? $data : $record?>

	<h2 class="f_red"><?= $record['name']  ?></h2>
	<br>

	<div class="_20"><?= $record['content']?></div>

	<br><br>
	<b>عدد المشاهدات : <?= $record['v'] ?></b>
	<br>
	<hr>
	<div>
		<h3 class="f_gray2">
			<a href="
			<?= url('p/'.$record['slug']); ?>
			">
			<?= url('p/'.$record['slug']); ?>
		</a>
	</h3>
	<br>
</div>
<div style="width:320px; margin:auto">

	<div class="center auto_margin">
		<a href="whatsapp://send?text=<?=url().'p/'.$record['slug'] ?>" data-action="share/whatsapp/share">
			<div class="pair " >
				<span class="i b_green" style="border:1px solid #999">انشر في واتساب </span>
				<span class="i b_white f_green" style="border:1px solid #999"><div class="fa fa-whatsapp"></div></span>
			</div>
		</a>
		<br>

		<a target="_blank" class="tw" href="https://twitter.com/intent/tweet?text=<?=url().'p/'.$record['slug']."-\n".$record['name']?>">
			<div class="pair">
				<span class="i b_blue2" style="border:1px solid #999">انشر في تويتر </span>
				<span class="i b_white f_blue2" style="border:1px solid #999"> <div class="fa fa-twitter"></div> </span>
			</div>
		</a>
		<br>

		<a target="_blank" class="tw" href="https://www.facebook.com/sharer/sharer.php?u=<?=url().'p/'.$record['slug'] ?>">
			<div class="pair">
				<span class="i b_blue" style="border:1px solid #999">انشر في فيسبوك </span>
				<span class="i b_white f_blue" style="border:1px solid #999"> <div class="fa fa-facebook"></div> </span>
			</div>
		</a>

	</div>

</div>

</div>
