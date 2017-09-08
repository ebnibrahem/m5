<?php namespace M5\Library;

/**
 * Navigating with Applications pages and get url off pages
 * 
 * and exit below it codes
 * 
 */

class Page {

    public static function location($page_url,$exit=true) {
        header('location:' . $page_url);

        if($exit){
            die();
        }
    }

    public static function go_to($page_url,$seconds='5',$boom = false) {
        echo '<meta http-equiv="refresh" content="'.$seconds.';url='.$page_url.'" />';

        if($boom){
            echo '<label id="boom" class="'.$boom.'" data-count="'.$seconds.'"><span></label>';
        }
    }

    /**
     * Get Current URL of page
     * @return  string
     */
    public static function url()
    {               
        echo $_SERVER['REQUEST_URI'];
    }

}
