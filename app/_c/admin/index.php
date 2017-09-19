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
use M5\Library\Email;

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
		// 	session::set('adminName', "Ethical Hacker");
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

	/** * Main Function */
	public function index($params = []){

		/*local route*/
		$alpha = $params[0];
		$beta = $params[1];
		$gama = $params[2];

		if($alpha && $beta){
			if($alpha == "do"){
				$this->request->form = $beta;
				$this->$beta($gama);

				/*breadcrumb*/
				$this->data["title"] = string($beta);
				$this->data["bread"] = Bread::create( [ str("blogs")=> "admin/blogs", $this->data["title"]=>"#"] );
			}

		}

		$this->getView()->onePage('admin/login/login_cp_view',$this->data,'admin');

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

				$redirect =  !Session::get("redirect_again_to") ? 'admin/cp' : Session::get("redirect_again_to") ;

				Router::redirect( $redirect );
				Session::set("redirect_again_to",null);

			} else {
				$msg = pen::msg( str('login_fail_msg') );
				session::setWink("msg", $msg);
				Router::redirect( url('admin') );
			}

			echo $thid->model->DB->error;
		}
	}

	/**
	 * Return login data. send reset link.
	 *
	 * @return mixed
	 */
	public function forget() {

		$user = new \M5\Models\Users_Model('',true,__METHOD__);

		$forget_aproach = $user->getPref("forget_aproach");
		$this->request->forget_form = $forget_aproach;

		/*forget by email */
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $forget_aproach != "question")
		{
			extract($_POST);

			/* Check captcha*/
			captcha_ck("captcha",  " رمز التحقق البشري غير صحيح! " );

			/* Check email syntax*/
			if(!filter_var($email, FILTER_SANITIZE_EMAIL) ){
				$msg = pen::msg("صيغة الايميل غير صحيحة");
				echo $msg;
				die();
			}
			// $user->set("printQuery");

			/* mysql:  Fetch data by email*/
			$cond = " && email = '$email'";
			$r = $user->_one('',$cond);

			/* Check email */
			if(!$r['email']){
				echo $msg = pen::msg(string('forget_msg_fail'),'alert alert-danger _caps');
				die();
			}

			/* prepare forget item*/
			$rand = substr( md5(rand(100,99999999)),"0","10" );

			$temp_forget_args =
			[
			"name" => $email,
			"type" => "resetAdmin",
			"ava"  => $rand,
			"st"    => 0
			];
			if( $user->insert($temp_forget_args,"types",0))
			{

				/*Send activation link*/
				$subj = site_name." - ".string("reasign_admin_ttl");
				$reciver = $email;
				$sender = mail_from;
				$link = url()."admin/index/do/reset/$rand";
				$msg = $logo.'<div>مرحباً </div><br />';
				$msg .= '<div>اسم الدخول: '.$r['user'].'</div>';
				$msg .= '<div>'.string("reasign_admin_ttl").': </div>'.$link;
				$msg .= '<div><br /><hr>'.site_name.'</div>';
				$msg .= '<div>'.url().'</div>';

				if(Email::smtp($subj, $reciver, $sender, $msg) ){
					// echo $msg;
					echo $msg = pen::msg(string('forget_msg_success / '.$email),'_caps alert alert-info');
					Session::set("captcha",123);
				}


			}

		}else{
			/*forget by answer security question */

		}

	}


	/**
	 * Receive reset link
	 */
	public function reset($reset_string){

		$this->request->string = $reset_string;

		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			extract($_POST);
			$newPass = Clean::sqlInjection($pass);
			$reset_string = Clean::sqlInjection($reset_string);
			// ve($_POST);

			/* Check link string*/
			$link_cond = " && ava ='$reset_string'  ";

			if( ! $r_string = self::$login->selectOne("types",$link_cond,null) ){
				$msg = pen::msg("الرابط منتهي");
				echo $msg;
				die();
			}
			$email = $r_string['name'];

			/*Check password length*/
			if (mb_strlen($newPass) <= 4) {
				$msg = pen::msg("كلمة المرور قصيرة! ");
				echo $msg;
				die();
			}

			/* update password */
			$up_cond = " &&  email = '$email'";
			if(self::$login->update(["pass"=>Hash::md5($newPass)],$up_cond)){
				echo msg("تم اعادة تعيين كلمة المرور بنجاح!","alert-success alert");

				/* delete trash*/
				self::$login->query("DELETE FROM types WHERE name = '$email'");
				echo'<br />
				<a class="btn btn-primary" href="'.url('admin').'"> تسجيل الدخول </a>';

			}


		}
	}

}