<?php
class headlines_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function add($data){
        $data["created_at"] = strtotime("now");
        $this->db->insert(PREFIX."headlines", $data);
        return $this->db->lastInsertId();

    }
    public function add_lang($data){
        $this->db->insert(PREFIX."headlines_langs", $data);
        return $this->db->lastInsertId();
    }
    public function edit($data)
    {
        $updated_at = strtotime("now");
        $postData = array(
            'main_head' => $data['main_head'],
            'top_head_id' => $data['top_head_id'],
            'link' => $data['link'],
            'ek' => $data['ek'],
            'form_id' => $data['form_id'],
            'slide_id' => $data['slide_id'],
            'galery_id' => $data['galery_id'],
            'popup_id' => $data['popup_id'],
            'inlink_type' => $data['inlink_type'],
            'link_opening' => $data['link_opening'],
            'link_selected' => $data['link_selected'],

            'updated_by' => @$_SESSION["user_id"] ? @$_SESSION["user_id"] : 0,
            'updated_at' => $updated_at,
        );
        if($data['image']) {
            $postData["image"] = $data['image'];
        }
        $postData["status"] = $data['status'];
        $this->db->update(PREFIX."headlines", $postData, "`id` = '{$data['head_id']}'");
    }
    public function edit_lang($data2)
    {
        $postData2 = array(
            'seflink' => $data2['seflink'],
            'content' => $data2['content'],
            'ek_description' => $data2['ek_description']
        );
        $postData2['title'] = $data2['title'];
        $postData2['description'] = $data2['description'];
        $postData2['keywords'] = $data2['keywords'];
        $this->db->update(PREFIX."headlines_langs", $postData2, "`head_id` = '{$data2['head_id']}' AND lang='{$data2["lang"]}'");
    }
    public function get_list($id=null)
    {
        $sql = "SELECT * FROM ".PREFIX."headlines order by id DESC ";
        return $this->db->select($sql);
    }
    public function delete($id)
    {
        $this->db->delete(PREFIX."headlines", "`id` = '$id'");
        $this->db->delete(PREFIX."headlines_langs", "`head_id` = '$id'");
        $this->db->delete(PREFIX."headlines_plugins", "`head_id` = '$id'");
        $this->db->delete(PREFIX."headlines_files", "`id` = '$id'");
        $this->db->delete(PREFIX."headlines_files_detail", "`id` = '$id'");
    }
    public function plugin_delete($id)
    {
        $this->db->delete(PREFIX."headlines_plugins", "`id` = '$id'");
    }
    public function get_single($id){
        $sql = "SELECT * FROM ".PREFIX."headlines WHERE id = :id ";
        return $this->db->select($sql,array(":id" => $id));
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."headlines", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function change_sub_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'bottom_status' => $status
        );
        $this->db->update(PREFIX."headlines", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function change_first_sub_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'first_bottom_head' => $status
        );
        $this->db->update(PREFIX."headlines", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function add_plugins($data){
        $this->db->insert(PREFIX."headlines_plugins", $data);
        return  $this->db->lastInsertId();
    }

    public function rank_kaydet($data)
    {
        $postData = array(
            'ranks' => $data['ranks'],
            'main_head' => $data['main_head'],
        );
        if($data['top_head_id']!='') $postData['top_head_id'] = $data['top_head_id'];
        return $this->db->update(PREFIX."headlines", $postData, "`id` = '{$data['id']}' ");
    }
    public function formList() {
        $sql = "SELECT * FROM ".PREFIX."formlar order by id DESC";
        return $this->db->select($sql);
    }
    public function headlines_languages_join($id)
    {
        $sql = "SELECT * FROM ".PREFIX."headlines_langs a JOIN ".PREFIX."languages b ON a.lang = b.ranks JOIN ".PREFIX."headlines c ON a.head_id = c.id  WHERE a.head_id = :head_id";
        return $this->db->select($sql, array(':head_id' => $id));
    }
    public function headlineslar_join($id) {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and head_id= :head_id order by a.id ASC";
        return $this->db->select($sql,array(':lang' => 1,':head_id' => $id));
    }
    public function alt_headlineslar_single($id)
    {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE top_head_id = :top_head_id and b.lang = :lang";
        return $this->db->select($sql, array(':top_head_id' => $id,"lang"=> 1));
    }
    public function modulTek($id) {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_plugins b ON a.id = b.head_id WHERE b.head_id= :head_id order by b.head_id ASC";
        return $this->db->select($sql, array(':head_id' => $id));
    }
    public function main_headList() {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and a.main_head = :main_head order by a.id ASC";
        return $this->db->select($sql,array(":lang"=>1,":main_head"=>1));
    }
    public function active_languages() {
        $sql = "SELECT * FROM ".PREFIX."languages WHERE status= :status order by ranks ASC";
        return $this->db->select($sql,array(":status"=>"1"));
    }
    public function all_headlines() {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang order by a.id ASC";
        return $this->db->select($sql,array(":lang"=>1));
    }
    public function resimList($id)
    {
        $sql = "SELECT * FROM ".PREFIX."headlines_resim WHERE head_id = :head_id and boyut = :boyut order by ranks ASC";
        return $this->db->select($sql, array(':head_id' => $id,':boyut' => 1));
    }
    public function galeriList() {
        $sql = "SELECT * FROM ".PREFIX."galeri a JOIN ".PREFIX."galeri_dil b ON a.id = b.galery_id WHERE b.lang = :lang order by a.id DESC";
        return $this->db->select($sql,array(":lang"=>DEFAULT_LANG));
    }
    public function bannerList() {
        $sql = "SELECT * FROM ".PREFIX."slayt order by id ASC";
        return $this->db->select($sql);
    }
    public function popupList() {
        $sql = "SELECT * FROM ".PREFIX."reklam_popup order by id ASC";
        return $this->db->select($sql);
    }

}
