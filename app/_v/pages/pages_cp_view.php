<?php use M5\Library\Page; ?>
<?php use M5\Library\Session; ?>

<div id="content">
	<?php //pa( $this ); ?>
	<?php //pa( $data["records"] ); ?>
	<div id="all">
		<?php if( $data["records"] ):?>
			<table class="table table-bordered table-hover b_white center">
				<thead>
					<tr>
						<th class="center b_gray" >#</th>
						<th class="center b_gray" ><?= str("name")?></th>
						<th colspan="2" class="center b_gray"><?= string("actions")?></th>
					</tr>
				</thead>
				<?php  $records = $data["records"]  ?>
				<tbody>
					<?php foreach ($records as $key => $rcrd): ?>
						<tr>
							<td><?= $key+1?></td>
							<td><a href="<?= url("admin/pages/".$rcrd["ID"])?>"><?= $rcrd["name"]?></a></td>
							<td class="center" >
								<a class="label label-primary vsmall" href="<?= url("pages/".$rcrd["slug"])?>" target="_blank" > <?= string("view")?> </a>
								<a class="label label-primary vsmall" href="<?= url("admin/pages/".$rcrd["ID"])?>"> <?= string("update")?> </a>
								<a class="label label-danger vsmall confirm" href="<?= url("admin/pages/delete/".$rcrd["ID"])?>"> <?= string("delete")?> </a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		<?php endif;?>

	</div>

	<?php if( !$data["theRecord"] && !$this->form && !$data['records'] ):?>
		<div class="alert alert-info" role="alert">
			<i class="fa fa-info-circle"></i> <?= string("no_data");?>
		</div>
	<?php endif;?>


	<!-- #forms	 -->
	<!-- add form -->
	<?php if($this->form == "add"):?>
		<form action="<?=url("admin/pages/do/add")?>" method="post">

			<section class="row">
				<content class="col-md-4">
					<div class="form-group">
						<label for=""><?= string("title")?></label>
						<input type="text" name="name" autofocus>
					</div>
				</content>
				<content class="col-md-4">

					<div class="form-group">
						<label for=""><?= str("the").string("link")?></label>
						<input type="text" name="slug">
					</div>

				</content>
				<content class="col-md-4">
					<div class="form-group">
						<label for=""><?= string("type")?></label>
						<select name="st" >
							<option value="1"><?= str('publish')?></option>
							<option value="2"><?= str('draft')?></option>
							<option value="3"><?= str('internal')?></option>
						</select>
					</div>

				</content>
			</section>

			<div class="form-group">
				<label for=""><?= string("content")?></label>
				<textarea name="content" id="" cols="30" rows="10" class="textarea"></textarea>
			</div>

			<section class="row">
				<content class="col-md-6">
					<div class="form-group">
						<textarea name="tags" rows="6" placeholder="<?= string('tags')?> "><?= Session::get("new_record_post")['tags'] ?></textarea>
					</div>
				</content>
			</section>

			<h5>
				<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("add")?></label>
				<input type="radio" name="page" id="page2" value="<?=url()."admin/pages"?>" > <label class="hand" for="page2"><?= str("add")?> + <?= str("back")?></label><br />
			</h5>
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
				<section class="row">
					<content class="col-md-4">
						<div class="form-group">
							<label for=""><?= string("title")?></label>
							<input type="text" name="name"  value="<?= $record['name']?>">
						</div>
					</content>
					<content class="col-md-4">

						<div class="form-group">
							<label for=""><?= str("the").string("link")?></label>
							<input type="text" name="slug" value="<?= $record['slug']?>">
						</div>

					</content>
					<content class="col-md-4">
						<div class="form-group">
							<label for=""><?= string("type")?></label>
							<select name="st" >
								<option value="1"  <?= $record['st'] == "1" ? "selected" : "" ?>  ><?= str('publish')?></option>
								<option value="2"  <?= $record['st'] == "2" ? "selected" : "" ?>  ><?= str('draft')?></option>
								<option value="3"  <?= $record['st'] == "3" ? "selected" : "" ?>  ><?= str('internal')?></option>
							</select>
						</div>

					</content>
				</section>

				<div class="form-group">
					<label for=""><?= string("content")?></label>
					<textarea name="content" id="" cols="30" rows="10" class="textarea"><?= $record["content"]?></textarea>
				</div>

				<section class="row">
					<content class="col-md-6">
						<div class="form-group">
							<textarea name="tags" rows="6" placeholder="<?= string('tags')?> "><?= $record['tags'] ?></textarea>
						</div>
					</content>
				</section>

				<h5>
					<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("update")?></label>
					<input type="radio" name="page" id="page2" value="<?=url()."admin/pages"?>" > <label class="hand" for="page2"><?= str("update")?> + <?= str("back")?></label><br />
				</h5>

				<div>
					<button type="submit" name="pagesbtnUp" value="pagesbtnAdd" class="btn btn-primary"><?= string("update")?></button>
				</div>
			<?php endif ?>
		</form>

	<?php endif ?>

	<!-- show form | printable -->
	<?php if($this->form == "show"):?>
	<?php endif ?>
</div>