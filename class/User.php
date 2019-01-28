<?php   

class User {
    private $iduser;
    private $login;
    private $passwd;
    private $dtregister;

    public function getIduser(){
        return $this->iduser;
    }
    public function setIduser($value){
        $this->iduser = $value;
    }

    public function getLogin(){
        return $this->login;
    }
    public function setLogin($value){
        $this-> login = $value;
    }

    public function getPass(){
        return $this->passwd;
    }
    public function setPass($value){
        $this->passwd = $value;
    }

    public function getDT(){
        return $this->dtregister;
    }
    public function setDT($value){
        $this->dtregister = $value;
    }

    public function loadById($id){
        $sql = new Db();

        $result = $sql->select("select * from tb_user where iduser = :ID", array(
            ":ID"=>$id
        ));
        if(count($result)>0){
            $this->setData($result[0]);
        }

    }
    public function setData($data){
        $this->setIduser($data['iduser']);
        $this->setLogin($data['login']);
        $this->setPass($data['passwd']);
        $this->setDT(new DateTime($data['dtregister']));
    }

    public static function getList(){
        $sql = new Db();
        return $sql->select("select * from tb_user");
    }

    public static function search($login){
        $sql = new Db();

        return $sql->select("select * from tb_user where login like :LOGIN", array(
            ":LOGIN"=>"%".$login."%"
        ));
    }

    public function login($login, $pass){
        $sql = new Db();

        $result = $sql->select("select * from tb_user where login = :LOGIN and passwd = :PASS", array(
            ":LOGIN"=>$login,
            ":PASS"=>$pass
        ));
        if(count($result)>0){
          
            $this->setData($result[0]);

        }else {
            throw new Exception("User and/or Password invalid!");
        }
    }

        public function insert(){
            $sql = new Db();

            $result = $sql->select("call sp_insert_user(:LOGIN, :PASS)",array(
                ':LOGIN'=>$this->getLogin(),
                ':PASS'=>$this->getPass()
            ));
            if(count($result) > 0){
                $this->setData($result[0]);
            }
        }

        public function update($login, $pass){
            $this->setLogin($login);
            $this->setPass($pass);
            
            $sql = new Db();

            $sql->query("update tb_user set login = :LOGIN, passwd = :PASS where iduser= :ID",array(
                ':LOGIN'=>$this->getLogin(),
                ':PASS'=>$this->getPass(),
                ':ID'=>$this->getIduser()
            ));
        }
    

    public function __toString(){
        
        return json_encode(array(
            "iduser"=>$this->getIduser(),
            "login"=>$this->getLogin(),
            "passwd"=>$this->getPass(),
            "dtregister"=>$this->getDT()->format("d/m/Y H:i:s")
        ));
    }
}

?>