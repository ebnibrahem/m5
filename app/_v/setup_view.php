<!DOCTYPE html >
<head>
	<meta charset=utf-8 />
	<title>Setup Script</title>
	<style type="text/css">
		div{
			font-family: 'ubuntu mono',consolas;
			margin: 5px auto;
			text-shadow: 0  0 5px #000;
			padding: 5px;
			min-width: 20px;
			margin-bottom: 10px;

		}
		body{
			background-color: #320927;
			color: #EFDEDC;
		}
		.b_white{
			background: #FFF;
			padding: 5px;
		}
	</style>
</head>

<body>
	<hr>
	<h3 class="b_white">
		<a href="<?= url('') ?>">Home </a> |
		<a href="<?= url('admin') ?>">Admin </a>
	</h3>

	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="#">Link</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Link</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Link</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled" href="#">Disabled</a>
		</li>
	</ul>
</body>
</html>