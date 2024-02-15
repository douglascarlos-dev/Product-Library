<?php

require_once 'model/documentsModel.php';
require_once 'model/settingsModel.php';

class DocumentsController {

    public function visualizar() {
        $documents = new Documents();
        require_once 'view/documents_view.php';
    }

    public function new() {
        require_once 'view/documents_new.php';
    }

    public function upload( $file_name ) {
        $documents = new Documents();
        $documents->setFileName($file_name);
        $documents = $documents->documents_list();
        require_once 'view/documents_upload.php';
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
            $extensions = array("pdf","mp4","png","jpg");

            $file_name = $this->formatFileName($file_name);

            $documents->setFileName($file_name);

            if(in_array($file_ext,$extensions)=== false){
                $errors[]="Extension not allowed.";
            }
            if($file_size > 10000000){
                $errors[]="File size must be excately 10 MB.";
            }
            if(!preg_match("/^[a-z0-9._]+$/", $file_name)){
                $errors[]="Invalid character in file name.";
            }


            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"files/".$file_name);
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
        $settings = new Settings();
        $settings = $settings->settings_list();
        require_once 'view/documents_edit.php';
    }

    public function update( $file_name ) {
        $documents = new Documents();
        $documents->setFileName($file_name);
        $documents = $documents->documents_list();
        $documents->setDescription($_REQUEST['descricao']);
        $documents->post_documents_update();
        DocumentsController::edit($documents->getFileName());
    }

    public function update_views( $file_name ) {
        /* $documents = new Documents();
        $documents->setFileName($file_name);
        $documents = $documents->documents_list();
        $documents->setDescription($_REQUEST['descricao']);
        $documents->post_documents_update();
        DocumentsController::edit($documents->getFileName()); */
    }

    public static function cdn( $file_name, $cdn ) {
        $documents = new Documents();
        $documents->setFileName($file_name);
        $documents->setCdn($cdn);
        $documents->post_documents_update_cdn();
    }

    public function fileupdate( $file_name ) {
        $documents = new Documents();
        $documents->setFileName($file_name);
        $documents = $documents->documents_list();

        if(isset($_FILES['document'])){
            $errors= array();
            //$file_name = $_FILES['document']['name'];

            
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_size = $_FILES['document']['size'];
            
            $documents->setSize($file_size);
           
            $file_tmp = $_FILES['document']['tmp_name'];
            $file_type = $_FILES['document']['type'];
            @$file_ext = strtolower(end(explode('.',$_FILES['document']['name'])));
            $extensions = array("pdf","mp4","png","jpg");

            //$file_name = $this->formatFileName($file_name);

            //$documents->setFileName($file_name);

            if(in_array($file_ext,$extensions)=== false){
                $errors[]="Extension not allowed, please choose a file.";
            }
            if($file_size > 10000000){
                $errors[]="File size must be excately 10 MB.";
            }
            if(!preg_match("/^[a-z0-9._]+$/", $file_name)){
                $errors[]="Invalid character in file name.";
            }


            if(empty($errors)==true){
                unlink("files/".$file_name);
                move_uploaded_file($file_tmp,"files/".$file_name);
                //$documents->post_documents_new();
                $documents->post_documents_update();
            } else {
                print_r($errors);
            }
        }

        DocumentsController::edit($documents->getFileName());
    }

    function formatFileName($file_name){
        // Substitui espaços, traços e caracteres especiais por underscores
        $file_name = preg_replace('/[ --&()~%]/', '_', $file_name);
        
        // Remove acentos
        $file_name = preg_replace(
            array("/[áàãâä]/","/[ÁÀÃÂÄ]/","/[éèêë]/","/[ÉÈÊË]/","/[íìîï]/","/[ÍÌÎÏ]/","/[óòõôö]/","/[ÓÒÕÔÖ]/","/[úùûü]/","/[ÚÙÛÜ]/","/ñ/","/Ñ/"),
            explode(" ","a A e E i I o O u U n N"),
            $file_name
        );
    
        // Converte para minúsculas
        $file_name = strtolower($file_name);
        
        return $file_name;
    }

    public function delete( $file_name ){
        $documents = new Documents();
        $documents->setFileName($file_name);
        $documents = $documents->documents_list();
        $documents->post_documents_delete();
        DocumentsController::visualizar();
    }

    public function search() {
        $documents = new Documents();

        $documents->setDescription($_REQUEST['search']);
        require_once 'view/documents_search.php';
    }

}

?>