<?php

require_once 'model/photoModel.php';
require_once 'controller/ProductsController.php';

class PhotoController {

    public function new( $stock_keeping_unit ){
        require_once 'view/photo_new.php';
    }

    public function save( $stock_keeping_unit ){
        $photo = new Photo();
        $photo->setStockKeepingUnit($stock_keeping_unit);

        $str_arr = $photo->post_photo_next();
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

        if(isset($_FILES['photo'])){
            $errors= array();
            $file_name = $_FILES['photo']['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name_2 = $stock_keeping_unit."_".$seq.".".$file_ext;
            $file_size = $_FILES['photo']['size'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_type = $_FILES['photo']['type'];
            @$file_ext = strtolower(end(explode('.',$_FILES['photo']['name'])));
            $extensions = array("jpeg","jpg","png");
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if($file_size > 2097152){
                $errors[]='File size must be excately 2 MB';
            }
            if(empty($errors)==true){
                @mkdir("foto/".$stock_keeping_unit, 0777, true);
                move_uploaded_file($file_tmp,"foto/".$stock_keeping_unit."/".$file_name_2);
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
                }
                $filename = "foto/".$stock_keeping_unit."/".$file_name_2;
                
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

                $photo->setFileName($file_name_2);
                $photo->setSequence($seq);
                $photo->post_photo_save();
                ProductsController::edit($photo->getStockKeepingUnit());
            }else{
                ProductsController::edit($photo->getStockKeepingUnit());
            }
        }
    }

    public function delete( $array ){
        $photo = new Photo();
        $photo->setStockKeepingUnit($array[0]);
        $photo->setFileName($array[1]);
        $photo->post_photo_delete();
        ProductsController::edit($photo->getStockKeepingUnit());
    }

}
?>