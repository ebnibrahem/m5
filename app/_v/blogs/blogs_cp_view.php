<?php use M5\Library\Page; ?>
<?php use M5\Library\Clean; ?>
<?php use M5\Library\Session; ?>

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

					<div class="col-xs-12 col-sm-4 col-md-4">
						<select name="child_id" id="part_id_flag" class="form-control">
							<option value=""><?= str('choose')?></option>
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

		<section class="row">
			<content class="col-md-6 col-sm-6">
				<div id="sort">
					<form action="<?= url($this->formAction.'?page='.$i.$meta['paggingUrl'])?>">
						<div style="text-align: right;" class=" _capss">
							<select name="sort" class="p100 form-control" >
								<option value="name" <?= ($_GET['sort'] == "name") ? 'selected' : '' ;?>><?=s('name')?></option>
								<option value="part_id" <?= ($_GET['sort'] == "part_id") ? 'selected' : '' ;?>><?=s('part')?></option>
								<option value="c_at" <?= ($_GET['sort'] == "date") ? 'selected' : '' ;?>><?=s('date')?></option>
								<option value="v" <?= ($_GET['sort'] == "v") ? 'selected' : '' ;?>><?=s('view')?></option>
							</select>

							<select name="by" class="p100 form-control" >
								<option value="ASC" <?= ($_GET['by'] != "DESC") ? 'selected' : '' ;?>> أ-ي</option>
								<option value="DESC" <?= ($_GET['by'] == "DESC") ? 'selected' : '' ;?>> ي-أ</option>
							</select>

							<button type="submit" class="btn btn-info" ><?= string('sort')?></button>
						</div>
					</form>
				</div><!-- /sort-->
			</content>
			<content class="col-md-6 col-sm-6">

				<div class="left" id="view_style">
					<div class="p100" >طريقة العرض:</div>

					<div class="p50">
						<a class="f_gray2" href="<?=url($this->formAction.'?view=grid')?>"> <i class="<?= Session::get("view_style")!="table" ?'f_blue' : '' ?> _24 fa fa-th"></i> شبكة</a>
					</div>
					<div class="p50" >
						<a class="f_gray2" href="<?=url($this->formAction.'?view=table')?>"> <i class="<?= Session::get("view_style")=="table" ?'f_blue' : '' ?> _24 fa fa-table"></i> جدول</a>
					</div>
				</div><!--/view style-->
			</content>
		</section> <!--/filter and sort-->
		<div class="hr"></div>

	<?php endif ?>

	<?php //pa($data["records"][0] ) ?>

	<?php $meta = $data['meta'] ?>

	<div id="all">

		<?php if( $records = $data["records"] ):?>

			<?php if (Session::get("view_style") == "table"): ?>
				<?php require view('blogs/table_cp.php') ; ?>
			<?php else: ?>
				<?php require view('blogs/grid_cp.php') ; ?>
			<?php endif ?>

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