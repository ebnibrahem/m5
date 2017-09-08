<?php use M5\Library\Page; ?>
<?php  //pa($record) ?>

<form action="<?=url($this->formAction.$record["ID"])?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="part_id">

	<section class="row">
		<content class="col-md-4">
			<div class="form-group">
				<label for=""><?= string("title")?></label>
				<input type="text" name="name" value="<?= $record['name'] ?>" autofocus>
			</div>
		</content>
		<content class="col-md-4">
			<div class="form-group p320">
				<label for=""><?= string("st")?></label>
				<select name="st">
					<option value="0" <?= $record['st'] == "0" ? 'selected' : '' ?> ><?= string('draft')?></option>
					<option value="1" <?= $record['st'] == "1" ? 'selected' : '' ?> ><?= string('publish')?></option>
				</select>
			</div>
		</content>
		<content class="col-md-4">

			<div class="form-group">
				<label for=""><?= string("categories")?></label>
				<select name="part_id" class="form-control" >
					<option value=""><?= s(['categories','choose'],"- ")?></option>
					<?php if ($data['categories']): ?>
						<?php foreach ($data['categories'] as $key => $categ): ?>
							<?php $selected = ($record['part_id'] == $categ['ID']) ? 'selected' : '' ?>
							<option value="<?= $categ['ID'] ?>" <?= $selected?> > <?= $categ['name'] ?> </option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
				<a href="<?=url('admin/categories')?>" class="label label-info"><?=s(['categories','add_new'],"- ")?></a>
			</div>

		</content>
	</section>

	<div class="form-group">
		<label for=""><?= string("content")?></label>
		<textarea name="content" id="" cols="30" rows="10" class="textarea"><?= $record['content']?></textarea>
	</div>

	<section class="row">
		<content class="col-md-6">
			<div class="form-group">
				<textarea name="tags" rows="6" placeholder="<?= string('tags')?> "><?= $record['tags'] ?></textarea>
			</div>
			<div class="form-group">
				<textarea name="notes" rows="6" placeholder="<?= string('description')?>"><?= $record['notes'] ?></textarea>
			</div>

		</content>
		<content class="col-md-6">
			<?php $images = $record['images'] ?>

			<div class="optimize">

				<?php  $images = ($record['images']); ?>
				<?php if ($images): ?>
					<?php foreach ($images as $key => $img): ?>
						<div class="p100 mg10 ss">
							<img src="<?=LOADING?>" data-src="<?= $img ?>" alt="<?= $ads['name'] ?>" class="viewPhoto" />


							<button type="button" id="del_img"  data-folder="blogs" data-del="<?='upload/blogs/'.$record['BETA'].'/'.basename($img)?>" class="del_img btn vsmall b_red f_white confirm _caps"><?= string('delete')?></button>
						</div>
					<?php endforeach ?>
				<?php endif ?>
				<div class="form-group">
					<label for=""><i class="fa fa-photo small f_gray2"></i>  اضف المزيد </label>
					<input type="file" name="images[]"  class="form-control" multiple="multiple">
				</div>

			</div>

		</content>
	</section>


	<h5>
		<hr>
		<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("update")?></label>
		<input type="radio" name="page" id="page2" value="<?= $this->formAction?>" > <label class="hand" for="page2"><?= str("update")?> + <?= str("back")?></label><br />
	</h5>
	<div>
		<button type="submit" name="recordsbtnUp" value="recordsbtnUp" class="btn btn-primary"><?= string("update")?></button>
	</div>

</form>