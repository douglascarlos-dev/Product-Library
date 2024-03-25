<?php

require_once 'model/bannerfileModel.php';
require_once 'controller/BannerController.php';

class BannerfileController {

    public function new( $banner_name ){
        require_once 'view/banner_file_new.php';
    }

    public function save( $banner_name ){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_FILES['file']['name'][0])) {
                $total_files = count($_FILES['file']['name']);
                $banner = new Bannerfile();
                for($key = 1; $key <= $total_files; $key++) {
                    //$banner->setFileName($banner_name);
                    //$photo->setStockKeepingUnit($stock_keeping_unit);
                    $banner->setBannerName($banner_name);
                    $banner->setDevice($_REQUEST['device']);
                    $banner->setLanguage($_REQUEST['language']);
                    echo $banner_name;
                    echo $str_arr = $banner->post_banner_file_next();
                    $str_arr = substr($str_arr, 1, -1);
                    $str_arr = preg_split("/\,/", $str_arr);
                    $array = $str_arr;
                    $seq = 1;
                    asort($array);
                    foreach ($array as $valor) {
                        if ($valor != $seq) {
                            break;
                        }
                        $seq++;
                    }
                    if (isset($_FILES['file']['name'][($key - 1)])) {
                        $errors = array();
                        $file_name = $_FILES['file']['name'][($key - 1)];
                        @$file_ext = strtolower(end(explode('.', $file_name)));
                        $file_name_2 = $banner_name . "_" . $_REQUEST['language'] . "_" . $_REQUEST['device'] . "_" . $seq . "." . $file_ext; // verificar nome
                        $file_size = $_FILES['file']['size'][($key - 1)];
                        $file_tmp = $_FILES['file']['tmp_name'][($key - 1)];
                        $file_type = $_FILES['file']['type'][($key - 1)];
                        $extensions = array("jpeg", "jpg", "png");
                        if (in_array($file_ext, $extensions) === false) {
                            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        }
                        if ($file_size > 1000000) {
                            $errors[] = 'File size must be excately 1 MB';
                        }
                        if (empty($errors) == true) {
                            @mkdir("banner/" . $banner_name, 0777, true);
                            move_uploaded_file($file_tmp, "banner/" . $banner_name . "/" . $file_name_2);
                            if ($file_type == "image/png") {
                                $image = imagecreatefrompng("banner/" . $banner_name . "/" . $file_name_2);
                                $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                                imagealphablending($bg, TRUE);
                                imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                                imagedestroy($image);
                                $quality = 100;
                                imagejpeg($bg, "banner/" . $banner_name . "/" . $banner_name . "_" . $seq . ".jpg", $quality);
                                imagedestroy($bg);
                                unlink("banner/" . $banner_name . "/" . $file_name_2);
                                $file_name_2 = $banner_name . "_" . $seq . ".jpg";
                            }
                            $filename = "banner/" . $banner_name . "/" . $file_name_2;
                            $width = 240;
                            $height = 240;
                            list($width_orig, $height_orig) = getimagesize($filename);
                            $ratio_orig = $width_orig / $height_orig;
                            if ($width / $height > $ratio_orig) {
                                $width = $height * $ratio_orig;
                            } else {
                                $height = $width / $ratio_orig;
                            }
                            $image_p = imagecreatetruecolor($width, $height);
                            $file_name_3 = $banner_name . "_thumbnail_" . $seq . ".jpg";
                            $image = imagecreatefromjpeg($filename);
                            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                            imagejpeg($image_p, "banner/" . $banner_name . "/" . $file_name_3, 100);
                            $banner->setFileName($file_name_2);
                            $banner->setFileNameThumbnail($file_name_3);
                            $banner->setSequence($seq);
                            $banner->setSize($file_size);
                            list($width, $height) = getimagesize($filename);
                            $banner->setWidth($width);
                            $banner->setHeight($height);
                            $banner->post_banner_save();
                        } else {
                            print_r($errors);
                        }
                    }
                }
                BannerController::edit($banner->getBannerName());
            } else {
                BannerController::edit($banner_name);
            }
        } else {
            BannerController::edit($banner_name);
        }
    }

}

?>