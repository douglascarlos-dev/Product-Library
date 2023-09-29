<?php
include_once 'connection.php';

class Documents extends Connection {

    private $id;
    private $file_name;
    private $file_name_thumbnail;
    private $description;
    private $size;
    private $created;
    private $updated;

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
    public function setDescription($description){
        $this->description=$description;
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
        //$updated= date("d/m/Y H:i", strtotime($updated));
        $this->updated=$updated;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getFileName(){
        return $this->file_name;
    }
    public function getFileNameThumbnail(){
        return $this->file_name_thumbnail;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getSize(){
        return $this->size;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function getUpdated()
    {
        return $this->updated;
    }

    public function formatDate($date){
        $date = date("d/m/Y H:i", strtotime($date));
        return $date;
    }

    /*
    function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
    */

    function convertToReadableSize($size){
        $suffix = ["B", "KB", "MB", "GB", "TB"];
        $base = log($size, 1024);
        $f_base = floor($base);
        return round($size / pow(1024, $f_base), 1) . $suffix[$f_base];
    }

    function get_all_documents(){
        $consulta = $this->database_select_all('documents');
        return $consulta;
    }

    function database_select_all($valor1){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT * FROM $valor1 ORDER BY id"); 
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    function post_documents_new(){
        $result = $this->documents_insert();
        return $result;
    }

    function documents_insert(){
        $sql_query = "SELECT * FROM documents_insert_function
                        (
                            '" . $this->getFileName() . "',
                            '" . $this->getFileNameThumbnail() . "',
                            '" . $this->getDescription() . "',
                            '" . $this->getSize() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function documents_list(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT * FROM documents WHERE file_name = '" . $this->getFileName() . "' LIMIT 1"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $documents = new Documents();
        $documents->setFileName($row[1]);
        $documents->setFileNameThumbnail($row[2]);
        $documents->setDescription($row[3]);
        $documents->setSize($row[5]);
        $documents->setCreated($row[6]);
        $documents->setUpdated($row[7]);
        return $documents;
    }

    function post_documents_update(){
        $result = $this->documents_update();
        return $result;
    }

    function documents_update(){
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTimeImmutable();
        $date = $date->format('Y-m-d H:i:s O');
        $sql_query = "SELECT * FROM documents_update_function
                        (
                            '" . $this->getFileName() . "',
                            '" . $this->getDescription() . "',
                            '" . $this->getSize() . "',
                            '" . $date . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function documents_delete(){
        $sql_query = "SELECT * FROM documents_remove_function
                        (
                            '" . $this->getFileName() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->rowCount();
        @unlink("pdf/".$this->getFileName());
        return $row;
    }

    function post_documents_delete(){
        $result = $this->documents_delete();
        return $result;
    }
    
}

?>