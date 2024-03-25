<?php

require_once 'model/bannerModel.php';

class BannerController {

    public function visualizar() {
        $banner = new Banner();
        require_once 'view/banner_view.php';
    }

    public function new() {
        require_once 'view/banner_new.php';
    }


    public function save() {
        $banner = new Banner();
        $banner->setDescription($_REQUEST['descricao']);
        $banner->setName($this->formatFileName($_REQUEST['descricao']));
        $banner->post_banner_new();
        BannerController::edit($banner->getName());
    }

    public static function edit( $name ) {
        $banner = new Banner();
        $banner->setName($name);
        $banner = $banner->banner_list();
        require_once 'view/banner_edit.php';
    }

    public static function teste( $id ) {
        $banner = new Banner();
        $banner->setId($id);
        $banner = $banner->banner_list();
        require_once 'view/banner_teste.php';
    }

    public function update( $id ) {
        $banner = new Banner();
        $banner->setId($id);
        $banner->setDescription($_REQUEST['descricao']);
        $banner->post_banner_update();
        BannerController::edit($banner->getId());
    }

    public function delete( $id ){
        $banner = new Banner();
        $banner->setId($id);
        $banner = $banner->banner_list();
        $banner->post_banner_delete();
        BannerController::visualizar();
    }

    public function search() {
        $banner = new Banner();
        $banner->setDescription($_REQUEST['search']);
        require_once 'view/banner_search.php';
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

}