<?php

require_once 'model/photoModel.php';
require_once 'controller/ProductsController.php';

class PhotoController {

    public function new( $stock_keeping_unit ){
        require_once 'view/photo_new.php';
    }


}
?>