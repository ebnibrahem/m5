<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

use M5\MVC\Model;

class Theme extends BaseController
{
	private $tbl = "preferences";
	private $class_label = "theme";

	function __construct()
	{
		parent::__construct();
		$this->request->formAction = "admin/theme/";

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
						//$this->data['anchor'] = '{"link":"admin/theme/do/add","label":"'.string('add_new').'"}';

	}

	/** * Main Function */
	public function index($params = [])
	{

		/*local route*/
		$alpha = $params[0];
		$beta = $params[1];
		$gama = $params[2];


		$this->add();


		/*view*/
		$this->getView()->template("admin/theme_cp_view",$this->data,$templafolder="admin/");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($cond=""){
		$r = $this->model->table([])->fetch([]);
				//$r = $this->model->_all();
		/*pa($r);*/
		$this->data["records"] = $r["data"];
	}



	/**
	 * add new record
	 *
	 * $_POST[]
	 */
	private function add(){
		if($_POST['bgBtnAdd']){
			extract($_POST);
			// pa(0,1);

			$bg  = $content;
			$this->model->setPref("bg",$bg);
			page::location($page);

		}

		if($_POST['main_colorBtnAdd']){
			extract($_POST);
			// pa(0,1);

			$main_color  = $content;
			$this->model->setPref("main_color",$main_color);
			page::location($page);

		}

		$this->data['bg'] = $this->model->getPref("bg");
		$this->data['main_color'] = $this->model->getPref("main_color");

	}
}
