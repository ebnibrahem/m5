

</div> <!-- section -->
<div class="clear"></div>
<br />
<br />
<br />

<footer>
	<?= site_name ?>
	<div class="mic small">
		powered by <span>MIC - Moiah <?=date("Y")?></span>

		<small>PHP VERSION :
			<small class="label label-default">
				<?=  PHP_VERSION; ?>
			</small> | <?= R_DATE_LONG ?>
		</small>

	</div>
</footer>
</div><!--MIC_CP wrapper-->



<?php if($this->editor){ ?>
<?php
if($_SERVER['HTTP_HOST'] == "localhost"):?>
<script src="<?='http://localhost/local_cdn/libs/tinymce/tinymce.min.js'?>"></script>
<?php else: ?>
	<script src="//cdn.tinymce.com/4/tinymce.js"></script>
<?php endif;?>

<script type="text/javascript">
	tinymce.init({
		selector: '.textarea',
		height: 300,
		theme: 'modern',
		relative_urls : false,
		remove_script_host : false,
		convert_urls : true,
		"menubar":1,
		content_css: "<?=assets('css/admin.css?123')?>",

		plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools'
		],
		toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		toolbar2: 'print preview media | forecolor backcolor emoticons',
		image_advtab: true,
		templates: [
		{ title: 'Test template 1', content: 'Test 1' },
		{ title: 'Test template 2', content: 'Test 2' }
		]
	});
</script>
<?php } ?>
</body>
</html>
