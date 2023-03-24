<?php
class Notification_Model extends Model{
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
    public function get_all_notifications($favorite=null,$user_id=null)
    {
        if ($favorite){
            $sql = "SELECT a.*,b.favorite,b.id AS noti_id FROM ".PREFIX."notifications a JOIN ".PREFIX."users_notifications b ON a.id = b.notification_id WHERE b.favorite = :favorite AND b.user_id = :user_id order by a.created_at DESC";
            return $this->db->select($sql,[":favorite"=>"1",":user_id"=>$user_id]);
        }else{
            $sql = "SELECT a.*,b.favorite,b.id AS noti_id FROM ".PREFIX."notifications a JOIN ".PREFIX."users_notifications b ON a.id = b.notification_id WHERE b.favorite <> :favorite AND b.user_id = :user_id order by created_at DESC";

            return $this->db->select($sql,[":favorite"=>"1",":user_id"=>$user_id]);
        }
    }
    public function get_single($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."users_notifications WHERE id = :id";
        return $this->db->select($sql,[":id"=>$id]);
    }
    public function update($data)
    {
        $postData["favorite"] = $data['favorite'];
        $this->db->update(PREFIX."users_notifications", $postData, "`id` = '{$data['id']}'");
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."users_notifications", "`id` = '$id'");
    }

}
