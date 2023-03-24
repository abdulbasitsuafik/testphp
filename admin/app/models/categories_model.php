<?php
class categories_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function categories_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."categories WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }
    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."categories order by id DESC";
        return $this->db->select($sql);
    }
    public function get_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."categories WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function get_single_from_category_id($id)
    {
        $sql = "SELECT * FROM ".PREFIX."categories WHERE category_id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
//        $data["created_at"] = strtotime("now");
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
       return $this->db->insert(PREFIX."categories", $data);
    }
    public function edit($data){
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
        if(@$data['name']!='') {
            $postData["name"] = @$data['name'];
        }

        return $this->db->update(PREFIX."categories", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."categories", "`id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."categories", $postData, "`id` = '{$id}'");
        return $status;
    }
}
