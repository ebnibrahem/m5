<?php use M5\Library\Page; ?>
<?php use M5\Library\Clean; ?>
<?php use M5\MVC\Controller as C; ?>

<div id="content">
	<?php //pa( $data ); ?>
	<?php //pa( $this ); ?>
	<?php //pa( $data["records"] ); ?>


	<?php if (!$this->form): ?>

		<div id="filter">
			<form action="<?=url('admin/users')?>" >
				<div class="row">

					<div class="col-md-3">
						<div class="form-group">
							<input type="search" name="q" value="<?= clean::sqlInjection($_GET['q'])?>" placeholder="بحث.. ">
						</div>
					</div>

					<input type="submit" value="<?= str('search')?>" name="searchBtn" class="btn btn-primary auto_margin">

				</div>
			</form>
			<div class="hr"></div>
			<div class="hr"></div>
			<br>
		</div>
		<!--filter-->
	<?php endif ?>

	<div id="all">
		<?php if( $records = $data["records"] ):?>
			<?php //require view('forms/table.php') ; ?>
			<?php foreach($records as $key => $rcrd):?>

				<div class="block b1 bb">
					<div class="line">
						<a href="<?=url('admin/users/'.$rcrd['ID'])?>" class="_12">
							<strong> <i class="fa fa-user"></i><?=$rcrd['name']?></strong>
						</a>
					</div>
					<div class="line"><i class="fa fa-key"></i><?=$rcrd['user']?></div>
					<div class="line"><i class="fa fa-phone"></i><?=$rcrd['tel']?></div>
					<div class="line">

						<a href="<?=url('admin/users/'.$rcrd['ID'])?>" class="label label-success f_white"><?= string('show')?></a>
						<?php if ($rcrd['ID'] > 1): ?>
							<a href="<?=url('admin/users/delete/'.$rcrd['ID'])?>" class="label label-danger f_white confirm"><?= string('Delete')?></a>
						<?php endif ?>

					</div>
				</div>

			<?php endforeach;?>

		<?php endif;?>

		<?php if( !$data && !$this->form ):?>
			<div class="alert alert-info" role="alert">
				<?= string("no_data");?>
			</div>
		<?php endif;?>

	</div>

	<!-- #forms	 -->
	<!-- add form -->
	<?php if($this->form == "add"):?>
		<?php //require view('forms/add.php') ; ?>

		<form action="<?= url("admin/users/do/add") ?>" method="post">
			<div class="ib b40 mleft10 ">

				<div class="form-group">
					<input class="form-control" type="text" name="name" placeholder="<?=string('name')?>" />
				</div>

				<div class="form-group">
					<input class="form-control" type="text" name="user" placeholder="<?=string('user_name')?>" required />
				</div>

				<div class="form-group">
					<input class="form-control" type="password" name="pass" placeholder="<?=string('password')?>" required />
				</div>

				<fieldset class="form-group">
					<label> اسم الجهة  </label>
					<select name="place">
						<option value="0"><?= str('choose') ?></option>
						<?php $root_flag = "place"; $place = C::branch($root_flag)?>
						<?php if ($place): ?>
							<?php foreach ( $place  as $key => $branch ): ?>
								<option value="<?= $branch['ID'] ?>"><?= $branch['name'] ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</fieldset>

				<div class="form-group">
					<input class="form-control" type="text" name="tel" placeholder="<?=string('tel')?>" required />
				</div>

			</div>

			<div class="ib b50">
			</div>

			<h5>
				<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("add")?></label>
				<input type="radio" name="page" id="page2" value="<?=url()."admin/users"?>" > <label class="hand" for="page2"><?= str("add")?> + <?= str("back")?></label><br />
			</h5>`

			<input type="submit" name="usersBtnAdd" value="<?=string('add')?> " class="btn btn-primary _caps" />
		</form>


	<?php endif ?>

	<!-- update form -->
	<?php if($this->form == "update"):?>
		<?php if ($data["theRecord"]): ?>
			<?php //pa($data["theRecord"]) ?>
			<?php $record = $data["theRecord"] ?>

			<form action="<?= url("admin/users/".$record['ID']) ?>" method="post">
				<div class="ib b40 mleft10 ">

					<div class="form-group">
						<label for=""><?= string('Full_Name')?>  </label>
						<input class="form-control" type="text" name="name" value="<?=$record['name']?>" />
					</div>

					<div class="">
						<label for=""><?= string('Username')?></label>
						<input class="form-control" type="text" name="user" value="<?=$record['user']?>" />
					</div>

					<div class="">
						<label for=""><?= string('tel')?></label>
						<input class="form-control" type="text" name="tel" value="<?=$record['tel']?>" />
					</div>


					<div class="">
						<input type="checkbox" name="changePassFlag" id="" class="">
						<label for=""><?= string('Change_password')?> </label>
						<input class="form-control" type="password" name="pass" value="" />
					</div>

					<fieldset class="form-group">
						<label> اسم الجهة  </label>
						<select name="place">
							<option value="0"><?= str('choose') ?></option>
							<?php $root_flag = "place"; $place = C::branch($root_flag)?>
							<?php if ($place): ?>
								<?php foreach ( $place  as $key => $branch ): ?>
									<?php $selected = ($record['about'] == $branch['ID']) ? 'selected' : '' ?>
									<option value="<?= $branch['ID'] ?>" <?= $selected ?> ><?= $branch['name'] ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</fieldset>

				</div>

				<div class="ib b50">
				</div>


				<h5>
					<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("update")?></label>
					<input type="radio" name="page" id="page2" value="<?=url()."admin/users"?>" > <label class="hand" for="page2"><?= str("update")?> + <?= str("back")?></label><br />
				</h5>


				<button type="submit" name="usersBtnUp" value="usersBtnUp" class="btn btn-primary"><?=string('update')?></button>
				<a href="<?=url('admin/users/delete/'.$record['ID'])?>" class="btn btn-danger f_white confirm"><?=string('delete')?></a>

			</form>

		<?php endif ?>
	<?php endif ?>

	<!-- show form | printable -->
	<?php if($this->form == "show"):?>
		<?php $record = $data["theRecord"] ?>
		<?php require view('forms/show.php') ; ?>
	<?php endif ?>

</div>