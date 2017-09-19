<?php use M5\Library\Page; ?>
<?php use M5\Library\Clean; ?>

<div id="content">

	<section>
		<content class="col-md-6 col-sm-6">

			<legend>
				<h3> تقرير المدونة : </h3>
			</legend>

			<form action="<?= url($this->formAction)?>" >
				<div class="row">

					<div class="col-md-3">
						<select name="user_id" class="form-control" data-fetch_flag="user_id" data-child_flag="user_id_flag">
							<option value=""><?= str('authers')." - ".str('all')?></option>
							<?php if ($data['users'] ): ?>
								<?php foreach ($data['users'] as $key => $user): ?>
									<?php $selected = ($_GET['user_id'] == $user['ID']) ? 'selected' : '' ?>
									<option value="<?= $user['ID'] ?>" <?= $selected?> ><?= $user['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>

						</select>
					</div>

					<div class="col-md-3">
						<select name="part_id" class="form-control select_pc" data-fetch_flag="part_id" data-child_flag="part_id_flag">
							<option value=""><?= str('categories')." - ".str('all')?></option>
							<?php if ($data['categories'] ): ?>
								<?php foreach ($data['categories'] as $key => $part): ?>
									<?php $selected = ($_GET['part_id'] == $part['ID']) ? 'selected' : '' ?>
									<option value="<?= $part['ID'] ?>" <?= $selected?> > <?= $part['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>

						</select>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4">
						<select name="child_id" id="part_id_flag" class="form-control">
							<option value=""><?= str('choose')?></option>
						</select>
					</div>


					<input type="submit" value="<?= str('show')?>" name="searchBtn" class="btn btn-primary auto_margin">

				</div>
			</form>
		</content>
		<content class="col-md-6 col-sm-6">
		</content>
	</section>



</div>
