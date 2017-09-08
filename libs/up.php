<?php namespace M5\Library;

use M5\Library\Session;
use M5\Library\Pen;
use M5\Library\Page;

    /**
    * upload files
    * must pass array in e.g: <input type "file" name="images[]"
    *
    * @return   array files Names
    */
    class Up{

        /**
         * [load description]
         * @param  array  $args [description]
         * @return [type]       [description]
         */

        const FILES_PATH = "upload/_files/";

        static function load($args = []){
            extract($args);

            //args
            $type = !$type ? 'photo' : $type;
            $inputname = !$inputname ? 'images' : $inputname;
            $path = !$path ? 'upload/' : $path;
            $rename = !$rename ? uniqid() : $rename;
            /*v1.1*/
            $watermark = !$watermark ? false : $watermark;

            if(!file_exists($path)){
                mkdir($path);
            }

            foreach ($_FILES[$inputname]['name'] as $key => $file):

                /*FILES array*/
            $name = $_FILES[$inputname]['name'][$key] ;
            $type = $_FILES[$inputname]['type'][$key] ;
            $tmp_name = $_FILES[$inputname]['tmp_name'][$key] ;
            $extention = ".".end( explode(".",$name) );

            /* dont set number with file name: 1logo.png if upload one file */
            $rename_rule =  count($_FILES[$inputname]['name']) == "1" ? '' : ($key+1);

            $remote_file = $path.'/'.$rename_rule.$rename.$extention;

            // if(self::check($tmp_name)){
            if( move_uploaded_file($tmp_name, $remote_file) )
            {
                /* add watermark in images*/
                if($watermark){
                    watermark(["src"=> $remote_file, "logo"=>$watermark]);
                }

                $_return['file'][] = $remote_file;
            }
            // }
            endforeach;

            // pa($_FILES[$inputname]);
            return $_return;
        }
        /**
         * delete file
         * @param  array  $args [description]
         * @return [type]       [description]
         */
        static function delete($args = []){
            extract($args);
            $file = $file;

            chown($file,666);
            if(file_exists($file)){
                if(unlink($file)){
                    return true;
                }else {
                    echo "Unabled to delete! ";
                }
            }
        }

         /**
         * check real file type
         *
         * @version v1.1 add pdf hecker
         * @param  [type] $temp_name
         * @param   $type
         * @return  bool
         */
         private function check($temp_name,$type=''){
            $type = !$type ? 'photo' : $type;

            /**chek images*/
            $image = getimagesize($temp_name);
            if($image[0]){
                $return['photo'] =  TRUE;
            }else{
                $return['photo'] = false;
            }

            /**check pdf*/
            $file = $temp_name;
            if(!$file){
                echo  pen::msg("اختر مسار الكتاب اولاً");
                die($msg);
            }

            //check if is a pdf file
            $filename = $file;
            $handle = fopen($filename, "r");
            $header = fread($handle, 4);
            fclose($handle);

            if($header != "%PDF"){
                $return['PDF'] =  false;
            }else{
                $return['PDF'] =  TRUE;
            }

            return $return;


        }
        /**
         * Delete directory and inside files | just delete directory.
         *
         * @version 1.1 delete files if inside | just delete dir if $del_dir = ture
         *
         */
        static function delete_dir($dir_name,$del_dir=true){

            /*get dir files*/
            $files = lens::cornea($dir_name,$dir_name)['file'];
            // pa($files);

            if($files){
                /*1. Delete all files*/
                foreach ($files as $key => $file) {
                    self::delete(['file'=>$file]);
                }
            }

            /*2. Delete dir*/
            if($del_dir && file_exists($dir_name) === TRUE){
                if( rmdir($dir_name) ){
                    return true;
                }
            }
        }
    }
