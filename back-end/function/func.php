<?php
class db{
    public $database_connection;
    public function connect($host,$db_name,$username,$password){
        try{
            $this->database_connection = new PDO("mysql:host=$host;dbname=$db_name;charset=UTF8",$username,$password);
        }catch(PDOException $hata){
            echo "Bağlantı hatası".$hata->getMessage();
            die();
        }
    }

    public function user_check($table,$email,$password){
        $data_check = $this->database_connection->prepare("SELECT * FROM $table WHERE username='$email' AND password='$password'");
        $data_check->execute();
        $number_of_check = $data_check->rowCount();

        $data_check = $this->database_connection->prepare("SELECT * FROM $table  WHERE email='$email' AND password='$password'");
        $data_check->execute();
        $number_of_check += $data_check->rowCount();
        return $number_of_check;
    }

    public function username_check($table ,$email,$password){
        $data_check = $this->database_connection->prepare("SELECT * FROM $table  WHERE username='$email' AND password='$password'");
        $data_check->execute();
        $number_of_check = $data_check->rowCount();

        return $number_of_check;
    }

    public function email_check($table,$email,$password){
        $data_check = $this->database_connection->prepare("SELECT * FROM $table  WHERE email='$email' AND password='$password'");
        $data_check->execute();
        $number_of_check = $data_check->rowCount();

        return $number_of_check;
    }

    public function banned_check($id,$username){
        $data_check = $this->database_connection->prepare("SELECT * FROM user  WHERE id='$id' AND username='$username' AND type='0'");
        $data_check->execute();
        $number_of_check = $data_check->rowCount();

        $data_check = $this->database_connection->prepare("SELECT * FROM banned  WHERE user_id='$id' AND username='$username'");
        $data_check->execute();
        $number_of_check += $data_check->rowCount();

        return $number_of_check;
    }

    public function add_user($table,$username,$password,$email,$type,$verify){
        $sorgu = $this->database_connection->prepare("INSERT INTO $table SET username='$username',password='$password',email='$email',type='$type',verify='$verify'");
        $sorgu->execute();
    }

    public function delete_user($table,$id,$username){
        $sorgu = $this->database_connection->prepare("DELETE FROM $table WHERE id=? and username=?");
        $sorgu->execute([$id,$username]);
    }

    public function get_list($table,$id,$filt){
        $dataList = $this->database_connection -> prepare("SELECT * FROM $table ORDER BY $id $filt");
        $dataList -> execute();
        $dataList = $dataList -> fetchALL(PDO::FETCH_ASSOC);
        return $dataList;
    }

    public function get_banned_list($table,$id,$filt){
        $dataList = $this->database_connection -> prepare("SELECT * FROM $table WHERE type='0' ORDER BY $id $filt");
        $dataList -> execute();
        $dataList = $dataList -> fetchALL(PDO::FETCH_ASSOC);
        return $dataList;
    }

    public function get($table,$who,$value){
        $sorgu = $this->database_connection->prepare("SELECT * FROM $table WHERE $who=?");
        $sorgu->execute([$value]);
        $send = $sorgu->fetch(PDO::FETCH_ASSOC);

        return $send;
    } 
    

    public function howmany_data($table){
        $sorgu = $this->database_connection->prepare("SELECT COUNT(*) FROM $table");
        $sorgu->execute();
        $say = $sorgu->fetchColumn();

        return $say;
    }

    public function howmany_data_use($table,$who,$value){
        $sorgu = $this->database_connection->prepare("SELECT COUNT(*) FROM $table WHERE $who=?");
        $sorgu->execute([$value]);
        $say = $sorgu->fetchColumn();

        return $say;
    }

    public function islem_yap($islem,$id){
        $user = $this->get("user","id",$id);
        if($islem=="ban"){

            if($this->banned_check($id,$user['username'])==0){
                $veri_ekle = $this->database_connection->prepare("UPDATE user SET type=? WHERE id=?");
                $veri_ekle->execute(["0",$id]);

                $veri_ekle = $this->database_connection->prepare("INSERT INTO banned SET username=?,user_id=?");
                $veri_ekle->execute([$user['username'],$user['id']]);
            }

        }
        else if($islem=="delete"){
            $this->delete_user("user",$id,$user['username']);
            if($this->banned_check($id,$user['username'])>0){
                $ban_user = $this->get("banned","user_id",$id);
                $this->delete_user("banned",$ban_user['id'],$user['username']);
            }
        }
        else if($islem=="unban"){
            $veri_ekle = $this->database_connection->prepare("UPDATE user SET type=? WHERE id=?");
            $veri_ekle->execute(["1",$id]);

            $ban_user = $this->get("banned","user_id",$id);
            $this->delete_user("banned",$ban_user['id'],$user['username']);
        }

        else if($islem=="edit"){
        }
        return $user;
    }

}

class user{
    public $account;
    public function getSession($value){
        return $_SESSION[$value];
    }
    public function checkSession(){
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            return 1;
        }
    }
}
class char{
    public function filter($Deger){
        $bir = trim($Deger);
        $iki = strip_tags($bir);
        $Uc = htmlspecialchars($iki,ENT_QUOTES);
        $Sonuc = $Uc;
        return $Sonuc;
    }

    public function cut($kelime, $str = 10){
        if (strlen($kelime) > $str){
         if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
          else $kelime = substr($kelime, 0, $str).'..';
         }
         return $kelime;
    }
}
?>