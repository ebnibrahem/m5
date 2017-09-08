<?php namespace M5\Library;

/**
 * whit pencil you can write all messages or alerts
 */

class Pen {

	public static function msg($Message, $class = 'alert alert-danger',$align='center',$dir='rtl') {
		$exe = "<div align=\"$align\" class='$class '>$Message</div>";
		return $exe;
	}

	public static function print_array($array, $stop = '') {
		echo "<pre dir=\"ltr\" align=\"left\" style='background:#FFF'>";
		print_r($array);
		echo "</pre>";

		if ($stop) {
			exit();
		}
	}

	public static function pa($array, $stop=''){
		echo "<meta charset=\"utf8\" >";
		return self::print_array($array, $stop);
	}

	public static function Ides($postIdKey = 'id') {
		$e = implode(",", $_POST[$postIdKey]);
		return $e;
	}

	public static function alert($text){
		echo "
		<script>
			alert('$text');
		</script>
		";
	}

	public static function toast(){
		echo"
		<style>
            #MIC_toast{height:100% !important;}
		</style>
		";
	}

	public static function json($json)
	{
		$e = $json;
		$e = json_decode($json,true);

		return $e;
	}
}
