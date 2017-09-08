<?php 	namespace M5\Controllers\Admin;


use M5\MVC\Controller as BaseController;
use M5\Library\Session;
use M5\Library\Pen;
use M5\Library\Clean;
use M5\Library\Lens;
use M5\Library\Up;
use M5\Library\Bread;

/**
*
*/
class Ajax extends BaseController
{
	const FILES_PATH = "upload/_files/";

	function __construct()
	{
		echo"<meta charset=\"utf8\">";
		parent::__construct();
	}

	/**
	*forget admin data
	*
	*/
	function forget(){
		if($_POST){
			extract($_POST);

			captcha_ck($captcha);

			$this->loadModels();
			$email = clean::sqlInjection($email);

			$sql = "SELECT id FROM admin WHERE `email` = '$email'";

			if($this->model->SELECTI($sql)){

				$rand = substr( md5(rand(100,99999999)),"0","10" );

				$SQL_reset = "INSERT INTO types (name,type,ava,st) VALUES('$email','resetAdmin','$rand','0')";

				if($this->model->EXECUTE_QUERY($SQL_reset)){

                    //send activation link
					$subj = site_name." - ".string("reasign_admin_ttl");
					$reciver = $email;
					$sender = site_email;
					$link = site."login/do/reset/$rand";
					$msg = $logo.'<div>HI</div><br />';
					$msg .= '<div>'.string("reasign_admin_ttl").': </div>'.$link;
					$msg .= '<div><br /><hr>'.site_name.'</div>';
					$msg .= '<div>'.site.'</div>';
					Email::Send($subj, $reciver, $sender, $msg);

					// echo $msg;
					echo $msg = pen::msg(string('forget_msg_success'),'_caps alert alert-info');
					echo '<img src="'.url('_v/human.php').'" alt="captcha" class="hide">';
				}

			}else{
				echo $msg = pen::msg(string('forget_msg_fail'),'_caps');
			}

		}
	}

	/**
	*load | show image in toast
	*
	*/
	public function library($sub_folder=null)
	{
		$sub_folder = clean::sqlInjection($sub_folder);

		$path = Ajax::FILES_PATH;

		if($sub_folder){
			$path =  $path."/".$sub_folder."/" ;

			$this->data["title"] = __CLASS__;
			$this->data["bread"] = Bread::create( [$this->data["title"]=>"files", "$sub_folder"=>"#"] );
		}

		$files = Lens::cornea($path);
		if($files){
			foreach ($files['file'] as $k => $f) {
				$real_path['files'][$k]['path'] = URL.$path."/".$f ;
				$real_path['files'][$k]['size'] = $files['size'][$k] ;
				$real_path['files'][$k]['type'] = $files['IsFolder'][$k] ;
			}
		}

		$this->request->media = $real_path['files'];
		$this->data['files'] = $real_path;
		$this->request->OnePage("admin/ajax_view",$this->data);
	}

	public function search()
	{
		$this->loadModels("beta");
		if($_POST){
			extract($_POST);
			$q = clean::sqlInjection($q);
			if($q){
				$sql = "SELECT * FROM `cources` WHERE `ttl` LIKE '%$q%'";
				$r = $this->model->SELECTI($sql);

				if($r){
					foreach ($r as $Id) {
						$data[] = $this->model->_one($Id['ID']);
					}
				}
				pen::pa($data);

				$this->request->search  = $data;

				$this->request->onePage('widgets/_search_result');
			}
		}
	}

	/*
	* interview Gallery Image
	*
	 */
	public function interviewGalleryImages(){
		//pen::pa(  $_POST['text'] );

		$text = $_POST['text'];

		foreach ($text as $src) {
			echo '<img src="'.$src.'" width="100" style="margin:5px" />';
		}

	}

	public function aside_menu(){
		if($_POST){
			extract($_POST);
			session::set("menu",$session);
			pen::pa($_SESSION);
		}
	}

	public function view()
	{
		if($_POST['view']){
			extract($_POST);
			session::set("view",$view);
			pen::pa($_SESSION);
		}
	}

    /**
     * delete image by admin
     */
    public function del_image(){
    	if($_POST){
    		extract($_POST);
    		// pa('','d');

    		if( Up::delete(["file"=>$file]))
    			echo "deleted";
    	}
    }

    public function addUser()
    {
    	$this->loadModels("users");
    	if($_POST) :
    		extract($_POST);


    	$name = Clean::htmlTag($name);
    	$user = Clean::htmlTag($user);
    	$pass = Hash::MD5($pass);
    	$r_date = date("Y/n/j h:i");

    	if (!$user || !$pass || !$email) {
    		echo pen::msg('حقول الاسم وكلمة المرور الصلاحيات لايمكن ان تكون خاليه');
    		exit();
    	}

    	$BETA = $_POST['BETA'];

    	$args = [
    	"BETA"=>$BETA,
    	"name"=>$name,
    	"user"=>$user,
    	"tel"=>$tel,
    	"pass"=>$pass,
    	"email"=>$email,
    	"level"=>$level,
    	"st"=>1,
    	];

    	/*check un-repeat BETA ID*/
    	$q_repeat_user = " SELECT BETA FROM users WHERE BETA = '$BETA' ";
    	$r_repeat_user = $this->model->SELECTI($q_repeat_user)[0];

    	if($r_repeat_user['BETA'] == $BETA){
    		echo   msg('هذا الرقم [ <strong>'.$BETA.' </strong> ] موجود بالفعل. اختر رقماَ آخر', 'alert alert-danger ');
    		die();
    	}

    	/*check un-repeat user*/
    	$q_repeat_user = " SELECT user FROM users WHERE user = '$user' ";
    	$r_repeat_user = $this->model->SELECTI($q_repeat_user)[0];

    	if($r_repeat_user['user'] == $user){
    		echo   msg('هذا المستخدم <u>'.$user.'</u> موجود بالفعل. اختر مستخدماً آخر', 'alert alert-danger ');
    		die();
    	}

    	/*check un-repeat email*/
    	$q_repeat_user = " SELECT email FROM users WHERE email = '$email' ";
    	$r_repeat_user = $this->model->SELECTI($q_repeat_user)[0];

    	if($r_repeat_user['email'] == $email){
    		echo   msg('هذا البريد <u>'.$email.'</u> موجود بالفعل. اختر بريداً آخر', 'alert alert-danger ');
    		die();
    	}

    	pa('','eeee');

    	if ($this->model->insert($args,'users')) {
    		$user_id = $this->model->SELECT("users","WHERE BETA = '$BETA'")[0]['ID'];

    		/*grant access*/
    		// foreach ($roles as $role) {
    		// 	$role_id = $role;
    		// 	$access_args = [ "user_id"=>$user_id,"access_id"=> $role_id ];
    		// 	$this->model->insert($access_args,'access','','');
    		// 	echo $this->DB->error;
    		// }
    		echo  msg(string('add_success'), 'alert alert-info ');
    	}

    	endif;
    }


    /*uploader*/
    function upload($path=''){

    	if($_FILES){


    		$BETA = Session::get("add_new_session");

    		$up_dir = $_POST['path'];

    		$temp_name = $_FILES['images']['tmp_name'][0];
    		$image = getimagesize($temp_name);
    		if($image[0]){
    			$return['photo'] =  TRUE;
    		}else{
    			echo msg( '<i class="fa fa-warning "></i> صيغة غير مدعومة!!' ,"alert  f_red" );
    			die();
    		}
    		$fileSize = $_FILES['images']['size'][0];


    		$args = ["path"=>$up_dir, "inputname"=>"images"];

    		if( $f = Up::load($args) ){
    			echo "<img src=".site.$f['file'][0]." width='100' />";
    			echo msg( '<i class="fa fa-check "></i>'.string('add_success') ,"alert  f_green small" );
    		}

    	}

    }


 }