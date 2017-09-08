<?php use M5\Library\Pen; ?>

<script src="<?= assets('js/jquery-2.2.0.min.js') ?>"></script>
<script src="<?= assets('js/js3.js') ?>"></script>

<div class="flag">
	<a class="btn btn-primary f_white" target="_blank" href="<?= url('admin/files')?>"> <?= string('upload')?> </a>
</div>
<br />
<?php  console(["ajax_view",$this->media]) ?>
<?php if($this->media): ?>

	<div id="main_wrapper">
		<?php foreach ($this->media as $key => $val): ?>
			<?php if ($val['type'] == "folder"): ?>
				<a class="sub_folder book" data-href="<?= end( explode("/", $val['path']) ) ?>">
					<i style="font-size: 120px;color:#e8e166; cursor: pointer;" class="fa fa-folder"></i><br/>
					<h4><?= end(explode("/", $val['path']) )?></h4>
				</a>
			<?php else: ?>
				<div class="book topicAva">
					<img src="<?=$val['path']?>" alt="" />
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>

	<div id="sub_wrapper" class="hide">
		<div class="btn btn-primary" id="ajax_back">
			<?= string('back'); ?>
		</div>
		<hr>
		<span></span>
	</div>


<?php else: ?>
	<?=pen::msg('Oops! No Media found!');?>
<?php endif;?>
