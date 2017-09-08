<?php use M5\Library\Page; ?>
<?php use M5\Library\Session; ?>
<?php $this->categories = $data['categories'] ?>

<?php $records =  !$data['records'] ? $this->categories : $data['records'] ?>
<?php $record =  $data["theRecord"]; ?>
<?php //pa( $this ); ?>
<?php //pa( $data ); ?>
<?php //pa( $records ); ?>
<?php //pa( $record ); ?>


<div id="content">
	<div class="row">
		<section class="col-md-5">
			<?php if ($this->form == "update"): ?>
				<form method="post" action="<?=page::url();?>">
					<?php if ($record['ID']): ?>
						<legend for="" class="">
							<?= string('Update') ." : ".$record['name']?>
						</legend>

						<?php //pa($record)?>
						<fieldset class="form-group">
							<label for=""><?= string('name')?>: </label>
							<input type="text" name="name" value="<?=$record['name']?>" class="form-control" />
						</fieldset>

						<fieldset class="form-group" >
							<label for=""><?= string('rank')?>: </label>
							<select name="rank" class="form-control" id="partRank">
								<option value="parent"><?= string('main')?></option>
								<option value="child" <?php if("child" == $record['rank']) echo 'selected'  ?>><?= string('sub')?></option>
							</select>
						</fieldset>

						<?php if($record['rank'] == "child"): ?>
							<fieldset class="form-group" >
								<label> <i class="fa fa-share-alt"></i> <?= string('part').' ال'.string('main')?> :</label>
								<select name="parent" class="">
									<?php foreach($this->categories as $part): ?>
										<option value="<?=$part['ID']?>" <?php if($part['ID'] == $record['parent']) echo 'selected'  ?> >
											<?=$part['name']?>
										</option>
									<?php endforeach;?>
								</select>
							</fieldset>
						<?php endif;?>

						<?php if($this->categories): ?>
							<fieldset class="form-group hide" id="childRank">
								<label for=""><?= str('categories_main')?> : </label>
								<select name="parent"   class="form-control ">
									<?php foreach($this->categories as $part): ?>
										<option value="<?=$part['ID']?>"><?=$part['name']?></option>
									<?php endforeach;?>
								</select>
							</fieldset>
						<?php endif;?>


						<textarea name="_desc" class="form-control"><?=$record['_desc']?></textarea><br />
						<img src="<?=$record['ava']?>" width="120" class="chooseFile hint" data-hint="change Categoriy avatar" >
						<input type="hidden" name="ava" class="avatar" value="<?=$record['ava']?>" >
						<br />

						<h4>
							<input type="radio" name="page" value="<?=page::url();?>" checked > <?= string('Update') ?>
							<input type="radio" name="page" value="<?=url('admin/').'categories'?>" > <?= string('Update') ?> + <?= string('back') ?>
							<br />
						</h4>
						<br />
						<input type="submit" value="<?= str('update') ?>" name="categoriesbtnUp" class="btn b_green">
					<?php endif ?>

				</form>


			<?php else:?>
				<!--add form -->
				<legend for="" class="">
					<?= string('add_new')?>
				</legend>
				<form method="post" action="<?=url('admin/categories')?>" role="form">
					<fieldset class="form-group" >
						<label for=""><?= string('rank')?>: </label>
						<select name="rank" class="form-control" id="partRank">
							<option value="parent"><?= string('main')?></option>
							<option value="child"><?= string('sub')?></option>
						</select>
					</fieldset>

					<?php if($this->categories): ?>
						<fieldset class="form-group hide" id="childRank">
							<label for=""><?= str('categories_main')?> : </label>
							<select name="parent"   class="form-control ">
								<?php foreach($this->categories as $part): ?>
									<option value="<?=$part['ID']?>"><?=$part['name']?></option>
								<?php endforeach;?>
							</select>
						</fieldset>
					<?php endif;?>

					<fieldset class="form-group">
						<input type="text" name="name" placeholder="<?= string('name')?>"  class="form-control" >
					</fieldset>

					<fieldset class="form-group">
						<input type="hidden" name="BETA" placeholder="<?= string('slug')?>" value="<?= uniqid() ?>"  class="form-control" >
					</fieldset>

					<textarea name="_desc" placeholder="<?= string('Description')?>" class="form-control"></textarea><br />

					<img src="<?=LOGO?>" width="120" class="chooseFile hint" data-hint="change Categoriy avatar" >
					<input type="hidden" name="ava" class="avatar" value="<?=LOGO?>" >
					<br />
					<br />

					<h4>
						<input type="radio" name="page" value="<?=page::url();?>" checked> <?= str('Add')?>
						<input type="radio" name="page" value="<?=url('admin/').'categories'?>"> <?= str('Add')?> +<?= str('Back')?>  <br />
					</h4>
					<br />
					<input type="submit" value="<?= str('Add')?>" name="categoriesbtnAdd" class="btn b_green">
				</form>
			<?php endif ?>
		</section>
		<section class="col-md-1"></section>

		<section class="col-md-6">
			<?php if($records) :?>
				<?php if ($this->is_parent): ?>
					<legend><?= str('Subs'). " " .str('part')?>  : <em> <?=$this->is_parent?> </em> </legend>
				<?php else: ?>
					<legend> <?= string('categories') ?> </legend>
				<?php endif ?>

				<table class="table table-hover center" >
					<thead class="">
						<tr>
							<th class="alignC">#</th>
							<th class="alignC"><?= str('Name')?></th>
							<!-- <th class="alignR"><i class="fa fa-check mark hand"></i></th> -->
						</tr>
					</thead>
					<tbody>
						<?php $c=1; foreach ($records as $part): extract($part); ?>
						<tr>
							<td><?=$c?></td>
							<td><a href="<?=url('admin/categories/').$ID?>"><?=$name?></a></td>

							<!-- <td><input class="multy" type="checkbox" name="ID[]" value="<?=$ID?>" ></td> -->
						</tr>
						<?php $c++; endforeach ?>
					</tbody>

					<!-- <thead class="f_white">
						<tr>
							<th>#</th>
							<th>Nae</th>
							<th>Avatar</th>
							<th>
								<select name="action" class="small form-control">
									<option value="delete">Delete</option>
								</select>
								<input class="btn btn-warning confirm" type="submit" value="Excute" name="actionsBtn">
								<input type="hidden" value="<?=page::url()?>" name="page">
							</th>
						</tr>
					</thead> -->

				</table>
			<?php endif;?>
		</section>
	</div>

</div>

<script type="text/javascript">
	$(document).ready(function($) {

		$("#childRank").fadeOut();
		$("#partRank").change(function() {

			var partRank = 	$(this).val();

			if(partRank == "parent"){
				$("#childRank").fadeOut();
			}else{
				$("#childRank").fadeIn();
			}

		});
	});
</script>