<?php

class products_model extends Model{
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
    public function add($data){
        $this->db->insert(PREFIX."products", $data);
        return  $this->db->lastInsertId();
    }
    public function edit($data)
    {
        $postData = array(
            'name' => $data['name'],
            'type' => $data['type'],
            'description' => $data['description'],
            'price' => $data['price'],
            'per_price' => $data['per_price'],
            'period' => $data['period'],
            'sku' => $data['sku'],
            'image' => $data['image'],
            'color' => $data['color'],
            'ios_id' => $data['ios_id'],
        );
        $this->db->update(PREFIX."products", $postData, "`id` = '{$data['id']}'");
    }
    public function get_list($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."products order by id DESC ";
        return $this->db->select($sql);
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."products", "`id` = '$id'");
    }

    public function get_single($id){
        $sql = "SELECT * FROM ".PREFIX."products WHERE id = :id ";
        return $this->db->select($sql,array(":id" => $id));
    }

    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."products", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function get_lessons($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."lessons order by id ASC ";
        return $this->db->select($sql);
    }
    public function get_lesson_by_id($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."lessons WHERE id= :id ";
        return $this->db->select($sql,[":id"=>$id]);
    }
}
