<?php
class stores_Model extends Model{
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
    public function get_all_stores($id=null)
    {
        if($id){
            $sql = "SELECT * FROM ".PREFIX."stores WHERE store_id = :id ";
            return $this->db->select($sql,[":id"=>$id]);
        }else{
            $sql = "SELECT * FROM ".PREFIX."stores order by id DESC";
            return $this->db->select($sql);
        }
    }
    public function get_all_users_stores($favorite=null,$user_id=null)
    {
        if ($favorite=="1"){
            $sql = "SELECT a.*,b.favorite,COUNT( c.id ) as couponsCount FROM ".PREFIX."stores a JOIN ".PREFIX."users_stores b ON a.store_id = b.store_id JOIN ".PREFIX."coupons c ON a.store_id = c.store_id WHERE b.favorite = :favorite AND b.user_id = :user_id group by b.id order by b.id DESC";
            return $this->db->select($sql,[":favorite"=>"1",":user_id"=>$user_id]);
        }else{
            $sql = "SELECT a.*,b.favorite,COUNT( c.id ) as couponsCount FROM ".PREFIX."stores a JOIN ".PREFIX."users_stores b ON a.store_id = b.store_id JOIN ".PREFIX."coupons c ON a.store_id = c.store_id WHERE b.favorite <> :favorite AND b.user_id = :user_id group by b.id order by b.id  DESC";

            return $this->db->select($sql,[":favorite"=>"1",":user_id"=>$user_id]);
        }
    }

    public function get_all_stores_from_category_id($id=null)
    {
        $sql = "SELECT COUNT( b.id ) as couponsCount,a.id,a.name,a.logo,a.image,a.large_image,a.status,a.created_at,a.store_id,a.currency,a.site_url,a.rating,a.categories,a.regions,a.activation_date,a.modified_date
        FROM ".PREFIX."stores a JOIN ".PREFIX."coupons b ON a.store_id = b.store_id WHERE a.categories LIKE :categories group by a.store_id order by a.created_at DESC";
        return $this->db->select($sql,[":categories"=>"%,".$id.",%"]);
    }

//    public function get_single($id=null)
//    {
//        $sql = "SELECT * FROM ".PREFIX."users_stores WHERE id = :id";
//        return $this->db->select($sql,[":id"=>$id]);
//    }
    public function get_all_coupons_for_category_page($id=null,$sortingType=null,$couponType=null,$popularity=null,$discount=null,$cachback=null)
    {
        $sql = "";
        $order = "b.id";
        $ascdesc = "DESC";
        if($couponType && $couponType!="all"){
            $sql.=" AND b.species = :species";
            $data[":species"] = $couponType;
        }
        if($discount){
            $sql.=" AND b.discountInt >= :discount";
            $data[":discount"] = $discount;
        }
        if($popularity){
            if($popularity=="Most Popular"){
                $order ="b.used_total";
                $ascdesc = "DESC";
            }else if($popularity=="Low Popular"){
                $order ="b.used_total";
                $ascdesc = "ASC";
            }else if($popularity=="New"){
                $order ="b.created_at";
                $ascdesc = "DESC";
            }else if($popularity=="Old"){
                $order ="b.created_at";
                $ascdesc = "ASC";
            }else if($popularity=="High Discount"){
                $order ="b.discountInt";
                $ascdesc = "DESC";
            }else if($popularity=="Low Discount"){
                $order ="b.discountInt";
                $ascdesc = "ASC";
            }
        }
        $data[":categories"] = "%,".$id.",%";
        $sql2 = "SELECT * FROM ".PREFIX."stores a JOIN ".PREFIX."coupons b ON a.store_id = b.store_id WHERE a.categories LIKE :categories {$sql} order by {$order} {$ascdesc}";
        return $this->db->select($sql2,$data);
    }
    public function get_all_coupons_from_store_id($id=null,$text=null,$sortingType=null,$couponType=null,$popularity=null,$discount=null,$cachback=null)
    {
        $sql = "";
        $order = "id";
        $ascdesc = "DESC";
        if($text){
            $sql.=" AND name LIKE :name";
            $data[":name"] = "%".$text."%";
        }
        $data[":id"] = $id;
        $sql2 = "SELECT * FROM ".PREFIX."coupons WHERE store_id = :id {$sql} order by id DESC";
        return $this->db->select($sql2,$data);
    }
    public function get_single_from_store_id($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."stores WHERE store_id = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function get_single_users_store_from_store_id($id,$user)
    {
        $sql = "SELECT * FROM ".PREFIX."users_stores WHERE store_id = :id and user_id = :user_id";
        return $this->db->select($sql,[":id"=>$id,":user_id"=>$user]);
    }
    public function update($data)
    {
        $postData["favorite"] = $data['favorite'];
        $this->db->update(PREFIX."users_stores", $postData, "`store_id` = '{$data['store_id']}' and user_id = '{$data['user_id']}'");
    }
//    public function delete($id)
//    {
//        $this->db->delete(PREFIX."users_stores", "`id` = '$id'");
//    }
//    public function delete_from_users_stores($id)
//    {
//        $this->db->delete(PREFIX."users_stores", "`id` = '$id'");
//    }

    public function addToFavorite($data){
//        $d = new DateTime();
//        $created_at = $d->format('Y-m-d H:i:s');
//        $data["created_at"] = $created_at;
        $this->db->insert(PREFIX."users_stores", $data);
        return  $this->db->lastInsertId();
    }

}
