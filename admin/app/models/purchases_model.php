<?php
class purchases_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function purchases_list($data=null){
        $sql = "SELECT * ";
        $sql.=" FROM ".PREFIX."purchases WHERE id <> :id ";
        $sql.= $data;
        return $this->db->select($sql,[":id"=>0]);
    }
    public function get_cities($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."il order by IL_ADI ASC";
        return $this->db->select($sql);
    }
    public function get_town($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["il_id"]){
            $add_sql .= " IL_ID = :il_id  ";
            $array[':il_id'] = $data["il_id"];
        }
        $sql = "SELECT * FROM ".PREFIX."ilce WHERE  ".$add_sql." order by ILCE_ADI ASC";
        return $this->db->select($sql,$array);
    }
    public function get_schools($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["ili"]){
            $add_sql .= " ili = :ili  ";
            $array[':ili'] = $data["ili"];
        }
        if (@$data["ilcesi"]){
            $add_sql .= " AND ilcesi = :ilcesi  ";
            $array[':ilcesi'] = $data["ilcesi"];
        }
        $sql = "SELECT * FROM ".PREFIX."kayitlar WHERE  ".$add_sql." order by adi ASC";
        return $this->db->select($sql,$array);
    }
    public function single_county($data)
    {
        $sql = "SELECT * FROM ".PREFIX."il WHERE IL_ID = :id ";
        return $this->db->select($sql,[":id"=>$data]);
    }
    public function single_town($data)
    {
        $sql = "SELECT * FROM ".PREFIX."ilce WHERE ILCE_ID = :id ";
        return $this->db->select($sql,[":id"=>$data]);
    }
    public function get_classes($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."classes order by id ASC";
        return $this->db->select($sql);
    }
    public function get_lessons($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."lessons order by id ASC";
        return $this->db->select($sql);
    }
    public function get_units($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."units order by id ASC";
        return $this->db->select($sql);
    }
    public function get_list() {
        $sql = "SELECT * FROM ".PREFIX."purchases order by id DESC";
        return $this->db->select($sql);
    }
    public function get_list_of_active_user() {
        $sql = "SELECT * FROM ".PREFIX."devices WHERE access_token != :access_token";
        return $this->db->select($sql,[":access_token"=>""]);
    }
    public function get_list_user_order_point() {
        $sql = "SELECT * FROM ".PREFIX."purchases order by point DESC";
        return $this->db->select($sql);
    }
    public function update_just_point($data)
    {
        $postData = array(
            'point' => $data["point"]
        );
        $this->db->update(PREFIX."purchases", $postData, "`id` = '{$data["user"]}'");
    }
    public function get_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function get_single_purchases($id)
    {
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function add($data){
//        $data["created_at"] = strtotime("now");
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
       return $this->db->insert(PREFIX."purchases", $data);
    }
    public function add_purchases_points_monthly($data){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data["created_at"] = $created_at;
       return $this->db->insert(PREFIX."purchases_points_monthly", $data);
    }
    public function get_purchases_points_monthly($data)
    {
        $sql = "SELECT * FROM ".PREFIX."purchases_points_monthly WHERE year = :year AND month = :month ";
        return $this->db->select($sql,[":month"=>$data["month"],":year"=>$data["year"]]);
    }
    public function get_purchases_sessions($id)
    {
        $sql = "SELECT * FROM ".PREFIX."sessions WHERE user= :user order by id ASC ";
        return $this->db->select($sql,[":user"=>$id]);
    }
    public function get_user_roles()
    {
        $sql = "SELECT * FROM ".PREFIX."`purchases_permissions_role` order by id ASC ";
        return $this->db->select($sql);
    }
    public function add_to_cart($data){
        try {
            $data["added_by"] = $_SESSION["user_id"];
            $data["updated_by"] = $_SESSION["user_id"];
            $this->db->insert(PREFIX."purchases", $data);
            return $this->db->lastInsertId();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function get_user_purchases($id)
    {
        $sql = "SELECT a.*,b.name AS product_name FROM ".PREFIX."purchases a JOIN products b ON a.product = b.id  WHERE a.user = :user AND a.payment = :payment  ";
        return $this->db->select($sql,[":user"=>$id,":payment"=>1]);
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
            $add_sql .= " AND start_date >= :start_date ";
            $array[':start_date'] = $data["start_date"];
        }
        if (@$data["end_date"]){
            $add_sql .= " AND end_date <= :end_date ";
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
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE  ".$add_sql;
        return $this->db->select($sql,$array);
    }
    public function edit($data){
//        $data["updated_by"] = @$_SESSION["user_id"];
//        $data["updated_at"] = strtotime("now");
        if(@$data['username']!='') {
            $postData["username"] = @$data['username'];
        }
        if(@$data['name']!='') {
            $postData["name"] = @$data['name'];
        }
        if(@$data['surname']!='') {
            $postData["surname"] = @$data['surname'];
        }
        if(@$data['full_name']!='') {
            $postData["full_name"] = @$data['full_name'];
        }
        if(@$data['role']!='') {
            $postData["role"] = @$data['role'];
        }
        if(@$data['ads_enabled']!='') {
            $postData["ads_enabled"] = @$data['ads_enabled'];
        }
        if(@$data['premium_competition']!='') {
            $postData["premium_competition"] = @$data['premium_competition'];
        }
        if(@$data['teacher_agreement']!='') {
            $postData["teacher_agreement"] = @$data['teacher_agreement'];
        }
        if(@$data['phone']!='') {
            $postData["phone_number"] = @$data['phone'];
        }
        if(@$data['town']!='') {
            $postData["town"] = @$data['town'];
        }
        if(@$data['city']!='') {
            $postData["city"] = @$data['city'];
        }
        if(@$data['school']!='') {
            $postData["school"] = @$data['school'];
        }
        if(@$data['class']!='') {
            $postData["class"] = @$data['class'];
        }
        if(@$data['image']!='') {
            $postData["image"] = @$data['image'];
        }
        if(@$data['email']!='') {
            $postData["email"] = @$data['email'];
        }
        if(@$data['password']!='') {
            $postData["password"] = @$data['password'];
        }
        if(@$data['point']!='') {
            $postData["point"] = @$data['point'];
        }

        return $this->db->update(PREFIX."purchases", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."purchases", "`id` = '$id'");
        $this->db->delete(PREFIX."answers", "`user` = '$id'");
        $this->db->delete(PREFIX."sessions", "`user` = '$id'");
        $this->db->delete(PREFIX."devices", "`user` = '$id'");
        $this->db->delete(PREFIX."purchases", "`user` = '$id'");
        $this->db->delete(PREFIX."purchases_notifications", "`user_id` = '$id'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."purchases", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function purchases_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'used' => $status
        );
        $this->db->update(PREFIX."purchases", $postData, "`id` = '{$id}'");
        return $status;
    }

    public function email_control($email) {
        $sql = "SELECT * FROM ".PREFIX."purchases WHERE email= :email";
        return $this->db->select($sql,array(":email"=>$email));
    }
}
