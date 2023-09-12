<?php

require_once 'model/videoModel.php';
require_once 'controller/ProductsController.php';
require 'vendor/autoload.php';

class VideoController {

    public function new( $stock_keeping_unit ){
        require_once 'view/video_new.php';
    }

    public function save( $stock_keeping_unit ){
        $video = new Video();
        $video->setStockKeepingUnit($stock_keeping_unit);

        $str_arr = $video->post_video_next();
        $str_arr = substr($str_arr, 1, -1);
        $str_arr = preg_split ("/\,/", $str_arr);
        $array = $str_arr;
        $seq = 1;
        asort($array);
        foreach($array as $valor){
            if($valor != $seq){
                break;
            }
            $seq++;
        }

        if(isset($_FILES['video'])){
            $errors= array();
            $file_name = $_FILES['video']['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name_2 = $stock_keeping_unit."_".$seq.".".$file_ext;
            $file_size = $_FILES['video']['size'];
            $file_tmp = $_FILES['video']['tmp_name'];
            $file_type = $_FILES['video']['type'];
            @$file_ext = strtolower(end(explode('.',$_FILES['video']['name'])));
            $extensions = array("mp4");
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a MP4 file.";
            }
            if($file_size > 20485760){
                $errors[]='File size must be excately 10 MB';
            }
            if(empty($errors)==true){
                //@mkdir("video/".$stock_keeping_unit, 0777, true);
                move_uploaded_file($file_tmp,"video/".$file_name_2);
                /*
                if($file_type == "image/png"){
                    $image = imagecreatefrompng("foto/".$stock_keeping_unit."/".$file_name_2);
                    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                    imagealphablending($bg, TRUE);
                    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                    imagedestroy($image);
                    $quality = 100;
                    imagejpeg($bg, "foto/".$stock_keeping_unit."/".$stock_keeping_unit."_".$seq.".jpg", $quality);
                    imagedestroy($bg);
                    unlink("foto/".$stock_keeping_unit."/".$file_name_2);
                    $file_name_2 = $stock_keeping_unit."_".$seq.".jpg";
                } */
                $filename = "video/".$file_name_2;
                
/*
                $width = 1200;
                $height = 1200;
                list($width_orig, $height_orig) = getimagesize($filename);
                $ratio_orig = $width_orig/$height_orig;
                if ($width/$height > $ratio_orig) {
                    $width = $height*$ratio_orig;
                } else {
                    $height = $width/$ratio_orig;
                }
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($filename);

                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                imagejpeg($image_p, "foto/".$stock_keeping_unit."/".$file_name_2, 100);
*/
/*
                $width = 240;
                $height = 240;
                list($width_orig, $height_orig) = getimagesize($filename);
                $ratio_orig = $width_orig/$height_orig;
                if ($width/$height > $ratio_orig) {
                    $width = $height*$ratio_orig;
                } else {
                    $height = $width/$ratio_orig;
                }
                $image_p = imagecreatetruecolor($width, $height);
                $file_name_3 = $stock_keeping_unit."_thumbnail_".$seq.".jpg";
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, "foto/".$stock_keeping_unit."/".$file_name_3, 100);
*/

                $video->setFileName($file_name_2);
                $video->setFileNameThumbnail('');
                $video->setSequence($seq);
                
/*
                $ffmpeg = FFMpeg\FFMpeg::create();
                $video_FFMpeg = $ffmpeg->open('video/'.$file_name_2);
                $video_FFMpeg
                    ->filters()
                    ->resize(new FFMpeg\Coordinate\Dimension(600, 600))
                    ->synchronize();
                $video_FFMpeg
                    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(6))
                    ->save('video/'.$stock_keeping_unit.'_'.$seq.'.jpg');
                    */
                //$video_FFMpeg
                    //->addFilter(new \FFMpeg\Filters\Audio\SimpleFilter(['-an']))
                    //->save(new FFMpeg\Format\Video\X264(), 'video/export-x264.mp4');

                    //unlink("video/".$file_name_2);
                    //rename("video/export-x264.mp4", "video/".$file_name_2);

                $video->setSize(filesize("video/".$file_name_2));
                //echo filesize("video/".$file_name_2);
                $video->post_video_save();

                ProductsController::edit($video->getStockKeepingUnit());
            }else{
                ProductsController::edit($video->getStockKeepingUnit());
            }
        }
    }

    public function delete( $array ){
        $video = new Video();
        $video->setStockKeepingUnit($array[0]);
        $video->setFileName($array[1]);
        $video->post_video_delete();
        ProductsController::edit($video->getStockKeepingUnit());
    }

}
?>