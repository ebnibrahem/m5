<?php use M5\MVC\Shared as C; ?>

<?php $categories = $data['categories'] ;?>

<div id="content">

	<div class="center">

		<br><br>
		<br>
		<?php if ($categories) :?>

			<?php foreach ($categories as $part) : ?>
				<div class="profile optimize">
					<a href="<?= url('blogs/part/'.$part['ID'].M5\Library\Axe::url($part['name'])) ?>">
						<div class="head"></div>
						<div class="avatar">
							<img src="<?= LOADING ?>" data-src="<?= $part['ava'] ?>" alt="<?= $part['name']  ?>">

						</div>
						<h2 class="bold"><?= $part['name']  ?> </im></h2>
					</a>
				</div>
			<?php endforeach ?>

		<?php endif ?>
	</div>

</div>
