<?php
class index_Model extends Model{
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
    public function veri_ekle($tablo,$data){
        $tablo  = str_replace("tolga_","",$tablo);
        $tablo  = PREFIX.$tablo;
        return $this->db->insert($tablo, $data);
    }
    public function find_headlines($tablo,$seflink)
    {
        $sql ="SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.seflink = :seflink ";
        $bulunan = $this->db->select($sql,array(":seflink"=>$seflink));
        $sql2 ="SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.lang = :lang and b.head_id = :head_id ";
        $bulunan2 = @$this->db->select($sql2,array(":lang"=>$bulunan[0]["lang"],":head_id"=>$bulunan[0]["head_id"]));
        return ($bulunan2);
    }
    public function active_headlines($tablo,$seflink)
    {
        $sql ="SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.seflink = :seflink ";
        $bulunan = $this->db->select($sql,array(":seflink"=>$seflink));
        $sql2 ="SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.lang = :lang and b.head_id = :head_id ";
        return $this->db->select($sql2,array(":lang"=>@$_SESSION["lang"],":head_id"=>@$bulunan[0]["head_id"]));
    }
    public function find_language_from_code($id)
    {
        $sql = "SELECT * FROM ".PREFIX."languages WHERE code = :code";
        return $this->db->select($sql, array(':code' => $id));
    }
    public function find_language_from_rank($id) {
        $sql = "SELECT * FROM ".PREFIX."languages WHERE rank= :rank order by id ASC";
        return $this->db->select($sql,array(":rank" => $id));
    }
    public function find_first_head() {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and a.status= :status order by a.rank ASC limit 1";
        return $this->db->select($sql,array(":lang"=>1,":status"=>"1"));
    }
    public function menuList($tablo,$id=null,$dil=null,$limit=null) {
        if($tablo=="headlines"){
            $ekle = "and a.top_head_id = :top_head_id";
            $data[":top_head_id"] = $id;
        }else{
            $ekle = "";
        }
        if($limit!=""){
            $limitt = "limit ".$limit;
        }else{
            $limitt ="";
        }
        $data[":status"]="1";
        $data[":lang"]=$dil;
        $sql = "SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.lang = :lang and a.status= :status  ".$ekle." order by a.rank ASC ".$limitt;
        return $this->db->select($sql,$data);
        //return $sql;
    }

    public function ayarList() {
        $sql = "SELECT * FROM ".PREFIX."general_settings WHERE id= :id order by id DESC";
        return $this->db->select($sql,array(":id"=>1));
    }
    public function seoAyar() {
        $sql = "SELECT * FROM ".PREFIX."seo_ayar WHERE lang = :lang order by lang ASC";
        return $this->db->select($sql,array(":lang"=>$_SESSION["lang"]));
    }
    public function popupModal($id) {
        $sql = 'SELECT * FROM '.PREFIX.'reklam_popup WHERE id = :id';
        return $this->db->select($sql, array(':id' => $id ));
    }
    public function slaytListAll($id)
    {
        $sql = "SELECT * FROM ".PREFIX."slayt_sayfa a JOIN ".PREFIX."slayt_dil b ON a.slide_id = b.slide_id and a.sayfa_no = b.sayfa_no  WHERE a.slide_id = :slide_id and b.lang = :lang order by a.sayfa_no ASC";
        return $this->db->select($sql,array(":slide_id"=>$id,":lang"=>@$_SESSION["lang"]));
    }
    public function modulTek($id) {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_plugins b ON a.id = b.head_id WHERE b.head_id = :head_id order by b.rank ASC";
        return $this->db->select($sql,array(":head_id"=>$id));
    }
    public function modulDetayTek($id) {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_detaymodul b ON a.id = b.head_id WHERE b.head_id = :head_id order by b.rank ASC";
        return $this->db->select($sql,array(":head_id"=>$id));
    }
     public function headlinesList($filtre) {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = '{$_SESSION["lang"]}' and status='1'  ";
        if($filtre['top_head_id']!='') $sql.= "and a.top_head_id = ".$filtre['top_head_id']." ";
        $sql .= " order by a.rank ASC";
        return $this->db->select($sql);
    }
    public function videolar($id) {
        $sql = "SELECT * FROM ".PREFIX."headlines_video WHERE id= :id order by rank ASC";
        return $this->db->select($sql,array(":id"=>$id));

    }
    public function tumheadlinesList() {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and bottom_status= :bottom_status";
        return $this->db->select($sql,array(":lang"=>$_SESSION["lang"],":bottom_status"=>"0"));
    }

    public function headlinesCek($id){
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and head_id= :head_id order by a.id ASC limit 1";
        return $this->db->select($sql,array("lang"=>@$_SESSION["lang"], "head_id"=>$id));
    }
    public function headlinesListesi($id){
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and top_head_id= :top_head_id order by a.id ASC";
        return $this->db->select($sql,array("top_head_id"=>0));
    }
    public function altheadlinesCek($id){
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and top_head_id= :top_head_id order by a.id ASC";
        return $this->db->select($sql,array("lang"=>@$_SESSION["lang"], "top_head_id"=>$id));
    }
    public function ilkAltMenu($tablo,$id=null) {
        $sql = "SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.".$tablo."_id WHERE b.lang = :lang and top_head_id= :top_head_id order by a.rank ASC limit 1";
        return $this->db->select($sql, array("lang"=>@$_SESSION["lang"], "top_head_id"=>$id));
    }

    public function formCek($id){
        $sql = "SELECT * FROM ".PREFIX."formlar a JOIN ".PREFIX."form_alani b ON a.id=b.form_id WHERE b.form_id = :id order by a.id ASC";
        $formcek =  $this->db->select($sql, array(':id' => $id));
        ?>
        <form action="<?php echo $formcek[0]["action"]?>" method="<?php echo $formcek[0]["method"]?>" >
            <?php foreach ($formcek as $key => $values) { ?>
                <label><?php echo $values["alan_name"];?></label>
                <?php if($values["alan_yapi"]=="textarea"){?>
                    <textarea class="<?php echo $values["alan_class"];?>" name="<?php echo $values["alan_name"];?>"><?php echo $values["alan_placeholder"];?></textarea>
                <?php }else if($values["alan_yapi"]=="selectbox"){?>
                    <?php $islev = explode(",", $values["alan_islevi"]);  ?>
                    <select name="<?php echo $values["alan_name"];?>" class="<?php echo $values["alan_class"];?>">
                        <?php foreach ($islev as $key => $valueislev) { ?>
                            <option value="<?php echo $valueislev;?>" style="text-transform: capitalize;"><?php echo $valueislev;?></option>
                        <?php }?>
                    </select>
                <?php }else if($values["alan_yapi"]=="button"){?>
                    <button type="<?php echo $values["alan_yapi"];?>" onClick="<?php echo $values["alan_onclick"];?>"><?php echo $values["alan_name"];?></button>
                <?php }else{?>
                    <input type="<?php echo $values["alan_yapi"];?>" name="<?php echo $values["alan_name"];?>" placeholder="<?php echo $values["alan_placeholder"];?>" <?php if($values["alan_zorunlu"]=="1"){echo "required";}?> class="<?php echo $values["alan_class"];?>">
                <?php }?>
            <?php }?>
            </div>
        </form>
        <?php
        //$this->formGonder($id);
    }
    public function acilmayacaklar() {
        $sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = :lang and bottom_status= :bottom_status";
        return $this->db->select($sql,array(":lang"=>$_SESSION["lang"],":bottom_status"=>"0"));
    }
    public function hangiheadlines($seflink) {
        $sql = "SELECT * FROM ".PREFIX."proje a JOIN ".PREFIX."proje_dil b ON a.id = b.proje_id WHERE b.lang = :lang and b.seflink= :seflink";
        return $this->db->select($sql,array(":lang"=>$_SESSION["lang"],":seflink"=>$seflink));
    }
    public function headlinesranksi($id) {
        $sql = "SELECT * FROM ".PREFIX."proje a JOIN ".PREFIX."proje_dil b ON a.id = b.proje_id WHERE b.lang = :lang and a.head_ids= :head_ids order by a.rank ASC";
        return $this->db->select($sql,array(":lang"=>$_SESSION["lang"],":head_ids"=>$id));
    }
    public function makalehit($id) {
        $sql = "SELECT * FROM ".PREFIX."makale WHERE id = :id";
        return $this->db->select($sql,array(":id"=>$id));
    }
    public function hitArtir($data)
    {
        $postData = array(
                'hit' => $data['hit']
                );
        $this->db->update(PREFIX."makale", $postData, "`id` = '{$data['id']}'");
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
}
