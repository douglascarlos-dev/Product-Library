<?php

require_once 'model/cdnModel.php';
require_once 'controller/DocumentsController.php';

class CdnController {

    public static function upload( $file ) {
        $cdn = new Cdn();
        $cdn = $cdn->upload($file);
        DocumentsController::cdn($file, 'True');
        DocumentsController::edit($file);
    }

    public static function delete( $file ) {
        $cdn = new Cdn();
        $cdn = $cdn->delete($file);
        DocumentsController::cdn($file, 'False');
        DocumentsController::edit($file);
    }

}

?>