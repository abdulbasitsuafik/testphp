<?php
class coupons_Model extends Model{
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
    public function get_all_coupons($order)
    {
        if($order=="featured"){
            $new_order = "used_total";
        }else{
            $new_order = "id";
        }
        $sql = "SELECT * FROM ".PREFIX."coupons order by {$new_order} DESC";
        return $this->db->select($sql);
    }
    public function get_searched_coupons($text,$sortingType=null,$couponType=null,$popularity=null,$discount=null,$cachback=null,$region=null)
    {
        $sql = "";
        $order = "id";
        $ascdesc = "DESC";
        if($couponType && $couponType!="all"){
            $sql.=" AND species = :species";
            $data[":species"] = $couponType;
        }
        if($discount){
            $sql.=" AND discountInt >= :discount";
            $data[":discount"] = $discount;
        }
        if($region){
            $sql.=" AND regions LIKE :regions";
            $data[":regions"] = "%,".$region.",%";
        }
        if($popularity){
            if($popularity=="Most Popular"){
                $order ="used_total";
                $ascdesc = "DESC";
            }else if($popularity=="Low Popular"){
                $order ="used_total";
                $ascdesc = "ASC";
            }else if($popularity=="New"){
                $order ="created_at";
                $ascdesc = "DESC";
            }else if($popularity=="Old"){
                $order ="created_at";
                $ascdesc = "ASC";
            }else if($popularity=="High Discount"){
                $order ="discountInt";
                $ascdesc = "DESC";
            }else if($popularity=="Low Discount"){
                $order ="discountInt";
                $ascdesc = "ASC";
            }
        }
        $data[":name"] = "%".$text."%";
        $sql2 = "SELECT * FROM ".PREFIX."coupons WHERE name LIKE :name {$sql} order by {$order} {$ascdesc}";
        return $this->db->select($sql2,$data);
//        return $sql;
    }
    public function get_all_stores_from_text($text=null)
    {
        $sql = "SELECT COUNT( b.id ) as couponsCount,a.id,a.name,a.logo,a.image,a.large_image,a.status,a.created_at,a.store_id,a.currency,a.site_url,a.rating,a.categories,a.regions,a.activation_date,a.modified_date
        FROM ".PREFIX."stores a JOIN ".PREFIX."coupons b ON a.store_id = b.store_id WHERE a.name LIKE :text group by a.store_id order by a.created_at DESC";
        return $this->db->select($sql,[":text"=>"%".$text."%"]);
    }
//    public function get_all_user_coupons()
//    {
//        $sql = "SELECT * FROM ".PREFIX."user_coupons order by id DESC";
//        return $this->db->select($sql);
//    }
    public function get_all_users_coupons($favorite=null,$user_id=null)
    {
        if ($favorite=="1"){
            $sql = "SELECT a.*,b.favorite,b.used FROM ".PREFIX."coupons a JOIN ".PREFIX."user_coupons b ON a.coupon_id = b.coupon_id WHERE b.favorite = :favorite AND b.user_id = :user_id order by a.created_at DESC";
            return $this->db->select($sql,[":favorite"=>"1",":user_id"=>$user_id]);
        }else{
            $sql = "SELECT a.*,b.favorite,b.used FROM ".PREFIX."coupons a JOIN ".PREFIX."user_coupons b ON a.coupon_id = b.coupon_id WHERE  b.user_id = :user_id order by a.created_at DESC";

            return $this->db->select($sql,[":user_id"=>$user_id]);
        }
    }
    public function get_all_users_searched_coupons($favorite=null,$user_id=null,$text=null,$sortingType=null,$couponType=null,$popularity=null,$discount=null,$cachback=null)
    {
        $sql = "";
        $order = "id";
        $ascdesc = "DESC";
        if($couponType && $couponType!="all"){
            $sql.=" AND a.species = :species";
            $data[":species"] = $couponType;
        }
        if($discount){
            $sql.=" AND a.discountInt >= :discount";
            $data[":discount"] = $discount;
        }
        if($text){
            $sql.=" AND a.name LIKE :text";
            $data[":text"] = "%".$text."%";
        }
        if($popularity){
            if($popularity=="Most Popular"){
                $order ="a.used_total";
                $ascdesc = "DESC";
            }else if($popularity=="Low Popular"){
                $order ="a.used_total";
                $ascdesc = "ASC";
            }else if($popularity=="New"){
                $order ="a.created_at";
                $ascdesc = "DESC";
            }else if($popularity=="Old"){
                $order ="a.created_at";
                $ascdesc = "ASC";
            }else if($popularity=="High Discount"){
                $order ="a.discountInt";
                $ascdesc = "DESC";
            }else if($popularity=="Low Discount"){
                $order ="a.discountInt";
                $ascdesc = "ASC";
            }
        }
        $data[":favorite"] = $favorite;
        $data[":user_id"] = $user_id;
        $sql2 = "SELECT a.*,b.favorite,b.used FROM ".PREFIX."coupons a JOIN ".PREFIX."user_coupons b ON a.coupon_id = b.coupon_id WHERE 
        b.favorite = :favorite AND b.user_id = :user_id {$sql} order by {$order} {$ascdesc}";

        return $this->db->select($sql2,$data);
    }
    public function get_single_coupon($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."coupons WHERE coupon_id = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
//    public function get_single($id=null)
//    {
//        $sql = "SELECT * FROM ".PREFIX."user_coupons WHERE id = :id";
//        return $this->db->select($sql,[":id"=>$id]);
//    }
    public function get_single_from_coupon_id($id=null,$user)
    {
        $sql = "SELECT * FROM ".PREFIX."user_coupons WHERE coupon_id = :id and user_id = :user_id";
        return $this->db->select($sql,[":id"=>$id,":user_id"=>$user]);
    }
    public function update($data)
    {
        if($data['used']){
            $postData["used"] = 1;
        }
        if($data['favorite']=="0" || $data['favorite']=="1"){
            $postData["favorite"] = $data['favorite'];
        }
        $this->db->update(PREFIX."user_coupons", $postData, "`coupon_id` = '{$data['coupon_id']}' and user_id = '{$data['user_id']}'");
    }
    public function updateCoupons($data)
    {
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
//        $data["created_at"] = $created_at;
        if($data["used_last"]) {
            $postData["used_last"] = $created_at;
        }
        if($data["used_total"]){
            $postData["used_total"] = $data["used_total"];
        }
        return $this->db->update(PREFIX."coupons", $postData, "`coupon_id` = '{$data['coupon_id']}'");
    }
    public function addToFavorite($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
        $this->db->insert(PREFIX."user_coupons", $data);
        return  $this->db->lastInsertId();
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."user_coupons", "`id` = '$id'");
    }

}
