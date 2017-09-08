<?php use M5\Library\Times; ?>


<div id="content">
	<?php $records = $data['records'];?>

	<?php  //pa($records)?>

	<?php if($records):?>
		<form action="<?= '' ?>" method="post">
			<div class="alignL">
				<i class="fa fa-check mark hand b_blue f_white" data-toggle="tooltip" data-placement="top" title="<?= string('select_all')?>" ></i>
				<button name="notiBtnDel" value="notiBtnDel" class="btn btn-danger vsmall"><i class="fa fa-remove"></i>حذف متعدد</button>
			</div>
			<hr>
			<?php foreach ($records as $k => $r): extract($r) ?>
				<div class="sun" style="background:<?=$st=="1"? '#ecedef' : ''?>" >
					<div class="">
						<i class="fa fa-bell small f_base"></i>
						<a href="<?=$url?>"><?=$notifications?></a>
					</div>
					<div class="">
						<?=Times::after($c_at)?>
					</div>
					<span class="label label-default">	<?= $st == "2" ? 'مقروءة'  : ''  ?></span>
					<a href="<?= url('admin/notifications/delete/'.$id)?>">
						<span class="label label-danger"><i class="fa fa-trash f_white"></i></span>
					</a>
					<span><input class="multy" type="checkbox" name="ID[]" value="<?=$id?>" ></span>
				</div>
			<?php endforeach ?>
		</form>

	<?php else:?>
		<div class="alert alert-info center">لاتوجد اشعارات </div>
	<?php endif?>

</div>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>