<?php use M5\MVC\config; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Composer | Create Contollers Models views</title>

	<link rel="stylesheet" href="<?=assets('css/bootstrap.min.css')?>" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="<?=assets('css/spots.css')?>" media="screen" title="no title" charset="utf-8">

	<style type="text/css">
		body {
			width: 95%;
			margin: auto;
			background: #333;
			color: #FFF;
		}
		#content{
			padding:100px;
		}

		.col-md-4{
			float: left;
		}

		input[type=text]{
			height: 50px;
			font-size: 22px;
		}

	</style>

</head>
<body>
	<script src="<?=assets('js/jquery.js')?>"></script>
	<script src = "<?=assets('js/bootstrap.min.js')?>" ></script>
	<script type="text/javascript">
		$(document).ready(function($) {

		});
	</script>
	<div id="content">
		<form role="form">


			<div class="row">

				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="c_file" placeholder="Controller file name" class="form-control">
						<small>Inside: <em><?= Config::get('C_PATH') ?></small></em>
					</div>

					<div>
						<input type="checkbox" name="adminTmpl2" id="adminTmpl2">
						<label for="adminTmpl2">use folder Template File</label><br>

						<input type="checkbox" name="routeFlag" id="routeFlag">
						<label for="routeFlag">include local route</label><br>

						<input type="checkbox" name="curd_func_Flag" id="curd_func_Flag">
						<label for="curd_func_Flag">include CURD Functions </label><br>
					</div>



					<input type="submit" name="cBtn" value="Create Controller" class="btn btn-primary"><br />
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="v_file" id="v_file" placeholder="View file name" class="form-control">
						<small>Inside: <em><?= Config::get('V_PATH') ?></small></em>
					</div>

					<div class="form-group">

						<input type="radio" name="view_file_Flag"  value = "blankFlag" id="blankFlag" checked>
						<label for="blankFlag">include Blank View </label><br />

						<input type="radio" name="view_file_Flag" value="CURDFlag" id="CURDFlag" >
						<label for="CURDFlag">include admin-CURD view page </label><br />

						<input type="radio" name="view_file_Flag" value="CURDFlag_user" id="CURDFlag_user" >
						<label for="CURDFlag_user">include user-CURD view page </label><br />

					</div>


					<input type="submit" name="vBtn" value="Create View" class="btn btn-info"><br>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="m_file" id="m_file" placeholder="Model file name" class="form-control">
						<small>Inside: <em><?= Config::get('M_PATH') ?></small></em>
					</div>

					<input type="submit" name="mBtn" value="Create Model" class="btn btn-success">
				</div>

			</div>


		</form>

		<hr>
		<a href="<?= url()?>">Home</a> |
		<a href="<?= url('admin')?>">Admin</a>

	</div>
</body>
</html>