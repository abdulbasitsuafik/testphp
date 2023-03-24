<?php
class general_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function active_languages() {
        $sql = "SELECT * FROM ".PREFIX."languages WHERE status= :status order by rank ASC";
        return $this->db->select($sql,array(":status"=>"1"));
    }
    public function add_files($data,$table){
        $data["created_at"] = strtotime("now");
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = strtotime("now");
        $this->db->insert(PREFIX.$table."_files", $data);
        return  $this->db->lastInsertId();
    }
    public function files_rank($data)
    {
        $postData = array(
            'rank' => $data['rank']
        );
        $this->db->update(PREFIX.$data["table"]."_files", $postData, "`head_id` = '{$data['head_id']}' AND code='{$data["code"]}'");
    }
    public function file_details($id,$table) {
        $sql = "SELECT * FROM ".PREFIX.$table."_file_details WHERE code = :code order by lang ASC";
        return $this->db->select($sql,array(":code"=>$id));
    }

    public function get_files_list($id = null,$table=null)
    {
        $sql = "SELECT * FROM ".PREFIX.$table."_files WHERE head_id = :head_id order by id DESC ";
        return $this->db->select($sql,array(":head_id"=>$id));
    }
    public function files_single($id,$table)
    {
        $sql = "SELECT * FROM ".PREFIX.$table."_files WHERE code = :code";
        return $this->db->select($sql, array(':code' => $id));
    }
    public function files_detail_single($id,$table) {
        $sql = "SELECT * FROM ".PREFIX.$table."_files_detail WHERE code = :code order by lang ASC";
        return $this->db->select($sql,array(":code"=>$id));
    }
    public function add_files_detail($data,$table){
        return  $this->db->insert(PREFIX.$table."_files_detail", $data);
    }
    public function files_detail_update($data)
    {
        $postData = array(
            "title"=>$data['title'],
            "content"=>$data['content'],
        );
        $this->db->update(PREFIX.$data["table"]."_files_detail", $postData, "`code` = '{$data['code']}' and lang='{$data['lang']}'");
    }
    public function delete_files($id,$table)
    {
        $this->db->delete(PREFIX.$table."_files", "`code` = '$id'");
        $this->db->delete(PREFIX.$table."_files_detail", "`code` = '$id'");
    }
}
