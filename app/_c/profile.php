<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;
use M5\Library\Hash;
use M5\Library\Pen;

use M5\Models\users_Model;
/*use M5\MVC\Model;*/

class Profile extends BaseController
{
	private $tbl = "users";
	private $class_label = "profile";

	function __construct()
	{
		parent::__construct();
		$this->request->formAction = "profile/";

		$this->model = new users_Model($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );

	}

	/** * Main Function */
	public function index($params = [])
	{

		$this->details();

		/*view*/
		$this->getView()->template("profile/profile_view.php",$this->data,$templafolder="");
	}

	private function details()
	{
		$user_id = Session::get("userID");

		$r = $this->model->_one($user_id);

		$this->data['theRecord'] = $r;

		/* update btn lisener*/
		$this->update($id,$r);
	}

	/**
	 * Update user data
	 *
	 * @param  int $id
	 * @param  array $r
	 * @return @mixed
	 */
	private function update($id,$r)
	{
		if($_POST['userBtnUp']){
			extract($_POST);
			pa($r);

			$user_id = Session::get("userID");

			/* ck captcha V1.1 */
			// $captcha_ck_value = captcha_ck("captcha",null,null);

			// if(!$captcha_ck_value){
			// 	$msg = msg("رمز التحقق البشري غير صحيح",'alert alert-danger ');
			// 	Session::setWink("msg",$msg);
			// 	page::location($page);
			// 	die();
			// }



			$pass = Hash::MD5($pass);
			$old_password = Hash::MD5($old_password);

			// pre($old_password . "<br/>" . $r['pass']);
			// die();

			if($old_password != $r['pass']){
				$msg = msg(" كلمة المرور القديمة خاطئة ",'alert alert-danger ');
				Session::setWink("msg",$msg);
				page::location($page);
				die();
			}


			$args = [
			"name"=>$name,
			];

			if($changePassFlag && $pass){
				$push = json_encode($args);
				$e = ',"pass":"'.$pass.'"}';
				$t = str_replace('}', $e, $push);
				$args = Pen::json($t);
			}

			if( $this->model->update($args,$user_id,0,1))
			{
				Session::setWink("userName",$name);
				session::setWink('msg', msg('تم تحديث البيانات بنجاح', 'alert alert-info '));
				page::location($page);
				die();
			}


		}
	}


}
