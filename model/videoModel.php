<?php
include_once 'connection.php';

class Video extends Connection {
    private $id;
    private $file_name;
    private $file_name_thumbnail;
    private $sequence;
    private $created;
    private $updated;
    private $stock_keeping_unit;

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
    public function setCreated($created){
        $created = date("d/m/Y H:i", strtotime($created));
        $this->created=$created;
        return $this;
    }
    public function setUpdated($updated){
        $this->updated=$updated;
        return $this;
    }
    public function setStockKeepingUnit($stock_keeping_unit){
        $this->stock_keeping_unit=$stock_keeping_unit;
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
    public function getCreated(){
        return $this->created;
    }
    public function getUpdated(){
        return $this->updated;
    }
    public function getStockKeepingUnit(){
        return $this->stock_keeping_unit;
    }

    function video_save(){
         $sql_query = "SELECT * FROM video_insert_function
                        (
                            '" . $this->getFileName() . "',
                            '" . $this->getSequence() . "',
                            '" . $this->getStockKeepingUnit() . "',
                            '" . $this->getFileNameThumbnail() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function post_video_save(){
        $result = $this->video_save();
        return $result;
    }

    function video_list(){
        $sql_query = "SELECT * FROM view_video_products WHERE stock_keeping_unit = '" . $this->getStockKeepingUnit() . "' ORDER BY sequence";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $array_video= array();
        $stmt->execute();
        while($row = $stmt->fetch()){
            $the_video = new Video();
            $the_video->setId($row[0]);
            $the_video->setFileName($row[1]);
            $the_video->setSequence($row[2]);
            $the_video->setFileNameThumbnail($row[4]);
            array_push($array_video, $the_video);
        }
        return $array_video;
    }

    function post_video_list(){
        $result = $this->video_list();
        return $result;
    }

    function post_video_delete(){
        $result = $this->video_delete();
        return $result;
    }

    function video_delete(){

        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT file_name_thumbnail FROM public.view_video_products WHERE file_name = '" . $this->getFileName() . "'");
        $stmt->execute(); 
        $row = $stmt->fetch();
        $thumbnail = $row[0];

        @unlink("video/".$this->getFileName());
        @unlink("video/".$thumbnail);
        $sql_query = "SELECT * FROM video_delete
                        (
                            '" . $this->getFileName() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }


    function video_next(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT ARRAY(SELECT sequence FROM public.view_video_products WHERE stock_keeping_unit = '" . $this->getStockKeepingUnit() . "' ORDER BY sequence ASC) AS sequencia"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $resultado = $row[0];
        return $resultado;
    }

    function post_video_next(){
        $result = $this->video_next();
        return $result;
    }

}
?>