<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

use M5\Models\Blogs_Model;

class Blogs extends BaseController
{
	private $tbl = "blogs";
	private $class_label = "blogs";

	function __construct()
	{
		parent::__construct();
		$this->request->formAction = "blogs/";

		$this->model = new Blogs_Model($this->tbl);

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );

	}

	/** * Main Function */
	public function index($params = [])
	{
		/*local route*/
		$alpha = $params[0];
		$beta  =  $params[1];
		$gama  =  $params[2];

		if($alpha && !$beta){
			$this->details($alpha);

		}elseif($alpha && $beta){

			if($alpha == "do"){
				$this->request->form = $beta;
				$this->$beta($gama);

				/*breadcrumb*/
				$this->data["title"] = string($beta);
				$this->data["bread"] = Bread::create( [ str("blogs")=> "blogs", $this->data["title"]=>"#"], null );
			}

			if($alpha == "part"){
				$this->part_id_flag = clean::int($beta);
				$this->all();
			}

		}else{
			$this->all($cond="");
		}

		/*view*/
		$this->getView()->template("blogs/blogs_view",$this->data,$templafolder="");
	}

	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($cond=""){
		$page[0] = $count  = $_GET['page'];
		$page[1] = $offset =  5;
		$sort = "";

		$cond = "";
		$paggingUrl = "";

		//parts ads filter
		if($this->part_id_flag){

			$r_part = $this->model->selectOne ("tree", "&& ID = '".$this->part_id_flag."'", ""  );

			$sql_field = ($r_part['rank'] == "parent" ) ? 'part_id' : 'child_id';

			$cond = " && $sql_field = ".$this->part_id_flag;

			if(!$r_part)
				die( pre(string('404')));

			$partName = $r_part["name"];
			$this->data['title'] = $partName;
			$this->data['bread'] = Bread::create( [string("blogs")=>"blogs",$partName=>"#"],'' );
			$this->request->SEO = $partName;
			$this->request->SEO_IMG = $r_part['ava'];

			/* sub caegories of parent*/
			// $sub_parts = controller::child_part_of($this->part_id_flag);
			// $this->data['sub_parts'] = $sub_parts;
			// pa($sub_parts);
		}

		/* Search Filter */
		if ($_GET['part_id'] || $_GET['q']) {

			$query_string = Clean::sqlInjection($_GET['q']);
			$part_id      = Clean::sqlInjection($_GET['part_id']);
			$child_id     = Clean::sqlInjection($_GET['child_id']);

			$cond .= " &&  ( blogs.name LIKE '%$query_string%'   ) ";
			$cond .= $part_id ? " &&  ( blogs.part_id = '$part_id'   ) " : "";
			$cond .= $child_id ? " &&  ( blogs.child_id = '$child_id'   ) " : "";

			$_string = $query_string;
			$_string .= $part_id ? " ".s("categories")." ".$part_id : "" ;

			//bread ^^
			$title = str('search_result')." : ".$_string;
			$this->data['title'] = $title;
			$this->data['bread'] = Bread::create( [string("blogs")=>"blogs", $this->data['title']=>"#"],'' );

			/*append after ?page?1&q=*/
			$paggingUrl .= '&q='.$_GET['q'];
			$paggingUrl .= $part_id ? " &part_id=$part_id" : "";
		}


		$r = $this->model->_all($cond,$page,$sort);

		/*pa($r);*/
		$this->data["records"] = $r["data"];
		$this->data["meta"] = $r['meta'];
		$this->data['meta']['paggingUrl'] = $paggingUrl;	}

	/**
	 * view one record
	 *
	 * $id int record id
	 */
	private function details($id){

		if(preg_match('/^[1-9]-/', $id)){
			$id = Clean::int($id);
			$r = $this->model->_one($id);
		}else{
			$id = str_replace("-", " ", $id);
			$cond = "&& LOWER(blogs.name) LIKE LOWER('%$id%')";
			$r = $this->model->_one(null,$cond);
		}

		/*pa($r);*/
		$this->data["theRecord"] = $r;

		if($r){

			/*bread*/
			$this->data["title"] = $r["name"];
			$this->data["bread"] = Bread::create( [str("blogs")=>"blogs", $this->data["title"]=>"#"], null );

			//seo
			$this->request->SEO = $r["name"];
			$this->request->SEO_DESC = clean::sqlInjection($r["content"]);
			$this->request->SEO_IMG = $r["ava"];

			/*related ads*/
			// $this->model->set("printQuery");
			$this->model->set("one",null);
			$cond = " && (blogs.part_id = '{$r["part_id"]}' ) ";
			$this->model->set("cond",$cond);
			$related = $this->model->_all($cond,[0,5],$sort);
			$this->data["related"] = $related['data'];

			/* has been shown */
			$v = $r['v']+1;
			$this->model->update(["v"=>$v]," && `ID` = '".$r['ID']."' ",null,null);

			/* addCommentBtn listener*/
			$this->add_comment();
		}else{
			$this->data["title"] = s("p404");
			$this->data["bread"] = Bread::create( [str("blogs")=>"blogs", $this->data["title"]=>"#"], null );

			$this->getView()->template("p404",$this->data);


		}

	}


	/**
	* add_comment
	* @type mixed
	*/
	private function add_comment($param=null){
		if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			extract($_POST);
			$newPass = Clean::sqlInjection($pass);
			$reset_string = Clean::sqlInjection($reset_string);
			pa();

			die();
		}

	}



}
