<?php namespace M5\Models;

use M5\MVC\Model as BaseModel;

class Users_Model extends BaseModel
{
	private $tbl = "users";

	function __construct($tbl='')
	{
		// $this->model = BaseModel::getInst($this->tbl);
		parent::getInst($this->tbl);
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

	public function _one($id)
	{
		$this->set("one", "first");
		$this->set("cond", "&& ".$this->tbl.".ID = '$id'");
		$r = $this->_all();

		$this_folder = 'upload/blogs/'.$r['BETA'].'/';

		return $r;

	}

}
