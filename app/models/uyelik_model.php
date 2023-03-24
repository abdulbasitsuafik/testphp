<?php
class Uyelik_Model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_single_user_from_username_or_email($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["email"]){
            $add_sql .= " AND email = :email ";
            $array[':email'] = $data["email"];
        }
        if (@$data["username"]){
            $add_sql .= " AND username = :username ";
            $array[':username'] = $data["username"];
        }
        if (@$data["phone_number"]){
            $add_sql .= " AND phone_number = :phone_number ";
            $array[':phone_number'] = $data["phone_number"];
        }
        if ($add_sql){
            $array[':id'] = 0;
            $sql = "SELECT * FROM ".PREFIX."`users` WHERE id <> :id ".$add_sql;
            return $this->db->select($sql, $array);
        }else{
            $sql = false;
            return $sql;
        }
    }
    public function userControl($array = array()){
        $sql = "SELECT * FROM ".PREFIX."memberships WHERE (username = :username OR email = :username)  AND password = :password AND status = :status";
        $count = $this->db->affectedRows($sql, $array);

        if($count > 0){
            $sql = "SELECT * FROM ".PREFIX."memberships WHERE (username = :username OR email = :username) AND password = :password AND status = :status";
            return $this->db->select($sql, $array);
        }else{
            return false;
        }
    }
    public function uyeol($data){
       $this->db->insert(PREFIX."uyeler", $data);
       return  $this->db->lastInsertId();
    }
    public function uyeList()
    {
        $sql = "SELECT * FROM ".PREFIX."uyeler";
        return $this->db->select($sql);
    }
    public function site_ayarlari()
    {
        $sql = "SELECT * FROM ".PREFIX."site_ayarlari";
        return $this->db->select($sql);
    }
    public function aktifEt($data)
    {
        $postData = array(
                'durum' => $data['durum']
                );
        $this->db->update(PREFIX."uyeler", $postData, "`email` = '{$data['email']}' AND kod = '{$data["kod"]}'");
    }
    public function duzenlerun($data)
    {
        $postData = array(
                    "adi"=>$data["adi"],
                    "email"=>$data["email"],
                    "telefon"=>$data["telefon"],
                    "il"=>$data["il"],
                    "dogum_tarihi"=>$data["dogum_tarihi"],
                    "sigara"=>$data["sigara"],
                    "kanser"=>$data["kanser"]
                );
        if($data["parola"]!=""){
            $postData["parola"] = $data["parola"];
        }
        $this->db->update(PREFIX."uyeler", $postData, "`id` = '{$data['id']}'");
    }
    public function mailSor($email){
        $sql = "SELECT * FROM ".PREFIX."uyeler WHERE email = :email";
        return $this->db->select($sql, array(":email"=>$email));
    }
    public function sikayetEkle($data){
       return $this->db->insert(PREFIX."sikayet", $data);
    }
    public function randevuAl($data){
        return $this->db->insert(PREFIX."randevular", $data);
    }
    public function emaildensor($email){
        $sql = "SELECT * FROM ".PREFIX."uyeler WHERE email = :email";
        return $this->db->select($sql, array(":email"=>$email));
    }
    public function telefondansor($telefon){
        $sql = "SELECT * FROM ".PREFIX."uyeler WHERE telefon = :telefon";
        return $this->db->select($sql, array(":telefon"=>$telefon));
    }
    public function koddansor($data){
        $sql = "SELECT * FROM ".PREFIX."uyeler WHERE kod = :code and id= :id";
        return $this->db->select($sql, array(":code"=>$data["kod"],":id"=>$data["id"]));
    }
    public function parolaDegistir($data){
        $postData = array(
                "parola" => $data['parola']
            );

        return $this->db->update(PREFIX."uyeler", $postData, "`id` = '{$data['id']}'");
    }
    public function kodDegistir($data){
        $postData = array(
                "kod" => $data['kod']
            );
        return $this->db->update(PREFIX."uyeler", $postData, "`id` = '{$data['id']}'");
    }
}
