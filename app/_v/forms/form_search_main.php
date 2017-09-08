<?php $this->categories = $data['categories'] ?>
<form action="<?= !$form_action ? url('blogs') :!$form_action ?>" id="searchFormMain" class="pd10">

	<section class="row">
		<content class="col-md-3 col-xs-12">
			<input type="search" name="q" id="q" placeholder="<?= string('the').string('product')?>.." value="<?= M5\Library\Clean::sqlInjection($_GET['q']) ?>" class="form-control">
		</content>


		<content class="col-md-2 col-xs-12">
			<select name="part_id" class="form-control select_pc" data-fetch_flag="part_id" data-child_flag="part_id_flag_0">
				<option value="0"><?= str('categories')." - ".str('all') ?></option>
				<?php foreach ($this->categories as $key => $part): ?>
					<?php $selected = ($_GET['part_id'] == $part['ID']) ? 'selected' : '' ?>
					<option value="<?= $part['ID'] ?>" <?= $selected?>><?= $part['name'] ?><?= $part['paerName'] ?></option>
				<?php endforeach ?>
			</select>
		</content>

		<content class="col-md-2 col-xs-12">
			<select name="child_id" id="part_id_flag_0" class="form-control">
				<option value=""><?= str('sub')?></option>
			</select>
		</content>

		<content class="col-md-2 col-xs-12">
			<button class="btn btn-primary auto_margin"><i class="fa fa-search"></i> <?= string('search')?></button>
		</content>

	</section>

</form>