<?php 	namespace M5\Controllers\Admin;

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

		$this->request->editor = true;

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
		$this->data['anchor'] = '{"link":"admin/pages/do/add","label":"'.string('add_new').'"}';

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
				$this->data["bread"] = Bread::create( [ str("pages")=> "admin/pages", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all($cond="");
		}

		/*view*/
		$this->getView()->template("pages/pages_cp_view",$this->data,$templafolder="admin/");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($cond=""){
		// $this->model->set("printQuery");
		$r = $this->model->table([])->where(" && type = 'page'")->fetch([]);
		//$r = $this->model->_all();
		// pa($r);
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
		$this->data["bread"] = Bread::create( [str("pages")=>"admin/pages", $this->data["title"]=>"#"] );

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
		if($_POST["pagesbtnAdd"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[1]);

			// pa(0,1);
			extract($_POST);
			/*clean post*/

			$slug = trim($slug,"/");

			$args = [
			"name"=>$name,
			"slug"=>$slug,
			"content"=>$content,
			"st"=>$st,
			"tags"=>$tags,

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

		if($_POST["pagesbtnUp"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[2]);

			$r = $r;


			extract($_POST);
			// pa(0,1);
			/*clean post*/

			$slug = trim($slug,"/");

			$args = [
			"name"=>$name,
			"slug"=>$slug,
			"content"=>$content,
			"tags"=>$tags,
			"st"=>$st,
			];

			if($this->model->update($args," && `ID` = '$id' "))
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

		$page = url("admin/".pure_class(__CLASS__));
		if( $this->model->delete(" && `ID` = '$id' ") ){
			Page::location($page);
			die();
		}

	}
}
