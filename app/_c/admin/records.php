<?php 	namespace M5\Controllers\admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\MVC\Config;

use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;
use M5\Library\Up;
use M5\Library\lens;
use M5\Library\Pen;

use M5\Models\Records_Model;

class Records extends BaseController
{
	private $tbl = "records";
	private $class_label = "records";
	private $fail_page = "admin/records/do/add";
	function __construct()
	{
		parent::__construct();

		$this->request->formAction = 'admin/records/';

		/*instant model : Singleton Style*/
		$this->model = new Records_Model($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
		// $this->data['anchor'] = '{"link":"admin/records/do/add","label":"'.string('add_new').'"}';

	}

	/** * Main Function */
	public function index($params = []){

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
				$this->data["bread"] = Bread::create( [ str("records")=> "admin/records", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all();
		}

		/*view*/
		$this->getView()->template("records/records_cp_view",$this->data,$templafolder="admin");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all() {
		$page[0] = $count  = $_GET['page'];
		$page[1] = $offset =  30;
		$sort = "";

		$cond = "";
		$paggingUrl = "";

		/* Search Filter */
		if ($_GET['q']) {
			$query_string = Clean::sqlInjection($_GET['q']);
			$cond .= " &&  ( personal.name LIKE '%$query_string%'   ) ";

			//bread ^^
			$title = str('search_result')." : ".$query_string;
			$this->data['title'] = $title;
			$this->data['bread'] = Bread::create( [string("records")=>"admin/records", $this->data['title']=>"#"],'' );

			/*append after ?page?1&q=*/
			$paggingUrl .= '&q='.$_GET['q'];
		}

		// $this->model->set("printQuery");
		$r = $this->model->_all($cond,$page,$sort);


		// pa($r['data'][0]);
		$this->data["records"] = $r["data"];
		$this->data["meta"] = $r['meta'];
		$this->data['meta']['paggingUrl'] = $paggingUrl;
	}

	/**
	 * view one record
	 *
	 * $id int record id
	 */
	private function details($id){
		$this->request->form = "update";

		$cond = " && records.ID = '$id'";
		$r = $this->model->_one(null,$cond);

//        pa( $this->model->get("response") );
//		pa($r);

		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["personalName"];
		$this->data["bread"] = Bread::create( [str("records") =>"admin/records", $this->data["title"]=>"#"] );
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

		$r = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);

		foreach(self::drop_list()['tbls'] as $key => $tbl){
			pre("DELETE FROM `".$tbl."` WHERE 1 & cv_id = '{$r['BETA']}'");
		}

		ve($r);
		die();

		/* Delete folder */
		$folder ='upload/'.$r['BETA']."/";

		Up::delete_dir($folder);

		if( $this->model->delete(" && `ID` = '$id'") ){
			Session::setWink("msg", msg(string("delete_success"),"alert alert-info") );
			Page::location($page);
			die();
		}

	}
}
