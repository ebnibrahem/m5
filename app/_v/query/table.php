<?php use M5\Library\Page; ?>
<?php use M5\Library\Clean; ?>
<?php use M5\MVC\Controller as C; ?>


<table class="table table-bordered table-hover b_white center _12 _f2">
	<thead>
		<tr>
			<th class="center b_gray" >#</th>
			
			<th class="center b_gray" > رقم الحصر</th>
			<th class="center b_gray" > رقم الدوسية</th>
			<th class="center b_gray" > اسم رب الاسرة </th>
			<th class="center b_gray" > القبيلة </th>
			<th class="center b_gray" > الجنس </th>
			<th class="center b_gray" > رقم الجوال </th>

			<th colspan="2" class="center b_gray"><?= string("actions")?></th>
		</tr>
	</thead>
	<?php  $records = $data["records"]  ?>
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

				<td><?= $rcrd["block_ID"];?></td>
				<td><?= $rcrd["BETA"];?></td>
				<td><a href="<?= url("admin/records/".$rcrd["ID"])?>"><?= $rcrd["raadbname"]?></a></td>
				<td> <?= C::typeName('tree', 'ID',$rcrd['tribe'])?> </td>
				<td> <?= C::typeName('tree', 'ID',$rcrd['gender'])?> </td>
				<td> <?= $rcrd['mobile'] ?> </td>  

				<td class="center" >
					<a class="btn btn-success vsmall" href="<?= url("admin/records/do/show/".$rcrd["ID"])?>"> <?= string("show")?> </a> 
				</td>


			</tr>
		<?php endforeach;?>
	</tbody>
</table>