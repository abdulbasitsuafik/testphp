<?php
class Index_Model extends Model{
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
}
