<?php
class Model{
    protected $db = array();
    public function __construct() {
        $dsn = 'mysql:dbname='.vt_veritabaniadi.';host='.vt_host.';charset=utf8';
        $user = vt_kullaniciadi;
        $password = vt_sifre;

        $this->db = new Database($dsn, $user, $password);
        $this->db->exec("SET CHARSET 'utf8'");
    }
}
