<?php 	namespace M5\Controllers\System;

/**
 * Create Contollers, Models, views whit UI page.
 *
 * @return mixed
 */
use M5\MVC\App;
use M5\MVC\Config;
use M5\MVC\Controller as BaseController;


class Composer extends BaseController{

	private $class_label = "composer";

	function __construct()
	{
		parent::__construct();
	}

	/** * Main Function */
	public function index(){

		$this->create();

		$this->getView()->onePage('system/composer_view',$this->data);
	}

	private function create(){
		if($_GET['c_file']){
			pa($_GET);
		}
	}


}