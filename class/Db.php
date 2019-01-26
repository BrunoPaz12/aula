<?php   

class Db extends PDO {
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=php7","root","");

    }
    private function setParams($statment, $parameters = array()){
        foreach ($parameters as $key => $value) {
            $this->setParam($statment, $key, $value);
        }
    }
    private function setParam($statment, $key, $value){
        $statment->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array())
    {
        $smtm = $this->conn->prepare($rawQuery);

        $this->setParams($smtm, $params);

        $smtm->execute();

        return $smtm;

    }

    public function select($rawQuery, $params = array()):array{
        $smtm = $this->query($rawQuery, $params);

         return $smtm->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>