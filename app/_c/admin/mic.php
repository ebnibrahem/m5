<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Config;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Auth;
use M5\Library\Clean;
use M5\Library\Up;

/*use M5\Models\mic_model;*/
use M5\MVC\Model;

class Mic extends BaseController
{
	private $tbl = "mic";
	Const FILES_PATH = "assets/images/";
	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str(pure_class(__CLASS__));
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );

	}

	/** * Main Function */
	public function index(){

		$this->details();
		$this->update();

		/*view*/
		$this->getView()->template("admin/mic_cp_view.php",$this->data,$templafolder="admin");
	}


	private function details(){
		$r = $this->model->table()->fetch( ['index'=>'first'] );
		$this->data['record'] = $r;
	}


	private function update(){
		if($_POST['micUpdateBtn']){
			extract($_POST);
			// pa();

			$mic_args = [
			"name"        =>  $name,
			"description" =>  $description,
			"keywords"    =>  $keywords,
			"email"       =>  $email,
			"tel"       =>  $tel,
			];


			if($_FILES['logo']['name'][0] && $changeLogoFlag){
				pa( $_FILES['logo']['name']);

				$file = $_FILES['logo']['name'][0];
				$url = $_FILES['logo']['tmp_name'][0];
				$type = @getimagesize($url);

				if($type['mime'] != "image/png")
					die("<h2>Please select PNG Format!! [ <em>{$type['mime']} </em>] Not Supported");

				$files_path = Mic::FILES_PATH;
				$args = ["path"=>$files_path, "inputname"=>"logo", "rename"=>"logo" ];

				if(!Up::load($args))
					die(' Not Changes LOGO');

				Session::set("rand_id",uniqid() );

				$msg = msg(str("change")." ".str("logo"),"alert alert-info");
				Session::setWink("msg",$msg);

				page::location( url('admin/mic'),"die" );
			}

			if($this->model->update($mic_args," && 1 = 1 ",null,'1')){
				page::location( url('admin/mic') );
			}else{
				echo
				$this->model->error();
			}
			// pa('','eeeee');
		}
	}


}
