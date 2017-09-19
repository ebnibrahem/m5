<?php namespace M5\MVC;

/**
* Basic Model
* Object Relations Map (ORM)
*
*/

class Model
{

    protected static $inst;
    protected static $DB;
    protected static $sql;

    protected static  $db_error;

    public $total = 0;
    public $offset = 30;
    public $pages = 0;

    private static $tbl;
    private static $show_error;
    private static $target;

    public static $cls;

/**
* Singleton Approach
*
* @return  Object
*/
public static function getInst($tbl='',$show_error=false,$target=false)
{
    self::$tbl = $tbl;

    if(!isset(self::$inst))
    {
        $class = static::class; /* to multi use of model >> with child class name not (Model)*/
        self::$cls = $tbl;
        self::$inst = new $class($show_error);
    }

    self::$show_error =  $show_error ;
    self::$target     =  $target ;

    return self::$inst;
}

/**
* Connect To Database
*
*/
private function __construct()
{
    $db['host']       =  Config::get("host");
    $db['user']       =  Config::get("user");
    $db['pass']       =  Config::get("pass");
    $db['db_name']    =  Config::get("db_name");
    $db['port']       =  Config::get("port");

    extract($db);

    @self::$DB = new \MySQLi($host, $user, $pass, $db_name, $port);
    @self::$DB->set_charset("utf8");

    if(self::$DB->connect_error){
        /*/ trigger_error(self::$DB->connect_error,E_USER_ERROR); //set as php runtime error.*/
        die( pre('<h2> :( '.self::$DB->connect_error.'</h2>','center','','#DD3333') );
    }
}

/**
* Show errors if occurred
*
*/
public function getError(){

    // ve("show_error = ".self::$show_error);

    if(self::$show_error){

        echo "<pre dir='ltr'>";
        if(self::$db_error){
            foreach (self::$db_error as $key => $error) {
                pre("<b>- DB</b>: ".__METHOD__."[  ".self::$target." ] <u>".$error."</u>",'left','ltr','#F33000');
             // trigger_error(self::$target." ".$error) ; //set as php runtime error.
            }
        }else{
            echo "no Errors";
        }
        echo "</pre>";
    }
}


/**
* Select From table ['tbl'=>tab_name]
*
* @param tbl String  associative array row;
*/
public function table(array $args = [] ){
    $tbl = !$args['tbl'] ? self::$tbl : $args['tbl'];
    $fld = !$args['fld'] ? "*" : $args['fld'];

    self::$sql = "SELECT $fld FROM $tbl WHERE 1 ";

    return $this;
}

/**
* @param  string $cond e.g " && 1=1" | " 1=1 " .
* @return Object
*/
public function where($cond=' && 1 ' ){
// if( !preg_match('/&&/', $cond) ){
//     self::$sql .= " && $cond ";
// }else{
//     self::$sql .= " $cond ";
// }
    self::$sql .= " $cond ";

    return $this;
}

/**
* @format : join(['tbl'=>['parts','blogs'], 'on'=> 'parts.ID = blogs.part_id', ])
*/
public function join(array $args , $flag='inner'){
    extract($args);

    $tbl1 = $tbl[0];
    $tbl2 = $tbl[1];

    $on = $args['on'];

    self::$sql = str_replace('WHERE 1', "", self::$sql);

    self::$sql .= " $flag JOIN $tbl1 ON ($on) ";
    self::$sql .= " WHERE 1 ";
    return $this;
}

/**
* Sorting result's records.
*/
public function order($order =''){
    $order = !$order ? " ID DESC " : $order ;
    self::$sql .= " ORDER BY $order ";
    return $this;
}

/**
* @param  String GROUP BY
* @return $this
*/
public function group($GROUP = ''){
    self::$sql .= "GROUP BY $GROUP ";
    return $this;
}

/**
* Geting result's records.
*/
public function fetch(array $args = [] ){
    extract($args);

    $count = !$page[0] ? '0' : $page[0];
    $offset = !$page[1] ? '30' : $page[1] ;
    $start_from = ($count == "0") ? "0" : ($count-1)*$offset;
    $offsetAll = !$offsetAll ? false : $offsetAll;
    $fetch_type = !$fetch_type ? "array" : $fetch_type;

    $sqlAll = self::$sql;

    $sql = !$offsetAll ? $sqlAll. " LIMIT $start_from,$offset" : $sqlAll ;


    $q     = $this->query($sql, $args['printQuery'].$this->get("printQuery"));
    $qAll  = $this->query($sqlAll,$this->get("printQueryAll"),"QUERY ALL: ");
    $total = $qAll->num_rows;

    $this->total = $total;
    self::$sql   = $sql;

    if($q){
        if($fetch_type == "array"){
            while ($row = $q->fetch_assoc() ) {
                $r['data'][] = $row;
            }
        }else{
            while ($row = $q->fetch_object() ) {
                $r['data'][] = $row;
            }
        }

        $r['meta']['total'] = $total;
        $r['meta']['offset'] = $offset;
        $r['meta']['count'] = $count;
        $r['meta']['query'] = $sql;
        $r['meta']['pages'] = ceil($total/$offset);

        $this->result = $r;
    }

    if( $args["index"] == "first")
        return $this->result['data'][0];
    else
        return $this->result;

}

/**
* Fetch rows by passing sql query.
*
* @param  String $sql
* @param  Boolean $printQuery
* @return mixed
*/
public function fetchAll($sql,$printQuery=null){
    $q = $this->query( $sql, $printQuery );

    if($q){
        while ($row = $q->fetch_assoc() ) {
            $r[] = $row;
        }
    }

    return isset($r) ? $r : 0 ;

}

/**
* Fetch One records by passing sql query.
*
* @param  String $sql
* @param  Boolean $printQuery
* @return mixed
*/
public function fetchOne($sql,$printQuery=null){
    $q = $this->query( $sql, $printQuery );

    if($q){
        while ($row = $q->fetch_assoc() ) {
            $r[] = $row;
        }
    }

    return isset($r[0]) ? $r[0] : 0 ;

}

/**
* Fetch rows by passing table name and where condition
*
* @param  String $tbl        table name
* @param  String $cond       where condition start with &&
* @param  Boolean $printQuery show execcuted sql query
* @return mixed
*/
public function select($tbl,$cond="",$printQuery=null){
    $sql = "SELECT * FROM $tbl where 1 $cond";
    $q = $this->query( $sql, $printQuery,__METHOD__ );

    if($q){
        while ($row = $q->fetch_assoc() ) {
            $r[] = $row;
        }
    }

    return isset($r) ? $r : 0 ;
}

/**
* Fetch one Record by passing table name and where condition
*
* @param  String $tbl        table name
* @param  String $cond       where condition start with &&
* @param  Boolean $printQuery show execcuted sql query
* @return mixed
*/
public function selectOne($tbl,$cond="",$printQuery=null){

    if($cond){
        if( !preg_match('/&&/', $cond) ){
            $cond = " && $cond ";
        }else{
            $cond = " $cond ";
        }
    }

    $sql = "SELECT * FROM $tbl where 1 $cond";
    $q = $this->query( $sql, $printQuery );

    if($q){
        while ($row = $q->fetch_assoc() ) {
            $r[] = $row;
        }
    }

    return isset($r[0]) ? $r[0] : 0 ;
}

/**
* Get total of row by passing table naem && cond
*
* @param  string  $tbl        [description]
* @param  string  $cond       [description]
* @param  boolean $printQuery [description]
* @return mixed
*/
public function num_rows($tbl='',$cond="",$printQuery=false) {

    $tbl = !$tbl ? self::$tbl : $tbl;

    $sql = "SELECT * FROM $tbl where 1 $cond";
    $q = $this->query( $sql, $printQuery );

    return $q->num_rows;
}

/**
* Get total of row by passing sql query
*
* @param  boolean $printQuery
* @return [type]
*/
public function total($sql,$printQuery=false){

    $sql = !$this->get("sql") ? $sql : $this->get("sql");
    $sql = !$sql ? self::$sql : $sql;

    $total =  $this->query($sql,$printQuery);

    return $this->total = $total->num_rows;
}

/**
* Execute Query against database.
*
* @param  boolean $printQuery [description]
* @return MYSQL Object | null
*/
public function query($sql,$printQuery=false,$printQueryTarget=false)
{
    $printQueryTarget = self::$target;

    if($printQuery){
        pre("<b>".$printQueryTarget ."</b> >> ".$sql,'','ltr','#00C');
    }

    if(!self::$DB->error){
        return self::$DB->query($sql) ;
    }else{
        self::$db_error[] = self::$DB->error;
        return self::$show_error ? $this->getError() : null;
    }
}

/**
* Excute Query against  database.
*
*/
public function exec($sql,$printQuery=false,$printQueryTarget=''){
    return $this->query($sql,$printQuery,$printQueryTarget);
}


#####################
# DML
####################

/**
* update database records
*
* $args array of records
* $tbl string table name
*
* @version v1.1 [ Now No Needs to specified (u_at_label pram), but MUST passing with args if its(u_at) in table columns ]
* @version v1.2 [ $id = $cond : update condition]
*/

function update($args=[],$id,$tbl='',$printQuery=FALSE)
{
// pa( func_get_args());

    /* When send $id as int */
    if( !preg_match('/&&/', $id) ){
        $id = " && ID = '$id' ";
    }


    if(!$args){
        pa( msg("<b>".$tbl." Error : </b>Missing  fieldset!!",'','ltr'),"exit");
    }
    $tbl = !$tbl ? self::$tbl : $tbl;
    $tbl = !$tbl ? pure_class(get_called_class()) : $tbl;

    $printQuery = (!$printQuery) ? "0" : $printQuery ;

    $total_of_args = count($args);

    $c= 1;
    foreach ($args as $key => $value) {
        $fld = $key."=";
        $data = ( $total_of_args == $c) ? "'".addslashes($value)."' " : "'".addslashes($value)."', " ;
        $record .= $fld.$data;
        $c++;
    }

    $sql = "UPDATE $tbl SET $record  WHERE 1 $id ";

    if($printQuery){
        echo '<pre dir="ltr">'.$sql.'</pre>';
    }

    if($this->exec($sql)){
        return 1;
    }else{
// pre(__METHOD__." <b>".self::$DB->error."</b>",'','ltr','#F33AAA');
        return 0;
    }

}

/*
* Insert database records
*
* $variable array
* $tbl string table name
*/
public function insert(array $variable=[],$tbl='',$printQuery=FALSE,$c_at_label='')
{
    if(!$variable){
        pa( msg("<b>".$tbl." Error : </b>Missing  fieldset!!",'','ltr'),"exit");
    }

    $tbl = !$tbl ? self::$tbl : $tbl;
    $tbl = !$tbl ? pure_class(get_called_class()) : $tbl;

    foreach ($variable as $key => $value) {
        $flds .= "`".trim($key)."`, ";
        $data .= "'".addslashes(trim($value))."', ";
    }

    $c_at_label = !$c_at_label ? 'c_at' : $c_at_label ;
    $c_at_value = R_DATE_LONG;

    /* Check Before insert */
    $ck_cond = $this->get("check_before_insert");

    $sql = "INSERT INTO $tbl ($flds `$c_at_label`) VALUES ($data '$c_at_value')  ";

    if($printQuery){
        pre($sql,'','ltr','#00C');
    }

    if( $this->query($sql) ){
        return true ;
    }else{
        $this->query($sql);
        return null;
    }
    /* pre(__METHOD__." <b>".self::$DB->error."</b>",'','ltr','#F33AAA');*/
}


/**
* Delete Database records
*
* @param  string  $cond
* @param  string  $tbl
* @param  boolean $printQuery
* @return boolean
*/
function delete($cond, $tbl='',$printQuery=FALSE)
{
    $tbl =  !$tbl ? self::$tbl : $tbl;
    $sql = "DELETE FROM $tbl WHERE 1 $cond";
    if($this->query($sql,$printQuery)){
        return 1;
    }else{
        return 0;
    }

}

    #####################
    # Setter and Getter
    #####################
public function set($name,$value= TRUE){
    return
    $this->$name = $value;
}

public function get($name){
    return
    $this->$name;
}

/**
* Set Preferences
*
* @return Boolean
*/
public function setPref($key,$value=1){

    $key = trim($key);
    $value = trim($value);

    $q = self::$DB->query("SELECT ID FROM preferences WHERE `key` = '$key'");
    if(!$q->num_rows){
        /* pre("insert");*/
        self::$DB->query("INSERT INTO preferences (`key`,`value`) VALUES ('$key','$value') ");
    }else{
        pre("update");
        self::$DB->query("UPDATE preferences SET `key` = '$key',`value` = '$value' WHERE `key` = '$key' ");
    }

}

    /**
    *get Preferences
    *
    * @return mysql result
    */
    public static function getPref($key){
        $sql = " SELECT value FROM preferences WHERE `key` = '$key' ";
        $q = self::$DB->query($sql);

        if($q->num_rows){
            while ($row = $q->fetch_assoc() ) {
                $r[] = $row;
            }
            return isset($r[0]) ? $r[0]['value'] : 0;
        }else{
            return null;
        }
    }



}