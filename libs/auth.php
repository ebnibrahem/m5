<?php namespace M5\Library;

use M5\MVC\Config;
use M5\Library\Session;
use M5\Library\Pen;
use M5\Library\Page;

class Auth
{

    /**
    * Checked if logined
    *
    * @version 1.1 remember current url and redirect-to when relogin.
    *
    * @return boolean
    */
    static function isLogined(array $args = [],$redirect_again_to=null) {
        // Intialize and Defauls ..
        $args['session'] = !$args['session'] ? 'login2' : $args['session'];
        $args['redirect'] = !$args['redirect'] ? Config::get("site") : $args['redirect'];
        $args['msg'] = !$args['msg'] ? str("Login") : $args['msg'];

        $args['redirect_again_to'] = !$redirect_again_to ?  Config::get("site") : $redirect_again_to;

        Session::set("redirect_again_to",$redirect_again_to);

        extract($args);

        if( !Session::get($session) ){
            $msg = Pen::msg($msg);
            Session::setWink("msg",$msg);
            Page::location($redirect);
            exit();
        }

    }


    /*
    *@parm array rolesArray : مصفوف الصلاحيات التي يملكها المستتخدم
    *@parm array required_rolesArray : الصلاحيات المطلوب توفرها لاتاحة الوصول
    *
    * @Since v1.1 [ add 3th arg] ( to avoid break code if its called inside views-pages)
    */
    static function valid(array $rolesArray,array $required_rolesArray,$dontshowecho=false)
    {

        if(!$rolesArray || !$required_rolesArray){
            throw new Exception("meet all auth Arguments ");
        }else{

            foreach ($rolesArray as $r) {

                foreach ($required_rolesArray as $p) {
                   // echo "<div>". var_dump($r == $p) ." </div>";
                    if($r == $p)
                        $out[] = $r;
                }
            }

            $out = !$out ? [] : array_unique($out);



            if(!$out[0]){
                if($dontshowecho){
                // //dont show print somthing
                // return 200;
                }else{
                    echo '<meta charset="utf-8">';
                    die("<h1 align='center' style=' position: fixed;
                        z-index: 100;
                        top: 50%;
                        color:#F00;
                        padding: 5px;
                        width:100%;
                        background:#FFF;
                        font-size: 33px;'> ".string('access_denied')."" );
                }
            }else{
                return 200;
            }

        }

    }

}