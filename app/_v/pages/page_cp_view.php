<?php use M5\Library\Page?>
<div id="content">
	<?php //pa( $this ); ?>
	<?php //pa( $data["records"] ); ?>
	<?php if( $data["records"] ):?>
		<table class="table table-bordered table-hover b_white center">
			<thead>
				<tr>
					<th class="center">#</th>
					<th class="center"><?= str('name') ?></th>
					<th class="center"><?= str('show') ?></th>
					<th   colspan="2" class="center"><?= string("actions")?></th>
				</tr>
			</thead>
			<?php  $records = $data["records"]  ?>
			<tbody>
				<?php foreach ($records as $key => $rcrd): ?>
					<tr>
						<td><?= $key+1?></td>
						<td><?= $rcrd["name"]?></td>
						<td><?= $rcrd["v"]?></td>
						<td class="center">
							<a class="btn btn-success vsmall" href="<?= url("p/".$rcrd["slug"])?>" target="_blank"><?= string("view")?></a>
							<a class="btn btn-primary vsmall" href="<?= url("admin/pages/".$rcrd["ID"])?>"><?= string("update")?></a> 
							<a class="btn btn-danger vsmall confirm" href="<?= url("admin/pages/delete/".$rcrd["ID"])?>"><?= string("delete")?></a>
						</td>

					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php elseif( !$data && !$this->form ):?>
		<div class="alert alert-info" role="alert">
			<?= string("no_data");?>
		</div>
	<?php endif;?>


	<!-- #forms	 -->
	<!-- add -->
	<?php if($this->form == "add"):?>
		<form action="" method="post">
			<div class="form-group">
				<label for=""><?= string("name")?></label>
				<input type="text" name="" >
			</div>
			<div class="form-group">
				<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("add")?></label>
				<input type="radio" name="page" id="page2" value="<?=url()."admin/pages"?>" > <label class="hand" for="page2"><?= str("add")?> + <?= str("back")?></label><br />
			</div>
			<div>
				<button type="submit" name="pagesbtnAdd" value="pagesbtnAdd" class="btn btn-primary"><?= string("add")?></button>
			</div>
		</form>
	<?php endif ?>

	<!-- update form -->
	<?php if($this->form == "update"):?>
		<?php if ($data["theRecord"]): ?>
			<?php //pa($data["theRecord"]) ?>
			<?php $record = $data["theRecord"] ?>
			<form action="<?= url("admin/pages/".$record["ID"]) ?>" method="post">
				<div class="form-group">
					<label for=""><?= string("name")?></label>
					<input type="text" name="name" value="<?= $record["name"]?>" >
				</div>

				<div class="form-group">
					<label for=""><?= string("link")?></label>	
					<input type="text" name="slug" value="<?= $record["slug"]?>" readonly >
				</div>

				<div class="form-group">
					<label for=""><?= string("content")?></label>
					<textarea name="content" id="" cols="30" rows="10"><?= $record["slug"]?></textarea>
				</div>

				<h5>	
					<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  
					<label class="hand" for="page1"><?= str("update")?></label>
					<input type="radio" name="page" id="page2" value="<?=url()."admin/pages"?>" >
					<label class="hand" for="page2"><?= str("update")?> + <?= str("back")?></label>
				</h5>

				<div>
					<button type="submit" name="pagesbtnUp" value="pagesbtnAdd" class="btn btn-primary"><?= string("update")?></button>
				</div>
			<?php endif ?>
		</form>

	<?php endif ?>

	<!-- show -->
	<?php if($this->form == "show"):?>
	<?php endif ?>
</div>