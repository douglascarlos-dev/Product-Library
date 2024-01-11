<?php

require_once 'model/documentsModel.php';
require_once 'controller/DocumentsController.php';

class FilesController {

        function __construct() {
            //print "In BaseClass constructor<br>\n";
        }

        public function download( $arquivo ) {
            
            /*print "In BaseClass constructor 2<br> \n";
            echo $file_type = mime_content_type("files/$arquivo");
            echo '<br>';
            echo filesize("files/$arquivo");*/
            $documents = new Documents();
            $documents->setFileName( $arquivo );
            $documents = $documents->documents_list();
            $documents = $documents->documents_update_views();
            //Documents::update_views(  $arquivo );
            $file_type = mime_content_type("files/$arquivo");
            header("Content-Type: $file_type");
            header('Content-Length: ' . filesize("files/$arquivo"));
            header('Content-Disposition: filename=' . $arquivo);
             // calc an offset of 24 hours
            $offset = 3600 * 24;
            // calc the string in GMT not localtime and add the offset
            $expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
            //output the HTTP header
            Header($expire);
            header("Cache-Control: max-age=$offset must-revalidate");
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime("files/$arquivo")));
            readfile("files/$arquivo");
            exit(0);
        }
    //public function visualizar( $file_name ) {
        //$documents = new Documents();
        //require_once 'view/documents_view.php';
          //echo $file_type = mime_content_type($file_name);
          //header('Content-Type: $file_type');
        //$imageFile = "PNSC01_2.jpg";
          //header('Content-Length: ' . filesize($file_name));
          //readfile($file_name);
    //}
/*
    public static function edit() {
        $settings = new Settings();
        $settings = $settings->settings_list();
        require_once 'view/settings_edit.php';
    }

    public function save() {
        $settings = new Settings();
        $settings = $settings->settings_list();
        $settings->setHcaptcha(isset($_REQUEST['hcaptcha']) ? 1 : 0);
        $settings->setHcaptchaSecret($_REQUEST['hcaptcha_secret']);
        $settings->setHcaptchaDataSitekey($_REQUEST['hcaptcha_data_sitekey']);
        $settings->setBunny(isset($_REQUEST['bunny']) ? 1 : 0);
        $settings->setBunnyCdnRegion($_REQUEST['bunny_cdn_region']);
        $settings->setBunnyCdnStorageName($_REQUEST['bunny_cdn_storage_name']);
        $settings->setBunnyCdnKey($_REQUEST['bunny_cdn_key']);
        $settings->setBunnyLinkedHostname($_REQUEST['bunny_linked_hostname']);
        $settings->post_settings_save();
        SettingsController::edit();
    }
    */

}

?>