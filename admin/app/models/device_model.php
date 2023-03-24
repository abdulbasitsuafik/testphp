<?php
class Device_Model extends Model{
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
    public function insert_device($data){
        $this->db->insert(PREFIX."devices", $data);
        return $this->db->lastInsertId();
    }
    public function find_device($data=null)
    {
        $add_sql = "";
        $array = [];
        if (@$data["device_id"]){
            $add_sql .= " AND device_id = :device_id  ";
            $array[':device_id'] = $data["device_id"];
        }
        if (@$data["access_token"]){
            $add_sql .= " AND access_token = :access_token ";
            $array[':access_token'] = $data["access_token"];
        }
        if (@$data["os_type"]){
            $add_sql .= " AND os_type = :os_type ";
            $array[':os_type'] = $data["os_type"];
        }
        if (@$data["app_version"]){
            $add_sql .= " AND app_version = :app_version ";
            $array[':app_version'] = $data["app_version"];
        }
        if(is_int($data["user"]) or $data["user"] > 0 ){
            $add_sql .= " AND user = :user ";
            $array[':user'] = $data["user"];
        }
        $array[':id'] = 0;
        $sql = "SELECT * FROM ".PREFIX."devices WHERE  id <> :id ".$add_sql;
//        return $sql;
        return $this->db->select($sql,$array);
    }
    public function find_device_from_user($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."devices WHERE device_id= :device_id ";
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
        if(@$data['updated_at']){
            $postData["updated_at"] = $data['updated_at'];
        }
        if(@$data['dark_mode']){
            $postData["dark_mode"] = $data['dark_mode'];
        }
        if(@$data['notification']){
            $postData["notification"] = $data['notification'];
        }
        if(is_int($data["logout"])){
            $postData["logout"] = $data['logout'];
        }
        if(is_int($data["user"]) or $data["user"] > 0 ){
            $postData["user"] = $data['user'];
        }
        $this->db->update(PREFIX."devices", $postData, "`device_id` = '{$data['device_id']}'");
    }
    public function device_update_from_user($data)
    {
        if(is_int($data["user"]) or $data["user"] > 0 ){
            $postData["user"] = $data['user'];
        }
        if(is_int($data["logout"])){
            $postData["logout"] = $data['logout'];
        }
        $this->db->update(PREFIX."devices", $postData, "`user` = '{$data['id']}'");
    }

}
