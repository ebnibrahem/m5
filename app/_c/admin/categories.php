<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Pen;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

/*use M5\Models\categories_model;*/
use M5\MVC\Model;

class Categories extends BaseController
{
	private $tbl = "tree";
	private $class_label = "categories";
	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );

	}

	/** * Main Function */
	public function index($Params = []){

		/*local route*/
		$alfa = $Params[0];
		$beta = $Params[1];
		$gama = $Params[2];

		if($alfa && !$beta){
			$this->details($alfa);

		}elseif($alfa && $beta){
			if($alfa == "do"){
				$this->request->form = $beta;
				$this->$beta($gama);

				/*breadcrumb*/
				$this->data["title"] = string($beta);
				$this->data["bread"] = Bread::create( [ str("categories")=> "admin/categories", $this->data["title"]=>"#"] );
			}

		}

		$this->add();

		/*view*/
		$this->getView()->template("categories/categories_cp_view",$this->data,$templafolder="admin");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($count="",$cond="",$offset=30){
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


		/* part childs-parts */
		if($r['rank'] == "parent"){
			$r['childs'] = true;
			$cond = " && parent = '{$r['ID']}' ";
			$childs = $this->model->table()->where($cond)->fetch()['data'];
		}
		$this->request->is_parent = isset( $childs ) ? $r['name'] : null;

		$this->data["theRecord"] = $r;

		$this->data["records"] = $childs;

		/*bread*/
		$this->data["title"] = $r["name"];
		$this->data["bread"] = Bread::create( [ str("categories") =>"admin/categories", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id);

	}

	/**
	 * add new record
	 *
	 * $_POST[]
	 */
	private function add(){

		if($_POST['categoriesbtnAdd']){
			extract($_POST);

			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[1]);

	// 		pa(0,1);


			$parent = $rank == "parent" ? "0" : $parent;

			if(!$name){
				$msg = pen::msg("الاسم لايمكن ان يكون خالي");
				session::setWink("msg",$msg);
				page::location($page);
				die();
			}

			if($this->model->select("tree"," &&  (name = '$name' && type ='part' && `rank` != 'child') ")){
				Session::setWink("msg", msg("هذا القسم <em>".$name."</em>  موجود") );
				page::location($page,"1");
			}else{
				$BETA = uniqid();

				$_args = [
				"name" => $name,
				"_desc" => $_desc,
				"rank" => $rank,
				"parent" => $parent,
				"ava" => $ava,
				"st" => 1,
				"BETA" => $BETA,
				];

				//pa($_args,1);

				if($this->model->insert($_args)){
					page::location($page);
				}else{
					echo $this->model->DB->error;
				}
			}
		}

	}

	/**
	 * update one|more record
	 *
	 * $id int record id
	 */
	private function update($id){

		if($_POST["categoriesbtnUp"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[2]);


			extract($_POST);
			// pa(0,1);
			/*clean post*/
			$parent = $rank == "parent" ? "0" : $parent;

			/* When category set as child of itself */
			if($id == $parent){
				Session::setWink("msg", msg(string("category_set_as_child_of_itself"),"alert alert-danger") );
				page::location($page);
				die();
			}

			$_args = [
			"name"=>$name,
			"_desc" => $_desc,
			"rank" => $rank,
			"parent" => $parent,
			"ava" => $ava,
			"u_at" => R_DATE_LONG,

			];

			// pa($_args,1);

			if($this->model->update($_args," && `ID` = '$id' "))
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

			$page = url("admin/pure_class(__CLASS__)");
			if( $this->model->delete($id) ){
				Page::location($page);
				die();
			}

		}
	}
