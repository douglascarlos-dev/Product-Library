<?php

require_once 'model/photoModel.php';
require_once 'controller/ProductsController.php';

class PhotoController {

    public function new( $stock_keeping_unit ){
        require_once 'view/photo_new.php';
    }

    public function save( $stock_keeping_unit ){

        // verifica se o formulário foi enviado
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //echo "Formulário enviado";

            // verifica se foi selecionado algum arquivo
            if (!empty($_FILES['photo']['name'][0])) {
                //echo "<br>O array não está vazio.";
                //echo "<br>Com arquivo(s)";

                // quantidade de arquivos
                $total_files = count($_FILES['photo']['name']);
                //echo "<br>" . $total_files . " arquivo(s)<br>";
                $photo = new Photo();
                // iterage enquanto tiver arquivos
                for($key = 1; $key <= $total_files; $key++) {
                    //echo "<br>Iteração " . $key;

                    
                    $photo->setStockKeepingUnit($stock_keeping_unit);
                    // descobre qual o proximo elemento - inicio
                    $str_arr = $photo->post_photo_next(); // Array atual
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
                    // descobre qual o proximo elemento - fim

                    // verificar se o arquivo está definido
                    if (isset($_FILES['photo']['name'][($key - 1)])) {
                        $errors = array();
                        $file_name = $_FILES['photo']['name'][($key - 1)];
                        @$file_ext = strtolower(end(explode('.', $_FILES['photo']['name'][($key - 1)])));
                        $file_name_2 = $stock_keeping_unit . "_" . $seq . "." . $file_ext;
                        $file_size = $_FILES['photo']['size'][($key - 1)];
                        $file_tmp = $_FILES['photo']['tmp_name'][($key - 1)];
                        $file_type = $_FILES['photo']['type'][($key - 1)];
                        $extensions = array("jpeg", "jpg", "png");
                        // verifica se o arquivo é do tipo esperado
                        if (in_array($file_ext, $extensions) === false) {
                            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        }
                        // verificar se o arquivo tem o tamanho adequado
                        if ($file_size > 2000000) {
                            $errors[] = 'File size must be excately 2 MB';
                        }
                        
                        // se não tiver nenhum erro continua
                        if (empty($errors) == true) {
                            // cria a pasta
                            @mkdir("foto/" . $stock_keeping_unit, 0777, true);
                            // move o arquivo temporario para a pasta do sku
                            move_uploaded_file($file_tmp, "foto/" . $stock_keeping_unit . "/" . $file_name_2);
                            if ($file_type == "image/png") {
                                $image = imagecreatefrompng("foto/" . $stock_keeping_unit . "/" . $file_name_2);
                                $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                                imagealphablending($bg, TRUE);
                                imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                                imagedestroy($image);
                                $quality = 100;
                                imagejpeg($bg, "foto/" . $stock_keeping_unit . "/" . $stock_keeping_unit . "_" . $seq . ".jpg", $quality);
                                imagedestroy($bg);
                                unlink("foto/" . $stock_keeping_unit . "/" . $file_name_2);
                                $file_name_2 = $stock_keeping_unit . "_" . $seq . ".jpg";
                            }
                            // endereço do arquivo
                            $filename = "foto/" . $stock_keeping_unit . "/" . $file_name_2;
                            // define altuar e largura
                            $width = 240;
                            $height = 240;
                            // pega largura e altura do arquivo
                            list($width_orig, $height_orig) = getimagesize($filename);
                            $ratio_orig = $width_orig / $height_orig;
                            if ($width / $height > $ratio_orig) {
                                $width = $height * $ratio_orig;
                            } else {
                                $height = $width / $ratio_orig;
                            }
                            $image_p = imagecreatetruecolor($width, $height);
                            $file_name_3 = $stock_keeping_unit . "_thumbnail_" . $seq . ".jpg";
                            $image = imagecreatefromjpeg($filename);
                            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                            imagejpeg($image_p, "foto/" . $stock_keeping_unit . "/" . $file_name_3, 100);
                            $photo->setFileName($file_name_2);
                            $photo->setFileNameThumbnail($file_name_3);
                            $photo->setSequence($seq);
                            $photo->setSize($file_size);
                            list($width, $height) = getimagesize($filename);
                            $photo->setWidth($width);
                            $photo->setHeight($height);
                            $photo->post_photo_save();
                            //echo " " . $file_name . " " . $file_size . " " . $file_type . " " . $file_name_2 . " " . $filename . " " . $file_name_3;
                        }
                    }
                }
                ProductsController::edit($photo->getStockKeepingUnit());
              } else {
                //echo "<br>O array está vazio.";
                ProductsController::edit($stock_keeping_unit);
              }

        } else {
            //echo "Formulário não enviado";
            ProductsController::edit($stock_keeping_unit);
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