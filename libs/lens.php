<?php namespace M5\Library;

    /**
    * update v2 29.00A2A612.2016
    * @ see all grime in crystal
    *
    */
    class Lens{

        static function  cornea($pathOfFiles,$full_path='')
        {
            if(!file_exists($pathOfFiles)){
                return 0;
                // return pre('the Folder <u>'.$pathOfFiles.'</u> Not Found!','','','#F00');
            }

            $ex = scandir($pathOfFiles, 1);
            $stop = (count($ex) - 2);
            for ($i=0; $i <$stop ; $i++) {
                $type = end( explode(".",$ex[$i]) );
                $Flist["IsFolder"][] = (is_dir($pathOfFiles.'/'.$ex[$i]) =="1") ? 'folder' : $type;

                $Flist["file"][] = $full_path.$ex[$i];
                $size = filesize( $pathOfFiles.'/'.$ex[$i]);
                $Flist["size"][] = number_format( ($size/1024/1024),2);//MB
            }
            // pa($pathOfFiles);
            // pa($ex);
            return $Flist;
        }

        static function type($extention){
            $image = array("png","jpg","jpeg","gif");
            $video = array("mp4","3gp");
            $audio = array("mp3","wav","rm","ogg");
            $folder = array("folder","dir");

            $extention = strtolower($extention);

            if(in_array($extention,$image) ){
                $return = "image";
            }elseif (in_array($extention,$video) ){
                $return = "video";
            }elseif (in_array($extention,$audio) ){
                $return = "audio";
            }elseif (in_array($extention,$folder) ){
                $return = "folder";
            }else{
                $return = "unkown";
            }
            return $return;
        }
    }