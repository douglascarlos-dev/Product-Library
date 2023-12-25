<?php

require_once 'model/settingsModel.php';

class SettingsController {

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

}

?>