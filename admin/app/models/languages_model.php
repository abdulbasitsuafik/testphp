<?php
class languages_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function sqlSorgu($sql,$array=[]){
        if(empty($array)){
            return $this->db->select($sql);
        }else{
            return $this->db->select($sql,$array);
        }
    }
    public function insert_settings($data){
        try{
            return $this->db->insert(PREFIX."general_settings", $data);
        }catch (Exception $e){
            return $e;
        }
    }
    public function insert_languages($data){
        try{
            return $this->db->insert(PREFIX."languages", $data);
        }catch (Exception $e){
            return $e;
        }
    }
    public function get_data_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."languages WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }
    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."languages order by id DESC";
        return $this->db->select($sql);
    }
    public function get_single($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."languages WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
       try{
           return $this->db->insert(PREFIX."languages", $data);
       }catch (Exception $e){
           return $e;
       }
    }
    public function edit($data){
        if(@$data['name']!='') {
            $postData["name"] = @$data['name'];
        }
        if(@$data['code']!='') {
            $postData["code"] = @$data['code'];
        }
        if(@$data['rank']!='') {
            $postData["rank"] = @$data['rank'];
        }
        if(@$data['status']!='') {
            $postData["status"] = @$data['status'];
        }

        return $this->db->update(PREFIX."languages", $postData, "`id` = '{$data['head_id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."languages", "`id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."languages", $postData, "`id` = '{$id}'");
        return $status;
    }
}
