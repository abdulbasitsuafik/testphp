<?php
class settings_model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function active_languages() {
        $sql = "SELECT * FROM ".PREFIX."languages WHERE status= :status order by rank ASC";
        return $this->db->select($sql,array(":status"=>"1"));
    }

    public function get_single()
    {
        $sql = "SELECT * FROM ".PREFIX."general_settings order by id ASC limit 1";
        return $this->db->select($sql);
    }
    public function edit($data){
        $data["updated_by"] = @$_SESSION["user_id"];
        $data["updated_at"] = strtotime("now");
        $postData = array(
            'facebook' => $data['facebook'],
            'twitter' => $data['twitter'],
            'whatsapp' => $data['whatsapp'],
            'googleplus' => $data['googleplus'],
            'instagram' => $data['instagram'],
            'linkedin' => $data['linkedin'],
            'pinterest' => $data['pinterest'],
            'youtube' => $data['youtube'],
            'skype' => $data['skype'],

            'analytics' => $data['analytics'],
            'formmail_alicilar' => $data['formmail_alicilar'],
            'formmail_host' => $data['formmail_host'],
            'formmail_mail' => $data['formmail_mail'],
            'formmail_sifre' => $data['formmail_sifre'],
            'formmail_secure' => $data['formmail_secure'],
            'formmail_port' => $data['formmail_port'],
            'yayin_durumu' => $data['yayin_durumu'],


             "telif_resmi_konum"=>$data['telif_resmi_konum'],
            "telif_resmi_yazi"=>$data['telif_resmi_yazi'],
            "telif_resmi_yazi_bg"=>$data['telif_resmi_yazi_bg'],
            "telif_resmi_yazi_renk"=>$data['telif_resmi_yazi_renk'],
            "telif_resmi_yazi_width"=>$data['telif_resmi_yazi_width'],
            "telif_resmi_yazi_height"=>$data['telif_resmi_yazi_height'],
            "telif_resmi_yazi_font"=>$data['telif_resmi_yazi_font'],
            "telif_resmi_yazi_font_size"=>$data['telif_resmi_yazi_font_size'],
            "telif_resmi_secim"=>$data['telif_resmi_secim'],


            'unvani' => $data['unvani'],
            'telif' => $data['telif'],
            'telefon' => $data['telefon'],
            'telefon1' => $data['telefon1'],
            'telefon2' => $data['telefon2'],
            'telefon3' => $data['telefon3'],
            'telefon4' => $data['telefon4'],
            'telefon5' => $data['telefon5'],
            'fax' => $data['fax'],
            'gsm' => $data['gsm'],
            'adres1' => $data['adres1'],
            'adres2' => $data['adres2'],
            'adres3' => $data['adres3'],
            'email' => $data['email'],
            'langitude' => $data['langitude'],
            'latitude' => $data['latitude'],
            'harita' => $data['harita'],
            'mobil_telefon' => $data['mobil_telefon'],
            'mobil_email' => $data['mobil_email'],
            'mobil_harita' => $data['mobil_harita']

        );
        if(@$data['logo']!='') {
            $postData["logo"] = @$data['logo'];
        }
        if(@$data['active_android_version']!='') {
            $postData["active_android_version"] = @$data['active_android_version'];
        }
        if(@$data['active_ios_version']!='') {
            $postData["active_ios_version"] = @$data['active_ios_version'];
        }
        if(@$data['footer_logo']!='') {
            $postData["footer_logo"] = @$data['footer_logo'];
        }
        if(@$data['favicon']!='') {
            $postData["favicon"] = @$data['favicon'];
        }
        if(@$data['telif_resmi']!='') {
            $postData["telif_resmi"] = @$data['telif_resmi'];
        }
        $postData["payment_method"] = @$data['payment_method'];
        $this->db->update(PREFIX."general_settings", $postData, "`id` = '1'");
    }
    public function change_status($id,$status)
    {
        if($status==1){$status=0;}else{$status=1;}
        $postData = array(
            'status' => $status
        );
        $this->db->update(PREFIX."general_settings", $postData, "`id` = '{$id}'");
        return $status;
    }
    public function fontlar() {
        $sql = "SELECT * FROM ".PREFIX."fontlar order by id DESC";
        return $this->db->select($sql);
    }
    public function fontYukle($data){
        $this->db->insert(PREFIX."fontlar", $data);
        return  $this->db->lastInsertId();
    }
}
