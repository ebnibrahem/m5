<?php 	namespace M5\Controllers\Admin;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;
use M5\Library\Bread;
use M5\Library\Page;
use M5\Library\Up;
use M5\Library\Session;
use M5\Library\Clean;
use M5\Library\Lens;

use M5\Models\Files_Model;

/**
 * File manager
 */
class Files extends BaseController
{

	const FILES_PATH = "upload/_files";

	private $class_label = "files";

	function __construct($alfa="",$beta="",$gama="")
	{
		parent::__construct();

		//breadcrumb
		$this->data["title"] = str($this->class_label);
		$this->data["bread"] = Bread::create( [$this->data["title"]=>"#"] );



	}

	/** main function  */
	public function index()
	{
		$this->add();

		$sub_folder = clean::sqlInjection($_GET['sub_folder']);

		$path = Files::FILES_PATH."/";

		if($sub_folder){
			$path =  $path."/".$sub_folder."/" ;

			$this->data["title"] = str($this->class_label);
			$this->data["bread"] = Bread::create( [$this->data["title"]=>"admin/files", "$sub_folder"=>"#"] );
		}


		$files = Lens::cornea($path);

		// pa($files);


		if($files){
			foreach ($files['file'] as $k => $f) {
				$real_path['files'][$k]['path'] = url().$path.$f ;
				$real_path['files'][$k]['size'] = $files['size'][$k] ;
				$real_path['files'][$k]['type'] = $files['IsFolder'][$k] ;
			}
		}

		$this->data['files'] = $real_path;

		/**/
		$this->getView()->template("admin/files_view",$this->data,$templafolder="admin");
	}


	/**
	 * upload files
	 */
	private function add()
	{
		if( !file_exists(Files::FILES_PATH) )
			mkdir(Files::FILES_PATH,0777,TRUE);

		if($_POST['filesBtn'] && $_FILES['files']['name'][0]){

			// pa( $_FILES['files'] );
			// pa($_POST,"E");

			if($_POST['folderFlag'] && !$_POST['folder']){
				$folder = date("ynjhis") ;
			}else{
				$folder = str_replace(".","_",rtrim($_POST['folder'],"/") ) ;
			}

			$files_path = Files::FILES_PATH."/".$folder;
			$wmAvatar = assets('images/logo.png');
			$watermark = !$_POST['wmFlag'] ? false :  $wmAvatar;
			$args = ["path"=>$files_path,"inputname"=>"files","watermark"=>$watermark];
			pa($args);

			Up::load($args);
			Session::setWink("msg",msg(string('add_success'),'alert b_green f_white','','ltr') );
			Page::location(url().'admin/files?sub_folder='.$_GET['sub_folder']);
		}
	}

	/**
	 * delete
	 */
	public function delete()
	{
		$fileName = clean::sqlInjection($_GET['file']);

		$file = FILES::FILES_PATH."/".$fileName;
		Up::delete(["file"=> $file]);

		page::location(url().'admin/files');
	}
}
