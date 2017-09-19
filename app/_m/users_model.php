<?php namespace M5\Models;

use M5\MVC\Model as BaseModel;

class Users_Model extends BaseModel
{
	private $tbl = "users";

	function __construct($tbl='',$se='',$target='')
	{
		$tbl = !$tbl ? $this->tbl : $tbl ;
		$target = !$target ? __METHOD__ : $target ;

		parent::getInst($tbl,$se,$target);
	}

	/**
	 * All records
	 *
	 * @param  string $cond
	 * @param  array  $page
	 * @param  string $sort
	 * @return mixed
	 */
	public function _all($cond='',$page=[],$sort=''){
		$main_tbl = $this->tbl;
		$one = $this->get("one");
		$cond .= $this->get("cond");

		$r = $this
		->table(
			['fld' => $main_tbl.'.*']
			)
		// ->join(['tbl'=>['users','blogs'],  'on'=> 'users.ID = blogs.user_id', ])

		->where($cond)
		->order($sort)
		->fetch(['page'=>[$page[0],$page[1]], 'index'=>$one, 'printQuery'=>$this->get('printQuery')]);

		return $r;
	}

	public function _one($id='',$cond='')
	{

		$cond = !$id ? $cond : "&& ".$this->tbl.".ID = '$id'";
		$this->set("cond", $cond);

		$this->set("one", "first");
		$r = $this->_all();

		return $r;

	}

}
