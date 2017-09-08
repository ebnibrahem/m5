<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

use M5\Models\Tree_Model;
/*use M5\MVC\Model;*/

class Categories extends BaseController
{
	private $tbl = "categories";
	private $class_label = "categories";

	function __construct()
	{
		parent::__construct();
		$this->request->formAction = "categories/";

		$this->model = new Tree_Model($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
						//$this->data['anchor'] = '{"link":"categories/do/add","label":"'.string('add_new').'"}';

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
				$this->data["bread"] = Bread::create( [ str("categories")=> "categories", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all($cond="");
		}

		/*view*/
		$this->getView()->template("categories/categories_view",$this->data,$templafolder="");
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
		$this->data["bread"] = Bread::create( [str("categories")=>"categories", $this->data["title"]=>"#"] );

				//seo
		$this->request->SEO = $r["name"];
		$this->request->SEO_DESC = clean::sqlInjection($r["content"]);
		$this->request->SEO_IMG = $r["ava"];

		/*related ads*/
		$cond = " && (ID != '$id' && part_id = '{$r["part_id"]}' )";
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
		if($_POST["categoriesbtnAdd"]){
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
}
