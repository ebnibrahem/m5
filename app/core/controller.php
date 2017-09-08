<?php namespace M5\MVC;

 /**
 * Main Controller
 *
 */
 class Controller extends Shared
 {
	public static $view; // Aceess view staticlly ::
	public $request; //access view normally ->

	private static $shared; // Access to share class

	function __construct(){

		parent::__construct();

		self::$view = new View();
		$this->request = self::$view;

		self::$shared = new Shared;

		$this->getShared();
	}

	public function getView(){
		return self::$view;
	}

	/**
	 * Access to Every things Sharable.
	 * @return object
	 */
	public  function getShared(){
		return self::$shared;
	}


}