<?php
use M5\MVC\App;
use M5\MVC\Config;
use M5\Library\Page;
use M5\Library\Session;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>  <?=!$data['title'] ? Config::get('site_name') : $data['title'] ; ?></title>
	<link rel="stylesheet" href="<?= assets('css/default.css?' . uniqid()) ?> ">

	<?php require view() . 'widgets/cdn_css.php'; ?>

	<link rel="stylesheet" href="<?= assets('css/admin.css?' . uniqid()) ?> ">
	<link rel="stylesheet" href="<?= assets('css/spots.css?' . uniqid()) ?> ">

	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body data-url="<?=url()?>" data-current_url="<?= M5\Library\Page::url() ?>" >
	<?php require view() . 'widgets/cdn_js.php'; ?>
	<script src="<?= assets('js/js2.js?' . uniqid()) ?>"></script>
	<script src="<?= assets('js/panel.js?' . uniqid()) ?>"></script>

	<div id="moreActions">
		<i class="fa fa-sliders"></i>
	</div>

	<div class="aside_open" title="Show Menu">
		<i class="fa fa-angle-double-right" ></i>
	</div>

	<div id="MIC_CP_wrapper">

		<?php require 'aside.php'; ?>

		<div class="section">
			<header class="b_white">
				<div class="b90 auto_margin alignL ">
					<ul class="inline-ul">
						<label class="btn btn-success small"> <i class="fa fa-lock"></i><?= string('access_range') ?> >> </label>
						<?php foreach (Session::get("roles") as $k => $ro): ?>
							<div class="btn btn-primary small">
								<?php $s_name = $data['drop_list']['poremission'][$ro]; ?>
								<?= $s_name?>
							</div>
						<?php endforeach ?>
					</ul>
				</div>

			</header>

			<?php require '_bread.php'; ?>

