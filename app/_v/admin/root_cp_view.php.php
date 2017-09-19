<?php use M5\Library\Page?>
<?php $this->services = $data['drop_list']['poremission'] ?>


<div id="content">

	<?php //pa( $this ); ?>
	<?php //pa( $data["records"] ); ?>
	<div id="all">
		<?php if( $data["records"] ):?>

			<?php  $records = $data["records"]  ?>

			<?php foreach ($records as $key => $rcrd): ?>
				<div class="block b1 bb pd10">
					<div class="line">
						<a href="<?=url('admin/root/'.$rcrd['ID'])?>" class="_12">
							<strong> <i class="fa fa-user"></i><?=$rcrd['name']?></strong>
						</a>
					</div>
					<div class="line"><i class="fa fa-key"></i><?=$rcrd['user']?></div>
					<div class="line"><i class="fa fa-at"></i><?=$rcrd['email']?></div>
					<div class="line">

						<a href="<?=url('admin/root/'.$rcrd['ID'])?>" class="label label-success f_white"><?= string('show')?></a>
						<?php if ($rcrd['ID'] > 1): ?>
							<a href="<?=url('admin/root/delete/'.$id)?>" class="label label-danger f_white confirm"><?= string('Delete')?></a>
						<?php endif ?>

					</div>
				</div>
			<?php endforeach;?>

		<?php elseif( !$data && !$this->form ):?>
			<div class="alert alert-info" role="alert">
				<?= string("no_data");?>
			</div>
		<?php endif;?>
	</div>


	<!-- #forms	 -->
	<!-- add form -->
	<?php if($this->form == "add"):?>
		<form action="<?= url("admin/root/do/add") ?>" method="post">
			<div class="ib b40 mleft10 ">

				<div class="form-group">
					<input class="form-control" type="text" name="name" placeholder="<?=string('name')?>" />
				</div>

				<div class="form-group">
					<input class="form-control" type="text" name="user" placeholder="<?=string('user_name')?>" required />
				</div>

				<div class="form-group">
					<input class="form-control" type="email" name="email" placeholder="<?=string('email')?>" required />
				</div>

				<div class="form-group">
					<input class="form-control" type="password" name="pass" placeholder="<?=string('password')?>" required />
				</div>

				<div class="form-group">
					<span><?= string('description')?></span>
					<textarea name="about" id="" cols="30" rows="6"></textarea>
				</div>
			</div>

			<div class="ib b50">

				<!-- <div class="form-group _caps">
					<label for="" class="label label-primary"><?= string('ava')?> :</label><br />
					<img src="<?= LOGO ?>" width="100" class="chooseFile hint" data-hint="<?=$GLOBALS['ava']?>" >
					<input type="text" name="ava" class="avatar" value="<?= LOGO ?>" >
				</div> -->

				<?php if($id != "1"):?>
					<div>
						<label class="btn btn-primary"> <i class="fa fa-lock"></i> <?=string('access_range')?> : </label>
					</div>
					<br>

					<?php foreach ($this->services as $k=> $s): ?>
						<div>
							<input type="checkbox" name="roles[]" id="role<?=$k?>" value="<?=$k?>">
							<label for="role<?=$k?>"><?=$s?></label>
						</div>
					<?php endforeach ?>

				<?php endif;?>
			</div>

			<h5>
				<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("add")?></label>
				<input type="radio" name="page" id="page2" value="<?=url()."admin/root"?>" > <label class="hand" for="page2"><?= str("add")?> + <?= str("back")?></label><br />
			</h5>`


			<input type="submit" name="rootBtnAdd" value="<?=string('add')?> " class="btn btn-primary _caps" />
		</form>

	<?php endif ?>

	<!-- update form -->
	<?php if($this->form == "update"):?>
		<?php if ($data["theRecord"]): ?>
			<?php //pa($data["theRecord"]) ?>
			<?php $record = $data["theRecord"] ?>
			<form action="<?= url("admin/root/".$record["ID"]) ?>" method="post">
				<div class="ib b40 mleft10">


					<div class="form-group">
						<label for=""><?= string('Full_Name')?>  </label>
						<input class="form-control" type="text" name="name" value="<?=$record['name']?>" />
					</div>

					<div class="">
						<label for=""><?= string('Username')?></label>
						<input class="form-control" type="text" name="user" value="<?=$record['user']?>" />
					</div>

					<div class="">
						<label for=""><?= string('Email')?></label>
						<input class="form-control" type="email" name="email" value="<?=$record['email']?>" />
					</div>

					<div class="form-group">
						<span><?= string('description')?></span>
						<textarea name="about" id="" cols="30" rows="6"><?= stripslashes( $record['about'])?></textarea>
					</div>

					<div>
						<div>
							<label class="btn btn-success" title="this user can do "> <i class="fa fa-lock"></i> <?=string('access_range')?> : </label>
						</div><br>
						<?php //pa($record ['userRoles']) ?>

						<?php if($record ['userRoles']):?>
							<?php foreach ($record ['userRoles'] as $k=> $ss): ?>

								<?php $s_name = $this->services[$ss]; ?>
								<div>
									<label for="role<?=$k?>" class="label label-success" ><i class="fa fa-check"></i><?=$s_name?></label>
								</div>

							<?php endforeach ?>
						<?php endif;?>

					</div>
					<br>
					<div class="">
						<input type="checkbox" name="changePassFlag" id="" class="">
						<label for=""><?= string('Change_password')?> </label>
						<input class="form-control" type="password" name="pass" value="" />
					</div>

				</div>

				<div class="ib b50">
					<br />
					<?php if($record['ID'] != "1"):?>
						<br>
						<div>
							<input type="checkbox" name="reRoleFlag" id="reRoleFlag" value="<?=$k?>">
							<label class="f_blue" for="reRoleFlag"><?= string('re_asign_access_range') ?> : </label><br><br>
						</div>

						<?php foreach ($this->services as $k=> $s): ?>
							<div>
								<input type="checkbox" name="reRole[]" id="reRole<?=$k?>" value="<?=$k?>">
								<label for="reRole<?=$k?>"><?=$s?></label>
							</div>
						<?php endforeach ?>

						<br>
						<br>
					<?php endif;?>
					<br>

					<!-- <div class="form-group _caps">
						<label for="" class="label label-primary"><?= string('ava')?> :</label><br />
						<img src="<?=  $ava ?>" width="100" class="chooseFile hint" data-hint="<?=$GLOBALS['ava']?>" >
						<input type="text" name="ava" class="avatar" value="<?= $ava ?>" >
					</div> -->

					<h5>
						<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("update")?></label>
						<input type="radio" name="page" id="page2" value="<?=url()."admin/root"?>" > <label class="hand" for="page2"><?= str("update")?> + <?= str("back")?></label><br />
					</h5>


					<button type="submit" name="rootBtnUp" value="rootBtnUp" class="btn btn-primary"><?=string('update')?></button>
					<a href="<?=url('admin/delete/'.$id)?>" class="btn btn-danger f_white confirm"><?=string('delete')?></a>

				</div>

			</form>

		<?php endif ?>
	<?php endif ?>

	<!-- show form | printable -->
	<?php if($this->form == "show"):?>
	<?php endif ?>
</div>