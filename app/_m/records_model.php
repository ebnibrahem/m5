<?php namespace M5\Models;

use M5\MVC\Model as BaseModel;

class Records_Model extends BaseModel
{
	private $tbl = "records";
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

		$r = $this->table(['fld' => $main_tbl.'.*, users.name as userName'])

		->join(['tbl'=>['users', $main_tbl], 'on'=> $main_tbl.'.user_id = users.ID', ])

		->where($cond)
		->order($sort)
		->fetch(['page'=>[$page[0],$page[1]], 'index'=>$one, 'printQuery'=>$this->get('printQuery')]);

		return $r;
	}

	public function _one($id)
	{
		$this->set("one", "first");
		$r = $this->_all();

		return $r;

	}

}
