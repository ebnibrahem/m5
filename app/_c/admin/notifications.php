<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

/*use M5\Models\notifications_model;*/
use M5\MVC\Model;

class Notifications extends BaseController
{
	private $tbl = "notifications";
	private $class_label = "notifications";

	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
						//$this->data['anchor'] = '{"link":"admin/notifications/do/add","label":"'.string('add_new').'"}';

	}

	/** * Main Function */
	public function index($params = [])
	{

		$this->notifications();
		$this->multiableDeletion();

		/*view*/
		$this->getView()->template("admin/notifications_view",$this->data,$templafolder="admin");
	}

	private function notifications()
	{
		$user_id = 'admin';

		$r = $this->model
		->table()
		->where(" && (user_id =   '$user_id') ")
		->order(" ID DESC ")
		->fetch( ['printQuery'=>0] );
		
		$this->data['records'] = $r['data'];

		// pa($r['data']);

		//read noficaxtions
		$this->model->query("update notifications SET st = 2 WHERE user_id='admin'");


	}


	/**
	 * Delete one|more record
	 *
	 * $id int record id
	 */
	public function delete($id)
	{
		/*Authentication*/
		$roles = Session::get("roles");
		Auth::valid($roles,[3]);

		$page = url("admin/".pure_class(__CLASS__));
		if( $this->model->delete(" && `ID` IN ($id)") ){
			Session::setWink("msg", msg(string("delete_success"),"alert alert-info") );
			Page::location($page);
			die();
		}

	}

	/**
	 * Delete multiable record(s)
	 *
 	 */
	function multiableDeletion()
	{
		if($_POST['notiBtnDel']){
			extract($_POST);

			$page = url("admin/".pure_class(__CLASS__));

			if(!$ID){
				$msg = msg("حدد الحقول المطلوب اولاً","alert alert-danger");
				Session::setWink("msg",$msg);
				page::location( $page );
				die();
			}
			
			// pa(0,1);

			$ides = implode(",", $ID);
			$this->delete($ides);
		}
	}


	
}
