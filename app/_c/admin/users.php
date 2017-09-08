<?php 	namespace M5\Controllers\Admin;

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
use M5\Library\Hash;

/*use M5\Models\records_model;*/
use M5\MVC\Model;

class Users extends BaseController
{
	private $tbl = "users";
	private $class_label = "users";
	private $fail_page = "admin/users/do/add";
	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
		$this->data['anchor'] = '{"link":"admin/users/do/add","label":"'.string('add_new').'"}';

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
				$this->data["bread"] = Bread::create( [ str("users")=> "admin/users", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all($cond="");
		}

		// $this->add();

		/*view*/
		$this->getView()->template("admin/users_cp_view",$this->data,$templafolder="admin");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all(){
		$page = $_GET['page'];
		$offset = 30;
		$cond = " && is_admin = '3'";

		/* Search Filter */
		if ($_GET['q'] || $_GET['searchBtn']) {
			$query_string = Clean::sqlInjection($_GET['q']);
			$cond .= " &&  ( users.ID = '$query_string' || tel = '$query_string'   ) ";
			//bread ^^
			$title = str('search_result')." : ".$query_string;
			$this->data['title'] = $title;
			$this->data['bread'] = Bread::create( [string("users")=>"admin/users", $this->data['title']=>"#"],'' );
		}


		$r = $this->model->table([])->where($cond)
		->order(" c_at DESC ")
		->fetch(['page'=>[$page,$offset],  'offsetAll'=>"show All users", 'printQuery'=>null]);

		// $r = $this->model->table([])->fetch([]);
//		 pa($r);
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
		// pa($r);

		/*get images*/
		$record_folder = 'upload/'.$r['BETA'].'/';
		$images = lens::cornea($record_folder,url().$record_folder);

		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["name"];
		$this->data["bread"] = Bread::create( [str("users") => "admin/users", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id,$r);

	}

	/**
	 * show one record
	 *
	 * $id int record id
	 */
	private function show($id){
		$this->request->form = "show";
		$r = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);


		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["raadbname"];
		$this->data["bread"] = Bread::create( [str("records") =>"admin/records", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id,$r);

	}

	/**
	 * add new record
	 *
	 * $_POST[]
	 */
	private function add()
	{

		if($_POST["usersBtnAdd"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[1]);

			extract($_POST);
			/*clean post*/
			$BETA =   uniqid()  ;

//			 pa(0,1);

			Session::set("new_record_post",$_POST);

			/*clean post*/
			if (!$user || !$pass) {
				session::setWink('msg', msg('حقول الاسم وكلمة المرور الصلاحيات لايمكن ان تكون خاليه','alert alert-danger'));
				page::location($page);
				exit();
			}

			/* Check if repeated */
			if ($this->model->num_rows("", "&&  user= '$user' ")) {
				session::setWink('msg', msg($user . ' : ' . 'هذا الاسم موجود بالفعل ','alert alert-danger'));
				page::location($page);
				exit();
			}

			/* Records folder */
			$record_folder = 'upload/'.$BETA;
			if(!file_exists($record_folder)){
				mkdir($record_folder);
			}

			$BETA = uniqid();
			$pass = Hash::MD5($pass);

			$args = [
			"name" => $name,
			"user" => $user,
			"pass" => $pass,
			"BETA" => $BETA,
			"tel" => $tel,
			"about" => $place,
			"is_admin" => 3,
			];

			if($this->model->insert($args))
			{
				Session::setWink("msg", msg( string("add_success"),"alert alert-success f_green") );
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
	private function update($id,$r){

		if($_POST["usersBtnUp"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[2]);



			extract($_POST);

			// pa(0,1);
			/*clean post*/

			/*check un-repeat user*/
			if ($this->model->num_rows("", "&&  (user = '$user' && id != $id )" )) {
				session::setWink('msg', msg('هذا المستخدم <u>'.$user.'</u> موجود بالفعل. اختر مستخدماً آخر', 'alert alert-danger '));
				page::location($page);
				exit();
			}

			$pass = Hash::MD5($pass);

			$args = [
			"name"=>$name,
			"user"=>$user,
			"tel"=>$tel,
			"about"=>$place,

			];

			if($changePassFlag){
				$push = json_encode($args);
				$e = ',"pass":"'.$pass.'"}';
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

		$r = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);

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
