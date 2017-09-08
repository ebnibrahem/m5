<?php use M5\Library\Page; ?>

<div id="content">
	<br>
	<br>

	<div class="ads-block  pd10" style="height: auto">
		<?php //pa( $this ); ?>
		<?php $record =$data["theRecord"]; ?>
		<?php //pa( $data["theRecord"] ); ?>

		<?php if (!$record): ?>
			<?php die() ?>
		<?php endif ?>


		<?php if ($data['theRecord']['slug'] == "contact-us"): ?>
			<!-- require view().'file'; ?>		call us form  -->

			<div class="defualt">
				<?php echo $data['theRecord']['content'] ?>
			</div>

		<?php else:?>

			<div class="defualt read_text">
				<?php echo $data['theRecord']['content'] ?>
			</div>

			<div class="ads-block pd10"  style="height: 90px">
				<!-- ####################[ share ads    ]###############################-->

				<div id="shareAds" class="alignL b80 auto_margin">
					<div class="">
						<ul class="sn">
							<li class="rounded share">
								<a target="_blank" class="fb"  href="https://www.facebook.com/sharer/sharer.php?u=<?=url().'pages/'.$record['slug']?>">
									<div class="fa fa-facebook"></div>
								</a>
							</li>

							<li class="rounded share">
								<a target="_blank" class="tw" href="https://twitter.com/intent/tweet?text=<?=url().'pages/'.$record['slug']?>">
									<div class="fa fa-twitter"></div>
								</a>
							</li>

							<li class="rounded share">
								<a target="_blank" class="gp" href="https://plus.google.com/share?url=<?=url().'pages/'.$record['slug']?>">
									<div class="fa fa-google-plus"></div>
								</a>
							</li>

							<li class="rounded share">
								<a href="whatsapp://send?text=<?=url().'blogs/'.$record['ID']?>" data-action="share/whatsapp/share">
									<div class="fa fa-whatsapp"></div>
								</a>
							</li>
						</ul>
					</div>
				</div><!-- share -->
			</div>


		<?php endif ?>

	</div>

</div>