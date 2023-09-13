<?php

require_once 'model/documentsModel.php';

class DocumentsController {

    public function visualizar() {
        $documents = new Documents();
        require_once 'view/documents_view.php';
    }

    public function new() {
        require_once 'view/documents_new.php';
    }

    public function save() {
        $documents = new Documents();
        
        $documents->setFileNameThumbnail('pdf.svg');
        $documents->setDescription($_REQUEST['descricao']);

        if(isset($_FILES['document'])){
            $errors= array();
            $file_name = $_FILES['document']['name'];

            
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_size = $_FILES['document']['size'];
            
            $documents->setSize($file_size);
           
            $file_tmp = $_FILES['document']['tmp_name'];
            $file_type = $_FILES['document']['type'];
            @$file_ext = strtolower(end(explode('.',$_FILES['document']['name'])));
            $extensions = array("pdf");

            $file_name = str_replace(' ', '_', $file_name);
            $file_name = str_replace('-', '_', $file_name);
            $file_name = str_replace('&', '_', $file_name);
            $file_name = str_replace('$', '_', $file_name);
            $file_name = str_replace('(', '_', $file_name);
            $file_name = str_replace(')', '_', $file_name);
            $file_name = str_replace('%', '_', $file_name);
            $file_name = str_replace('~', '_', $file_name);
            $file_name = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$file_name);
            $file_name = strtolower($file_name);

            $documents->setFileName($file_name);

            if(in_array($file_ext,$extensions)=== false){
                $errors[]="Extension not allowed, please choose a PDF file.";
            }
            if($file_size > 10000000){
                $errors[]="File size must be excately 10 MB.";
            }
            if(!preg_match("/^[a-z0-9._]+$/", $file_name)){
                $errors[]="Invalid character in file name.";
            }


            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"pdf/".$file_name);
                $documents->post_documents_new();
            } else {
                print_r($errors);
            }
        }

        
        DocumentsController::edit($documents->getFileName());
    }

    public static function edit( $file_name ) {
        $documents = new Documents();
        $documents->setFileName($file_name);
        $documents = $documents->documents_list();
        require_once 'view/documents_edit.php';
    }

}

?>