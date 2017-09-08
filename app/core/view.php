<?php namespace M5\MVC;

class View{


    public static $_injected;

    function __constrcut($page = '' , $data = [], $adminemplate = ''){

        $this->page = $page;
        $this->data = $data;
    }

    /**
    * That's what does eyes will see
    *
    * @param string $page : page | folder path
    * @param array $data
    * @param String $widgetsTemplate : folder that content header.php footer.php
    * @return Mixed
    */
    public function template($page='', $data = [], $widgetsTemplate = '') {

        $page = !$this->page ? $page : $this->page;
        $data = !$this->data ? $data : $this->data;

        // $data[] = self::$_injected ;

        if ($this->renderd) {
            return false;
        }

        $widgetsTemplate = rtrim($widgetsTemplate,"/");

        $page = strtolower($page) . Config::get('default_view_prefix').'.php';

        $page = !$adminfolder ?  V_PATH.$page :  V_PATH.'admin/'.$page;

        $header = !$widgetsTemplate ?  V_PATH . 'widgets/header.php' :  V_PATH . $widgetsTemplate.'/header.php';
        $footer = !$widgetsTemplate ?  V_PATH . 'widgets/footer.php' :  V_PATH . $widgetsTemplate.'/footer.php';

        if (is_readable($page)) {
            // ob_start();
            require $header;
            require $page;
            require $footer;
        } else {
           echo
           $notes = '<span style="color:#F00"> View Error : <u> ' . $page . "</u> [404!] </span>";
       }

       return $this->renderd = true;
   }


    /**
     *  Show|load one page without header footer .. etc. of template
     *
     * @param  string $page
     * @param  string $data
     * @return mixed
     */
    public function onePage($page='',$data='')
    {
        if ($this->renderd) {
            return false;
        }

        $page = !$page ? V_PATH.'template.php' : V_PATH.strtolower($page).'.php';

        if(is_readable($page)){
            require $page;
        }
        else
            echo '<h4 dir="ltr" style="font:18px tahoma;padding:10px;background-color:#FFCCBC;color:#272727"> <u> '.$page."</u> [404!] </h4>";

        return $this->renderd = true;
    }

    /**
    * Set somthings
    */
    public function set($key,$value){
        return
        $this->$key = $value;
    }


    /**
    * Get somthings
    */
    public function get($key){
        return
        $this->$key;
    }

    public static function inject($values)
    {
        if(!values){
            throw new Exception("params missed!", 1);
        }

        return self::$_injected = $values;
    }


}