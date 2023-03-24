<?php

class contacts_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_data_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."forms WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }
   public function sqlSorgu($sql,$array){
        if(empty($array)){
            return $this->db->select($sql);
        }else{
            return $this->db->select($sql,$array);
        }
    }
    public function add($data){
        $this->db->insert(PREFIX."forms", $data);
        return  $this->db->lastInsertId();
    }
    public function edit($data)
    {
        $postData = array(
            'cevap_konu' => $data['cevap_konu'],
            'cevap_mesaj' => $data['cevap_mesaj'],
            'updated_by' => $_SESSION["user_id"],
            'status' => $data['status']
        );
        $this->db->update(PREFIX."forms", $postData, "`id` = '{$data['id']}'");
    }
    public function get_list($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."forms order by id DESC ";
        return $this->db->select($sql);
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."forms", "`id` = '$id'");
    }

    public function get_single($id=null){
        $sql = "SELECT * FROM ".PREFIX."forms WHERE id = :id ";
        return $this->db->select($sql,array(":id" => $id));
    }

    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."forms", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function get_forms($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."forms order by id ASC ";
        return $this->db->select($sql);
    }
    public function get_forms_by_id($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."forms WHERE id= :id ";
        return $this->db->select($sql,[":id"=>$id]);
    }
}
