<?php use M5\MVC\Config; ?>
<?php use M5\Library\Schema; ?>

<div id="content">

	<div class="alignL" dir="ltr">

		<h3><i class="fa fa-database"></i> Database: <?= Config::get("db_name")?>
			<a href="<?=url($this->fromAction.'do/add')?>" class="btn btn-success"><i class="fa fa-save"></i>  نسخة احتياطية </a>
		</h3>
		<hr>
		<h4><i class="fa fa-database"></i> Tables: </h4>

		<?php if ($data['tables']): ?>
			<ul class="inline-ul ">
				<?php foreach ($data['tables'] as $key => $tbl): ?>
					<li> <i class="fa fa-hashtag vsmall"></i> <?=$tbl?></li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
		<hr>
	</div>


	<br><br>
	<legend># Last backup</legend>
	<?php //pa($data['records']) ?>
	<table class="table table-bordered table-hover center _14">
		<thead>
			<tr>
				<th class="b_gray center _caps">#</th>
				<th class="b_gray center _caps">name</th>
				<th class="b_gray center _caps">size .Mb</th>
				<th class="b_gray center _caps">download</th>
				<th class="b_gray center _caps">Modified</th>
				<th class="b_gray center _caps">Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($data['records']): ?>
				<?php foreach ($data['records'] as $key => $value): ?>
					<tr>
						<td><?= $key+1?></td>
						<td><?= $value['name']?></td>
						<td><?= $value['size']?></td>
						<td><a href="<?= $value['url']?>" class="btn btn-primary _caps"><?=s('download')?></a></td>
						<td><?= date("Y-m-d H:i:s",$value['c_at'])?></td>
						<td>
							<a href="<?=url($this->fromAction.'details?file='.$value['name'])?>" class="btn btn-primary vsmall"><?=s('show')?></a>
							<a href="<?=url($this->fromAction.'delete?file='.$value['name'])?>" class="btn btn-danger vsmall confirm"><?=s('delete')?></a>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
	</table>
</div>