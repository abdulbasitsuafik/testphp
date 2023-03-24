<?php
class Forms_Model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function sqlSorgu($sql,$array){
        if(empty($array)){
            return $this->db->select($sql);
        }else{
            return $this->db->select($sql,$array);
        }
    }
    public function insert($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        $this->db->insert(PREFIX."forms", $data);
        return $this->db->lastInsertId();
    }
    public function insert_card($data){
        try {
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $data["created_at"] = $created_at;
            $this->db->insert(PREFIX."users_cards", $data);
            return $this->db->lastInsertId();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function delete_card($id)
    {
        $this->db->delete(PREFIX."users_cards", "`id` = '$id'");
    }
    public function find_user($data)
    {
        $sql = "SELECT * FROM ".PREFIX."users WHERE  id = :id ";
        return $this->db->select($sql,[":id"=>$data["id"]]);
    }
    public function find_device_from_user($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."forms WHERE device_id= :device_id ";
        return $this->db->select($sql,[":device_id"=>$id]);
    }
    public function device_update($data)
    {
        if(@$data['access_token']){
            $postData["access_token"] = $data['access_token'];
        }
        if(@$data['push_token']){
            $postData["push_token"] = $data['push_token'];
        }
        if(@$data['user']){
            $postData["user"] = $data['user'];
        }
        if(@$data['updated_at']){
            $postData["updated_at"] = $data['updated_at'];
        }
        if(@$data['logout']){
            $postData["logout"] = $data['logout'];
        }
        $this->db->update(PREFIX."forms", $postData, "`device_id` = '{$data['device_id']}'");
    }


}
