<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Session;
use M5\Library\Page;

/*use M5\Models\cp_model;*/
use M5\MVC\Model;

class Cp extends BaseController
{
	private $tbl = "records";

	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		$this->analysis_traffic();
		$this->sn();

		/*breadcrumb*/
		$this->data["title"] = str('cpanel');
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );

	}

	/** * Main Function */
	public function index(){

		/*local route*/
		$Params = App::getRouter()->getParams();
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
				$this->data["bread"] = Bread::create( ["blogs_cp"=>"blogs_cp", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all($count="",$cond="",$offset=30);
		}
		$this->update($alfa);
		$this->add();

		/*view*/
		$this->getView()->template("admin/cp_view",$this->data,$templafolder="admin");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	function all($count="",$cond="",$offset=30){
		$r = $this->model->table([])->order("ID DESC")->fetch([]);
		// pa($r);
		$this->data["records"] = $r['data'];
	}

	/**
	 * view one record
	 *
	 * $id int record id
	 */
	function details($id){
		$this->request->form = "update";
		$r = $this->model->table()->one($id);
		/*pa($r);*/
		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["ID"];
		$this->data["bread"] = Bread::create( ["cp"=>"cp", $this->data["title"]=>"#"] );

	}

	/**
	 * add new record
	 *
	 * $_POST[]
	 */
	function add(){
		if($_POST["cpbtnAdd"]){
			pa();
			extract($_POST);
			/*clean post*/

			$args = [
			"fld"=>$value,
			];
			if($this->model->insert($args))
			{
				\Session::set("msg", msg( string("add_success"),"alert alert-success") );
				\page::location($page);
				die();
			}
		}
	}

	/**
	 * update one|more record
	 *
	 * $id int record id
	 */
	function update($id){
		if($_POST["cpbtnUp"]){
			extract($_POST);
			pa();
			/*clean post*/

			$args = [
			"fld"=>$value,
			];

			if($this->model->update($args,$id))
			{
				\Session::set("msg", msg(string("update_success"),"alert alert-info") );
				\page::location($page);
				die();
			}
		}
	}

	/**
	 * Delete one|more record
	 *
	 * $id int record id
	 */
	function delete($id){
		/*Authentication*/
		$roles = $this->request->userRoles;
		\Auth::valid($roles,[3]);

		$page = url(__CLASS__);
		if( $this->model->delete($id) ){
			\page::location($page);
			die();
		}

	}

	/**
	 * Socail Networks
	 *
	 */
	private function sn()
	{
		if($_POST['snBtn']){
			extract($_POST);
			pa();
			$this->model->setPref("fb",$fb);
			$this->model->setPref("tw",$tw);
			$this->model->setPref("gp",$gp);
			$this->model->setPref("yt",$yt);
			$this->model->setPref("ista",$ista);
			Session::set("msg", msg( string("update_success"),"alert alert-success") );
			Page::location( url('admin/cp'));
		}

		$this->data['sn']['fb'] = $this->model->getPref("fb");
		$this->data['sn']['tw'] = $this->model->getPref("tw");
		$this->data['sn']['gp'] = $this->model->getPref("gp");
		$this->data['sn']['yt'] = $this->model->getPref("yt");
		$this->data['sn']['ista'] = $this->model->getPref("ista");

		$this->data['bg'] = $this->model->getPref("bg");
		$this->data['main_color'] = $this->model->getPref("main_color");
	}

	private function analysis_traffic(){

		$today = date("j");
		$thisMonth = date("n");

		$sqlAll = "SELECT id FROM audience";
		$all = $this->model->TOTAL($sqlAll);

		$sql= "SELECT ip,country,count(country) AS count FROM audience GROUP BY country ORDER BY count DESC ";
		$retrun = $this->model->fetchAll($sql);
		$this->request->analysis_traffic = $retrun;
		$this->request->analysis_traffic_all = $all;
	}

}
