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

/*use M5\Models\records_model;*/
use M5\MVC\Model;

class Printout extends BaseController
{
	private $tbl = "records";
	private $class_label = "records";
	private $fail_page = "admin/records/do/add";
	function __construct()
	{
		parent::__construct();

		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
		
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
				$this->data["bread"] = Bread::create( [ str("records")=> "admin/records", $this->data["title"]=>"#"] );
			}					

		}else{
			$this->all($cond="");
		}

		Session::set("menu",1);

		/*view*/
		$this->getView()->template("print/print",$this->data,$templafolder="admin");
	}

	
	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($cond=""){
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

		// pa($images);

		$image = $images['file'][0] ;
		$r['image'] = !$image ? Config::get('NO_IMG') : $image;

		/* Get family list if there  */
		$r_family = $this->model
		->table(["tbl"=>"records2"])
		->where(" && block_ID = '{$r['block_ID']}' ")
		->fetch(["offsetAll"=>"first", "printQuery"=>0]);
		
		$r['family'] = 	$r_family;


		$this->data["theRecord"] = $r;
		// console($r);

		/*bread*/
		$this->data["title"] = $r["raadbname"];
		$this->data["bread"] = Bread::create( [str("records") =>"admin/records", $this->data["title"]=>"#"] );

	}


}
