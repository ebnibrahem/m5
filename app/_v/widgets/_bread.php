<?php use M5\Library\Pen; ?>

<?php $anchor = Pen::json($data['anchor']); ?>

<?php if($anchor): ?>
	<?php extract($anchor);?>
	<a class="anchor label label-info" href="<?=url().$link?>">
		<?=$label?>
	</a>
<?php endif ?>

<?php $bread = $data['bread'];?>

<?=$bread?>


