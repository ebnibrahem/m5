<?php use M5\Library\Session; ?>
<?php use M5\Library\Pen; ?>

<?php $anchor = Pen::json($data['anchor']); ?>

<?php if($anchor): ?>
	<?php extract($anchor);?>
	<a class="anchor label label-info" href="<?=url()	.$link?>">
		<?=$label?>
	</a>
<?php endif ?>

<?php $bread = $data['bread'];?>

<?=$bread?>

<?php if( session::getWink("msg",0) ): ?>
	<?php $show = 'show'?>
	<script type="text/javascript">
		$(document).ready(function($) {
			$(".echo_box").addClass('show');

			var c = 5;
			var boom = setInterval(function(){
				c--;
				if(c == "0"){
					$(".echo_box").removeClass('show');
				}
			},1000);

			// $(".echo_box").removeClass('show').delay(1000);;

		});
	</script>

	<div class="echo_box " >
		<div class="msg">
			<?=  session::getWink("msg"); ?>
		</div>
	</div>

<?php endif;?>

<?php //pa($_SESSION) ?>

