<?php use M5\Library\Page; ?>
<?php use M5\Library\Session; ?>

<?php $records =  $data["records"]; ?>
<?php $meta = $data['meta'] ?>
<?php $record =  $data["theRecord"]; ?>
<?php //pa( $this ); ?>
<?php //pa( $data ); ?>
<?php //pa( $records ); ?>
<?php //pa( $record ); ?>

<div id="content">

	<?php if( $data["records"] ):?>

		<div id="all" class="center">

			<?php foreach ($records as $key => $blog): ?>
				<?php require view().'blogs/thumbnail.php';?>
			<?php endforeach ?>

			<?php //ve($meta) ?>
			<hr>
			<div class="hr"></div>
			<br>

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
		</div>
	<?php endif; ?>

	<?php if ($record): ?>
		<?php require view().'blogs/details.php';?>
	<?php endif;?>

	<?php if( !$data && !$this->form ):?>
		<div class="alert alert-info" role="alert">
			<?= string("no_data");?>
		</div>
	<?php endif;?>
</div>
