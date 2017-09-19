<?php use M5\Library\Session;?>

<div id="content">

	<div class="page">

		<table width="100%">
			<tr>
				<td width="50%">
					<div align="right">
						<a href="<?=url('admin/reports')?>"> <img src="<?= LOGO?>" alt="" width="150"></a> <br>
						<div><?=site_name?></div>
					</div>
				</td>
				<td width="50%">
					<div align="left">
						<div>التاريخ: <?= R_DATE?></div>
						<div> المسـتخدم: <?= Session::get("adminUser")?></div>
					</div>
				</td>
			</tr>

			<tr>
				<td colspan="2"><hr></td>
			</tr>
		</table>

		<h3 align="center"> تقرير : <?= !$this->report_title ? '<small>.....................</small>' : $this->report_title ?></h3><br>
		<?php  $records = $data["records"]  ?>

		<?php if ($records): ?>
			<table class="table table-bordered table-hover b_white center _12 _f2">
				<thead>
					<tr>
						<th class="center b_gray" >#</th>

						<th class="center b_gray" ><?= s('title')?></th>
						<th class="center b_gray" > <?= s('auther')?></th>
						<th class="center b_gray" colspan="2" > <?= s('part')?></th>
						<th class="center b_gray" > <?= s('tags')?></th>
						<th class="center b_gray" > <?= s('date')?></th>
						<th class="center b_gray" > <?= s('st')?></th>
					</tr>
				</thead>
				<?php  //pa( $records[0] )  ?>
				<tbody>
					<?php foreach ($records as $key => $rcrd): ?>
						<tr>
							<td>
								<?php if($_GET['page']) :?>
									<?= ( ($_GET['page'] - 1)*$meta['offset'])+$key+1 ?>
								<?php else:?>
									<?= ($key+1) ?>
								<?php endif;?>
							</td>

							<td> <?= $rcrd["name"];?></td>
							<td> <?= $rcrd["authorName"];?></td>

							<td> <?= $rcrd["partName"];?></td>
							<td> <?= $rcrd["childName"];?></td>

							<td> <?= $rcrd["tags"];?></td>
							<td> <?= $rcrd["c_at"];?></td>
							<td> <?=  $data['drop_list']['st'][ $rcrd['st'] ] ?></td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="alert alert-info" role="alert">
				<?= s('no_data')?>
			</div>
		<?php endif ?>

	</div>
</div>


<style>
	aside,header,footer,#bread{
		display: none;
	}
	.section{
		width: 100%;
		margin: auto;
	}

	* {
		box-sizing: border-box;
		-moz-box-sizing: border-box;
	}
	.page {
		width: 21cm;
		min-height: 29.7cm;
		padding: 2cm 1cm;
		margin: 1cm auto;
		border: 1px #D3D3D3 solid;
		border-radius: 5px;
		background: white;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	}
	.subpage {
		padding: 1cm;
		border: 5px red solid;
		height: 256mm;
		outline: 2cm #FFEAEA solid;
	}

	@page {
		size: A4;
		margin: 0;
	}
	@media print {
		.page {
			padding: 2cm 1cm;
			margin: 0;
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		}

		html, body {
			width: 210mm;
			height: 297mm;
		}
	}

</style>