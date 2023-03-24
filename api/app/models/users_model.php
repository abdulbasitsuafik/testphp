<?php
class users_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function ask_user($phone_number)
    {
        $sql = "SELECT * FROM ".PREFIX."users WHERE phone_number = :phone_number ";
        return $this->db->select($sql, [":phone_number"=>$phone_number]);
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
            $sql = "SELECT * FROM ".PREFIX."users WHERE id <> :id ".$add_sql;
            return $this->db->select($sql, $array);
        }else{
            $sql = false;
            return $sql;
        }


    }
    public function add_user($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        try {
            $this->db->insert(PREFIX."users", $data);
            return $this->db->lastInsertId();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function get_single_user($id)
    {
        $sql = "SELECT * FROM ".PREFIX."users WHERE id = :id ";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function get_single_user_from_tc($id)
    {
        $sql = "SELECT * FROM ".PREFIX."users WHERE tc = :tc ";
        return $this->db->select($sql, array(':tc' => $id));
    }
    public function get_single_user_from_email($id)
    {
        $sql = "SELECT * FROM ".PREFIX."users WHERE email = :email ";
        return $this->db->select($sql, array(':email' => $id));
    }
    public function get_single_user_cards($id)
    {
        $sql = "SELECT * FROM ".PREFIX."users_cards WHERE user = :id ";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function get_single_user_cards_from_card($id,$card_number)
    {
        $sql = "SELECT * FROM ".PREFIX."users_cards WHERE user = :user and card_number= :card_number";
        return $this->db->select($sql, array(':user' => $id,":card_number"=>$card_number));
    }
    public function get_single_users_card_detail($id,$card_id)
    {
        $sql = "SELECT * FROM ".PREFIX."users_cards WHERE user = :user and id= :id";
        return $this->db->select($sql, array(':user' => $id,":id"=>$card_id));
    }
    public function get_single_user_role($id)
    {
        if($id){
            $sql = "SELECT * FROM ".PREFIX."`users_permissions_role` WHERE id = :id ";
            return $this->db->select($sql, array(':id' => $id));
        }
    }


    public function edit_user($data)
    {
        if(@$data['password']){
            $postData["password"] = $data['password'];
        }
        if(@$data['name']){
            $postData["name"] = $data['name'];
        }
        if(@$data['surname']){
            $postData["surname"] = $data['surname'];
        }
        if(@$data['full_name']){
            $postData["full_name"] = $data['full_name'];
        }
        if(@$data['username']){
            $postData["username"] = $data['username'];
        }
        if(@$data['password']){
            $postData["password"] = $data['password'];
        }
        if(@$data['phone_number']){
            $postData["phone_number"] = $data['phone_number'];
        }
        if(@$data['email']){
            $postData["email"] = $data['email'];
        }
        if(@$data['city']){
            $postData["city"] = $data['city'];
        }
        if(@$data['town']){
            $postData["town"] = $data['town'];
        }
        if(@$data['avatar']){
            $postData["avatar"] = $data['avatar'];
        }
        if(@$data['born_date']){
            $postData["born_date"] = $data['born_date'];
        }
        if(@$data['language']){
            $postData["language"] = $data['language'];
        }
        if(@$data['resetPasswordToken']){
            $postData["resetPasswordToken"] = $data['resetPasswordToken'];
        }
        $this->db->update(PREFIX."users", $postData, "`id` = '{$data['id']}'");
    }
    public function get_users_points_monthly($data)
    {
        $add_sql = "";
        if (@$data["created_at_lte"] && @$data["created_at_gte"]){
            $array[':created_at_gte'] = $data["created_at_gte"];
            $array[':created_at_lte'] = $data["created_at_lte"];
            $add_sql .= " created_at >= :created_at_gte AND created_at <= :created_at_lte ";
        }
        if(@$data['user']){
            $array[':user'] = $data["user"];
            $add_sql .= " AND user = :user ";
        }
        $sql = "SELECT * FROM ".PREFIX."users_points_monthly WHERE ".$add_sql." order by point DESC limit 50";
        return $this->db->select($sql,$array);
    }
    public function get_cities($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."il order by IL_ADI ASC";
        return $this->db->select($sql);
    }
    public function get_classes($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."classes order by id ASC";
        return $this->db->select($sql);
    }
    public function get_lessons($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."lessons order by id ASC";
        return $this->db->select($sql);
    }
    public function get_leaderboard($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."users WHERE role= :role  order by point DESC limit 50";
        return $this->db->select($sql,[":role"=>3]);
    }
}
