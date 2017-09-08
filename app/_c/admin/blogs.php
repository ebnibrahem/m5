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

use M5\Models\Blogs_Model as Record;

class Blogs extends BaseController
{
	private $tbl = "blogs";
	private $class_label = "blogs";
	private $fail_page = "admin/blogs/do/add";

	function __construct()
	{
		parent::__construct();

		$this->request->formAction = "admin/blogs/";
		$this->request->editor = 1;

		/*instant model : Singleton Style*/
		$this->model = new Record();

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
		$this->data['anchor'] = '{"link":"admin/blogs/do/add","label":"'.string('add_new').'"}';

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
				$this->data["bread"] = Bread::create( [ str("blogs")=> "admin/blogs", $this->data["title"]=>"#"] );
			}

		}else{
			$this->all($cond="");
		}

		// $this->add();

		/*view*/
		$this->getView()->template("blogs/blogs_cp_view",$this->data,$templafolder="admin");
	}

	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all(){
		$page[0] = $count  = $_GET['page'];
		$page[1] = $offset =  32;
		$sort = "";

		$cond = "";
		$paggingUrl = "";

		/* Search Filter */
		if ($_GET['part_id'] || $_GET['q']) {

			$query_string = Clean::sqlInjection($_GET['q']);
			$part_id = Clean::sqlInjection($_GET['part_id']);

			$cond .= " &&  ( blogs.name LIKE '%$query_string%'   ) ";
			$cond .= $part_id ? " &&  ( blogs.part_id = '$part_id'   ) " : "";

			$_string = $query_string;
			$_string .= $part_id ? " ".s("categories")." ".$part_id : "" ;

			//bread ^^
			$title = str('search_result')." : ".$_string;
			$this->data['title'] = $title;
			$this->data['bread'] = Bread::create( [string("blogs")=>"admin/blogs", $this->data['title']=>"#"],'' );

			/*append after ?page?1&q=*/
			$paggingUrl .= '&q='.$_GET['q'];
			$paggingUrl .= $part_id ? " &part_id=$part_id" : "";
		}

		// $this->model->set("printQuery");
		$r = $this->model->_all($cond,$page,$sort);


		// pa($r['data'][0]);
		$this->data["records"] = $r["data"];
		$this->data["meta"] = $r['meta'];
		$this->data['meta']['paggingUrl'] = $paggingUrl;
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
		$record_folder = 'upload/blogs/'.$r['BETA'].'/';
		$images = lens::cornea($record_folder,url().$record_folder);


		if($r){
			/*get images*/
			$images = get_uploads($record_folder,'file');
			$r['images'] = $images;
			$r['ava'] = !$images[0] ? ADS_LOGO : $images[0];
		}

		$this->data["theRecord"] = $r;

		/*bread*/
		$this->data["title"] = $r["name"];
		$this->data["bread"] = Bread::create( [str("blogs") =>"admin/blogs", $this->data["title"]=>"#"] );

		/*update Btn listener*/
		$this->update($id,$r);
	}

 	/**
	 * add new record
	 *
	 * $_POST[]
	 */
 	private function add()
 	{

 		if($_POST["recordsbtnAdd"]){
 			/*Authentication*/
 			$roles = Session::get("roles");
 			Auth::valid($roles,[1]);

 			extract($_POST);
 			/*clean post*/
 			$BETA =   uniqid()  ;

			 //pa(0,1);

 			Session::set("new_record_post",$_POST);


 			if(!$name || !$content || !$part_id){
 				$msg = msg( str("input_error"),'alert alert-danger');
 				Session::setWink("msg",$msg);
 				Page::location( url( $this->fail_page) );
 			}

 			/* Check repeat  */
			// $sql_ck = " SELECT * FROM blogs WHERE  1 && ref_id = '$ref_id' ";

			// if( $this->model->query($sql_ck)->num_rows ){

			// 	$msg = msg("الكود المرجعي الذي ادخلته موجود مسبقاً ",'alert alert-warning');
			// 	Session::setWink("msg",$msg);
			// 	Page::location( url( $this->fail_page) );
			// 	die();
			// }

 			/* blogs folder */
 			$record_folder = 'upload/blogs/'.$BETA;
 			if(!file_exists($record_folder)){
 				mkdir($record_folder,0777,TRUE);
 			}

 			/* Upload images */
 			if($_FILES['images']['name'][0]){
 				pa( $_FILES['images']['name']);

 				$file = $_FILES['images']['name'][0];
 				$url = $_FILES['images']['tmp_name'][0];
 				$type = @getimagesize($url);

 				if($type['mime'] != "image/png"  && $type['mime'] != "image/jpeg" )
 					die("<h2>Please select PNG, JPG Format!! [ <em>{$type['mime']} </em>] Not Supported");

 				$files_path = $record_folder;
 				$args = ["path"=>$files_path, "inputname"=>"images", "rename"=>$BETA ];

 				if(!Up::load($args))
 					die(' Not uploaded image');
 			}

 			$args = [
 			"user_id"=>Session::get("login2"),
 			"BETA"=>$BETA,

 			"name"    => $name,
 			"part_id" => $part_id,
 			"st"      => $st,
 			"content" => $content,
 			"tags"    => $tags,
 			"notes"    => $notes,
 			];

 			if($this->model->insert($args))
 			{
 				Session::end("new_record_post");
 				Session::setWink("msg", msg( string("add_success"),"alert alert-success") );
 				page::location($page);
 				die();
 			}
 		}

 	}

	/**
	 * update one|more record
	 *
	 * $id int record id
	 */
	private function update($id,$r){

		if($_POST["recordsbtnUp"]){
			/*Authentication*/
			$roles = Session::get("roles");
			Auth::valid($roles,[2]);


			extract($_POST);
			/*clean post*/

			// pa(0,1);

			/* blogs folder */
			$record_folder = 'upload/blogs/'.$r['BETA'];
			if(!file_exists($record_folder)){
				mkdir($record_folder);
			}

			/* Upload More images*/
			if($_FILES['images']['name'][0]){
				pa( $_FILES['images']['name']);

				$file = $_FILES['images']['name'][0];
				$url = $_FILES['images']['tmp_name'][0];
				$type = @getimagesize($url);

				if($type['mime'] != "image/png"  && $type['mime'] != "image/jpeg" )
					die("<h2>Please select PNG, JPG Format!! [ <em>{$type['mime']} </em>] Not Supported");

				$files_path = $record_folder;
				$args = ["path"=>$files_path, "inputname"=>"images", "rename"=>$BETA ];

				if(!Up::load($args))
					die(' Not uploaded image');
			}

			$args = [
			"name"    => $name,
			"part_id" => $part_id,
			"st"      => $st,
			"content" => $content,
			"tags"    => $tags,
			"notes"    => $notes,
			"u_at"     => R_DATE_LONG,
			];

			if($this->model->update($args," && `ID` = '$id' "))
			{
				Session::setWink("msg", msg(string("update_success"),"alert alert-success") );
				page::location($page);
				die();
			}
		}
	}

	/**
	 * Delete one|more record
	 *
	 * $id int record id
	 */
	public function delete($id){

		/*Authentication*/
		$roles = Session::get("roles");
		Auth::valid($roles,[3]);

		$page = url("admin/".pure_class(__CLASS__));

		$r = $this->model->table()->where(" && ID = $id ")->fetch(["index"=>"first"]);

		// pa($r,1);

		/* Delete folder */
		$folder ='upload/blogs/'.$r['BETA']."/";

		Up::delete_dir($folder);

		if( $this->model->delete(" && `ID` = '$id'") ){
			Session::setWink("msg", msg(string("delete_success"),"alert alert-info") );
			Page::location($page);
			die();
		}

	}
}
