<?php namespace M5\MVC;

class Route
{
	public     static $http_request;
	public     static $uri;
	public     static $class;

	public     static $route_ruels_list;
	protected  static $notes = [];

	protected static $router;

	protected static $directory;
	protected static $language;
	protected static $controller;
	protected static $method;
	protected static $params;


	static function http($uri,$controller='')
	{
		// pa( func_get_args() );

		self::$uri[]   = $uri;
		self::$class[] = $controller;

		self::$route_ruels_list[$uri] = $controller;

	}

	/**
	 * Play Application.
	 *
	 * @param  boolean :to: $show_st show application status.
	 * @return mixed
	 */
	static function play($show_st=null)
	{
		/*1. http_request*/
		$url = isset($_GET['url']) ? "/".$_GET['url'] : "/";

		/*2. parser http_request*/
		self::parser($url);

		$controller_rules = "/".strtolower(self::$controller);


		/*3. dispatcher*/
		self::dispatcher();

		// pa(self::$route_ruels_list);

		/*4. show application status */
		self::status($show_st);
	}

	/**
	* Speciefied lang,dir,controller,method and params.
	*
	* @param string $url
	* @return mixed
	*/
	protected static function parser($url){

		$request = trim($request,"/");
		$router = new Router($url);

		self::$http_request  = $url;
		self::$directory  = $router->getDirectory();
		self::$language   = $router->getLanguage();
		self::$controller = $router->getController();
		self::$method     = $router->getMethod();
		self::$params     = $router->getParams();
	}

	/**
	* Calling controller | call default controller if does not exists.
	*
	*  @return mixed
	*/
	function dispatcher()
	{
		$http_request       = self::$http_request;
		$getController      = strtolower(self::$controller);

		$main_class_handler = ($getController == "index") ? "/" : $getController;

		/* adding "/" */
		$route_rules_key   = ($main_class_handler=="/") ? $main_class_handler : "/".$main_class_handler;

		// ve(self::$route_ruels_list);

		/* name of controller in route_ruels_list*/
		$controller_name = self::$route_ruels_list[$route_rules_key];

		// var_dump($controller_name);

		/*check in|not route rules contoller list (app/routes.php) */
		if($controller_name){

			/*? aren't callable */
			if(is_string($controller_name)){

				/* 1. $http_request without [@,.] */
				if($http_request == $route_rules_key){
					$msg = "calling $controller_name::default_method() " ;
					self::$notes[] = $msg;

					// $class = "\M5\Controllers\\".ucfirst($controller_name);
					// $init = new $class();
					// $init->index();
					App::play($controller_name);

				}else{
					/* 2. $http_request with [@,.] */
					echo $url = trim($http_request,"/");
					App::play($url);
				}


			}else{
				call_user_func($controller_name);
				$msg  = "[ $main_class_handler ] callable function";
				self::$notes[] = $msg;
			}

		}else{
			$msg = "[ ".$getController." ] not exists in route rules (app/routes.php)" ;
			self::$notes[] = $msg;
		}

		// if(is_string($http_request)){

		// 	if (preg_match('/@/',$http_request))
		// 	{
		// 		$boot = str_replace("@", "/", $http_request);
		// 		self::boot($boot);

		// 	}else{
		// 		// $class = "\M5\Controllers\\".ucfirst($http_request)."Controller";
		// 		// $init = new $class();
		// 		// $init->index();
		// 	}

		// }else{
			// call_user_func($http_request);
		// }
	}

	/**
	 * application status.
	 *
	 * @return mixed
	 */
	public static function status($flag=null)
	{
		if(!$flag)return null;

		echo "<pre align=\"left\" style=\"direction:ltr\">";
		echo div("\t<h4><u>Application Status:</u></h4>");
		echo div("\t<b> Current http_request</b>: <u>".self::$http_request )."\n</u>";
		echo div("\t<b> Directory</b>: ".self::$directory);
		echo div("\t<b> Language</b>: ".self::$language);
		echo div("\t<b> Controller</b>: ".self::$controller);
		echo div("\t<b> Method</b>: ".self::$method);
		echo div("\t<b> Params</b>: ".!self::$params ? "\t<b> Params</b>: null " : implode(self::$params,", ") );
		echo div("\t<h4><u>Runtime Notes:</u> </h4>");
		if(self::$notes){
			echo "<ul>";
			foreach (self::$notes as $key => $msg) {
				echo div("<li>$msg</li> ");
			}
		}
		echo "</ul>";
		echo "</pre>";
	}

}