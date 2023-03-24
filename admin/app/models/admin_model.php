<?php
class Admin_Model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function userControl($array = array()){
        $sql = "SELECT * FROM ".PREFIX."admin_users WHERE (username = :username OR email = :username)  AND password = :password AND status = :status";
        $count = $this->db->affectedRows($sql, $array);

        if($count > 0){
            $sql = "SELECT * FROM ".PREFIX."admin_users WHERE (username = :username OR email = :username) AND password = :password AND status = :status";
            return $this->db->select($sql, $array);
        }else{
            return false;
        }
    }
    public function userControlGruplu($array = array()){
        $sql = "SELECT * FROM ".PREFIX."admin_users a JOIN ".PREFIX."user_authority b ON a.authority = b.id WHERE username = :username AND password = :password AND status = :status";
        $count = $this->db->affectedRows($sql, $array);

        if($count > 0){
            $sql = "SELECT * FROM ".PREFIX."admin_users a JOIN ".PREFIX."user_authority b ON a.authority = b.id WHERE username = :username AND password = :password AND status = :status";
            return $this->db->select($sql, $array);
        }else{
            return false;
        }
    }
}
