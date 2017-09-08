<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;
use M5\Library\Pen;


/*use M5\Models\records_model;*/
use M5\MVC\Model;

class Query extends BaseController
{
	private $tbl = "records";
	private $class_label = "query";
	private $fail_page = "admin/query/do/add";
	function __construct()
	{
		parent::__construct();

		/*Hide menu ?*/
		// Session::set("menu",true);

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
		
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
				$this->data["bread"] = Bread::create( [ str("query")=> "admin/query", $this->data["title"]=>"#"] );
			}					

		}else{
			$this->all($cond="");
		}

		// $this->add();
		
		/*view*/
		$this->getView()->template("admin/query_cp_view",$this->data,$templafolder="admin");
	}

	
	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($cond=""){
		$page = $_GET['page'];
		$offset = 30;
		$cond = " ";




		/* Search Filter */
		if ($_GET['searchBtn']) {
			extract($_GET);
			/* vars */
			$nat          =  Clean::sqlInjection( $_GET['nat'] );
			$gender       =  Clean::sqlInjection( $_GET['gender'] );
			$marred       =  Clean::sqlInjection( $_GET['marred'] );
			$edu_level    =  Clean::sqlInjection( $_GET['edu_level'] );
			$certify      =  Clean::sqlInjection( $_GET['certify'] );
			$tribe        =  Clean::sqlInjection( $_GET['tribe'] );

			$query_string = Clean::sqlInjection($_GET['q']);
			$cond .= " &&  ( records.block_ID = '$query_string' || records.raadbname LIKE  '%".$query_string."%' ) ";


			/* Cond */
			$cond .= $nat          ? " && ( `nat` = '$nat' ) "             :  "" ;
			$cond .= $gender       ? " && ( `gender` = '$gender' ) "       :  "" ;
			$cond .= $marred       ? " && ( `marred` = '$marred' ) "       :  "" ;
			$cond .= $edu_level    ? " && ( `edu_level` = '$edu_level' ) " :  "" ;
			$cond .= $certify      ? " && ( `certify` = '$certify' ) "     :  "" ;
			$cond .= $tribe        ? " && ( `tribe` = '$tribe' ) "         :  "" ;


			//bread ^^
			$title = str('search_result')." : ".$query_string;
			$this->data['title'] = $title;
			$this->data['bread'] = Bread::create( [string("query")=>"admin/query", $this->data['title']=>"#"],'' );
		}


		$r = $this->model->table([])->where($cond)
		->order(" c_at DESC ")
		->fetch(['page'=>[$page,$offset],  'offsetAll'=>"show All records", 'printQuery'=>0]);

		// $r = $this->model->table([])->fetch([]);
		// pa($r);
		$this->data["records"] = $r["data"];
		$this->data["meta"] = $r['meta'];
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
		$this->data["bread"] = Bread::create( [str("query") =>"admin/query", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id);

	}

	/**
	 * show one record
	 *
	 * $id int record id
	 */
	private function show($id){
		$this->request->form = "show";
		$r = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);
				//$r = $this->model->_one($id);
		/*pa($r);*/
		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["raadbname"];
		$this->data["bread"] = Bread::create( [str("records") =>"admin/query", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id);

	}

	/**
	 * add new record
	 *
	 * $_POST[]
	 */
	private function add()
	{

		if($_POST["recordsbtnAdd"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[1]);

			extract($_POST);
			/*clean post*/
			$BETA = !$BETA ? uniqid() : $BETA;


			/* Check Block_ID  */
			$sql_ck = " SELECT * FROM records WHERE  1 && block_ID = '$block_ID' ";

			Session::set("new_record2_post",$_POST);

			if( !$this->model->query($sql_ck)->num_rows ){

				$msg = msg("(!) رقم الحصر الذي ادخلته لا يعود لبيان مدخل من قبل ",'alert alert-warning');
				Session::setWink("msg",$msg);
				Page::location( url( $this->fail_page) );
				die();
			}


			$birth = "$birth_h-$birth_m-$birth_d";

			$args = [
			"block_ID"=>$block_ID,
			"user_id"=>Session::get("login2"),
			"name" => $name,
			"relevance" => $relevance,
			"birth"   => $birth,
			"edu_level" => $edu_level,
			];


			if($this->model->insert($args))
			{
				Session::setWink("msg", msg( string("add_success"),"alert alert-success") );
				Session::end("new_record2_post");
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
	private function update($id){

		if($_POST["recordsbtnUp"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[2]);


			extract($_POST);
			/*clean post*/

			$args = [
			"name" => $name,
			"relevance" => $relevance,
			"birth"   => $birth,
			"edu_level" => $edu_level,
			];

			$birth = "$birth_h-$birth_m-$birth_d";

			if($birthflag){
				$push = json_encode($args);
				$e = ',"birth":"'.$birth.'"}';
				$t = str_replace('}', $e, $push);
				$args = Pen::json($t);
			}

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
		if( $this->model->delete(" && `ID` = '$id'") ){
			Session::setWink("msg", msg(string("delete_success"),"alert alert-info") );
			Page::location($page);
			die();
		}

	}
}
