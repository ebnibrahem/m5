<?php namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Config;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Schema;
use M5\Library\Session;
use M5\Library\Auth;
use M5\Library\Clean;
use M5\Library\Lens;
use M5\Library\Up;
use M5\Library\page;

/*use M5\Models\mic_model;*/
use M5\MVC\Model;

class Backup extends BaseController
{
	private $tbl = "mic";
	private $tbl_label = "backup";

	function __construct()
	{
		parent::__construct();


		$this->request->fromAction = 'admin/backup/';
		/*instant model : Singleton Style*/
		$this->model = Model::getInst($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str(pure_class($this->tbl_label));
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );

	}

	/** * Main Function */
	public function index($params = []){

		$alpha = $params[0];
		$beta  = $params[1];
		$gama  = $params[2];

		if($alpha && !$beta){
			$this->details($alpha);

		}elseif($alpha && $beta){
			if($alpha == "do"){
				$this->request->form = $beta;
				$this->$beta($gama);

				/*breadcrumb*/
				$this->data["title"] = string($beta);
				$this->data["bread"] = Bread::create( [ str("blogs")=> "admin/blogs", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all();
		}

		/*view*/
		$this->getView()->template("admin/backup_cp_view",$this->data,$templafolder="admin");
	}

	/**
	* all
	* @type mixed
	*/
	private function all($param=null){
		$tables = Schema::tables();

		$this->data['tables'] =  $tables;

		$pre = Lens::cornea(BACKUP_DIR);
		if($pre){
			foreach ($pre['file'] as $key => $fl) {
				$r[$key]['name'] = $fl;
				$r[$key]['size'] = $pre['size'][$key];
				$r[$key]['url']  = url( http_format(BACKUP_DIR)).$fl;
				$r[$key]['c_at']  = filemtime(BACKUP_DIR.$fl);
			}
		}
		$this->data['records'] = $r;
	}

	public function details($id=''){
		$fileName = clean::sqlInjection($_GET['file']);
		$file = BACKUP_DIR."/".$fileName;

		$this->data["title"] = $fileName;

		echo "<meta charset='utf-8'>";
		pre( file_get_contents($file) );
	}

	public function download($id=''){
		$fileName = clean::sqlInjection($_GET['file']);
		$file = BACKUP_DIR."/".$fileName;

		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"".$fileName."\"");
		echo file_get_contents($file);
		exit;


	}

	/**
	 * make to_day Backup
	 */
	private function add(){
		$tables = Schema::tables();

		/* Schema of Create Tables*/
		if ($tables) {
			foreach ($tables as $key => $tbl) {
				$content .= Schema::export_table($tbl);
			}
		}

		/*Create sql file*/
		$file_name = BACKUP_DIR.DS.Config::get("db_name")."_".date("Y_m_d_H_i_s").".sql";
		$export_file = fopen( $file_name ,"w");
		file_put_contents($file_name,$content);

		$msg = msg(s("add_success"));
		Session::setWink("msg",$msg);
		page::location(url().'admin/backup');

	}

	/**
	 * delete
	 */
	public function delete()
	{
		/*Authentication*/
		$roles = Session::get("roles");
		Auth::valid($roles,[3]);

		$fileName = clean::sqlInjection($_GET['file']);

		$file = BACKUP_DIR."/".$fileName;
		if( Up::delete(["file"=> $file]) )
		{
			$msg = msg(s("delete_success"));
			Session::setWink("msg",$msg);
			page::location(url().'admin/backup');
		}

	}

}
