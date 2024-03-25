<?php
include_once 'connection.php';

class Banner extends Connection {
    private $id;
    private $name;
    private $description;
    private $code;
    private $created;
    private $updated;

    public function setId($id){
        $this->id=$id;
        return $this;
    }
    public function setDescription($description){
        $this->description=$description;
        return $this;
    }
    public function setCode($code){
        $this->code=$code;
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
    public function setName($name){
        $this->name=$name;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function getName()
    {
        return $this->name;
    }

    function get_all_banner(){
        $consulta = $this->database_select_all();
        return $consulta;
    }

    function database_select_all(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT id, description, banner_name FROM banner ORDER BY description"); 
        $stmt->execute(); 
        $row = $stmt->fetchAll();
        return $row;
    }

    function post_banner_new(){
        $result = $this->banner_insert();
        return $result;
    }

    function banner_insert(){
        $sql_query = "SELECT * FROM banner_insert_function
                        (
                            '" . $this->getName() . "',
                            '" . $this->getDescription() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function banner_list(){
        $pdo = $this->o_db;
        $stmt = $pdo->prepare("SELECT * FROM banner WHERE banner_name = '" . $this->getName() . "' LIMIT 1"); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        $banner = new Banner();
        $banner->setId($row[0]);
        $banner->setDescription($row[1]);
        $banner->setCode($row[2]);
        $banner->setName($row[5]);
        return $banner;
    }

    function post_banner_update(){
        $result = $this->banner_update();
        return $result;
    }

    function banner_update(){
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTimeImmutable();
        $date = $date->format('Y-m-d H:i:s O');
        $sql_query = "SELECT * FROM banner_update_function
                        (
                            '" . $this->getId() . "',
                            '" . $this->getDescription() . "',
                            '" . $date . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    function banner_delete(){
        $sql_query = "SELECT * FROM banner_remove_function
                        (
                            '" . $this->getId() . "'
                        )";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
        $row = $stmt->rowCount();
        //@rmdir("foto/".$this->getStockKeepingUnit());
        return $row;
    }

    function post_banner_delete(){
        $result = $this->banner_delete();
        return $result;
    }

}

?>