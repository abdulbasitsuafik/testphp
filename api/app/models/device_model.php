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
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        $this->db->insert(PREFIX."devices", $data);
        return $this->db->lastInsertId();
    }
    public function get_single_general_settings()
    {
        $sql = "SELECT * FROM ".PREFIX."general_settings order by id ASC limit 1";
        return $this->db->select($sql);
    }
    public function find_device($data)
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
        if(is_int($data["user"]) or $data["user"] > 0 ){
            $add_sql .= " AND user = :user ";
            $array[':user'] = $data["user"];
        }
        if ($add_sql){
            $array[':id'] = 0;
            $sql = "SELECT * FROM ".PREFIX."devices WHERE  id <> :id ".$add_sql;
            return $this->db->select($sql,$array);
        }else{
            $sql = false;
            return $sql;
        }
    }
    public function find_device_from_user($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."devices WHERE device_id= :device_id ";
        return $this->db->select($sql,[":device_id"=>$id]);
    }
    public function device_update($data)
    {
        if(@$data['access_token'] || @$data['access_token']=="null"){
            if(@$data['access_token']=="null"){
                $postData["access_token"] = "";
            }else{
                $postData["access_token"] = $data['access_token'];
            }
        }
        if(@$data['push_token']){
            $postData["push_token"] = $data['push_token'];
        }
        if(@$data['brand']){
            $postData["brand"] = $data['brand'];
        }
        if(@$data['model']){
            $postData["model"] = $data['model'];
        }
        if(@$data['os_type']){
            $postData["os_type"] = $data['os_type'];
        }
        if(@$data['os_version']){
            $postData["os_version"] = $data['os_version'];
        }
        if(@$data['app_version']){
            $postData["app_version"] = $data['app_version'];
        }
        if(@$data['local_language']){
            $postData["local_language"] = $data['local_language'];
        }

        if(@$data['updated_at']){
            $postData["updated_at"] = $data['updated_at'];
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
        if(is_int($data["user"]) or $data["user"] >= 0 ){
            $postData["user"] = $data['user'];
        }
        if(is_int($data["logout"])){
            $postData["logout"] = $data['logout'];
        }
        if(@$data['access_token'] || @$data['access_token']=="null"){
            if(@$data['access_token']=="null"){
                $postData["access_token"] = "";
            }else{
                $postData["access_token"] = $data['access_token'];
            }
        }
        $this->db->update(PREFIX."devices", $postData, "`user` = '{$data['id']}'");
    }
    public function device_update_from_for_noti_and_dark($data)
    {
        if($data['dark_mode'] == 1 || $data['dark_mode'] == 0){
            $postData["dark_mode"] = $data['dark_mode'];
        }
        if($data['notification'] == 1 || $data['notification'] == 0){
            $postData["notification"] = $data['notification'];
        }
        $this->db->update(PREFIX."devices", $postData, "`device_id` = '{$data['device_id']}'");
    }

}
