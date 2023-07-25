<?php

require_once 'model/productsModel.php';
require_once 'model/photoModel.php';

class ProductsController {

    public function visualizar() {
        $products = new Products();
        require_once 'view/products_view.php';
    }

    public function new() {
        require_once 'view/products_new.php';
    }

    public function save() {
        $products = new Products();
        $products->setStockKeepingUnit($_REQUEST['sku']);
        $products->setDescription($_REQUEST['descricao']);
        $products->post_products_new();
        ProductsController::edit($products->getStockKeepingUnit());
    }

    public static function edit( $stock_keeping_unit ) {
        $products = new Products();
        $products->setStockKeepingUnit($stock_keeping_unit);
        $products = $products->products_list();
        $photo = new Photo();
        $photo->setStockKeepingUnit($stock_keeping_unit);
        $photo = $photo->post_photo_list();
        require_once 'view/products_edit.php';
    }

    public function update( $stock_keeping_unit ) {
        $products = new Products();
        $products->setStockKeepingUnit($stock_keeping_unit);
        $products->setDescription($_REQUEST['descricao']);
        $products->post_products_update();
        ProductsController::edit($products->getStockKeepingUnit());
    }


}