<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;

use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Pen;
use M5\Library\Hash;
use M5\Library\Tools;
use M5\Library\Email;

class Forms extends BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->model = \M5\MVC\Model::getInst();

		$this->msg_join = "تهانينا تم التسجيل بنجاح.";
		$this->msg_email = "شكراّ لتواصلك معنا <br /> سيتم الرد عليك في اقرب وقت ممكن";

	}

	/** * Main Function */
	public function index(){}


	/**
	* check field id repeated on focus out
	* @return boolen | String
	*/
	public function checkFildes()
	{
		if($_POST){
			extract($_POST);
			/* pa($_POST,"e");*/

			$fld = clean::sqlInjection($fld);
			$val = clean::sqlInjection($val);

			$sql = "SELECT  $fld FROM users WHERE $fld = '$val' ";

			if($this->model->TOTAL($sql) > 0){
				if($fld =="email")
					echo '<small class="ajaxing f_red"><i class="fa fa-remove"><i></small>';
				else
					echo '<small class="ajaxing f_red"><i class="fa fa-remove"><i></small>';
			}
			else
				echo '<small class="ajaxing f_green"><i class="fa fa-check"><i></small>';
		}
	}

	/**
	* callus
	* @type mixed
	*/
	public function callus($param=null){

		if( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
			extract($_POST);
			//pen::pa($_POST);

			captcha_ck("captcha","<h4 style='color:#F00' class='alert alert-danger'> رمز التحقق البشري غير صحيح! </h4>");


			$subject = clean::blind($subject);
			$name = clean::blind($name);
			$message = clean::blind($msg);

			if(!filter_var($email, FILTER_SANITIZE_EMAIL) ){
				$msg = pen::msg("صيغة الايميل غير صحيحة");
				echo $msg;
				die();
			}

			if(!$message){
				$msg = pen::msg("نسيت كتابه المحتوى!");
				echo $msg;
				die();
			}

			$subj = site_name." - $subject";
			$sender = $mail_from;
			$reciver = mail_from;
			$msg = '<center><img src="'.LOGO.'" alt = "logo" /></center><br />';
			$msg .= '<div>المرسل : '.$email.' '.IP.'</div>';
			$msg .= '<div>الموضوع : '.$subject.'</div>';
			$msg .= '<div>رسالة من الموقع </div><hr /><br />';
			$msg .= $message;

			$GLOBALS['email_set_addReplyTo'] = "ebnibrahem@gmail.com";

			if(Email::smtp($subj, $reciver, $sender, $msg)){
				$success = pen::msg("تم استلام رسالتك. سيتم الرد عليك في اقرب وقت ممكن!","alert alert-success");
				echo $success;
				session::set("captcha","123");
			}
		}

	}


	/**
	 * [join] to register
	 * @return [successed] [send activation code to email]
	 */
	public function join()
	{

		/* pa($_SESSION,"e");*/

		if($_POST){
			extract($_POST);
			// pa();

			script('$("html, body").animate({
				scrollTop: 0
			}, 700)',1);

			captcha_ck("captcha","<h4 style='color:#F00' class='alert alert-danger'> رمز التحقق البشري غير صحيح! </h4>");

			$name = clean::sqlInjection($name);
			$email = clean::sqlInjection($email);
			$pass = clean::sqlInjection($pass);

			$statusValue = 1;

			if(!$name){ $error = '<div>full name</div>'; }
			if(!$pass){   $error .= '<div>password</div>'; }

			if($error){
				$msg = pen::msg( str("required") .$error );
				echo $msg;
				die();
			}

			if(!filter_var($email, FILTER_SANITIZE_EMAIL)){
				$msg = pen::msg("صيغة الايميل خاطئة");
				echo $msg;
				die();
			}

			if (mb_strlen($pass) <= 4) {
				$msg = pen::msg("كلمة المرور قصيرة");
				echo $msg;
				die();
			}

			$sql = "SELECT * FROM users WHERE email = '$email' ";

			if($this->model->total($sql)){
				$msg = pen::msg("اسم الدخول او البريد الالكتروني موجود مسبقاً");
				echo $msg;
				die();
			}

			$password = Hash::MD5($pass);

			$BETA = Hash::MD5( rand(0,9999999999) );
			$r_date = R_DATE_LONG;

			$ip = IP;
			$countryName = Tools::Geo()['geoplugin_countryName'];

			$args = [
			"BETA"=>$BETA,
			"ip"=>$ip,
			"country"=>$countryName,
			"name"=>$name,
			"user"=>$user,
			"pass"=>$password,
			"email"=>$email,
			"tel"=>$tel,
			"st"=>1,
			];

			// pa($args);

			if($this->model->insert($args,"users")){
				/*get user*/
				$r_user = $this->model->selectOne("users","&& BETA = '$BETA'");

				// pa($r_user);

				$name = $r_user['user'];
				$ID = $r_user['ID'];


				$logo = '<div align="center"> <img src="'.LOGO.'" width="100" alt="'.site_name.'"> </div<br />';

				/*send activation link if joinStyle == "2"*/
				$subj = site_name." - مرحبا بكم ";
				$reciver = $email;
				$sender = "";
				$link = site."account/";
				$msg = $logo.'<div>'.site_name.'</div><br />';
				$msg .= '<div><br /> <hr /> '.site_name.'</div>';
				$msg .= '<div> '.url().' </div>';
				$msg .= '<div>'.site_email.'</div>';

				$msg .= "IP ".IP ;

				/* echo $msg;*/
				$successMsg = msg( $this->msg_join ,"alert alert-success");
				echo $successMsg;

				/*notify admin*/
				$notifications = "عضو جديد! $name ";
				$url = url()."admin/users/".$ID;

				/*email*/
				$alert_args['email']  = $email;
				$alert_args['subj']   = $subj;
				$alert_args['msg']    = $msg;

				parent::sendAlert('admin','user',$url,$notifications,null);

				echo '<img src="'.url('app/_v/human.php').'" alt="captcha" class="hide">';

				die();

			}else{
				echo msg( "Fatal Error (SQL):".$this->model->error() );
			}
		}
	}

	/**
	 * [forget] user forget data
	 *
	 * @return [string] [send message to email]
	 */
	public function forget()
	{

		if($_POST){
			extract($_POST);
			// pen::pa($_POST);

			script('$("html, body").animate({
				scrollTop: 0
			}, 700)',1);

			captcha_ck("captcha","<h4 style='color:#F00' class='alert alert-danger'> رمز التحقق البشري غير صحيح! </h4>");

			$email = clean::sqlInjection($email);

			$login_cond = " && (email = '$email')";
			$r_login = $this->model->selectOne("users",$login_cond);

			/* Check email */
			if(!$r_login){
				$msg = pen::msg("عذراً! هذا الايميل لا يعود لمستخدم مسجل بالفعل ");
				echo $msg;
				die();
			}

			/* Send activation code */
			$rand = substr( md5(rand(100,99999999)),"0","10" );

			$forget_args =
			[
			"name" => $email,
			"type" => $reset,
			"ava"  => $rand
			];
			if($this->model->insert($forget_args,"types")){

				$logo = '<div align="center"> <img src="'.LOGO.'" width="100" alt="'.site_name.'"> </div> <br />';

				/*send activation link*/
				$subj = site_name." اعادة تعيين كلمة المرور";
				$reciver = $email;
				echo				$sender = site_email;
				$link = url()."account?tab=reset&code=$rand";
				$msg = $logo.'<div>السلام عليكم ورحمة الله وبركاته</div><br />';
				$msg .= '<div>لاعادة تعيين كلمة المرور اضغط الرابط التالي : </div>'.$link;
				$msg .= '<div style="font-size=small"><hr />نرجو تجاهل هذه الرسالة ان لم تقم بطلب استرجاع كلمة المرور</div>';
				$msg .= '<div><br /> <hr /> شكراّ  </div>';
				$msg .= '<div>'.site_name.'</div>';
				$msg .= '<div>'.url().'</div>';

				$msg .= "".IP;

				Email::smtp($subj, $reciver, $sender, $msg);

				// echo $msg;
				$msg = pen::msg("تم ارسال الرابط! راجع $email لاكمال عملية اعادة التعيين","alert alert-info");
				echo $msg;

				echo '<img src="'.url('app/_v/human.php').'" alt="captcha" class="hide">';

				die();
			}



		}

	}

	/**
	 * [forget] user forget data
	 *
	 * @return [string] [send message to email]
	 */
	public function reset($code)
	{

		if($_POST){
			extract($_POST);
			// pen::pa($_POST);

			script('$("html, body").animate({
				scrollTop: 0
			}, 700)',1);

			$code = clean::sqlInjection($code);

			$reset_cond = " && (ava = '$code')";
			$r_login = $this->model->selectOne("types",$reset_cond,0);

			$email = $r_login['name'];
			$newPass = clean::sqlInjection($newPass);
			$pass = Hash::MD5($newPass);

			/* Check email */
			if(!$r_login){
				$msg= pen::msg("هذا الرابط منتهي !");
				echo $msg;
				die();
			}

			if (mb_strlen($newPass) <= 4) {
				$msg = pen::msg("كلمة المرور قصيرة! ");
				echo $msg;
				die();
			}

			if( $this->model->update(["pass" => $pass]," && `email` = '$email'","users",0) )
			{
				$this->model->delete($reset_cond,"types",0);

				$msg  = pen::msg("تم اعادة تعيين كلمة المرور بنجاح!","alert alert-success");
				$msg .= '<a class="btn btn-primary" href="'.url('account').'">'.str('login').'</a>';

				echo $msg;


			}




		}

	}


	/**
	 * Save record when focus out
	 * @return response
	 */
	public function synch(){
		extract($_POST);

		$BETA = Session::get("add_new_session");

		$model = \M5\MVC\Model::getInst("pages");

		$value = Clean::sqlInjection($value);

		if($name == "content")
			$value = nl2br($value);

		if($name == "slug"){
			$value = str_replace(" ", "_", $value);
		}

		$args = [
		$name => $value
		];

		$cond = " && BETA = '$BETA' ";

		$model->update($args,$cond,'',1);
		echo "updated";
	}

	/**
	 * preview xhttpRequest
	 */
	public function preview_page()
	{
		$BETA = Session::get("add_new_session");
		$r = $this->model->table()->where(" && BETA = '$BETA' ")->fetch(['index'=>'first']);
		$this->data = $r;

		$this::$view->template('pages/details',$this->data);
	}

	/**
	* Load more records
	*
	* @return mixed
	*/
	public function loadMore()
	{
		if(!$_POST)
			die("ZZzz");
		extract($_POST);

		$model = new \M5\Models\Blogs_Model();

		$count = abs($count);
		$part = Clean::int($part);
		$cond = Clean::blind($cond);

		$cond = stripcslashes($cond);


		$page[0] = $count  ;
		$page[1] = $offset =  10;
		$sort = "";
		// pa($_POST);

		// $model->set("printQuery");
		$r = $model->_all($cond,$page,$sort);


		// pen::pa($r['data']);

		if($r['data'][0]['name']){
			foreach ($r['data'] as $key => $blog) {
				require view()."blogs/thumbnail.php";
			}

		}else{
			echo "end";
		}
	}

	/**
	 * Parent and child select Dynamic Drop list
	 * When change select droplist show parent droplist
	 *
	 */
	public function select_pc(){

		if($_POST){
			extract($_POST);

			// pa(0,1);
			/* return child form table DB */

			$cond = " && parent = '$partent_value' ";
			$r = $this->model->select($tbl,$cond,0);
			// pa($r);
			if($r[0]){
				echo "<select name='child_id' class='form-control'> ";
				echo "<option value='0'> اختر </option>";
				foreach ($r as $key => $value) {
					echo "<option value='".($value['ID'])."'>".$value['name']."</option>";
				}
				echo "</select>";
			}else{
				echo "<select name='child_id' class='form-control'> ";
				echo "<option value='0'> لاتوجد اقسام فرعية </option>";
				echo "</select>";
			}

		}
	}




}
