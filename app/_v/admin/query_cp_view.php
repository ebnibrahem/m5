<?php use M5\Library\Page; ?>
<?php use M5\Library\Clean; ?>
<?php use M5\MVC\Controller as C; ?>

<div id="content">

	<div id="filter">
		<form action="<?= url('admin/query') ?>">
			<section class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input type="search" name="q" value="<?= clean::sqlInjection($_GET['q'])?>" placeholder="بحث بالاسم أو الرقم ">
					</div>

					<fieldset class="form-group">
						<select name="nat">
							<option value="0"><?= str('choose') ?>- الجنسية</option>
							<?php $root_flag = "nat"; $nat = C::branch($root_flag)?>
							<?php if ($nat): ?>						
								<?php foreach ( $nat  as $key => $branch ): ?>
									<?php $selected = ($_GET['nat'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</fieldset>

					<fieldset class="form-group">
						<select name="gender">
							<option value="0"><?= str('choose') ?> - الجنس</option>
							<?php $root_flag = "gender"; $gender = C::branch($root_flag)?>
							<?php if ($gender): ?>						
								<?php foreach ( $gender  as $key => $branch ): ?>
									<?php $selected = ($_GET['gender'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</fieldset>

				</div>

				<div class="col-md-4">
					<fieldset class="form-group">
						<select name="marred">
							<option value="0"><?= str('choose') ?> - الحالة الإجتماعية</option>
							<?php $root_flag = "marred"; $marred = C::branch($root_flag)?>
							<?php if ($marred): ?>						
								<?php foreach ( $marred  as $key => $branch ): ?>
									<?php $selected = ($_GET['marred'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>		
					</fieldset>

					<fieldset class="form-group">
						<select name="edu_level">
							<option value="0"><?= str('choose') ?> - المستوى التعليمي</option>
							<?php $root_flag = "edu_level"; $edu_level = C::branch($root_flag)?>
							<?php if ($edu_level): ?>						
								<?php foreach ( $edu_level  as $key => $branch ): ?>
									<?php $selected = ($_GET['edu_level'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>		
					</fieldset>

					<fieldset class="form-group">
						<select name="certify">
							<option value="0"><?= str('choose') ?> - الشهادة الحائز عليها</option>
							<?php $root_flag = "certify"; $certify = C::branch($root_flag)?>
							<?php if ($certify): ?>						
								<?php foreach ( $certify  as $key => $branch ): ?>
									<?php $selected = ($_GET['certify'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>	
					</fieldset>

				</div>

				<div class="col-md-4">

					<fieldset class="form-group">
						<select name="tribe">
							<option value="0"><?= str('choose') ?> - القبيلة</option>
							<?php $root_flag = "tribe"; $tribe = C::branch($root_flag)?>
							<?php if ($tribe): ?>						
								<?php foreach ( $tribe  as $key => $branch ): ?>
									<?php $selected = ($_GET['tribe'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>	
					</fieldset>

					<input type="submit" value="<?= str('filter')?>" name="searchBtn" class="btn btn-primary auto_margin">

				</div>
			</section>

		</form>

		<div class="hr"></div>
		<div class="hr"></div>
		<br>
	</div>


	<?php require view('query/table.php'); ?>

</div>