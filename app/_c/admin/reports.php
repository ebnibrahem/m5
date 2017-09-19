<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Auth;

use M5\Models\Blogs_Model ;
use M5\Models\Users_Model ;

class Reports extends BaseController
{
	private $tbl = "orders";
	private $class_label = "reports";
	function __construct()
	{
		parent::__construct();
		$this->request->formAction = "admin/reports/";

		/*instant model : Singleton Style*/
		$this->model = new Blogs_Model();

		/*breadcrumb*/
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"], null );
						//$this->data['anchor'] = '{"link":"admin/reports/do/add","label":"'.string('add_new').'"}';

	}

	/** * Main Function */
	public function index($Params = []){

		/*local route*/
		$alfa = $Params[0];
		$beta = $Params[1];
		$gama = $Params[2];

		if($alfa && !$beta){
			$this->details($alfa);

		}elseif($alfa && $beta){
			if($alfa == "do"){
				$this->request->form = $beta;
				$this->$beta($gama);
			}

		}

		$this->all();

		/*view*/
		$this->getView()->template("admin/reports_cp_view",$this->data,$templafolder="admin");
	}


	/**
	 * view All record
	 *
	 * @return mixed
	 */
	private function all($count="",$cond="",$offset=30){
		$users = new Users_Model();
		$r_users = $users->_all();
		$this->data['users'] = $r_users['data'];


		if($_GET['searchBtn']){
			$page[0] = $count  = $_GET['page'];
			$page[1] = $offset =  32;
			$sort = "";

			$cond = "";
			$paggingUrl = "";

			/* Search part */
			if ($_GET['part_id']) {

				/*clean vars*/
				$part_id = Clean::sqlInjection($_GET['part_id']);

				/*part info*/
				$r_part = $this->model->selectOne("tree",$part_id);
				// pa($r_part);

				/* cond append*/
				$cond .= $part_id ? " &&  ( blogs.part_id = '$part_id'   ) " : "";


				//bread ^^
				$title = s("part")." ".$r_part['name'];
				$this->data['title'] = $title;

				$this->request->report_title .= $title." . ";
			}

			/* Search user */
			if ($_GET['user_id']) {

				/*clean vars*/
				$user_id = Clean::int($_GET['user_id']);

				/*user info*/
				$r_user = $this->model->selectOne("users",$user_id);
				// pa($r_user);

				/* cond append*/
				$cond .= " &&  ( blogs.user_id = '$user_id') ";

				//bread ^^
				$title = s("auther")." ".$r_user['name'];
				$this->data['title'] = $title;

				$this->request->report_title .= $title." . ";
			}

			$this->model->set("printQuery");
			$records = new Blogs_Model();
			$r = $records->_all($cond,$page,$sort);

			$this->data["records"] = $r["data"];
			$this->data["meta"] = $r['meta'];

			/*^^*/
			$this->getView()->template("print/print_cp_view",$this->data,$templafolder="admin");
		}

	}


	private function all_x($count="",$cond="",$offset=30){

		/*Customers info*/		/*Records info*/
		$users = new Users_Model();
		$records = new Blogs_Model();

		$r_users = $users->_all();
		$this->data['users'] = $r_users['data'];

		$r_records = $records->_all();
		$this->data['records'] = $r_records;
	}


	/**
	 * view one record
	 *
	 * @return mixed
	 */
	private function details($value='')
	{

		/* By Customer report */
		if($_GET['customersBtn']){
			$this->request->form = "print";

			$c_id = Clean::sqlInjection($_GET['customers_id']);


			$cond = " && orders.user_id = '$c_id'";
			$sort = "  orders.ID DESC ";

			$this->model->set("fetchAll",1);

			$r = $this->model->_all($cond,$page,$sort);

			$this->request->header =  "تقرير عن الوكيل: ".parent::typeName("customers","ID",$c_id);

			/*pa($r);*/
			$this->data["reports"] = $r['data'];

		}

		/* By record report */
		if($_GET['recordsBtn']){
			$this->request->form = "print";

			$rec_id = Clean::sqlInjection($_GET['record_id']);
			$rec_id = Clean::sqlInjection($_GET['rec_id']);
			$t_start = Clean::sqlInjection($_GET['t_start']);
			$t_end = Clean::sqlInjection($_GET['t_end']);


			$cond = " && orders.alias_id = '$rec_id'";
			$sort = "  orders.ID DESC ";

			$this->model->set("fetchAll",1);

			$r = $this->model->_all($cond,$page,$sort);

			$this->request->header =  "تقرير عن المنتج: ".parent::typeName("records","ID",$rec_id);

			/*pa($r);*/
			$this->data["reports"] = $r['data'];

		}

		/* Custom report */
		if($_GET['reportCustBtn']){
			$this->request->form = "print";

			// pa($_GET);

			$user_id    = Clean::sqlInjection($_GET['customers_id']);
			$rec_id  = Clean::sqlInjection($_GET['record_id']);
			$store_id  = Clean::sqlInjection($_GET['store_id']);
			$t_start = Clean::sqlInjection($_GET['t_start']);
			$t_end   = Clean::sqlInjection($_GET['t_end']);

			$t_start_opar   = Clean::blind($_GET['t_start_opar']);
			$t_end_opar   = Clean::blind($_GET['t_end_opar']);

			// $t_start_opar = "=";
			// $t_end_opar   = "=";

			$link = $t_end_opar == "=" ? "OR" : "AND";
			$link = $t_start_opar == "=" ? "OR" : "AND";

			$op_hd = $t_end_opar == "=" ? "و" : "الى";

			// condition where
			$cond .= !$user_id   ?  "" :  " && orders.user_id = '$user_id'";
			$cond .= !$rec_id    ?  "" :  " && orders.alias_id = '$rec_id'";
			$cond .= !$store_id    ?  "" :  " && orders.store_id = '$store_id'";

			$cond .= !$t_start   ?  "" :  " && date(orders.c_at) $t_start_opar '$t_start'";
			$cond .= !$t_end     ?  "" :  " $link date(orders.c_at) $t_end_opar '$t_end'";


			// header text
			$header .= !$user_id      ?  "" : "<span class='_18'> الوكيل: ".$this->model->selectOne("customers",$user_id)['name']."</span>" ;
			$header .= !$rec_id    ?  "" :  "<span class='_18'> المنتج: ".$this->model->selectOne("records"," && ID = '$rec_id'")['name']."</span>" ;
			$header .= !$store_id    ?  "" :  "<span class='_18'> المخزن: ".$this->model->selectOne("stores"," && ID = '$store_id'")['name']."</span>" ;
			$header .= !$t_start   ?  "" : "<span class='_18'>   ".$t_start."</span>";
			$header .= !$t_end     ?  "" : "<span class='_18'> $op_hd  ".$t_end."</span>";

			// Sort
			$sort = "  orders.ID DESC ";

			$this->model->set("fetchAll",1);

			// pre($cond);

			// $this->model->set("printQuery");
			$r = $this->model->_all($cond,$page,$sort);

			$this->request->header =  "تقرير مخصص<br /><br /> ".$header;
			// $this->request->header =  "تقرير مخصص<br /> ".$c_id_name." ".$rec_id_name." ".$t_start_name." ".$t_end;

			// pa($r);
			$this->data["reports"] = $r['data'];

		}


	}

	/**
	 * view one record
	 *
	 * $id int record id
	 */
	private function report($id){
		$this->request->form = "print";
		// pre($id );

		$today = R_DATE;

		$dt = new \DateTime( $today. '+7 day');
		$last_day_in_this_week  = $dt->format('Y-m-d');

		$dt = new \DateTime( $today. '+30 day');
		$last_day_after_30  = $dt->format('Y-m-d');

		$dt = new \DateTime( $today. '+1 year');
		$last_day_after_year  = $dt->format('Y-m-d');

		$label =
		[
		"daily"   => " && date({$this->tbl}.c_at) = '$today'",
		"weekly"  => " && ( date({$this->tbl}.c_at) >= date('$today') && date({$this->tbl}.c_at) <= date('$last_day_in_this_week') )",
		"monthly" => " && date({$this->tbl}.c_at) <= '$last_day_after_30'",
		"yearly"  => " && date({$this->tbl}.c_at) <= '$last_day_after_year'",
		];

		$header =
		[
		"daily"   => "  التقرير اليومي ".$today,
		"weekly"  => "  التقرير الاسبوعي <br>".$today." / ".$last_day_in_this_week,
		"monthly"  => "  التقرير الشهري <br>".$today." / ".$last_day_after_30,
		"yearly"  => "  التقرير السنوي <br>".$today." / ".$last_day_after_year,
		];
		$this->request->header =  $header[$id];

		$cond = $label[$id];
		$sort = "  orders.ID DESC ";

		$this->model->set("fetchAll",0);
		// $this->model->set("printQuery",1);

		$r = $this->model->_all($cond,$page,$sort);

		/*pa($r);*/
		$this->data["reports"] = $r['data'];
	}


	private function site()
	{
		$r = $this->model->table(['tbl'=>'mic'])->fetch( ['index'=>'first'] );
		$this->data['site'] = $r;
	}

}
