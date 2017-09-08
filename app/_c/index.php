<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Axe;

use M5\MVC\Model;
use M5\Models\Blogs_Model;

class Index extends BaseController
{
	private $class_label = "home";
	private $tbl = "users";

	protected static $login;

	function __construct()
	{
		parent::__construct();

		self::$login = Model::getInst($this->tbl);

		$this->request->action = "index";
		$this->request->header_string = "home";


		/*breadcrumb*/
		$this->data["title"] = site_name ." | ".str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );

		$subj = "Test SMTP";
		$reciver = "ebnibrahem@gmail.com";
		$sender = mail_from;
		$msg = "<b>Test</b> STMP FROM ".IP ;
		// \M5\Library\Email::smtp($subj, $reciver, $sender, $msg);

	}


	/** * Main Function */
	public function index($params = []){

		$this->records_last();
		$this->traffic();
		$this->sitemap();

		/*SEO */
		$r = $this->model->fetchOne("SELECT * FROM mic WHERE 1",0);

		$this->request->SEO = $r["keywords"];
		$this->request->SEO_DESC = $r["description"];
		$this->request->SEO_IMG = $r["ava"];


		/*view*/
		$this->getView()->template("index/index_view",$this->data);
	}


	/**
	 *  Show last records | blogs
	 *
	 */
	private function records_last(){

		/* Last blogs*/
		$cond = " && blogs.st IN (1)";
		$offset = 10;
		$page = [$_GET['page'], $offset ];
		$sort = 'blogs.ID DESC';

		$blogs = new Blogs_Model();
		$r = $blogs->_all($cond,$page,$sort);

		$this->data['blogs_last'] = $r['data'];

		$this->request->cond = $cond;


	}


	/**
	 * [traffic description]
	 * @return mixed
	 */
	private function traffic()
	{
		$ip = IP;
		$countryName = \M5\Library\Tools::Geo()['geoplugin_countryName'];
		$r_date = R_DATE;
		$r_time = date("h:ia");
		$today = date("j");

		$sql = "select ip from audience where ip = '$ip' && day(r_date) = '$today'";
		$exec = $this->model->query($sql);

		// if($exec->num_rows  <= 0 ){
		$SQL = "INSERT INTO audience (`ip`,`country`,`r_time`,`r_date`) VALUES ('$ip','$countryName','$r_time','$r_date')";
		$this->model->query($SQL);
		// }
	}

	private function sitemap()
	{

		/*minimizing css*/
		// minimizing("style");

		minimizing(["smart","style","spots","default","ltr"]);

		$xml = '<?xml version="1.0" encoding="utf-8"?>
		<urlset
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
		';

		$fixed_pages = ["blogs","categories"];

		/*Dynamic_pages*/
		$pre_pages = $this->model->select("pages"," && `type` = 'page' ");

		if($pre_pages){
			foreach ($pre_pages as $p) {
				$pages[] = "pages/".$p['slug'];
			}
		}

		if($pages){
			$nodes = array_merge($fixed_pages,$pages);
		}else{
			$nodes = $fixed_pages;
		}

		// ve($nodes);

		if($nodes){
			foreach ($nodes as $n) {
				$header .= '
				<url>
					<loc>'.url().$n.'</loc>
					<lastmod>'.R_DATE.'</lastmod>
					<changefeq>'.Daily.'</changefeq>
				</url>';
			}
		}

		/*blogs*/
		$blogs = new Blogs_Model();
		$r_blogs =  $blogs->_all();

			// pa($r_blogs['data']);

		if($r_blogs['data']){
			foreach ($r_blogs['data'] as $_ads) {
				$blog .=
				"<url> <loc>".url().'blogs/'.$_ads['ID'].Axe::url($_ads['name']).'</loc>
				<lastmod>'.str_replace("/", "-", current( explode(" ",$_ads['c_at']) ) ).'</lastmod>
				<changfreq>Daily</changfreq>'
				."</url>";
			}
		}

		$content = $xml.
		'<url>
		<loc>'.url().'</loc>
		<lastmod>'.current(explode(" ",R_DATE) ).'</lastmod>
		<changefeq>'.Daily.'</changefeq>
	</url>
	'
	.$header;

	$content .= $blog;
	$content .= '</urlset>';

	/*create xml file*/
	$myfile = fopen("Sitemap.xml", "w");
	file_put_contents("Sitemap.xml",$content);
}



}