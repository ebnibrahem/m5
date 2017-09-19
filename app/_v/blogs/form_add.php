<?php use M5\Library\Page; ?>
<?php use M5\Library\Session; ?>

<?php //pa(Session::get('new_record_post'))?>

<form action="<?=url($this->formAction."do/add")?>" method="post" enctype="multipart/form-data">

	<section class="row">
		<content class="col-md-4">
			<div class="form-group">
				<label for=""><?= string("title")?></label>
				<input type="text" name="name" value="<?= Session::get("new_record_post")['name'] ?>" autofocus>
			</div>
		</content>
		<content class="col-md-2">
			<div class="form-group p320">
				<label for=""><?= string("st")?></label>
				<select name="st">
					<option value="1" <?= $record['st'] == "1" ? 'selected' : '' ?> ><?= string('publish')?></option>
					<option value="0" <?= $record['st'] == "0" ? 'selected' : '' ?> ><?= string('draft')?></option>
				</select>
			</div>
		</content>
		<content class="col-md-3">
			<div class="form-group">
				<?php //pa($data['categories']) ?>
				<label for=""><?=s(['categories','home'])?></label>
				<div class="form-group">
					<select name="part_id" class="form-control select_pc" data-child_flag="add_child_here" data-fetch_flag="<?=$part_id?>">
						<option value=""><?= s(['choose'],"- ")?></option>
						<?php if ($data['categories']): ?>
							<?php foreach ($data['categories'] as $key => $categ): ?>
								<?php $selected = (Session::get("new_record_post")['part_id'] == $categ['ID']) ? 'selected' : '' ?>
								<option value="<?= $categ['ID'] ?>" <?= $selected?> > <?= $categ['name'] ?> </option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
					<a href="<?=url('admin/categories')?>" class="label label-info"><?=s(['categories','add_new'],"- ")?></a>
				</div>
			</div>
		</content>
		<content class="col-md-3">
			<label for="">&nbsp;</label>
			<div id="add_child_here">
				<select name="" id="" class="form-control">
					<option><?=s('choose')?></option>
				</select>
			</div>
		</content>

	</section>

	<div class="form-group">
		<label for=""><?= string("content")?></label>
		<textarea name="content" id="" cols="30" rows="10" class="textarea"><?= Session::get("new_record_post")['content']?></textarea>
	</div>

	<section class="row">
		<content class="col-md-4">
			<div class="form-group">
				<?php //pa($data['categories']) ?>
				<label for=""><i class="fa fa-file small f_gray2"></i> <?= str('images') ?></label>
				<input type="file" name="images[]"  class="form-control" multiple="multiple">
			</div>
		</content>

		<content class="col-md-4">
			<div class="form-group">
				<textarea name="tags" rows="6" placeholder="<?= string('tags')?> "><?= Session::get("new_record_post")['tags'] ?></textarea>
			</div>
		</content>
		<content class="col-md-4">
			<div class="form-group">
				<textarea name="notes" rows="6" placeholder="<?= string('description')?>"><?= Session::get("new_record_post")['notes'] ?></textarea>
			</div>
		</content>
	</section>


	<h5>
		<hr>
		<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("add")?></label>
		<input type="radio" name="page" id="page2" value="<?=url($this->formAction)?>" > <label class="hand" for="page2"><?= str("add")?> + <?= str("back")?></label><br />
	</h5>
	<div>
		<button type="submit" name="recordsbtnAdd" value="recordsbtnAdd" class="btn btn-primary"><?= string("add")?></button>
	</div>

</form>