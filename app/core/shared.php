<?php namespace M5\MVC;

use M5\Library\Session;
use M5\Library\Pen;
use M5\Library\Page;

/**
* Every thing that shared with all Application Controller
*
*/
class Shared
{


	public function __construct(){

		$this->model = Model::getInst('mic','show_error',__METHOD__);

		/* List of things thats nedd in every view */
		$this->boot();
	}

	/**
	 * Shared data between Views.
	 *
	 * @return mixed
	 */
	private function boot(){
		/* Application */
		$Application = $this->model->table(["tbl"=>"mic"])->fetch(["index"=>"first"]);

		// pa($Application);

		define('site_name', $Application['name']);
		define('site_email', $Application['email']);
		define('site_tel', $Application['tel']);
		define('site_description', $Application['description']);

		$this->data['application'] = $Application;

		/* Catetogries parent */
		$tree = new \M5\Models\Tree_Model('','',__METHOD__);
		$categories = $tree->parents('part',0);

		if($categories){
			foreach ($categories as $key => $cat) {
				$categories[$key]['total'] = $tree->num_rows("blogs","  && part_id ='".$cat['ID']."' ",0);
			}
		}

		$this->data['categories'] = $categories;

		$this->data['drop_list'] = $this->drop_list();

		/*Page Socail links*/
		$this->data['sn']['fb'] = $this->model->getPref("fb");
		$this->data['sn']['tw'] = $this->model->getPref("tw");
		$this->data['sn']['gp'] = $this->model->getPref("gp");
		$this->data['sn']['yt'] = $this->model->getPref("yt");
		$this->data['sn']['ista'] = $this->model->getPref("ista");

		/*theme*/
		$this->data['bg'] = $this->model->getPref("bg");
		$this->data['main_color'] = $this->model->getPref("main_color");

		/*notification*/
		$notification = $this->model->num_rows("notifications"," && ( user_id = 'admin' && st = '1') ");
		$this->data['alert_admin'] = $notification;

		return null;
	}


	/**
	 * user Roles
	 *
	 * @return Mixed
	 */
	private function userRoles(){

		if(Session::get("login2")){
			$root = [1,2,3,4];
			$sql_userRoles = "SELECT role_id FROM passport WHERE admin_id ='".session::get("login2")."'";
			$r_userRoles = $this->_fetch($sql_userRoles);
			if($r_userRoles){
				foreach ($r_userRoles as $r) {
					$_userRoles[] = $r['role_id'];
				}
			}
		}

		$userRoles = session::get("login2") == "1" ? $root : $_userRoles;
		$this->request->userRoles = $userRoles;

	}

	/**
	 * reteun array of $query
	 *
 	 */
	private function _fetch($query,$printQuery='0'){
		$db = Model::getInst();
		return $db->fetchAll($query,$printQuery);
	}

    /**
    * Get X_name from table
    */
    static function typeName($tbl, $fieldCond='ID', $ID, $fieldName='name'){
    	$db = Model::getInst("tree");
		// echo
    	$SQL = "SELECT $fieldName FROM $tbl WHERE $fieldCond = '$ID'";
    	$r = $db->fetchAll($SQL )[0];
    	return $r[$fieldName];
    }


    /**
	 *  Tree branches
	 *
	 * @param  string  $cond
	 * @return mixed
	 */
    public static function branch($cond, $printQuery = 0){
    	$db = Model::getInst("tree");

    	$cond = (preg_match('/&&/', $cond)) ? $cond : " && parent = '$cond'";

    	/* Get child part of parent */
    	$cats = $db->table()->where($cond)->fetch(['printQuery'=>$printQuery]);

    	return $cats['data'];
    }


    static function _sum($tbl='records',$fldName,$fldValue)
    {
    	$db = Model::getInst("records");

		// echo
    	$sql = "SELECT ID FROM $tbl WHERE $fldName = '$fldValue' ";
    	$r =  $db->query($sql)->num_rows;
    	return $r = !$r ? '0' : $r ;
    }


	/**
	 * Records total
	 *
	 */
	static function _sum2($args,$tbl='',$printQuery=false)
	{
		$db = Model::getInst($tbl);

		if($args){
			foreach($args as $k => $v){
				$cond .= $k."='".$v."' && " ;
			}
		}

		$sql = "SELECT ID FROM $tbl WHERE $cond 1 ";
		$r =  $db->query($sql)->num_rows;

		if($printQuery){
			echo $sql;
		}

		// ve($r);

		return $r = !$r ? '0' : $r ;
	}


	/* Send notification*/
	static function sendAlert($user_id,$type,$url,$notifications_msg,$alert_args=[]){
		$db = Model::getInst("notifications");

		// pa( func_get_args() );

		$args_notfiy = [
		"type"          => $type,
		"user_id"       => $user_id,
		"notifications" => $notifications_msg,
		"url"           => $url,
		"st"            => 1,
		];

		if(!$db->insert($args_notfiy,'')){
			die("error sql_notfiy<br />".pa($args_notfiy));
		}

		if($alert_args['email'] && $alert_args['msg']){
			$subj = !$alert_args['subj'] ? site_name." اشعار " : $alert_args['subj'];
			$reciver = $alert_args['email'];
			$sender = site_email;

			$logo = '<div align="center"> <img src="'.LOGO.'" width="70" alt="'.site_name.'"> </div>';

			$msg .= $logo.'<br />';

			$msg .= $alert_args['msg'];

			$msg .= '<div><br /> <hr /> شكراّ Thanks </div>';
			$msg .= '<div>'.site_name.'</div>';

			// echo $msg;

			\M5\Library\Email::smtp($subj, $reciver, $sender, $msg);
		}
	}

	/**
	 * Drop list.
	 *
	 * @return array.
	 */
	static function drop_list($key=null,$flag=null)
	{
		/*access poremission name*/
		$poremission = [
		"1" => "الاضافة",
		"2" => "التعديل",
		"3" => "الحذف",
		"4" => "ادارة النظام",
		];

		$COLOR = ["#5bc0de","#272FFF","#199199","#272272","#8B4C90","#673AB7","#03A9F4","#FF5A5E",
		"#d84","#FF5722","#37b06d","#fc0","#d60123","#272","#03A9F4","#FFC870","#228c07"];


		$st = [
		"0"=>"<i class='fa fa-spinner'></i>".string('Draft'),
		"1"=>"<i class='fa fa-check'></i>".string('Publish'),
		];

		$tbls = [ "achievement","courses","education","experience","interest","language","personal","reference","skill","social"];

		$lst  = ["poremission"=>$poremission, "st" => $st, "tbls"=>$tbls, "COLOR" => $COLOR];


		return $key ? $lst[$key] : $lst;


	}

}

