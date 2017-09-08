<?php namespace M5\Models;

use M5\MVC\Model as BaseModel;

/**
 * ##################### DEVELOPING #################
 */

class Tree_Model extends BaseModel{
	/**
	* Tree and categiores
	*/

	private $tbl = "tree";

	function __construct($tbl='',$se='',$target='')
	{
		$tbl = !$tbl ? $this->tbl : $tbl ;
		$target = !$target ? __METHOD__ : $target ;

		parent::getInst($tbl,$se,$target);
	}


	public function parents($type = '', $printQuery = FALSE){
		$type = !$type ? "part" : $type;

		$cond = " && parent = '0' && type = '$type'";
		$cats = $this->table()->where($cond)->fetch(['printQuery'=>$printQuery]);

		return $cats['data'];
	}


	public function branch($root_flag = '',$fld='', $printQuery = 1){

		$fld = !$fld ? "BETA" : $fld;

		/* Get parent record */
		$parent = $this->table()->where(" && $fld = '$root_flag' ")->fetch(['index'=>'first', 'printQuery'=>$printQuery]);

		$parent_id = $parent['ID'];

		$cond = " && (parent = '$parent_id' )";
		// $cond = " && 1 ";

		$cats = $this->table()->where($cond)->fetch(['printQuery'=>$printQuery]);

		return $cats['data'];

	}

}