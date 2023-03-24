<?php
class notifications_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function users_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."notifications WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }

    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."notifications order by id DESC";
        return $this->db->select($sql);
    }

    public function get_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."notifications WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
//        $data["created_at"] = strtotime("now");
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
       $this->db->insert(PREFIX."notifications", $data);
       return $this->db->lastInsertId();
    }
    public function add_to_user($data){
//        $data["created_at"] = strtotime("now");
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
        return $this->db->insert(PREFIX."users_notifications", $data);
    }
    public function edit($data){
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
        $postData = array(
            'username' => $data['username'],
            'full_name' => $data['name'],
            'role' => $data['role'],
            "ads_enabled" => $data['ads_enabled'],
            "premium_competition" => $data['premium_competition'],
            "teacher_agreement" => $data['teacher_agreement'],
//            'authority' => $data['authority'],
//            'authority_name' => $data['authority_name'],
//            'user_authority' => @$data['user_authority'],
            'phone_number' => $data['phone'],
//            'updated_by' => $data['updated_by'],
//            'updated_at' => $data['updated_at'],
        );
        if(@$data['image']!='') {
            $postData["image"] = @$data['image'];
        }
        if(@$data['email']!='') {
            $postData["email"] = @$data['email'];
        }
        if(@$data['password']!='') {
            $postData["password"] = @$data['password'];
        }

        $this->db->update(PREFIX."notifications", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."notifications", "`id` = '$id'");
        $this->db->delete(PREFIX."users_notifications", "`notification_id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."notifications", $postData, "`id` = '{$id}'");
        return $status;
    }

    public function email_control($email) {
        $sql = "SELECT * FROM ".PREFIX."notifications WHERE email= :email";
        return $this->db->select($sql,array(":email"=>$email));
    }
}
