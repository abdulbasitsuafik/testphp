<?php
class Report_Model extends Model{
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
    public function find_sessions($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["completed"]){
            $add_sql .= " AND completed = :completed ";
            $array[':completed'] = $data["completed"];
        }
        if (@$data["user"]){
            $add_sql .= " AND user = :user ";
            $array[':user'] = $data["user"];
        }
        $array[':id'] = 0;
        $sql = "SELECT * FROM ".PREFIX."sessions WHERE  id <> :id ".$add_sql;
        return $this->db->select($sql,$array);
    }
    public function find_exam($id)
    {
        $add_sql = "";
        $array = [];
        $array[':id'] = $id;
        $sql = "SELECT * FROM ".PREFIX."exams WHERE  id = :id ".$add_sql;
        return $this->db->select($sql,$array);
    }
    public function find_unit($id)
    {
        $add_sql = "";
        $array = [];
        $array[':id'] = $id;
        $sql = "SELECT * FROM ".PREFIX."units WHERE  id = :id ".$add_sql;
        return $this->db->select($sql,$array);
    }
    public function find_session_exam_unit($data)
    {
        $add_sql = "";
        $array = [];
        if (@$data["user"]){
            $add_sql .= " a.user = :user ";
            $array[':user'] = $data["user"];
        }
        if (@$data["completed"]){
            $add_sql .= " AND a.completed = :completed ";
            $array[':completed'] = $data["completed"];
        }
        if (@$data["exam"]){
            $add_sql .= " AND a.exam = :exam ";
            $array[':exam'] = $data["exam"];
        }
        if (@$data["created_at_lte"] && @$data["created_at_gte"]){
            $array[':created_at_gte'] = $data["created_at_gte"];
            $array[':created_at_lte'] = $data["created_at_lte"];
            $add_sql .= " AND a.created_at >= :created_at_gte AND a.created_at < :created_at_lte ";
        }
        if($add_sql){
//            $array[':id'] = 0;
            $sql = "SELECT a.*,b.name AS exam_name,c.name AS unit_name FROM ".PREFIX."sessions a JOIN exams b ON a.exam = b.id JOIN units c ON b.unit = c.id WHERE  ".$add_sql." order by c.name ASC";
            return $this->db->select($sql,$array);
        }else{
            return [];
        }

    }
}
