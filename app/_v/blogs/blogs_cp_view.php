<?php use M5\Library\Page; ?>
<?php use M5\Library\Clean; ?>

<div id="content">
	<?php //pa( $data ); ?>
	<?php //pa( $this ); ?>
	<?php //pa( $data["records"] ); ?>


	<?php if (!$this->form): ?>

		<div id="filter">
			<form action="<?= url($this->formAction)?>" >
				<div class="row">

					<div class="col-md-3">
						<div class="form-group">
							<input type="search" name="q" value="<?= clean::sqlInjection($_GET['q'])?>" placeholder="<?=s('search')?>.. ">
						</div>
					</div>
					<div class="col-md-3">
						<select name="part_id" class="form-control select_pc" data-fetch_flag="part_id" data-child_flag="part_id_flag">
							<option value=""><?= str('categories')." - ".str('all')?></option>
							<?php if ($data['categories'] ): ?>
								<?php foreach ($data['categories'] as $key => $part): ?>
									<?php $selected = ($_GET['part_id'] == $part['ID']) ? 'selected' : '' ?>
									<option value="<?= $part['ID'] ?>" <?= $selected?>><?= $part['name'] ?><?= $part['paerName'] ?></option>
								<?php endforeach ?>
							<?php endif ?>

						</select>
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

	<?php //pa($data["records"][0] ) ?>

	<?php $meta = $data['meta'] ?>

	<div id="all">
		<?php if( $records = $data["records"] ):?>
			<?php //require view('records/table_cp.php') ; ?>

			<?php foreach($records as $key => $record):?>
				<?php $image = get_uploads("upload/blogs/".$record['BETA'],'file')[0]; ?>

				<div class="block b1">
					<a class=""  href="<?= url( $this->formAction.$record['ID'])?>">
						<img src="<?=!$image ? NO_IMG : $image?>" alt="<?=$record['name']?>">
						<h4><?=$record['name']?></h4>
					</a>

					<div class="line"><i class="fa fa-share-alt"></i><?=$record['partName']?>
						<?= !$record['ChildName'] ? '':  '<i class="fa fa-minus"></i>'.$record['ChildName']; ?>
					</div>

					<div class="line"><i class="fa fa-user-o"></i><?=$record['authorName']?></div>

					<div class="line"><?=$record['v']?> <i class="fa fa-eye"></i></div>

					<div class="line"> <?=  $data['drop_list']['st'][ $record['st'] ] ?></div>

					<div class="line"><?=$record['c_at']?></div>

					<div class="ftr">
						<a class="confirm"  href="<?=url($this->formAction.'delete/'.$record['ID'])?>">
							<i class="fa fa-trash"></i>
						</a>
					</div>
				</div>
			<?php endforeach;?>

			<?php //ve($meta) ?>
			<hr>
			<div class="row" id="meta">
				<div class="col-md-6 col-sm-6 col-xs-12">

					<?php if ($meta['pages'] > 1 ): ?>
						<ul class="pagging">
							<?php for ($i = 1; $i <= $meta['pages'] ; $i++): ?>
								<li class="<?= $_GET['page'] == $i ? "active" : "" ?>" ><a href="<?= url($this->formAction.'?page='.$i.$meta['paggingUrl'])?>"><?=$i?></a>
								</li>
							<?php endfor ?>
						</ul>
					<?php endif ?>

				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="pd10 rd5" style=" border: 1px solid #789;">
						<b class="pd10 fa fa-database"></b> السجلات  : <?= $meta['total'] ?>
						<b class="pd10 fa fa-table"></b>    السجلات في الصفحة   : <?= $meta['offset'] ?>
						<b class="pd10 fa fa-copy"></b>     الصفحات  : <?= $meta['pages'] ?>
					</div>
				</div>
			</div><!-- ./row- meta-->

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
		<?php require view('blogs/form_add.php') ; ?>
	<?php endif ?>

	<!-- update form -->
	<?php if($this->form == "update"):?>
		<?php if ($data["theRecord"]): ?>
			<?php// pa($data["theRecord"]) ?>
			<?php $record = $data["theRecord"] ?>
			<?php require view('blogs/form_update.php') ; ?>
		<?php endif ?>
	<?php endif ?>

	<!-- show form | printable -->
	<?php if($this->form == "show"):?>
		<?php $record = $data["theRecord"] ?>
		<?php require view('blogs/show.php') ; ?>
	<?php endif ?>

</div>