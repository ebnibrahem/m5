<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

use M5\MVC\Model;

class Pages extends BaseController
{
	private $tbl = "pages";
	private $class_label = "pages";

	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );

	}

	/** * Main Function */
	public function index($params = [])
	{

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
				$this->data["bread"] = Bread::create( [ str("pages")=> "pages", $this->data["title"]=>"#"],null );
			}

		}else{
			$this->all($cond="");
		}

		/*view*/
		$this->getView()->template("pages/pages_view",$this->data,$templafolder="");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($cond=""){
		$r = $this->model->table([])->where(" && type = 'page'")->fetch([]);
				//$r = $this->model->_all();
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
		// $this->model->set("printQuery");
		$r = $this->model->table()->where(" && slug = '$id' ")->fetch(["index"=>"first"]);
				//$r = $this->model->_one($id);
		/*pa($r);*/
		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["name"];
		$this->data["bread"] = Bread::create( [str("pages")=>"pages", $this->data["title"]=>"#"],null );

				//seo
		$this->request->SEO = $r["tags"];
		$this->request->SEO_DESC = clean::sqlInjection($r["content"]);
		$this->request->SEO_IMG = LOGO;
	}


}
