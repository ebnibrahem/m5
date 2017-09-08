<?php// pa($record) ?>
<div id="details">

	<div class="optimize center mg10">
		<img src="<?=LOADING?>" data-src="<?= $record['ava'] ?>" alt="<?=$record['name']?>" width="320">
		<br>

		<?php if ($images = $record['images']): ?>
			<?php foreach ($images as $key => $img): ?>
				<div class="p100 mg10 ss">
					<img src=<?= LOADING ?>"  data-src="<?= $img ?>" alt="<?= $record['name'] ?>" class="viewPhoto" />
				</div>
			<?php endforeach ?>
		<?php endif?>
	</div>

	<h2 class="pd10"><?= $record['name']?></h2>
	<h5 class="alignR _16"> <i class="fa fa-pencil"></i> <?= $record['authorName'] ?> ــ <i class="fa fa-clock-o"></i>  <?= date_echo($record['c_at'],'D, d - m - Y') ?></h5>
	<br>

	<div class=" read_text"><?= $record['content']?></div>
	<?php //pa($record) ?>

	<br><br>
	<div class="ads-block pd10"  style="height: 90px">
		<!-- ####################[ share ads    ]###############################-->

		<div id="shareAds" class="alignL b80 auto_margin">

			<ul class="sn">
				<li class="rounded share">
					<a target="_blank" class="fb"  href="https://www.facebook.com/sharer/sharer.php?u=<?=url().'blogs/'.$record['ID']?>">
						<div class="fa fa-facebook"></div>
					</a>
				</li>

				<li class="rounded share">
					<a target="_blank" class="tw" href="https://twitter.com/intent/tweet?text=<?=url().'blogs/'.$record['ID']?>">
						<div class="fa fa-twitter"></div>
					</a>
				</li>

				<li class="rounded share">
					<a target="_blank" class="gp" href="https://plus.google.com/share?url=<?=url().'blogs/'.$record['ID']?>">
						<div class="fa fa-google-plus"></div>
					</a>
				</li>

				<li class="rounded share">
					<a href="whatsapp://send?text=<?=url().'blogs/'.$record['ID']?>" data-action="share/whatsapp/share">
						<div class="fa fa-whatsapp"></div>
					</a>
				</li>
			</ul>
		</div><!-- share -->

	</div>
</div>


<style type="text/css">
	#land{height:230px;background:url(<?= $record['ava'] ?>);background-size: auto;background-position: center;background-repeat: no-repeat;}
	.land{background-color: rgba(0,0,0,0.5)!important;}
</style>
