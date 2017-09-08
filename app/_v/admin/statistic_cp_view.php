<?php use M5\Library\Page; ?>
<?php use M5\MVC\Controller; ?>
<?php use M5\MVC\Shared as C; ?>
<?php $this->categories = $data['categories'] ?>

<script type="text/javascript" src="<?= assets() ?>/js/Chart.min.js" ></script>


<div id="content">

	<div id="chart2_div">
		<div class="left">
			<legend > <?= str('records') ?>: </legend>

			<div class="row">
				<div class="col-md-6">
					<div class="pair">
						<div class="i"><?= str('blogs') ?></div>
						<div class="i">	<?= C::_sum('blogs',1,1)?>	</div>
					</div>
				</div>
				<div class="col-md-6">

				</div>
			</div>
			<div class="hr"></div>
		</div>
	</div>

	<?php //pa($this->categories) ?>


	<div>
		<?php $omitted_part = ["relevance"] ?>
		<?php foreach ($this->categories as $k => $part):?>
			<?php $root_flag = $part['ID']; $branchs = C::branch($root_flag,0)?>

			<?php //pa($branchs);  ?>
			<?php if ( !in_array($root_flag, $omitted_part ) ): ?>

				<div class="mg10" id="<?=$k?>">
					<h3>  #<?= $part['name'] ?> <im class="_12">	<?= C::_sum2(["part_id" => $part['ID'] ],'blogs',0) ?></im> </h3>
					<div class="hr b_blue" ></div>

					<canvas id="chart<?=$k?>" style="min-width: 100px;background: #f9f9f9" height="340"></canvas>
					<?php if ($branchs): ?>

						<?php foreach ($branchs as $kk => $branch):?>

							<script type="text/javascript">

								$(document).ready(function($) {

									var chart<?=$k?>= $("#chart<?=$k?>").get(0).getContext("2d");

									var data<?=$k?> = {
										labels: [
										<?php if($branch): ?>
										<?php foreach (C::branch($part['ID']) as $brnc):?>
										<?php echo '"'.$brnc['name'].'",' ?>
									<?php endforeach;?> <?php endif;?>
									],

									datasets: [
									{
										label: "All",
										fillColor: "<?=$data['drop_list']['COLOR'][$k]?>",
										strokeColor: "<?=$data['drop_list']['COLOR'][$k]?>",
										pointColor: "rgb(34,140,7)",
										pointStrokeColor: "#fff",
										pointHighlightFill: "#ff<?=$k?>",
										pointHighlightStroke: "rgba(151,187,205,1)",
										data: [
										<?php if(C::branch($part['ID'])): ?>
										<?php foreach (C::branch($part['ID']) as $brnc):?>
										<?php echo '"'.C::_sum2(["child_id" => $brnc['ID'] ],'blogs',0).'",' ?><?php endforeach;?><?php endif;?>
										]
									}
									]
								};

								var options = {
									showTooltips: false,
									onAnimationComplete: function () {

										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";

										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								};

								var myLineChart = new Chart(chart<?=$k?>).Bar(data<?=$k?>,options);

							});
						</script>

					<?php endforeach ?>
				<?php endif ?>

			</div>

		<?php endif ?>

	<?php endforeach ?>

</div>


</div>