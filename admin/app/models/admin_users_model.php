<?php
class admin_users_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function users($data){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."admin_users WHERE ISNULL(id) ";
        $sql.= $data;
        return $this->db->select($sql);
    }

    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."admin_users order by id DESC";
        return $this->db->select($sql);
    }

    public function get_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."admin_users WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
        $data["created_at"] = strtotime("now");
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = strtotime("now");
       return $this->db->insert(PREFIX."admin_users", $data);
    }
    public function edit($data){
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = strtotime("now");
        $postData = array(
            'username' => $data['username'],
            'name' => $data['name'],
            'authority' => $data['authority'],
            'authority_name' => $data['authority_name'],
            'user_authority' => @$data['user_authority'],
            'phone' => $data['phone'],
            'updated_by' => $data['updated_by'],
            'updated_at' => $data['updated_at'],
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

        $this->db->update(PREFIX."admin_users", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."admin_users", "`id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."admin_users", $postData, "`id` = '{$id}'");
        return $status;
    }

    public function email_control($email) {
        $sql = "SELECT * FROM ".PREFIX."admin_users WHERE email= :email";
        return $this->db->select($sql,array(":email"=>$email));
    }
}
