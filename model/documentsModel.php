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
        $created = date("d/m/Y H:i", strtotime($created));
        $this->created=$created;
        return $this;
    }
    public function setUpdated($updated){
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

    function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
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
        return $documents;
    }
    
}

?>