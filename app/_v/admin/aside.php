<?php use M5\Library\Session; ?>
<?php use M5\Library\Auth; ?>
<?php use M5\Library\Page; ?>

<style>
	<?php if(Session::get("menu") == "1"):?>
	aside{
		width: 0;
		overflow: hidden;
	}
	.section{
		width: 100%;
		margin:0;
	}
	.aside_open{
		display: block;
	}
<?php else:?>
	aside_show();
<?php endif?>
</style>

<?php
$FREEMB = (disk_free_space(ROOT)/1000000);
$TOTALMB = (disk_total_space(ROOT)/1000000);

$FREE_SPACE = number_format($FREEMB,"2")." MB<br />";

$FREE_SPACE = number_format( ($FREEMB*100/$TOTALMB) , "2");
?>

<aside>
	<div class="panel panel-default center aside_close" title="Desmiss">
		<i class="fa fa-angle-double-left" ></i>
		<i class="fa fa-angle-double-left" ></i>
	</div>

	<div class="panel panel-default center">

		<div id="logo">
			<img src="<?=LOGO?>" alt="<?=site_name?>" width="100">
		</div>
		<br>

		<div class="panel-body _20">

			<a href="<?=url('admin/root')?>" class="f_olive" data-toggle="tooltip" data-placement="top" title="<?= Session::get("adminName")?>"><i class="fa fa-user"></i></a>

			<a href="<?=url()?>" target="_blank" class="f_blue"  data-toggle="tooltip" data-placement="top" title="<?= site_name?>"><i class="fa fa-globe"></i></a>

			<a href="<?=url('admin?do=logout')?>" class="f_red" target="_blank" data-toggle="tooltip" data-placement="top" title="<?= str('logout')?>"><i class="fa fa-power-off"></i></a>
		</div>

		<div>
			<?php if ($this->notificationsTotal): ?>
				<label class="label label-info">
					<a href="<?=url('admin/notifications')?>" class="f_white">
						<i class="fa fa-bell "></i>
						<?= string('notifications')?>
						( <?=$this->notificationsTotal?> )
					</a>
				</label>
			<?php else: ?>
				<label class="label b_gray">
					<a href="<?=url('admin/notifications')?>" class="f_white">
						<i class="fa fa-bell "></i>
						<?= string('notifications')?> (0)
					</a>
				</label>
			<?php endif ?>
			<br>
			<br>
			<?php //lang() ?>
			<?php //lang('en') ?>

			<a href="<?=URL.'admin'?>">عربي</a> |
			<a href="<?=URL.'en/admin'?>">English</a>
			<br>
		</div>
	</div>

	<ul class="list-group ">
		<li class="list-group-item"><a href="<?=url('admin/cp')?>"> <i class="fa fa-home small f_base"></i> <?= string('Cpanel') ?> </a></li>

		<?php  /*Authentication*/?>
		<?php $roles = Session::get("roles"); ?>

		<?php if( Auth::valid($roles,[4],'dontshowecho') == "200") :?>

			<li class="list-group-item">
				<a style="float: <?= TEXT_DIRECTION_END?>;" target="" href="<?=url('admin/categories/do/add')?>"> <i class="fa fa-plus small f_base" data-toggle="tooltip" data-placement="top" title="<?=str('add_new')?>" ></i> </a>
				<a href="<?=url('admin/categories')?>"> <i class="fa fa-share-alt small f_base"></i> <?= string('categories') ?> </a>
			</li>

			<li class="list-group-item br">
				<a style="float: <?= TEXT_DIRECTION_END?>;" target="" href="<?=url('admin/blogs/do/add')?>"> <i class="fa fa-plus small f_base" data-toggle="tooltip" data-placement="top" title="<?=str('add_new')?>" ></i> </a>
				<a href="<?=url('admin/blogs')?>"> <i class="fa fa-pencil small f_base"></i> <?= string('blogs') ?> </a>
			</li>

			<li class="list-group-item"><a href="<?=url('admin/pages')?>"> <i class="fa fa-database small f_base"></i> <?= string('pages'); ?> </a></li>

			<li class="list-group-item br"><a href="<?=url('admin/statistic')?>"> <i class="fa fa-pie-chart small f_base"></i> <?= string('statistic') ;?> </a></li>

			<li class="list-group-item"><a href="<?=url('admin/root')?>"> <i class="fa fa-lock small f_base"></i> <?= str('administration') ?> </a> </li>

			<li class="list-group-item"><a href="<?=url('admin/mic')?>"> <i class="fa fa-gear small f_base"></i> <?= str('setting') ?> </a> </li>

			<li class="list-group-item">
				<a style="float: <?= TEXT_DIRECTION_END?>;" target="_blank" href="<?=url('admin/files')?>"> <i class="fa fa-external-link small f_base" data-toggle="tooltip" data-placement="top" title="فتح في صفحة مستقلة" ></i> </a>
				<a href="<?=url('admin/files')?>"> <i class="fa fa-folder small f_base"></i> <?= string('files') ?> </a>
			</li>
		<?php endif;?>

		<li class="list-group-item">
			<a class="confirm" href="<?=url('admin?do=logout')?>"> <i class="fa fa-power-off small f_red"></i><?=string('Logout')?>  </a>
		</li>
	</ul>

</aside>


