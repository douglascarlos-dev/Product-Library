<?php
include_once 'connection.php';

class Address extends Connection {
    private $id;
    private $name;
    private $sequence;
    private $created;
    private $updated;
    private $id_products;

    public function setId($id){
        $this->id=$id;
        return $this;
    }
    public function setName($name){
        $this->name=$name;
        return $this;
    }
    public function setSequence($sequence){
        $this->sequence=$sequence;
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
    public function setIdProducts($id_products){
        $this->id_products=$id_products;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
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
    public function getIdProducts(){
        return $this->id_products;
    }

    function photo_save(){
         $sql_query = "SELECT * FROM photo_insert_function
                        (
                            '" . $this->getName() . "',
                            '" . $this->getSequence() . "',
                            '" . $this->getCreated() . "',
                            '" . $this->getUpdated() . "',
                            '" . $this->getIdProducts() . "'
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
        $sql_query = "SELECT * FROM view_photo_products WHERE id_products = '" . $this->getIdProducts() . "'";
        $pdo = $this->o_db;
        $stmt = $pdo->prepare($sql_query);
        $array_photo= array();
        $stmt->execute();
        while($row = $stmt->fetch()){
            $the_photo = new Photo();
            $the_photo->setId($row[0]);
            $the_photo->setName($row[1]);
            $the_photo->setSequence($row[2]);
            array_push($array_photo, $the_photo);
        }
        return $array_photo;
    }

    function post_photo_list(){
        $result = $this->photo_list();
        return $result;
    }

}
?>