<?php
include_once 'connection.php';

class Photo extends Connection {
    private $id;
    private $file_name;
    private $file_name_thumbnail;
    private $sequence;
    private $width;
    private $height;
    private $size;
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
        //$created = date("d/m/Y H:i", strtotime($created));
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
    public function getStockKeepingUnit(){
        return $this->stock_keeping_unit;
    }

    function formatDate($date){
        $date = date("d/m/Y H:i", strtotime($date));
        return $date;
    }

    function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

    function photo_save(){
         $sql_query = "SELECT * FROM photo_insert_function
                        (
                            '" . $this->getFileName() . "',
                            '" . $this->getSequence() . "',
                            '" . $this->getWidth() . "',
                            '" . $this->getHeight() . "',
                            '" . $this->getSize() . "',
                            '" . $this->getStockKeepingUnit() . "',
                            '" . $this->getFileNameThumbnail() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function post_photo_save(){
        $result = $this->photo_save();
        return $result;
    }

    function photo_list(){
        $sql_query = "SELECT id, file_name, sequence, stock_keeping_unit, file_name_thumbnail, size, created, width, height FROM view_photo_products WHERE stock_keeping_unit = '" . $this->getStockKeepingUnit() . "' ORDER BY sequence";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $array_photo= array();
        $stmt->execute();
        while($row = $stmt->fetch()){
            $the_photo = new Photo();
            $the_photo->setId($row[0]);
            $the_photo->setFileName($row[1]);
            $the_photo->setSequence($row[2]);
            $the_photo->setFileNameThumbnail($row[4]);
            $the_photo->setSize($row[5]);
            $the_photo->setCreated($row[6]);
            $the_photo->setWidth($row[7]);
            $the_photo->setHeight($row[8]);
            array_push($array_photo, $the_photo);
        }
        return $array_photo;
    }

    function post_photo_list(){
        $result = $this->photo_list();
        return $result;
    }

    function post_photo_delete(){
        $result = $this->photo_delete();
        return $result;
    }

    function photo_delete(){

        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT file_name_thumbnail FROM public.view_photo_products WHERE file_name = '" . $this->getFileName() . "'");
        $stmt->execute(); 
        $row = $stmt->fetch();
        $thumbnail = $row[0];

        unlink("foto/".$this->getStockKeepingUnit()."/".$this->getFileName());
        unlink("foto/".$this->getStockKeepingUnit()."/".$thumbnail);
        //@rmdir("foto/".$this->getStockKeepingUnit());
        $sql_query = "SELECT * FROM photo_delete
                        (
                            '" . $this->getFileName() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }


    function photo_next(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT ARRAY(SELECT sequence FROM public.view_photo_products WHERE stock_keeping_unit = '" . $this->getStockKeepingUnit() . "' ORDER BY sequence ASC) AS sequencia"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $resultado = $row[0];
        return $resultado;
    }

    function post_photo_next(){
        $result = $this->photo_next();
        return $result;
    }

}
?>