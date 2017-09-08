<?php namespace M5\Library;

use M5\MVC\Model;
/**
* Make Mysql tables
*
*/
class Schema {
	private static $tbl;
	private static $ready = null;
	private static $DB;

	private function __construct(){}

	private function __clone(){}

	/**
	 * Create tbl with main records[ID,BETA.c_at,u_at]
	 * @param  [type] $tbl [description]
	 * @return [type]      [description]
	 */
	public static function init($tbl='',$show_error=null,$printQuery=null)
	{
		if(! isset($tbl)){
			throw new \Exception("table name required!", 1);
		}

		self::$DB = Model::getInst($tbl);

		self::$tbl = $tbl;

		//self::$DB->set("hide_error",!$show_error);

		$DML = " CREATE TABLE IF NOT EXISTS $tbl (
		ID INT PRIMARY KEY AUTO_INCREMENT,
		BETA VARCHAR(64),
		c_at VARCHAR(20),
		u_at VARCHAR(20)
		) ";

		if( self::$DB->query($DML,$printQuery,__METHOD__) ){
			// pre("# $tbl Created!");
			return self::$ready = true;
		}
		else
			return false;
	}

	//Ckeck if table exists => Create
	//OR => UPDATE
	public static function weave(array $args,$printQuery=null)
	{
		if(! self::$ready)
			die(" Error in Schema::init function ");

		$tbl = self::$tbl;

		ksort($args);

		$sql_check_if_coulms_added = "SHOW COLUMNS FROM $tbl";
		$r = self::$DB->fetchAll($sql_check_if_coulms_added);

		if($r){
			foreach ($r as $key => $value) {
				$tbl_flds[] = $value['Field'];
			}
			// pa($tbl_flds);

			foreach ($args as $key => $value) {
				$fld = $key;
				$datatype = $value;
				if (! in_array($fld, $tbl_flds)) {
					// pre("not found ".$fld);
					$sql = "ALTER TABLE $tbl ADD `$fld` $datatype AFTER `BETA` ;";
					$sqled .= $sql."\n";
					self::$DB->query($sql,$printQuery,__METHOD__);
				}
			}

			$printQuery ? pre( $sqled) : "";
		}

	}

	/**
	 * get tables name
	 *
	 * @return array
	 */
	public static function tables($db,$implode=null,$show_fields=null)
	{
		self::$DB = Model::getInst($tbl);

		$sql_check_if_coulms_added = "SHOW TABLES";
		$r = self::$DB->fetchAll($sql_check_if_coulms_added);

		if($r){
			foreach ($r as $key => $value) {
				$tbls[] = $value['Tables_in_'.$db];
				/* .. Here show fields of table */
				// Schema::fields($value['Tables_in_'.$db]);
			}
			if($implode){
				return implode($implode, $tbls);
			}

			return $tbls;
		}
	}

	/**
	 * get table fields
	 *
	 * @return array
	 */
	public static function fields($tbl,$implode=null)
	{
		self::$DB = Model::getInst($tbl);

		$sql_check_if_coulms_added = "SHOW COLUMNS FROM $tbl";
		$r = self::$DB->fetchAll($sql_check_if_coulms_added);

		if($r){
			foreach ($r as $key => $value) {
				$tbl_flds[] = $value['Field'];
			}
			if($implode){
				return implode($implode, $tbl_flds);
			}

			return $tbl_flds;
		}

	}
}

