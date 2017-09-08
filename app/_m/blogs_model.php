<?php namespace M5\Models;

use M5\MVC\Model as BaseModel;

class Blogs_Model extends BaseModel
{
	private $tbl = "blogs";

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
			['fld' => $main_tbl.'.*, users.name authorName, tree.name as partName, childPart.name as childName  ']
			)
		->join(['tbl'=>['users','blogs'],  'on'=> 'users.ID = blogs.user_id', ])
		->join(['tbl'=>['tree','blogs'],  'on'=> 'tree.ID = blogs.part_id', ],'LEFT')
		->join(['tbl'=>['tree as childPart','blogs'],  'on'=> 'tree.ID = blogs.child_id', ],'LEFT')

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

		$this_folder = 'upload/blogs/'.$r['BETA'].'/';

		/* Create Empty folder if not created before*/
		// mkdir($this_folder,0777,TRUE);
		// mkdir($this_folder_atachment,0777,TRUE);
		// mkdir($this_folder_video,0777,TRUE);


		if($r){
			/*get images*/
			$images = get_uploads($this_folder,'file');
			$r['images'] = $images;
			$r['ava'] = !$images[0] ? NO_IMG : $images[0];
		}

		return $r;

	}

}
