<?php $this->categories = $data['categories'] ?>
<div id="land">
	<div class="land">

		<form action="<?= url('blogs') ?>" id="searchForm">
			<div class="searchForm">

				<div>
					<input type="search" name="q" id="q" placeholder="<?= string('the').string('search')?>.." value="<?= M5\Library\Clean::sqlInjection($_GET['q']) ?>">
					<i class="ic fa fa-search"></i>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<select name="part_id" class="form-control select_pc" data-fetch_flag="part_id" data-child_flag="part_id_flag">
							<option value=""><?= str('categories')." - ".str('all')?></option>
							<?php if ($this->categories ): ?>
								<?php foreach ($this->categories as $key => $part): ?>
									<?php $selected = ($_GET['part_id'] == $part['ID']) ? 'selected' : '' ?>
									<option value="<?= $part['ID'] ?>" <?= $selected?>><?= $part['name'] ?><?= $part['paerName'] ?></option>
								<?php endforeach ?>
							<?php endif ?>

						</select>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4">
						<select name="child_id" id="part_id_flag" class="form-control">
							<option value=""><?= str('choose')?></option>
						</select>
					</div>


					<div class="col-xs-12 col-sm-4 col-md-4">
						<button class="btn btn-primary auto_margin"><i class="fa fa-search"></i> <?= string('search')?></button>
					</div>
				</div>

			</div>
		</form>

	</div>
</div>
