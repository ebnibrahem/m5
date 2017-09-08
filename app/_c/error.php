<?php namespace M5\Controllers;

use M5\MVC\Controller as BaseController;

/**
 * Error handler Controller
 *
 */
class Error extends BaseController
{
	public function index(){
		echo "<title>404</title>";

		echo "<h4 dir=\"ltr\" style=\"font:18px tahoma;padding:10px;background-color:#FFCCBC;color:#272727\"> <u> </u> [404!] </h4>";

		\M5\MVC\APP::getAppst(1);

		echo pre("<a href='".url()."'>Home</a> |"."<a href='".url('sole.php')."'>Sole</a> ");
		die();

	}
}