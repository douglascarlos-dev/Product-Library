<?php
include_once 'connection.php';

class Bannerfile extends Connection {
    private $id;
    private $file_name;
    private $file_name_thumbnail;
    private $sequence;
    private $device;
    private $language;
    private $width;
    private $height;
    private $size;
    private $created;
    private $updated;
    private $banner_name;

    public function setId($id){
        $this->id=$id;
        return $this;
    }
    public function setFileName($file_name){
        $this->file_name=$file_name;
        return $this;
    }
    public function setFileNameThumbnail($file_name_thumbnail){
        $this->file_name_thumbnail=$file_name_thumbnail;
        return $this;
    }
    public function setSequence($sequence){
        $this->sequence=$sequence;
        return $this;
    }
    public function setDevice($device){
        $this->device=$device;
        return $this;
    }
    public function setLanguage($language){
        $this->language=$language;
        return $this;
    }
    public function setWidth($width){
        $this->width=$width;
        return $this;
    }
    public function setHeight($height){
        $this->height=$height;
        return $this;
    }
    public function setSize($size){
        $this->size=$size;
        return $this;
    }
    public function setCreated($created){
        $this->created=$created;
        return $this;
    }
    public function setUpdated($updated){
        $this->updated=$updated;
        return $this;
    }
    public function setBannerName($banner_name){
        $this->banner_name=$banner_name;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
    public function getFileName(){
        return $this->file_name;
    }
    public function getFileNameThumbnail(){
        return $this->file_name_thumbnail;
    }
    public function getSequence(){
        return $this->sequence;
    }
    public function getDevice(){
        return $this->device;
    }
    public function getLanguage(){
        return $this->language;
    }
    public function getWidth(){
        return $this->width;
    }
    public function getHeight(){
        return $this->height;
    }
    public function getSize(){
        return $this->size;
    }
    public function getCreated(){
        return $this->created;
    }
    public function getUpdated(){
        return $this->updated;
    }
    public function getBannerName(){
        return $this->banner_name;
    }

    function banner_file_next(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT ARRAY(SELECT sequence FROM public.view_banner WHERE banner_name = '" . $this->getBannerName() . "' AND device = '" . $this->getDevice() . "' ORDER BY sequence ASC) AS sequencia"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $resultado = $row[0];
        return $resultado;
    }
        
    function post_banner_file_next(){
        $result = $this->banner_file_next();
        return $result;
    }

    function banner_save(){
        $sql_query = "SELECT * FROM banner_file_insert_function
                       (
                           '" . $this->getFileName() . "',
                           '" . $this->getSequence() . "',
                           '" . $this->getWidth() . "',
                           '" . $this->getHeight() . "',
                           '" . $this->getSize() . "',
                           '" . $this->getBannerName() . "',
                           '" . $this->getFileNameThumbnail() . "',
                           '" . $this->getDevice() . "',
                           '" . $this->getLanguage() . "'
                       )";
       $pdo = $this->o_db;
       $stmt = $pdo->prepare($sql_query);
       $stmt->execute();
       $row = $stmt->fetch();
       return $row;
   }

    function post_banner_save(){
        $result = $this->banner_save();
        return $result;
    }
    
}

?>