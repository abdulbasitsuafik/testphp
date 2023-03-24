<?php
class Content_Model extends Model{
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
    public function get_county($data)
    {
        $sql = "SELECT * FROM ".PREFIX."iller  order by baslik ASC";
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
    public function get_contents($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["class"]){
            $add_sql .= " AND class = :class  ";
            $array[':class'] = $data["class"];
        }
        if (@$data["lesson"]){
            $add_sql .= " AND lesson = :lesson  ";
            $array[':lesson'] = $data["lesson"];
        }
        $array[':id'] = 0;
        $sql = "SELECT * FROM ".PREFIX.$data["content_name"]." WHERE id <> :id ".$add_sql;
        return $this->db->select($sql,$array);
    }

    public function get_head($id,$lang)
    {
        if($lang=="en"){$new_lang = 1;}else{$new_lang = 1;}
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.head_id = :head_id and b.lang = :lang and a.status = :status";
        return $this->db->select($sql, array(':head_id' => $id,"lang"=> $new_lang,":status"=>1));
    }
    public function get_head_files($id,$type)
    {
        $sql = "SELECT * FROM ".PREFIX."headlines_files a JOIN headlines_files_detail b ON a.head_id = b.head_id WHERE a.head_id = :head_id AND b.head_id = :head_id and a.file_type = :file_type and a.status = :status and b.lang = :lang group by a.id order by a.id DESC";
        return $this->db->select($sql, array(':head_id' => $id,"file_type"=> $type,":status"=>1,":lang"=>1));
    }
    public function get_head_subs($id)
    {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE a.top_head_id = :top_head_id and b.lang = :lang and a.status = :status order by a.rank ASC";
        return $this->db->select($sql, array(':top_head_id' => $id,":lang"=> 1,":status"=>1));
    }

}
