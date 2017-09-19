<?php foreach($records as $key => $record):?>
	<?php $image = get_uploads("upload/blogs/".$record['BETA'],'file')[0]; ?>

	<div class="block b1">
		<a class=""  href="<?= url( $this->formAction.$record['ID'])?>">
			<img src="<?=!$image ? NO_IMG : $image?>" alt="<?=$record['name']?>" height="100">
			<h4><?=$record['name']?></h4>
		</a>

		<div class="line"><i class="fa fa-share-alt"></i><?=$record['partName']?>
			<?= !$record['childName'] ? '':  '<i class="fa fa-minus"></i>'.$record['childName']; ?>
		</div>

		<div class="line"><i class="fa fa-user-o"></i><?=$record['authorName']?></div>

		<div class="line"><?=$record['v']?> <i class="fa fa-eye"></i></div>

		<div class="line"> <?=  $data['drop_list']['st'][ $record['st'] ] ?></div>

		<div class="line"><?=$record['c_at']?></div>

		<div class="ftr">
			<a class="confirm"  href="<?=url($this->formAction.'delete/'.$record['ID'])?>">
				<i class="fa fa-trash"></i>
			</a>
		</div>
	</div>
<?php endforeach;?>