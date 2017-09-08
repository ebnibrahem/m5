<?php use M5\Library\Page; ?>
<?php use M5\MVC\Controller; ?>
<?php use M5\MVC\Controller as C; ?>

<script type="text/javascript" src="<?= assets() ?>/js/Chart.min.js" ></script>
<script type="text/javascript">

	$(document).ready(function($) {

		<?php foreach ($this->categories as $key => $part):?>

		var chartTribe= $("#chartTribe").get(0).getContext("2d");

		var data = {
			labels: [
			"فرع وزارة العمل والشؤون الإجتماعية",
			"الشؤون الزراعية",
			],
			datasets: [
			{
				label: "All",
				fillColor: "rgb(34,14,70)",
				strokeColor: "rgb(34,14,70)",
				pointColor: "rgb(34,140,7)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [
				"8",       
				"10",       
				"100",       
				]
			}
			]
		};

		var options = {
			showTooltips: false,
			onAnimationComplete: function () {

				var chartTribe = this.chart.ctx;
				chartTribe.font = this.scale.font;
				chartTribe.fillStyle = this.scale.textColor
				chartTribe.textAlign = "center";
				chartTribe.textBaseline = "bottom";

				this.datasets.forEach(function (dataset) {
					dataset.bars.forEach(function (bar) {
						chartTribe.fillText(bar.value, bar.x, bar.y - 5);
					});
				})
			}
		};

		var myLineChart = new Chart(chartTribe).Bar(data,options);

	<?php endforeach;?>

});
</script>

<div id="content">

	<div id="chart2_div">
		<div class="left"> 
			<legend >  السجلات - المجموع : </legend>

			<div class="row">
				<div class="col-md-6">
					<div class="pair">
						<div class="i"><?= str('records') ?></div>
						<div class="i">	<?= C::_sum('records',1,1)?>	</div>
					</div>					
				</div>
				<div class="col-md-6">
					<div class="pair">
						<div class="i"><?= str('records2') ?></div>
						<div class="i">	<?= C::_sum('records2',1,1)?>	</div>
					</div>					
				</div>
			</div>
			<div class="hr"></div>
		</div>
	</div>

	<?php //pa($this->categories) ?>


	<div>
		<?php $omitted_part = ["relevance"] ?> 
		<?php foreach ($this->categories as $k => $part):?>
			<?php $root_flag = $part['BETA']; $branchs = C::branch($root_flag)?>

			<?php if ( !in_array($root_flag, $omitted_part ) ): ?>

				<div class="mg10">
					<h3>  #<?= $part['name'] ?> </h3>
					<div class="hr b_blue" ></div>

					<?php foreach ($branchs as $kk => $branch):?>

						<?php if ($k == "0"): ?>
							<canvas id="chartTribe" width="800" height="340"></canvas>
							<div id="js-legend" class="chart-legend"></div>

						<?php else: ?>

							<div class="looh">
								<div class="looh_d _caps b_gray"><!-- data-->
									<div class="b_black" style="background:<?=$this->COLOR[$k+5]?>; height:<?=$hi.'px'?>;line-height:<?=$hi.'px'?>" >
										<?= C::_sum2([$root_flag => $branch['ID'] ],'records',0)?>
									</div>
								</div>

								<div class="looh_f"><!-- footer-->
									<?= $branch['name']?>
								</div>

							</div>
						<?php endif; ?>

					<?php endforeach ?>

				</div>

			<?php endif ?>

		<?php endforeach ?>

	</div>


</div>