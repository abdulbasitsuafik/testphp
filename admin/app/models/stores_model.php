<?php
class stores_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function stores_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."stores WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }
    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."stores order by id DESC";
        return $this->db->select($sql);
    }
    public function get_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."stores WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = $created_at;
       return $this->db->insert(PREFIX."stores", $data);
    }
    public function edit($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["created_at"] = $created_at;

        if(@$data['name']!='') {
            $postData["name"] = @$data['name'];
        }
        if(@$data['store_id']!='') {
            $postData["store_id"] = @$data['store_id'];
        }
        if(@$data['description']!='') {
            $postData["description"] = @$data['description'];
        }
        if(@$data['logo']!='') {
            $postData["logo"] = @$data['logo'];
        }
        if(@$data['image']!='') {
            $postData["image"] = @$data['image'];
        }
        if(@$data['large_image']!='') {
            $postData["large_image"] = @$data['large_image'];
        }
        if(@$data['site_url']!='') {
            $postData["site_url"] = @$data['site_url'];
        }
        if(@$data['status']!='') {
            $postData["status"] = @$data['status'];
        }
        if(@$data['currency']!='') {
            $postData["currency"] = @$data['currency'];
        }
        if(@$data['rating']!='') {
            $postData["rating"] = @$data['rating'];
        }
        if(@$data['activation_date']!='') {
            $postData["activation_date"] = @$data['activation_date'];
        }
        if(@$data['modified_date']!='') {
            $postData["modified_date"] = @$data['modified_date'];
        }
        if(@$data['categories']!='') {
            $postData["categories"] = @$data['categories'];
        }
        if(@$data['regions']!='') {
            $postData["regions"] = @$data['regions'];
        }

        return $this->db->update(PREFIX."stores", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."stores", "`id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."stores", $postData, "`id` = '{$id}'");
        return $status;
    }
}
