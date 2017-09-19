
<div class="table-responsive">

	<table class="table table-bordered table-hover b_white center _12 _f2">
		<thead>
			<tr>
				<th class="center b_gray" >#</th>

				<th class="center b_gray" ><?= s('title')?></th>
				<th class="center b_gray" > <?= s('auther')?></th>
				<th class="center b_gray" colspan="2" > <?= s('part')?></th>
				<th class="center b_gray" > <?= s('tags')?></th>
				<th class="center b_gray" > <?= s('date')?></th>
				<th class="center b_gray" > <?= s('show')?></th>
				<th class="center b_gray" > <?= s('st')?></th>

				<th class="center b_gray" > <?= s('actions')?></th>
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

					<td> <a href="<?=url($this->formAction.$rcrd['ID'])?>"><?= $rcrd["name"];?></a></td>
					<td> <?= $rcrd["authorName"];?></td>

					<td> <?= $rcrd["partName"];?></td>
					<td> <?= $rcrd["childName"];?></td>

					<td> <?= $rcrd["tags"];?></td>
					<td> <?= $rcrd["c_at"];?></td>
					<td> <?= $rcrd["v"];?></td>
					<td> <?=  $data['drop_list']['st'][ $rcrd['st'] ] ?></td>
					<td>
						<a class="small label label-primary"  href="<?=url($this->formAction.$rcrd['ID'])?>"><?= s(['view','update'],', ')?></a>
						<a class="small label label-danger confirm"  href="<?=url($this->formAction.'delete/'.$rcrd['ID'])?>"><?= s('delete')?></a>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
