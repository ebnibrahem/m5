<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Auth;
use M5\Library\Pen;
use M5\Library\Hash;

/*use M5\Models\root_model;*/
use M5\MVC\Model;

class Root extends BaseController
{
	private $tbl = "users";
	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str(pure_class(__CLASS__));
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );
		$this->data['anchor'] = '{"link":"admin/root/do/add","label":"'.string('add_new').'"}';

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

				/*bread*/
				$this->data["title"] = string($beta);
				$this->data["bread"] = Bread::create( [ str("root")=> "admin/root", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all($count="",$cond="",$offset=30);
		}

		$this->add();

		/*view*/
		$this->getView()->template("admin/root_cp_view.php",$this->data,$templafolder="admin");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all(){
		$page = $_GET['page'];
		$offset = 30;
		$cond = " && is_admin IN (1,2) ";

		/* Search Filter */
		if ($_GET['q'] || $_GET['searchBtn']) {
			$query_string = Clean::sqlInjection($_GET['q']);
			$cond .= " &&  ( records.ref_id = '$query_string'   ) ";
			//bread ^^
			$title = str('search_result')." : ".$query_string;
			$this->data['title'] = $title;
			$this->data['bread'] = Bread::create( [string("records")=>"admin/records", $this->data['title']=>"#"],'' );
		}


		$r = $this->model->table([])->where($cond)
		->order(" c_at DESC ")
		->fetch(['page'=>[$page,$offset],  'offsetAll'=>"show All records", 'printQuery'=>null]);

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
		$r_admin = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);
				//$r = $this->model->_one($id);
		/*pa($r);*/

		/*this move to root_model if implementing..*/

		$root_roles = [1,2,3,4]; /*must equals $this::services() value in controller.php*/

		/*access range list : */
		$sql_userRoles = "SELECT * FROM passport WHERE admin_id ='{$r_admin['ID']}'";
		$r_userRoles = $this->model->fetchAll($sql_userRoles);
		if($r_userRoles){
			foreach ($r_userRoles as $role) {
				$_userRoles[] = $role['role_id'];
			}
		}
		$userRoles = ($r_admin['is_admin'] == "1") ? $root_roles : $_userRoles;
		$r_admin['userRoles'] = $userRoles;

		$this->data["theRecord"] = $r_admin;

		/*bread*/
		$this->data["title"] = $r_admin["name"];
		$this->data["bread"] = Bread::create( [str("root") => "admin/root", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id);

	}

	/**
	 * add new record
	 *
	 * $_POST[]
	 */
	private function add(){
		if($_POST["rootBtnAdd"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[1]);

			$page = !$page ? url('admin/root/do/add') : '';

			// pa(0,1);

			extract($_POST);
			/*clean post*/
			if (!$user || !$pass || !$email || !$roles) {
				session::setWink('msg', msg('حقول الاسم وكلمة المرور الصلاحيات لايمكن ان تكون خاليه','f_yellow'));
				page::location($page);
				exit();
			}

			/* Check if repeated */
			if ($this->model->num_rows("", "&&  user= '$user' ")) {
				session::setWink('msg', msg($user . ' : ' . 'هذا الاسم موجود بالفعل ','f_yellow'));
				page::location($page);
				exit();
			}

			$BETA = uniqid();
			$pass = Hash::MD5($pass);

			$args = [
			"name" => $name,
			"user" => $user,
			"pass" => $pass,
			"BETA" => $BETA,
			"email" => $email,
			"about" => $about,
			"is_admin" => 2,
			];

			if($this->model->insert($args))
			{
				/*grant access*/
				$user = $this->model->table()->where(" && BETA = '$BETA'")->fetch(['index'=>"first"]);
				$user_id = $user['ID'];

				foreach ($roles as $role) {
					$role_id = $role;
					$SQL_PASSPORT = "INSERT INTO `passport` (admin_id,role_id) VALUES ('$user_id','$role') ";
					$this->model->query($SQL_PASSPORT);
				}

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
	private function update($id){

		if($_POST["rootBtnUp"]){
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

			/*check un-repeat email*/
			if ($this->model->num_rows("", "&&  (email = '$email' && id != $id )" )) {
				session::set('msg', msg('هذا البريد <u>'.$email.'</u> موجود بالفعل. اختر بريداً آخر', 'alert alert-danger '));
				page::location($page);
				exit();
			}

			$pass = Hash::MD5($pass);

			$args = [
			"name"=>$name,
			"user"=>$user,
			"email"=>$email,
			"about"=>$about,
			// "is_admin"=>2,

			];

			if($changePassFlag){
				$push = json_encode($args);
				$e = ',"pass":"'.$pass.'"}';
				$t = str_replace('}', $e, $push);
				$args = Pen::json($t);
			}


			if($this->model->update($args," && `ID` = '$id' "))
			{

				/*reRole*/
				if($reRoleFlag && $reRole){
				//delete old role + reAsign new
					$this->model->query("DELETE FROM passport WHERE admin_id = '$id'");
				//grant access
					pa($reRole);

					foreach ($reRole as $role) {
						$role_id = $role;
						$SQL_PASSPORT = "INSERT INTO `passport` (admin_id,role_id) VALUES ('$id','$role') ";
						$this->model->query($SQL_PASSPORT);
					}
				}


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

		$page = url(pure_class(__CLASS__));
		if( $this->model->delete($id) ){
			\page::location($page);
			die();
		}

	}
}
