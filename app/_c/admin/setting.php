<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

use M5\MVC\Model;

class Setting extends BaseController
{
	private $tbl = "preferences";
	private $class_label = "setting";

	function __construct()
	{
		parent::__construct();
		$this->request->formAction = "admin/setting/";

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );

	}

	/** * Main Function */
	public function index($params = [])
	{

		$this->customize();

		/*view*/
		$this->getView()->template("admin/setting_cp_view",$this->data,$templafolder="admin/");
	}

	/* Set cusomize values*/
	private function customize()
	{
		/*forget_aproach*/
		$this->data['forget_aproach'] = $this->model->getPref("forget_aproach");
		if($_POST['forget_aproachBtnAdd']){
			extract($_POST);
			// pa(0,1);

			$forget_aproach  = $forget_aproach;
			$this->model->setPref("forget_aproach",$forget_aproach);
			page::location($page);
		}

	}


}
