<?php use M5\Library\page; ?>
<?php use M5\Library\Lens; ?>
<?php use M5\Library\Clean; ?>

<div id="content">

	<div>
		<?php 
		$maxUpload      = (int)(ini_get('upload_max_filesize'));
		define("MAX_UPLOAD",$maxUpload);
		$maxPost        = (int)(ini_get('post_max_size'));
		define("MAX_POST",$maxPost);

		echo msg(" maxUpload : ". MAX_UPLOAD." MB | maxPost : ". MAX_POST." MB","alert alert-info",'left','rtl');
		?>
	</div>
	
	<div class="p320 auto_margin">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for=""><?= string('upload_multi')?> : </label>
				<input type="file" name="files[]" id="files" multiple >
			</div>

			<div class="form-group">

				<?php if($_GET['sub_folder']):?>
					<div>
						<input type="checkbox" name="wmFlag" id="wmFlag" checked>
						<label for="wmFlag" class="" data-toggle="tooltip" title="<?= string('Put_Watermark')?>">
							<?= string('Watermark')?> 
						</label>
					</div>

					<input type="checkbox" checked disabled>
					<input type="hidden" name="folderFlag" id="folderFlag"  value="on">
					<label for="folderFlag">Put this files in current Folder</label>
					<div id="foldercontent">
						<input type="text" name="folder" placeholder="folder name"  value="<?= clean::sqlInjection($_GET['sub_folder'])?>" readonly>
					</div>
				<?php else:?>
					<div>
						<input type="checkbox" name="wmFlag" id="wmFlag">
						<label for="wmFlag" class="" data-toggle="tooltip" title="<?= string('Put_Watermark')?>">
							<?= string('Watermark')?> 
						</label>

					</div>

					<input type="checkbox" name="folderFlag" id="folderFlag">
					<label for="folderFlag"><?= string('surround_with_folder')?></label>
					<div id="foldercontent" style="display: none;">
						<input type="text" name="folder" placeholder="<?= string('folder_name')?>">
						<div class="vsmall">dont use dot (.) in folder name </div>
					</div>
					<script type="text/javascript">
						$("[name = folderFlag]").click(function(event) {
							$("#foldercontent").toggle();
							$("[name = folder]").focus();
						});
					</script>
				<?php endif;?>
			</div>

			<div class="form-group">
				<button class="btn btn-primary" name="filesBtn" value="filesBtn"><?= string('upload')?></button>
			</div>

			<input type="hidden" name="page" value="<?= page::url()?>">
		</form>
		<hr>    
	</div>
	<br>

	<?php //pa($data['files']) ?>
	<?php if ($data['files']['files']): ?>

		<?php foreach ($data['files']['files'] as $c => $file): ?>
			<div class="book optimize">
				
				<?php if(lens::type($file['type']) == "folder"):?>
					<a class="book" href="<?= url('admin/files?sub_folder=').end( explode("/", $file['path']) ) ?>">
						<i style="font-size: 120px;color:#e8e166" class="fa fa-folder"></i><br/>
						<h4><?= end(explode("/", $file['path']) )?></h4>
					</a>

				<?php else :?>

					<div class="cover">
						<img data-src="<?= $file['path'] ?>" alt="" class="viewPhoto">
					</div>
					<div class="ftr center">
						<?php $filepath = !$_GET['sub_folder'] ? basename($file['path']) : clean::sqlInjection($_GET['sub_folder'])."/".basename($file['path']) ?>
						<im class="b_red  confirm"><a class="f_white" href="<?=url('admin/').'files/delete?file='.$filepath ?>"> <i class="fa fa-remove"></i> </a></im>

						<br /><input type="text" value="<?=$file['path']?>" class="selectAll">
						<im class=""><?=lens::type($file['type'])?> </im>
						<?= $file['size'] ?>MB      
					</div>

				<?php endif;?>

			</div>
		<?php endforeach ?>

	<?php else: ?>
		<div class="alert alert-info" role="alert">
			this folder is empty!
		</div>
	<?php endif ?>

</div>
