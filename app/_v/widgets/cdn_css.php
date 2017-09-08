<?php use M5\MVC\Config; ?>

<?php if (HOST == "localhost"): ?>
	<link rel="stylesheet" href="<?= assets('css/font-awesome.css') ?>">
	<link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?>">
<?php else: ?>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- <link href="http://fonts.googleapis.com/earlyaccess/droidarabicnaskh.css" rel="stylesheet"> -->
<?php endif; ?>

<link rel="stylesheet" href="<?= assets('fonts/fonts.css'.CACHE_VAR) ?>">
<link rel="stylesheet" href="<?= assets('css/spots.css'.CACHE_VAR) ?>">

<?php if (TEXT_DIRECTION_END == "right"): ?>
	<link rel="stylesheet" href="<?= assets('css/ltr.css'.CACHE_VAR) ?>">
<?php endif ?>
