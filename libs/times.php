<?php namespace M5\Library;

use M5\Library\Session;
use M5\Library\Pen;
use M5\Library\Page;

class Times
{

    static function after($date,$prefex='قبل')
    {
           // echo "$date ";
        $date = new \DateTime($date);
        $now = new \DateTime( date("Y-m-d H:i:s"));

        $_y = $date->diff($now)->y;
        $_m = $date->diff($now)->m;
        $_d = $date->diff($now)->d;
        $_h = $date->diff($now)->h;
        $_i = $date->diff($now)->i;

        $_y = !$_y ? '' :  $_y.' سنة ';

        if($_m){
            if ($_m == "1")
                $_m = ' شهر واحد ';
            elseif($_m == "2")
                $_m = ' شهرين ';
            elseif($_m > 2 && $_m <= 10)
                $_m = $_m.' أشهر ';
            elseif($_m > 10)
                $_m = $_m.' شهر ';

        }else
        $_m = '';

        if($_d){
            if ($_d == "1")
                $_d = ' يوم واحد ';
            elseif($_d == "2")
                $_d = ' يومين ';
            elseif($_d > 2 && $_d <= 10)
                $_d = $_d.' ايام ';
            elseif($_d > 10)
                $_d = $_d.' يوم ';

        }else
        $_d = '';


        if($_h){
            if ($_h == "1")
                $_h = ' ساعة واحدة ';
            elseif($_h == "2")
                $_h = ' ساعتين ';
            elseif($_h > 2 && $_h <= 10)
                $_h = $_h.' ساعات ';
            elseif($_h > 10)
                $_h = $_h.' ساعة ';
        }else
        $_h = '';

        if($_i){
            if ($_i == "1")
                $_i = ' دقيقة واحدة ';
            elseif($_i == "2")
                $_i = ' دقيقتين ';
            elseif($_i > 2 && $_i <= 10)
                $_i = $_i.' دقائق ';
            elseif($_i > 10)
                $_i = $_i.' دقيقة ';

        }else
        $_i = '';


        if($_y){
            unset($_i,$_h,$_d,$_m);
        }

        if($_m){
            unset($_i,$_h,$_d);
        }

        if($_d){
            unset($_i,$_h);
        }

        if($_h){
            unset($_i);
        }

        $e = $_i.$_h.$_d.$_m.$_y;

        $e = !$e ? ' ثواني ' : $e;

        return "$prefex ".$e;
    }
}