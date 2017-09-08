<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

/*use M5\Models\statistic_model;*/
use M5\MVC\Model;

class Statistic extends BaseController
{
	private $tbl = "statistic";
	private $class_label = "statistic";
	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		$this->request->COLOR = $this->COLOR;

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );

	}

	/** * Main Function */
	public function index($params = []){

		/*view*/
		$this->getView()->template("admin/statistic_cp_view",$this->data,$templafolder="admin");
	}


}
