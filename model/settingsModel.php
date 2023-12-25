<?php
include_once 'connection.php';

class Settings extends Connection {

    private $id;
    private $hcaptcha;
    private $hcaptcha_secret;
    private $hcaptcha_data_sitekey;
    private $bunny;
    private $bunny_cdn_region;
    private $bunny_cdn_storage_name;
    private $bunny_cdn_key;
    private $bunny_linked_hostname;

    public function setId($id){
        $this->id=$id;
        return $this;
    }
    public function setHcaptcha($hcaptcha){
        $this->hcaptcha=$hcaptcha;
        return $this;
    }
    public function setHcaptchaSecret($hcaptcha_secret){
        if (!$this->stringContemCaractere($hcaptcha_secret)) {
            $this->hcaptcha_secret=$hcaptcha_secret;
        }
        return $this;
    }
    public function setHcaptchaDataSitekey($hcaptcha_data_sitekey){
        if (!$this->stringContemCaractere($hcaptcha_data_sitekey)) {
            $this->hcaptcha_data_sitekey=$hcaptcha_data_sitekey;
        }
        return $this;
    }
    public function setBunny($bunny){
        $this->bunny=$bunny;
        return $this;
    }
    public function setBunnyCdnRegion($bunny_cdn_region){
        $this->bunny_cdn_region=$bunny_cdn_region;
        return $this;
    }
    public function setBunnyCdnStorageName($bunny_cdn_storage_name){
        $this->bunny_cdn_storage_name=$bunny_cdn_storage_name;
        return $this;
    }
    public function setBunnyCdnKey($bunny_cdn_key){
        if (!$this->stringContemCaractere($bunny_cdn_key)) {
            $this->bunny_cdn_key=$bunny_cdn_key;
        }
        return $this;
    }
    public function setBunnyLinkedHostname($bunny_linked_hostname){
        $this->bunny_linked_hostname=$bunny_linked_hostname;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getHcaptcha()
    {
        return $this->hcaptcha;
    }
    public function getHcaptchaSecret()
    {
        return $this->hcaptcha_secret;
    }
    public function getHcaptchaDataSitekey()
    {
        return $this->hcaptcha_data_sitekey;
    }
    public function getBunny()
    {
        return $this->bunny;
    }
    public function getBunnyCdnRegion()
    {
        return $this->bunny_cdn_region;
    }
    public function getBunnyCdnStorageName()
    {
        return $this->bunny_cdn_storage_name;
    }
    public function getBunnyCdnKey()
    {
        return $this->bunny_cdn_key;
    }
    public function getBunnyLinkedHostname()
    {
        return $this->bunny_linked_hostname;
    }

    function settings_list(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT id, hcaptcha, hcaptcha_secret, hcaptcha_data_sitekey, bunny, bunny_cdn_region, bunny_cdn_storage_name, bunny_cdn_key, bunny_linked_hostname FROM public.settings WHERE id = 1"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $settings = new Settings();
        $settings->setId($row[0]);
        $settings->setHcaptcha($row[1]);
        $settings->setHcaptchaSecret($row[2]);
        $settings->setHcaptchaDataSitekey($row[3]);
        $settings->setBunny($row[4]);
        $settings->setBunnyCdnRegion($row[5]);
        $settings->setBunnyCdnStorageName($row[6]);
        $settings->setBunnyCdnKey($row[7]);
        $settings->setBunnyLinkedHostname($row[8]);
        return $settings;
    }

    function processaString($input) {
        $primeirosCinco = substr($input, 0, 5);
        $restante = str_repeat('●', max(0, strlen($input) - 5));
        $resultado = $primeirosCinco . $restante;
        return $resultado;
    }

    function stringContemCaractere($str) {
        return strpos($str, '●') !== false;
    }

    function post_settings_save(){
        $result = $this->settings_save();
        return $result;
    }

    function settings_save(){
        $sql_query = "SELECT * FROM settings_save_function
                        (
                            '" . $this->getHcaptcha() . "',
                            '" . $this->getHcaptchaSecret() . "',
                            '" . $this->getHcaptchaDataSitekey() . "',
                            '" . $this->getBunny() . "',
                            '" . $this->getBunnyCdnRegion() . "',
                            '" . $this->getBunnyCdnStorageName() . "',
                            '" . $this->getBunnyCdnKey() . "',
                            '" . $this->getBunnyLinkedHostname() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

}

?>