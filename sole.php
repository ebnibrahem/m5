<?php

require_once 'app/init.php';

use M5\MVC\config;
// require "libs/functions.php";
// require __DIR__."/app/config.php";
?>
<!DOCTYPE html>
<html>


<head>
	<title>Sole of MIC</title>
	<link rel="stylesheet" href="<?=assets('css/bootstrap.min.css')?>" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="<?=assets('css/spots.css')?>" media="screen" title="no title" charset="utf-8">
	<style type="text/css">
		body {
			background: #333;
			color: #FFF;
		}
	</style>
</head>

<body>
	<script src="<?=assets('js/jquery.js')?>">
		< script src = "<?=assets('js/bootstrap.min.js')?>" >
	</script>
	<?php
	$path = Config::get('C_PATH');
	############################################
	# Controller
	############################################

	if($_GET['cBtn']){
		if($_GET['cName']){
			$c = preg_match('/^.+\//', $_GET['cName'] ) ? end( explode("/", $_GET['cName']) ) : $_GET['cName'];

			$tbl  = str_replace("_cp","",$c);

			$c_view =  $_GET['view_file'];

			$sub_dirc = explode("/", $_GET['cName']);
			$sub_dir = $sub_dirc[0] ? ucfirst($sub_dirc[0]) :"admin";

			$admin_folder =  $_GET['adminTmpl2'] ? strtolower( "$sub_dir/") : '';

			$sub_folder = (!$admin_folder ) ? "" : strtolower( "$sub_dir/");
			$sub_namespace = (!$admin_folder) ? "" : "\\$sub_dir";

			$template_view =  !$c_view ? $_GET['cName'] : $c_view;


			$route = !$_GET['routeFlag'] ? '' : '
			/*local route*/
			$alpha = $params[0];
			$beta = $params[1];
			$gama = $params[2];

			if($alpha && !$beta){
				$this->details($alpha);

			}elseif($alpha && $beta){
				if($alpha == "do"){
					$this->request->form = $beta;
					$this->$beta($gama);

					/*breadcrumb*/
					$this->data["title"] = string($beta);
					$this->data["bread"] = Bread::create( [ str("'.$c.'")=> "'.$sub_folder.$c.'", $this->data["title"]=>"#"] );
				}

			}else{
				$this->all($cond="");
			}
			';

			/* CREATE LOCAL ROUTE FUNCTIONS */
			$route_func =  !$_GET['routeFlag'] ? '' :
			'
			/**
	 * view All record
	 *
	 * @return mixed
	 */
			private function all($cond=""){
				$r = $this->model->table([])->fetch([]);
				/*$r = $this->model->_all();*/
				/*pa($r);*/
				$this->data["records"] = $r["data"];
			}

			/**
	 * view one record
	 *
	 * $id int record id
	 */
			private function details($id){
				$this->request->form = "update";
				$r = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);
				//$r = $this->model->_one($id);
				/*pa($r);*/
				$this->data["theRecord"] = $r;

				/*bread*/
				$this->data["title"] = $r["name"];
				$this->data["bread"] = Bread::create( [str("'.$c.'")=>"'.$sub_folder.$c.'", $this->data["title"]=>"#"] );

				//seo
				$this->request->SEO = $r["name"];
				$this->request->SEO_DESC = clean::sqlInjection($r["content"]);
				$this->request->SEO_IMG = $r["ava"];

				/*related ads*/
				$cond = " && (ID != \'$id\' && part_id = \'{$r["part_id"]}\' )";
				$related = "??";
				$this->data["related"] = $related;


				/*update Btn listener*/
				$this->update($id, $r);

			}

			/**
	 * add new record
	 *
	 * $_POST[]
	 */
			private function add(){
				if($_POST["'.$tbl.'btnAdd"]){
					/*Authentication*/
					$roles = Session::get("roles");
					Auth::valid($roles,[1]);

					pa(0,1);
					extract($_POST);
					/*clean post*/

					$args = [
					"name"=>$name,

					];
					if($this->model->insert($args))
					{
						Session::setWink("msg", msg( string("add_success"),"alert alert-success") );
						page::location($page);
						die();
					}
				}
			}

			/**
	 * update one|more record
	 *
	 * $id int record id
	 */
			private function update($id, array $r){

				if($_POST["'.$tbl.'btnUp"]){
					/*Authentication*/
					$roles = Session::get("roles");
					Auth::valid($roles,[2]);

					$r = $r;


					extract($_POST);
					pa(0,1);
					/*clean post*/

					$args = [
					"name"=>$name,

					];

					if($this->model->update($args," && `ID` = \'$id\' "))
					{
						Session::setWink("msg", msg(string("update_success"),"alert alert-info") );
						page::location($page);
						die();
					}
				}
			}

			/**
	 * Delete one|more record
	 *
	 * $id int record id
	 */
			public function delete($id){
				/*Authentication*/
				$roles = Session::get("roles");
				Auth::valid($roles,[3]);

				$page = url("'.$sub_folder.'".pure_class(__CLASS__));
				if( $this->model->delete(" && `ID` = \'$id\' ") ){
					Page::location($page);
					die();
				}

			}'; //END OF LOCAL ROUTE CONTENTS


			/*** 1. CREATE Contorller File ***/
			$controllers_file = $path.DS.$sub_folder.$c.'.php';
			if(! file_exists($controllers_file)){
				$content = '<?php 	namespace M5\Controllers'.$sub_namespace.';

				use M5\MVC\App;
				use M5\MVC\Controller as BaseController;
				use M5\Library\Bread;
				use M5\Library\Page;
				use M5\Library\Session;
				use M5\Library\Clean;
				use M5\Library\Auth;

				use M5\Models\\'.ucfirst($c).'_Model;
				/*use M5\MVC\Model;*/

				class '.ucfirst($c).' extends BaseController
				{
					private $tbl = "'.$tbl.'";
					private $class_label = "'.$tbl.'";

					function __construct()
					{
						parent::__construct();
						$this->request->formAction = "'.$sub_folder.$c.'/";

						/*instant model : Singleton Style*/
						/*$this->model = Model::getInst($this->tbl);*/
						$this->model = new '.ucfirst($c).'_Model($this->tbl);

						/*breadcrumb*/
						$this->data["title"] = str($this->class_label);
						$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
						//$this->data[\'anchor\'] = \'{"link":"'.$sub_folder.$c.'/do/add","label":"\'.string(\'add_new\').\'"}\';

					}

					/** * Main Function */
					public function index($params = [])
					{
						'.$route.'
						/*view*/
						$this->getView()->template("'.$template_view.'",$this->data,$templafolder="'.$admin_folder.'");
					}

					'.$route_func.'
				}
				';

				$myfile = fopen($path.DS.$sub_folder.$c.".php", "w");
				file_put_contents($path.DS.$sub_folder.$c.".php",$content);
				echo msg(ucfirst($c).' Controller Yeaned!','alert alert-success','ltr');


				/*** CREATE view FILE ***/
				if($_GET['view_file']){
					$_view_path =  $_GET['view_file'] ;
					$sub_dirc = explode("/", $_GET['view_file']);
					$sub_dir = $sub_dirc[0] ? strtolower($sub_dirc[0]) :"";
					mkdir(Config::get('V_PATH').$sub_dir,0777,TRUE);

					if(!file_exists( Config::get('V_PATH').DS.$_view_path."_view.php")){

						$view_content_blank = '<div id="content"></div>';

						/* Admin CURD */
						$view_content_CRUD = '<?php use M5\Library\Page; ?>

						<div id="content">
							<?php //pa( $this ); ?>
							<?php //pa( $data["records"] ); ?>
							<div id="all">
								<?php if( $data["records"] ):?>
								<table class="table table-bordered table-hover b_white center">
									<thead>
										<tr>
											<th class="center b_gray" >#</th>
											<th class="center b_gray" ><?= str("name")?></th>
											<th colspan="2" class="center b_gray"><?= string("actions")?></th>
										</tr>
									</thead>
									<?php  $records = $data["records"]  ?>
									<tbody>
										<?php foreach ($records as $key => $rcrd): ?>
										<tr>
											<td><?= $key+1?></td>
											<td><a href="<?= url("'.$sub_folder.$c.'/".$rcrd["ID"])?>"><?= $rcrd["name"]?></a></td>
											<td class="center" >
												<!--<a class="label label-primary vsmall" href="<?= url("'.$c.'/".$rcrd["ID"])?>" target="_blank" > <?= string("view")?> </a>-->
												<a class="label label-primary vsmall" href="<?= url("'.$sub_folder.$c.'/".$rcrd["ID"])?>"> <?= string("update")?> </a>
												<a class="label label-danger vsmall confirm" href="<?= url("'.$sub_folder.$c.'/delete/".$rcrd["ID"])?>"> <?= string("delete")?> </a>
											</td>
										</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						<?php endif;?>

					</div>

					<?php if(!$data["records"] && !$data["theRecord"] && !$this->form ):?>
					<div class="alert alert-info" role="alert">
						<i class="fa fa-info-circle"></i> <?= string("no_data");?>
					</div>
				<?php endif;?>


				<!-- #forms	 -->
				<!-- add form -->
				<?php if($this->form == "add"):?>
				<form action="<?= url($this->formAction."do/add") ?>" method="post">
					<div class="form-group">
						<label for=""><?= string("name")?></label>
						<input type="text" name="name" placeholder = "name">
					</div>

					<div class="form-group">
						<label for=""><?= string("choose")?></label>
						<select name="part_id" >
							<?php // foreach ($variable as $key => $value):?>
							<?php $selected = ($record["part_id"] == $value["ID"]) ? "selected" : "" ?>
							<option value="" <?= $selected ?>></option>
							<?php //endforeach;?>
						</select>
					</div>

					<div class="form-group">
						<label for=""><?= string("content")?></label>
						<textarea name="content" id="" cols="30" rows="10" class="textareaX"></textarea>
					</div>

					<h5>
						<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("add")?></label>
						<input type="radio" name="page" id="page2" value="<?=url()."'.$sub_folder.$c.'"?>" > <label class="hand" for="page2"><?= str("add")?> + <?= str("back")?></label><br />
					</h5>
					<div>
						<button type="submit" name="'.$tbl.'btnAdd" value="'.$tbl.'btnAdd" class="btn btn-primary"><?= string("add")?></button>
					</div>
				</form>
			<?php endif ?>

			<!-- update form -->
			<?php if($this->form == "update"):?>
			<?php if ($data["theRecord"]): ?>
			<?php //pa($data["theRecord"]) ?>
			<?php $record = $data["theRecord"] ?>
			<form action="<?= url($this->formAction.$record["ID"]) ?>" method="post">
				<div class="form-group">
					<label for=""><?= string("name")?></label>
					<input type="text" name="name" value="<?= $record["name"]?>" >
				</div>

				<div class="form-group">
					<label for=""><?= string("choose")?></label>
					<select name="part_id" >
						<?php // foreach ($variable as $key => $value):?>
						<?php $selected = ($record["part_id"] == $value["ID"]) ? "selected" : "" ?>
						<option value="" <?= $selected ?>></option>
						<?php //endforeach;?>
					</select>
				</div>

				<div class="form-group">
					<label for=""><?= string("content")?></label>
					<textarea name="content" id="" cols="30" rows="10" class="textareaX"><?= $record["content"]?></textarea>
				</div>


				<h5>
					<input type="radio" name="page" id="page1" value="<?=page::url();?>"  checked >  <label class="hand" for="page1"><?= str("update")?></label>
					<input type="radio" name="page" id="page2" value="<?=url()."'.$sub_folder.$c.'"?>" > <label class="hand" for="page2"><?= str("update")?> + <?= str("back")?></label><br />
				</h5>

				<div>
					<button type="submit" name="'.$tbl.'btnUp" value="'.$tbl.'btnAdd" class="btn btn-primary"><?= string("update")?></button>
				</div>
			</form>
		<?php endif ?>

	<?php endif ?>

	<!-- show form | printable -->
	<?php if($this->form == "show"):?>
<?php endif ?>
</div>'; /* END Admin CURD*/

$view_content_CRUD_user = '<?php use M5\Library\Page; ?>
<?php use M5\Library\Session; ?>

<?php $records =  $data["records"]; ?>
<?php $record =  $data["theRecord"]; ?>
<?php //pa( $this ); ?>
<?php //pa( $data ); ?>
<?php //pa( $records ); ?>
<?php //pa( $record ); ?>

<div id="content">

	<div id="all">
		<?php if( $data["records"] ):?>
		all records here
	<?php endif; ?>
</div>

<?php if ($data["theRecord"]): ?>
	individual  record here
<?php endif;?>

<?php if( !$data && !$this->form ):?>
	<div class="alert alert-info" role="alert">
		<?= string("no_data");?>
	</div>
<?php endif;?>
</div>
'; /* END user CURD */



$view_content = ( $_GET['view_file_Flag'] == "blankFlag") ? $view_content_blank : $view_content_CRUD;
$view_content = ( $_GET['view_file_Flag'] == "CURDFlag_user") ? $view_content_CRUD_user : $view_content_CRUD;

if(! file_exists( Config::get('V_PATH').DS.$_view_path.".php") ){
	$myview = fopen( Config::get('V_PATH').DS.$_view_path.".php", "w");
	file_put_contents( Config::get('V_PATH').DS.$_view_path.".php",$view_content);
	pre($_view_path.".php Created",'','','#00F');
}else{
	pre( Config::get('V_PATH').DS.$_view_path."_view.php Existsed",'','','#f00');
}

}
}

}else{
	echo msg('Controller <b>'.$controllers_file.' </b>  Existsed!',"alert alert-danger",'ltr');
}

}
}

######################################################
# Views
############################################3

if($_GET['vBtn']){
	$path = V_PATH;
	$path = !$_GET['adminTmpl'] ?  $path : $path.'admin'.DS;

	if($_GET['cName']){
		$c = $_GET['cName'];
		if(!file_exists($path.DS.$c.'_view.php')){
			$content = '<div id="content">
		</div>
		';

		$myfile = fopen($path.DS.$c.'_view.php', "w");
		file_put_contents($path.DS.$c.'_view.php',$content);
		echo msg($c.' View Yeaned!','alert alert-success','ltr');

	}else{
		echo msg('View <i>'.$c.' </i>  Existsed!',"alert alert-danger",'ltr');
	}
}
}

######################################################
# Models
############################################3

if($_GET['mBtn']){
	$path = M_PATH;

	if($_GET['cName']){
		$c = $_GET['cName'];
		if(!file_exists($path.DS.$c.'_model.php')){
			$content = '<?php
			namespace M5\Models;
			use M5\MVC\Model as BaseModel;

			class '.ucfirst($c).'_model extends BaseModel
			{
				function __construct()
				{
					parent::__construct();

					/*code*/
				}

				private function schema()
				{
					$class = pure_class(__CLASS__);
					$sql = "
					CREATE TABLE IF NOT EXISTS $class
					(
					`id` INT( 11 )  AUTO_INCREMENT PRIMARY KEY ,

					`c_at` VARCHAR( 100 ),
					`u_at` VARCHAR( 100 )
					)
					";
					if(!$this->query($sql))
						die($this->DB->error);
				}
			}
			';

			$myfile = fopen($path.DS.$c."_model.php", "w");
			file_put_contents($path.DS.$c."_model.php",$content);
			echo msg(ucfirst($c).' Model Yeaned!','alert alert-success','ltr');

		}else{
			echo msg('Model <i>'.$c.' </i>  Existsed!',"alert alert-danger",'ltr');
		}
	}
}

?>
<br />
<div class="p480 auto_margin">
	<?php pa($_GET); ?>
	<form role="form">
		<input type="text" name="cName" class="form-control" placeholder="File name">
		<br><br>

		<input type="checkbox" name="adminTmpl2" id="adminTmpl2">
		<label for="adminTmpl2">use folder Template File</label><br>

		<input type="checkbox" name="routeFlag" id="routeFlag">
		<label for="routeFlag">include local route</label><br>

		<input type="checkbox" name="curd_func_Flag" id="curd_func_Flag">
		<label for="curd_func_Flag">include CURD Functions </label><br>
		<br><br>

		<input type="text" name="view_file" id="CURD_view_file" placeholder="CURD_view_file" class="form-control">
		<input type="radio" name="view_file_Flag"  value = "blankFlag" id="blankFlag" checked>
		<label for="blankFlag">include Blank View </label>

		<input type="radio" name="view_file_Flag" value="CURDFlag" id="CURDFlag" >
		<label for="CURDFlag">include admin-CURD view page </label>
		<br>

		<input type="radio" name="view_file_Flag" value="CURDFlag_user" id="CURDFlag_user" >
		<label for="CURDFlag_user">include user-CURD view page </label>
		<br>

		<small>Inside: <em><?= Config::get('V_PATH') ?></small></em>


		<hr>
		<div class="row">

			<div class="col-md-4">
				<input type="submit" name="mBtn" value="Create Model" class="btn btn-success">
			</div>

			<div class="col-md-4">
				<input type="submit" name="vBtn" value="Create View" class="btn btn-info"><br>
			</div>

			<div class="col-md-4">
				<input type="submit" name="cBtn" value="Create Controller" class="btn btn-primary"><br />
			</div>
		</div>

	</form>
	<div>
		<hr /> <a href="<?=url()?>">Home</a> </div>
	</div>
</body>

</html>