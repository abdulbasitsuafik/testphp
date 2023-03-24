<?php
class coupons_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function coupons_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."coupons WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }
    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."coupons order by id DESC";
        return $this->db->select($sql);
    }
    public function get_stores() {
        $sql = "SELECT * FROM ".PREFIX."stores order by id DESC";
        return $this->db->select($sql);
    }
    public function get_categories() {
        $sql = "SELECT * FROM ".PREFIX."categories order by id DESC";
        return $this->db->select($sql);
    }
    public function get_regions() {
        $sql = "SELECT * FROM ".PREFIX."regions order by id DESC";
        return $this->db->select($sql);
    }
    public function get_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."coupons WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = $created_at;
        return $this->db->insert(PREFIX."coupons", $data);
    }
    public function edit($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = $created_at;
        if(@$data['name']!='') {
            $postData["name"] = @$data['name'];
        }
        if(@$data['short_name']!='') {
            $postData["short_name"] = @$data['short_name'];
        }
        if(@$data['description']!='') {
            $postData["description"] = @$data['description'];
        }
        if(@$data['start_date']!='') {
            $postData["start_date"] = @$data['start_date'];
        }
        if(@$data['end_date']!='') {
            $postData["end_date"] = @$data['end_date'];
        }
        if(@$data['promocode']!='') {
            $postData["promocode"] = @$data['promocode'];
        }
        if(@$data['promolink']!='') {
            $postData["promolink"] = @$data['promolink'];
        }
        if(@$data['discount']!='') {
            $postData["discount"] = @$data['discount'];
        }

        if(@$data['categories']!='') {
            $postData["categories"] = @$data['categories'];
        }
        if(@$data['regions']!='') {
            $postData["regions"] = @$data['regions'];
        }
        if(@$data['species']!='') {
            $postData["species"] = @$data['species'];
        }
        if(@$data['code_type']!='') {
            $postData["code_type"] = @$data['code_type'];
        }
        if(@$data['cashback']!='') {
            $postData["cashback"] = @$data['cashback'];
        }
        if(@$data['source']!='') {
            $postData["source"] = @$data['source'];
        }
        if(@$data['store_id']!='') {
            $postData["store_id"] = @$data['store_id'];
        }
        if(@$data['rating']!='') {
            $postData["rating"] = @$data['rating'];
        }
        if(@$data['exclusive']!='') {
            $postData["exclusive"] = @$data['exclusive'];
        }
        if(@$data['language']!='') {
            $postData["language"] = @$data['language'];
        }
        if(@$data['types']!='') {
            $postData["types"] = @$data['types'];
        }
        if(@$data['image']!='') {
            $postData["image"] = @$data['image'];
        }
        if(@$data['coupon_id']!='') {
            $postData["coupon_id"] = @$data['coupon_id'];
        }
        return $this->db->update(PREFIX."coupons", $postData, "`id` = '{$data['id']}'");
//        return $postData;
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."coupons", "`id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."coupons", $postData, "`id` = '{$id}'");
        return $status;
    }
}
