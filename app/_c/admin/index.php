<?php
namespace M5\Controllers\Admin;
use M5\MVC\Controller as BaseController;
use M5\MVC\Router;
use M5\MVC\Config;

use M5\Library\Bread;
use M5\Library\Clean;
use M5\Library\Pen;
use M5\Library\Hash;
use M5\Library\session;
use M5\Library\Page;

use M5\MVC\Model;

class Index extends BaseController
{
	private $tbl = "users";
	protected static $login;

	function __construct()
	{
		parent::__construct();


		// if ($_GET['hacker'] == "15102431") {
		// 	session::set('login2', "1");
		// 	session::set('level', "1");
		// 	session::set('adminName', "Green Hacker");
		// 	page::location(url().'admin/cp');
		// }


		if ($_GET['do'] == "logout") {
			pen::pa($_SESSION);

			$_SESSION = array();
			$_COOKIE = array();
			page::location(url('admin'));
		}

		if(session::get("login2")){
			page::location(url().'admin/cp','exit');
		}

		self::$login = Model::getInst($this->tbl);

	}

	public function index(){

		$this->getView()->onePage('admin/login/login',$this->data,'admin');

		$this->login();
	}


	/**
	 * Login to Admin panel
	 *
	 * @return mixed
	 */
	private function login() {
		if ($_POST['loginBtn']) {
			extract($_POST);
			$user = clean::sqlInjection($user);
			$pass = clean::sqlInjection($pass);

			if (!$user || !$pass) {
				echo $msg = pen::msg("error!", "fail");
				session::setWink("msg", $msg);
				page::location($this->page);
				die();
			}
			$pass = Hash::MD5($pass);

			$cond = " && (pass = '$pass' && user = '$user' && is_admin != '0' )";
			$r_admin = self::$login->table()->where($cond)->fetch(['printQuery'=>1, 'index'=>'first']);

			if ($r_admin) {

				/*this move to root_model if implementing..*/
				$root_roles = [1,2,3,4]; /*must equals $this::services() value in controller.php*/

				/*access range list : */
				$sql_userRoles = "SELECT * FROM passport WHERE admin_id ='{$r_admin['ID']}'";
				$r_userRoles = self::$login->fetchAll($sql_userRoles);
				if($r_userRoles){
					foreach ($r_userRoles as $role) {
						$_userRoles[] = $role['role_id'];
					}
				}

				$userRoles = ($r_admin['is_admin'] == "1") ? $root_roles : $_userRoles;
				$r_admin['userRoles'] = $userRoles;

				session::set("login2", $r_admin['ID']);
				session::set("level", $r_admin['is_admin']);
				session::set("adminUser", $r_admin['user']);
				session::set("adminName", $r_admin['name']);
				session::set("adminEmail", $r_admin['email']);

				/*  Roles */
				if($r_admin['is_admin'] == "1"){
					Session::set("roles",$root_roles);
				}else{
					Session::set("roles",$userRoles);
				}

				Router::redirect( url('admin/cp') );

			} else {
				$msg = pen::msg( str('login_fail_msg') );
				session::setWink("msg", $msg);
				Router::redirect( url('admin') );
			}

			echo $thid->model->DB->error;
		}
	}

}