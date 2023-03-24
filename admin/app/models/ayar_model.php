<?php
class Ayar_Model extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function ayarList() {
        $sql = "SELECT * FROM ".PREFIX."site_ayarlari order by id DESC";
        return $this->db->select($sql);
    }
    public function seoAyar() {
        $sql = "SELECT * FROM ".PREFIX."seo_ayar order by dil_id ASC";
        return $this->db->select($sql);
    }
    public function footerLogo($data)
    {
        $postData = array(
            'footer_logo' => $data['footer_logo']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function fontlar() {
        $sql = "SELECT * FROM ".PREFIX."fontlar order by id DESC";
        return $this->db->select($sql);
    }
    public function fontYukle($data){
        $this->db->insert(PREFIX."fontlar", $data);
        return  $this->db->lastInsertId();
    }
    public function telifresimleriGuncelle($tablo,$data)
    {
        $postData = array(
            $tablo.'_resmi_yeni' => $data[$tablo.'_resmi_yeni']
        );
        $this->db->update(PREFIX.$tablo, $postData, "`id` = '{$data['id']}'");
    }
    public function telifekresimleriGuncelle($tablo,$data)
    {
        $postData = array(
            'resim_link_yeni' => $data['resim_link_yeni']
        );
        $this->db->update(PREFIX.$tablo."_resim", $postData, "`id` = '{$data['id']}'");
    }
    public function haberUstBaslik($data)
    {
        $postData = array(
            'haber_ust_baslik_id' => $data['haber_ust_baslik_id']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function ayarListSingle($id)
    {
        $sql = "SELECT * FROM ".PREFIX."site_ayarlari WHERE id = :id";
        return $this->db->select($sql, array(':id' => $id));
    }
    public function aktifDiller() {
        $sql = "SELECT * FROM ".PREFIX."diller WHERE status= :status order by sira ASC";
        return $this->db->select($sql,array(":status"=>"1"));
    }
    public function ekleRunAjax($data){
        $this->db->insert(PREFIX."site_ayarlari", $data);
        echo json_encode($data);
    }
    public function seoAyarDuzenle($data)
    {
        $postData = array(
            "title" => $data["title"],
            "aciklama" => $data["aciklama"],
            "keywords" => $data["keywords"],
            "baslik_title" => $data["baslik_title"],
            "baslik_aciklama" => $data["baslik_aciklama"],
            "baslik_keywords" => $data["baslik_keywords"],
            "alt_baslik_title" => $data["alt_baslik_title"],
            "alt_baslik_aciklama" => $data["alt_baslik_aciklama"],
            "headlines_title" => $data["headlines_title"],
            "headlines_aciklama" => $data["headlines_aciklama"],
            "headlines_keywords" => $data["headlines_keywords"],
            "alt_headlines_title" => $data["alt_headlines_title"],
            "alt_headlines_aciklama" => $data["alt_headlines_aciklama"],
            "proje_headlines_title" => $data["proje_headlines_title"],
            "proje_headlines_aciklama" => $data["proje_headlines_aciklama"],
            "proje_headlines_keywords" => $data["proje_headlines_keywords"],
            "proje_alt_headlines_title" => $data["proje_alt_headlines_title"],
            "proje_alt_headlines_aciklama" => $data["proje_alt_headlines_aciklama"],
            "hizmet_headlines_title" => $data["hizmet_headlines_title"],
            "hizmet_headlines_aciklama" => $data["hizmet_headlines_aciklama"],
            "hizmet_headlines_keywords" => $data["hizmet_headlines_keywords"],
            "hizmet_alt_headlines_title" => $data["hizmet_alt_headlines_title"],
            "hizmet_alt_headlines_aciklama" => $data["hizmet_alt_headlines_aciklama"],
            "urun_title" => $data["urun_title"],
            "urun_aciklama" => $data["urun_aciklama"],
            "urun_keywords" => $data["urun_keywords"],
            "proje_title" => $data["proje_title"],
            "proje_aciklama" => $data["proje_aciklama"],
            "proje_keywords" => $data["proje_keywords"],
            "hizmet_title" => $data["hizmet_title"],
            "hizmet_aciklama" => $data["hizmet_aciklama"],
            "hizmet_keywords" => $data["hizmet_keywords"],
            "haber_title" => $data["haber_title"],
            "haber_aciklama" => $data["haber_aciklama"],
            "haber_keywords" => $data["haber_keywords"],
            "etkinlik_title" => $data["etkinlik_title"],
            "etkinlik_aciklama" => $data["etkinlik_aciklama"],
            "etkinlik_keywords" => $data["etkinlik_keywords"],
        );
        $this->db->update(PREFIX."seo_ayar", $postData, "`dil_id` = '{$data["dil_id"]}'");
    }
    public function sosyalDuzenle($data)
    {
        $postData = array(
            'facebook' => $data['facebook'],
            'twitter' => $data['twitter'],
            'whatsapp' => $data['whatsapp'],
            'googleplus' => $data['googleplus'],
            'instagram' => $data['instagram'],
            'linkedin' => $data['linkedin'],
            'pinterest' => $data['pinterest'],
            'youtube' => $data['youtube'],
            'skype' => $data['skype']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function genelDuzenle($data)
    {
        $postData = array(
            'analytics' => $data['analytics'],
            'formmail_alicilar' => $data['formmail_alicilar'],
            'formmail_host' => $data['formmail_host'],
            'formmail_mail' => $data['formmail_mail'],
            'formmail_sifre' => $data['formmail_sifre'],
            'formmail_secure' => $data['formmail_secure'],
            'formmail_port' => $data['formmail_port'],
            'yayin_durumu' => $data['yayin_durumu']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function genelLogo($data)
    {
        $postData = array(
            'logo' => $data['logo']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function genelFavicon($data)
    {
        $postData = array(
            'favicon' => $data['favicon']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function genelTelifresmi($data)
    {
        $postData = array(
            'telif_resmi' => $data['telif_resmi']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function telifresmiGuncelle($data)
    {
        $postData = array(
            "telif_resmi_konum"=>$data['telif_resmi_konum'],
            "telif_resmi_yazi"=>$data['telif_resmi_yazi'],
            "telif_resmi_yazi_bg"=>$data['telif_resmi_yazi_bg'],
            "telif_resmi_yazi_renk"=>$data['telif_resmi_yazi_renk'],
            "telif_resmi_yazi_width"=>$data['telif_resmi_yazi_width'],
            "telif_resmi_yazi_height"=>$data['telif_resmi_yazi_height'],
            "telif_resmi_yazi_font"=>$data['telif_resmi_yazi_font'],
            "telif_resmi_yazi_font_size"=>$data['telif_resmi_yazi_font_size'],
            "telif_resmi_secim"=>$data['telif_resmi_secim']
        );
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function iletisimDuzenle($data)
    {
        $postData = array(
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
        $this->db->update(PREFIX."site_ayarlari", $postData, "`id` = '1'");
    }
    public function seoBaslikGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."baslik_dil", $postData, "`dil_id` = '{$data['dil_id']}' and baslik_id='{$data["baslik_id"]}'");
    }
    public function seoheadlinesGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."headlines_langs", $postData, "`dil_id` = '{$data['dil_id']}' and head_id='{$data["head_id"]}'");
    }
    public function seoProjeheadlinesGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."proje_headlines_langs", $postData, "`dil_id` = '{$data['dil_id']}' and head_id='{$data["head_id"]}'");
    }
    public function seoHizmetheadlinesGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."hizmet_headlines_langs", $postData, "`dil_id` = '{$data['dil_id']}' and head_id='{$data["head_id"]}'");
    }
    public function seoUrunGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."urun_dil", $postData, "`dil_id` = '{$data['dil_id']}'");
    }
    public function seoProjeGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."proje_dil", $postData, "`dil_id` = '{$data['dil_id']}'");
    }
    public function seoHizmetGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."hizmet_dil", $postData, "`dil_id` = '{$data['dil_id']}'");
    }
    public function seoHaberGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."makale_dil", $postData, "`dil_id` = '{$data['dil_id']}'");
    }
    public function seoEtkinlikGuncelle($data)
    {
        $postData = array(
            'title' => $data['title'],
            'aciklama' => $data['aciklama'],
            'keywords' => $data['keywords']
        );
        $this->db->update(PREFIX."etkinlik_dil", $postData, "`dil_id` = '{$data['dil_id']}'");
    }
}