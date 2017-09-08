
<?php use M5\MVC\Config; ?>

<?php if (HOST == "localhost"): ?>
	<script src="<?= assets('js/jquery-2.2.0.min.js') ?>"></script>
	<script src="<?= assets('js/bootstrap.min.js') ?>"></script>

<?php else: ?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<?php endif; ?>

<?php if ($data['jsFile']): ?>
	<?php foreach ($data['jsFile'] as $k => $v): ?>
		<script type="text/javascript" src="<?= assets('js/' . $v . '.js') ?>" ></script>
	<?php endforeach ?>
<?php endif ?>

<script src="<?= assets('js/main.js' . CACHE_VAR) ?>"></script>
<script src="<?= assets('js/check.js' . CACHE_VAR) ?>"></script>



<?php require 'toast.php';?>