<?php
class Store_Model extends Model{
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
    public function add_mydrives($data){
        try {
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $data["created_at"] = $created_at;
            $this->db->insert(PREFIX."mydrives", $data);
            return $this->db->lastInsertId();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function set_mydrives($data)
    {
        if(@$data['start_date']){
            $postData["start_date"] = $data['start_date'];
        }
        if(@$data['end_date']){
            $postData["end_date"] = $data['end_date'];
        }
        if(@$data['reserv_end_date']){
            $postData["reserv_end_date"] = $data['reserv_end_date'];
        }
        if(@$data['payment']){
            $postData["payment"] = $data['payment'];
        }
        if(@$data['used']){
            $postData["used"] = $data['used'];
        }
        if(@$data['vehicle_status']){
            $postData["vehicle_status"] = $data['vehicle_status'];
        }
        if(@$data['muId']){
            $postData["muId"] = $data['muId'];
        }
        if(@$data['plate']){
            $postData["plate"] = $data['plate'];
        }
        if(@$data['invoice']){
            $postData["invoice"] = $data['invoice'];
        }
        $this->db->update(PREFIX."mydrives", $postData, "`id` = '{$data['id']}'");
    }
    public function add_to_cart($data){
        try {
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $data["created_at"] = $created_at;
            $this->db->insert(PREFIX."purchases", $data);
            return $this->db->lastInsertId();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function set_to_cart($data)
    {
        if(@$data['start_date']){
            $postData["start_date"] = $data['start_date'];
        }
        if(@$data['end_date']){
            $postData["end_date"] = $data['end_date'];
        }
        if(@$data['payment']){
            $postData["payment"] = $data['payment'];
        }
        if(@$data['used']){
            $postData["used"] = $data['used'];
        }
        if(@$data['drive_id']){
            $postData["drive_id"] = $data['drive_id'];
        }
        if(@$data['custom_price']){
            $postData["custom_price"] = $data['custom_price'];
        }
        $this->db->update(PREFIX."purchases", $postData, "`id` = '{$data['id']}'");
    }
    public function get_products($id=null,$sku=null,$ios_id=null)
    {
        if ($id){
            $sql = "SELECT * FROM ".PREFIX."products WHERE id = :id ";
            return $this->db->select($sql,[":id"=>$id]);
        }else if ($sku){
            $sql = "SELECT * FROM ".PREFIX."products WHERE sku = :sku ";
            return $this->db->select($sql,[":sku"=>$sku]);
        }else if ($ios_id){
            $sql = "SELECT * FROM ".PREFIX."products WHERE ios_id = :ios_id ";
            return $this->db->select($sql,[":ios_id"=>$ios_id]);
        }else{
            $sql = "SELECT * FROM ".PREFIX."products";
            return $this->db->select($sql);
        }
    }
    public function get_purchases_from_id($id)
    {
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE id= :id ";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function get_purchases_from_user_id_for_list($id)
    {
        $sql = "SELECT *,b.name,a.created_at FROM ".PREFIX."purchases a JOIN ".PREFIX."products b ON a.product = b.id WHERE a.user= :user and a.payment= :payment order by a.id DESC";
        return $this->db->select($sql,[":user"=>$id,":payment"=>1]);
    }
    public function get_purchases_from_user_id($id)
    {
        $sql = "SELECT * FROM ".PREFIX."purchases a JOIN ".PREFIX."products b ON a.product = b.id WHERE a.user= :user and a.used= :used and a.payment= :payment";
        return $this->db->select($sql,[":user"=>$id,":used"=>0,":payment"=>1]);
    }
    public function get_purchases_from_user_id_last($id)
    {
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE user= :user and used= :used and payment= :payment order by id DESC limit 1";
        return $this->db->select($sql,[":user"=>$id,":used"=>1,":payment"=>1]);
    }
    public function get_mydrives_from_vehicle_id($id)
    {
        $sql = "SELECT * FROM ".PREFIX."mydrives WHERE vehicle_id= :vehicle_id and used = :used and payment = :payment";
        return $this->db->select($sql,[":vehicle_id"=>$id,":used"=>0,":payment"=>1]);
    }

    public function get_single_from_type($type){
        $sql = "SELECT * FROM ".PREFIX."products WHERE type = :type ";
        return $this->db->select($sql,array(":type" => $type));
    }
    public function get_purchases($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["id"]){
            $add_sql .= " id = :id ";
            $array[':id'] = $data["id"];
        }else{
            $add_sql .= " id <> :id ";
            $array[':id'] = 0;
        }
        if (@$data["payment"]){
            $add_sql .= " AND payment = :payment ";
            $array[':payment'] = $data["payment"];
        }
        if (@$data["user"]){
            $add_sql .= " AND user = :user ";
            $array[':user'] = $data["user"];
        }
        if (@$data["start_date"]){
            $add_sql .= " AND start_date <= :start_date ";
            $array[':start_date'] = $data["start_date"];
        }
        if (@$data["end_date"]){
            $add_sql .= " AND end_date >= :end_date ";
            $array[':end_date'] = $data["end_date"];
        }
        if (@$data["used"] || @$data["used"]==0 || @$data["used"]!=null){
            $add_sql .= " AND used = :used ";
            $array[':used'] = $data["used"];
        }
        if (@$data["product"]){
            $add_sql .= " AND product = :product ";
            $array[':product'] = $data["product"];
        }
        if (@$data["drive_id"]){
            $add_sql .= " AND drive_id = :drive_id ";
            $array[':drive_id'] = $data["drive_id"];
        }
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE  ".$add_sql;
        return $this->db->select($sql,$array);
    }
}
