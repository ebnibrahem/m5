<?php namespace M5\Library;

  /**
   * @ axeing text
   * @var string wall : set walls between home rooms
   */
  class Axe
  {
  	static function word($text,$wordNumber=10)
  	{
  		$ex = explode(" ", $text);
  		$exCount = count($ex);
  		for($i=0; $i<$wordNumber; $i++){
  			$showWords .= $ex[$i]." ";
  		}
  		return $showWords;
  	}

      //discover \n and replace with private wall
  	static function putLn($text,$wall="_1987_"){
  		$ex = str_replace("\n", $wall, $text);
  		return $ex;
  	}
  	static function optLn($text,$wall="_1987_"){
  		$ex = str_replace($wall,"<br />" , $text);
  		return $ex;
  	}
  	static function knife($text,$boan="_1987_"){
  		$ex = str_replace($boan,"\n" , $text);
  		return $ex;
  	}

    /*
    * Setup link to be accept in url
    *
    */
    static function url($text,$long='70')
    {
    	$ex = str_replace(" ","-",$text);
    	$ex = mb_substr($ex, 0,$long,"utf8");
    	return rawurlencode("-".$ex);
    }

    static function deUrl($text)
    {
    	$ex = str_replace("-"," ",$text);
    	return rawurldecode($ex);
    }

    static function first($text)
    {
    	$e = explode(" ", $text);
    	return $e[0];
    }

    /* April 2016 */
    static function youtube($url)
    {
    	$e = end( explode("watch?v=",$url) );
    	return $e;
    }


    /*
    * prepare link to be accept as url.
    *
    */
    static function preUrl($text)
    {
      $ex = trim($text);
      $ex = str_replace(" ","-",$text);
      return rawurlencode($ex);
    }


    /*
    * re-prepare link to be accept as String.
    *
    */
    static function preUrlGet($text)
    {
      $ex = trim($text);
      $ex = str_replace("-"," ",$text);
      return rawurldecode($ex);
    }

    static function mb_str_replace($needle, $replacement, $haystack) {
     return implode($replacement, mb_split($needle, $haystack));
   }

 }
