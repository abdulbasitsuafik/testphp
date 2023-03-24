<?php
class admitad_Model extends Model{
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
    public function get_all_coupons()
    {
        $sql = "SELECT * FROM ".PREFIX."coupons";
        return $this->db->select($sql);
    }
    public function get_single_coupons($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."coupons WHERE coupon_id = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function insert($data,$table){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        $this->db->insert(PREFIX.$table, $data);
        return $this->db->lastInsertId();
    }
    public function edit_store($data){
        $data["updated_by"] = @$_SESSION["user_id"];
        if(@$data['name']!='') {
            $postData["name"] = @$data['name'];
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

        return $this->db->update(PREFIX."stores", $postData, "`store_id` = '{$data['store_id']}'");
    }
    public function edit_coupons($data){

        $data["updated_by"] = @$_SESSION["user_id"];
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
        if(@$data['discount']!='' or @$data['discount']=='0') {
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
//        if(@$data['coupon_id']!='') {
//            $postData["coupon_id"] = @$data['coupon_id'];
//        }
        return $this->db->update(PREFIX."coupons", $postData, "`coupon_id` = '{$data['coupon_id']}'");
    }



    public function get_single_categories($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."categories WHERE category_id = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function get_single_regions($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."regions WHERE name = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function get_all_regions($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."regions order by name ASC";
        return $this->db->select($sql);
    }
    public function get_single_stores($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."stores WHERE store_id = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function update($data)
    {
        $postData["favorite"] = $data['favorite'];
        $this->db->update(PREFIX."users_coupons", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."users_coupons", "`id` = '$id'");
    }
    public function delete_coupons($id)
    {
        $this->db->delete(PREFIX."coupons", "`coupon_id` = '$id'");
        $this->db->delete(PREFIX."users_coupons", "`coupon_id` = '$id'");
    }

}
