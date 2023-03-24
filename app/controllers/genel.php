<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Genel extends Controller{
    public function __construct() {
        parent::__construct();
        $this->islemController = $this->load->controllers("islemler");
        require_once 'vendor/autoload.php';
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);
    }
    public function urlcek($rank){
        $suanki_url = $_GET['url'];
        $suanki_url = explode("/",$suanki_url);
        return $suanki_url[$rank];
    }
    public function ajaxFormGonder(){
        $model = $this->load->model("index_model");
        $form = $this->load->otherClasses("Form");
        $form->post("form_id");
        $form->post("guvenlik_kodu");
        $form->post("mecburiAlanlar");
        $form->post("mecburiAlanlarid");
        $form->post("chapta");
        $form->post("googlechapta");
        $form->post("alan_renk");
        $form->post("alan_guvenlik_renk");
        if($form->submit()){
            $form_id = $form->values['form_id'];
            $guvenlik_kodu = $form->values["guvenlik_kodu"];
            $formCek = $this->sqlSorgu("SELECT * FROM ".PREFIX."formlar a JOIN ".PREFIX."formlar_dil b ON a.id=b.form_id WHERE a.id = :id",array(":id"=>$form_id));
            $mecburiAlanlar = explode(",", $form->values["mecburiAlanlar"]);
            $mecburiAlanlarid = str_replace("inputid_","",explode(",", $form->values["mecburiAlanlarid"]));
            foreach ($mecburiAlanlar as $key => $value) {
                if($value!=""){
                    $boslanlar[] = array("id"=>$mecburiAlanlarid[$key],"adi"=>$value,"post"=>$form->values[$value]);
                }
            }
            $sonuc["mecburiAlanlar"] = $boslanlar;
            if( $boslanlar < 1){
                if($guvenlik_kodu == $_SESSION['guvenlik_kodu'] || ($form->values["chapta"] !="1" and $form->values["googlechapta"]!="") ) {
                        $mailMesaj = $this->formMailOlustur($form_id,$_POST);
                        if($mailMesaj["mailcevapları"][1]["sonuc"]=="true"){
                            $tarih = strtotime("now");
                            $veriler = array(
                                "form_id"=>$form_id,
                                "veriler"=>json_encode($mailMesaj["kayitDegerleri"]),
                                "tarih"=>$tarih
                            );
                            $model->veri_ekle("form_kayitlar",$veriler);
                            $sonuc["status"] = "true";
                            $sonuc["genelMesaj"] = $formCek[0]["form_adi"]." ".$this->islemController->dilcek()["dil_formbasarili"];
                            $sonuc["email"] = $mailMesaj["email"];
                            $sonuc["gidecek_mailler"] = $mailMesaj["gidecek_mailler"];
                            $sonuc["mailcevap"] = $mailMesaj["mailcevapları"];
                            $sonuc["content"] = $form->values;
                            $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/'.$form->values["alan_renk"].'/'.$form->values["alan_guvenlik_renk"].'" class="guvenlikResim"/>  ';
                            $sonuc["chapta"] = $form->values["chapta"];
                            $sonuc["googlechapta"] = $form->values["googlechapta"];
                        }else{
                            $sonuc["status"] = "false";
                            $sonuc["genelMesaj"] = $formCek[0]["form_adi"]." ".$this->islemController->dilcek()["dil_formbasarisiz"];
                            $sonuc["mailcevap"] = $mailMesaj["mailcevapları"];
                            $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/'.$form->values["alan_renk"].'/'.$form->values["alan_guvenlik_renk"].'" class="guvenlikResim"/>  ';
                        }
                }else{
                    $sonuc["status"] = "false";
                    $sonuc["genelMesaj"] = $this->islemController->dilcek()["dil_guvenlikkoduhatali"];
                    $sonuc["alanMesajı"] = $this->islemController->dilcek()["dil_bualanzorunlu"];
                    $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/'.$form->values["alan_renk"].'/'.$form->values["alan_guvenlik_renk"].'" class="guvenlikResim"/>  ';
                    $sonuc["content"] = $form->values;
                    $sonuc["gidecek_mailler"] = $mailMesaj["gidecek_mailler"];
                    $sonuc["guvenlik_kodu"] = $guvenlik_kodu." - ".$_SESSION['guvenlik_kodu'];
                    $sonuc["chapta"] = $form->values["chapta"];
                    $sonuc["googlechapta"] = $form->values["googlechapta"];
                }
            }else{
                $sonuc["status"] = "false";
                $sonuc["genelMesaj"] = $this->islemController->dilcek()["dil_bosalanlaridoldurunuz"];
                $sonuc["alanMesajı"] = $this->islemController->dilcek()["dil_bualanzorunlu"];
                $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/'.$form->values["alan_renk"].'/'.$form->values["alan_guvenlik_renk"].'" class="guvenlikResim"/>  ';
                $sonuc["content"] = $form->values;
                $sonuc["guvenlik_kodu"] = $guvenlik_kodu." - ".$_SESSION['guvenlik_kodu'];
                $sonuc["chapta"] = $form->values["chapta"];
                $sonuc["googlechapta"] = $form->values["googlechapta"];
            }
            //$gelen = $this->gonderisle($formid,$ayarlar,randevu);
            echo json_encode($sonuc);
        }
    }
    public function guvenlikGuncelle(){
        $renk = $this->urlcek(2);
        $guvenlikRenk = $this->urlcek(3);
        $Guvenlikkodu = $this->load->otherClasses("Guvenlikkodu");
        echo $Guvenlikkodu->guvenlikKodu("#".$renk,"#".$guvenlikRenk);
    }
    public function formMailOlustur($id,$gelenPost){
        $formCek = $this->sqlSorgu("SELECT * FROM ".PREFIX."formlar a JOIN ".PREFIX."form_alani b ON a.id=b.form_id WHERE b.form_id = :form_id order by b.alan_no ASC",array(":form_id"=>$id));
        $formlarDil = $this->sqlSorgu("SELECT * FROM ".PREFIX."formlar_dil WHERE form_id = :form_id and lang = :lang",array(":form_id"=>$id,":lang"=>$_SESSION["lang"]));
        $form_adi = $formlarDil[0]['form_adi'];
        if($_SESSION["lang_code"]=="tr" or $_SESSION["lang_code"]=="ar" or $_SESSION["lang_code"]=="ch" or $_SESSION["lang_code"]=="ru"){
            $konu = $form_adi." ".$this->islemController->dilcek()["dil_ndangelenmesaj"];
        }else{
            $konu = $this->islemController->dilcek()["dil_ndangelenmesaj"]." ".$form_adi;
        }
        $mesaj='
         <div class="mesajKap" style="width: 600px; background: #525252; color: #FFF; font-family: Arial; font-size: 13px; border-radius: 5px; overflow: hidden;">
             <div class="mesaj_headlines" style="font-weight: 600; width: 100%; height: 40px; line-height: 40px; background: #0552a2; box-sizing: border-box; padding: 0 15px;">'.$form_adi.' -  Mesajınız Var</div>
             <div class="mesaj_content" style="box-sizing: border-box; width: 100%; background: #f3f3f3; color: #2f2f2f; padding: 40px 20px;">
                 <table border="1" cellpadding="0" cellspacing="0" style="border-color:#fff;width: 90%;">';
                foreach ($gelenPost as $key => $value) {
                    $postEdilecek[] = $key;
                }
                foreach ($formCek as $key => $value) {
                    if(in_array($value["alan_name"], $postEdilecek)){
                        $alanDil = $this->sqlSorgu("SELECT * FROM ".PREFIX."form_dil WHERE form_id = :form_id and alan_no= :alan_no and lang = :lang order by alan_no ASC",array(":form_id"=>$value["form_id"],":alan_no"=>$value["alan_no"],":lang"=>$_SESSION["lang"]));
                        if ($value["alan_yapi"] == "checkbox" ) {
                            $degiskenler=$gelenPost[$value["alan_name"]];
                            $degisken_say = count($degiskenler);
                            for($i=0; $i < $degisken_say;$i++){
                                $deger .= $degiskenler[$i].",";
                            }
                            $postDegeri = trim($deger,",");
                        }else if ($value["alan_yapi"] == "label" ) {
                        }else{
                            $postDegeri = $gelenPost[$value["alan_name"]];
                        }
                        if ($value["alan_yapi"] == "file" ) {
                            $dosya_yukle = $this->dosya_yukle($name,"resimler/form_upload/",$values["alan_file_type"]);
                            if($dosya_yukle['durum']){
                                $deger = '<a href="' . SITE_URL . 'resimler/form_upload/' . $dosya_yukle['dosya_adi'] . '"  download="' . $dosya_yukle['dosya_adi'] . '">Dosyayı İndir</a>';
                            }else{
                                $deger = 'basarisiz';
                            }
                        }
                        $mesaj .= '<tr>
                                    <td width="150" style="padding: 10px;">'.$alanDil[0]["adi"].'</td>
                                    <td style="padding: 10px;">
                                        '.$postDegeri.' 
                                    </td>
                                </tr>';
                        $kayitDegerleri[] = array("headlines" => $alanDil[0]["adi"], "deger" => $postDegeri);
                        $emailVarmi = strpos($gelenPost[$value["alan_name"]], "@");
                        if($emailVarmi > 0){
                            $emailler[] = $gelenPost[$value["alan_name"]];
                        }
                    }
                }
         $mesaj.=' </table>
             </div>
             <div class="mesaj_alt" style="width: 100%; height: 30px; line-height: 31px; background: #0552a2; padding: 0 15px; box-sizing: border-box; font-size: 11px; text-align: left;">Bu mesaj '.date('d-m-Y H:i').' Tarihinde otomatik olarak gönderilmiştir. </div>
        </div>';
            $mailcevap = $this->formMailGonder($formCek[0]['gidecek_mailler'],$konu,$mesaj);
            if($formCek[0]['geri_bildirim']=="1"){
                foreach ($emailler as $key => $value) {
                   $mailcevap2=  $this->formMailGonder($value,$formlarDil[0]['bildirim_konu'],$formlarDil[0]['bildirim_mesaji']."\r\n\r\n".$mesaj."\r\n\r\n");
                }
            }
        return array("mesaj"=>$mesaj,"kayitDegerleri"=>$kayitDegerleri,"email"=>$emailler,"gidecek_mailler"=>$formCek[0]['gidecek_mailler'],"mesaj"=>$mesaj,"mailcevapları"=>array("1"=>$mailcevap,"2"=>$mailcevap));
    }
    public function formMailGonder($kime,$konu,$mesaj){
        $sitebilgi = $this->sqlSorgu("SELECT * FROM ".PREFIX."site_ayarlari WHERE id = :id order by id ASC limit 1",array(":id"=>"1"));
        $path = "public/eklentiler/";
        if($kime){
            $sitegelenmail = explode(",", $kime);
        }else{
            $sitegelenmail = explode(",", $sitebilgi[0]["formmail_mail"]);
        }

        if(strpos($_SERVER["SERVER_NAME"], "localhost")){
            $data["secure"] = "ssl";
            $data["host"] = "smtp.yandex.com";
            $data["port"] = "465";
            $data["username"] = "tolga@tolga.com.tr";
            $data["pass"] = "tolga1245";
        }else{
            $data["secure"] = $sitebilgi[0]['formmail_secure'];
            $data["host"] = $sitebilgi[0]['formmail_host'];
            $data["port"] = $sitebilgi[0]['formmail_port'];
            $data["username"] = $sitebilgi[0]['formmail_mail'];
            $data["pass"] = $sitebilgi[0]['formmail_sifre'];
        }
        if($sitegelenmail){
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            //$mail->Timeout = 20;
            $mail->SMTPDebug = 2; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
            $mail->Debugoutput = function($str, $level) {echo "";};
            //$mail->Debugoutput = "html";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = $data[secure]; // Güvenli baglanti icin ssl normal baglanti icin tls
            $mail->Host = $data["host"]; // Mail sunucusuna ismi
            $mail->Port = $data["port"]; // Gucenli baglanti icin 465 Normal baglanti icin 587
            $mail->IsHTML(true);
            $mail->SetLanguage("tr", "phpmailer/language");
            $mail->CharSet  ="utf-8";
            $mail->Username = $data["username"]; // Mail adresimizin kullanicı adi
            $mail->Password = $data["pass"]; // Mail adresimizin sifresi
            $mail->SetFrom($data["username"],$sitebilgi[0]['unvani'] ); // Mail attigimizda gorulecek ismimiz
            $mail->AddAddress($sitegelenmail['0']); // Maili gonderecegimiz kisi yani alici
            $sayi = count($sitegelenmail);
            for($i = 1; $i<=$sayi;$i++){
                if($sitegelenmail[$i]!=''){
                    $mail->AddBCC($sitegelenmail[$i]);
                }
            }
            $mail->addReplyTo($sitegelenmail['0'], $sitegelenmail['0']);
            $mail->Subject = $konu; // Konu basligi
            $mail->Body = $mesaj; // Mailin icerigi
            try {
                if(!$mail->Send()){
                    $sonuc["sonuc"] = "false";
                    $sonuc["sonucmesaj"] = 'MEsaj Gönderilemedi';
                    $sonuc["data"] = $data;
                }else{
                    $sonuc["sonuc"]= "true";
                    $sonuc["sonucmesaj"] = 'Mesaj Gönderildi';
                    $sonuc["data"] = $data;
                }
            } catch (Exception $e) {
                $sonuc["sonuc"] = "false";
                $sonuc["sonucmesaj"] = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
                $sonuc["data"] = $data;
            }
        }else{
            $sonuc["sonuc"] = "false";
            $sonuc["sonucmesaj"] = 'Gönderilecek Mail Yok';
            $sonuc["data"] = $data;
        }
        return $sonuc;
    }
    public function dosya_yukle($name,$folder = 'resimler/',$izinli_uzantilar = ""){
        $path = "public/eklentiler/upload/";
        $s=0;
        if($_FILES[$name]['name']!= '')
        {
            include_once($path.'class.upload.php');
            $resimler = array();
            foreach($_FILES[$name] as $k => $l)
            {
                foreach($l as $i => $v)
                {
                    if(!array_key_exists($i, $resimler)) $resimler[$i] = array();
                    $resimler[$i][$k] = $v;
                }
            }
            foreach($resimler as $resim)
            {
                $yukleyici = new upload($resim);
                if($yukleyici->uploaded)
                {
                    $yukleyici->file_new_name_body = substr(base64_encode(uniqid(true)),0,20);
                    $yukleyici->image_resize = true;
                    $yukleyici->file_max_size = '5242880' * 2; // 10mb
                    $allowed = "";
                    $izinli_uzantilar = explode(",",$izinli_uzantilar);
                    if(in_array("jpg",$izinli_uzantilar) || in_array("JPG",$izinli_uzantilar) || in_array("png",$izinli_uzantilar) || in_array("jpeg",$izinli_uzantilar) ){
                        $allowed = 'image/*,';
                    }
                    if(in_array("pdf",$izinli_uzantilar) || in_array("xls",$izinli_uzantilar) || in_array("doc",$izinli_uzantilar) || in_array("rar",$izinli_uzantilar) ){
                        $allowed .= 'application/pdf,application/msword';
                    }
                    $allowed = trim($allowed,",");
                    if($allowed!=''){
                        $allowed = explode(",",$allowed);
                        $yukleyici->allowed = $allowed;
                    }
;
                    $yukleyici->process($folder);
                    if($yukleyici->processed)
                    {
                        $dosya_adi = $yukleyici->file_dst_name;
                        return array("durum"=>true,"dosya_adi"=>$dosya_adi);
                    }else{
                        return array("durum"=>false,"dosya_adi"=>"");
                    }

                    $yukleyici->Clean();
                }
                $s++;
            }
        }
    }
    public function get_video(){
    	$id = $_POST["id"];
        $model = $this->load->model("index_model");

        $videolar = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines_files a JOIN ".PREFIX."headlines_files_detail b ON a.id=b.head_id WHERE a.id = :id AND (a.file_type= :type )   order by a.rank ASC",[":id"=>$id,":type"=>'mp4']);

        $data["title"] = $videolar[0]["title"];
        $data["url"] = SITE_URL.$videolar[0]["file_path"];

        ob_start();
        $this->view->render("other/get_video",$data,"1");
        $renderView = ob_get_clean();

        $newData["renderView"] = $renderView;

        echo json_encode($newData);
    }
    public function videoModal(){
    	$id = $_POST["id"];
    	$model = $this->load->model("index_model");
    	$videolar = $model->videolar($id);

    	?>
    	<div id="videoModal-<?php echo $id;?>" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center"><?php echo $videolar[0]["title"];?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo $videolar[0]["video_link"];?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    public function modalKadro(){
        $id = $_POST["id"];
        $elemalar = $this->sqlSorgu("SELECT * FROM ".PREFIX."kadro_kisi a JOIN ".PREFIX."kadro_kisi_dil b ON a.id=b.kisi_id WHERE b.kisi_id = :kisi_id and b.lang= :lang order by a.rank ASC ",array(":kisi_id"=>$id,":lang"=>$_SESSION["lang"]));
        ?>
            <div class="modal fade" id="modalKadro-<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"><span style="font-weight: 700;"><?php echo $elemalar[0]["kisi_adi"];?></span></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="col-md-4 col-sm-4 col-xs-4">
                              <img class="img-responsive" src="<?php echo $this->islemController->resimcek($elemalar[0]["presmi"],370,370,1);?>"/>
                      </div>
                      <div class="col-md-8 col-sm-4 col-xs-4">
                          <?php echo $elemalar[0]["kisi_not"];?>
                      </div>
                    </div>

                  </div>
                </div>
            </div>
        <?php
    }
    public function etkinlikModal(){
        $id = $_POST["id"];
        $etkinlik_liste = $this->sqlSorgu('SELECT * FROM '.PREFIX.'etkinlik a JOIN '.PREFIX.'etkinlik_dil b ON a.id=b.etkinlik_id WHERE b.lang= :lang order by a.id ASC',array(":lang"=>$_SESSION["lang"]));
        ?>
        <div id="etkinlikModal-<?php echo $id;?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center"><?php echo $etkinlik_liste[0]["title"]?></h4>
                </div>
                <div class="modal-body">
                <?php echo $etkinlik_liste[0]["content"]?>
                </div>
            </div>
        </div>
    </div><?php
    }
    public function jsoncek(){
        $separator = "";
        $days = 16;
        $etkinlik_liste = $this->sqlSorgu('SELECT * FROM '.PREFIX.'etkinlik a JOIN '.PREFIX.'etkinlik_dil b ON a.id=b.etkinlik_id WHERE b.lang= :lang order by a.id ASC',array(":lang"=>$_SESSION["lang"]));
        //print_r($etkinlik_liste);
             foreach( $etkinlik_liste as $yaz ){
                $giris = $yaz["baslangic"];
                $cikis = $yaz["bitis"];
                $toplam = $cikis - $giris;
                $toplamgun = date("d",$toplam);
                    for ($index = 0; $index < $toplamgun; $index++) {
                            $girisstamp = $giris * 1000;
                            if($index == 0){
                                $data[] = array(
                                    "date"=>$girisstamp,
                                    "type"=> "meeting",
                                    "title"=> $yaz["title"]." | ".$toplamgun,
                                    "description"=> "Giriş Çıkış Tarihi: ".date("d-m-Y", $yaz["baslangic"])." | ".date("d-m-Y", $yaz["bitis"]),
                                    "url"=> 'etkinlikModal(' . $yaz["id"]. ')',
                                    "onclick"=> 'etkinlikModal(' . $yaz["id"]. ')'
                                );
                            }else{
                                $eklenecek = ($index) * 86400 * 1000;
                                $data[] = array(
                                    "date"=>$girisstamp + $eklenecek,
                                    "type"=> "meeting",
                                    "title"=> $yaz["title"]." | ".$toplamgun,
                                    "description"=> "Giriş Çıkış Tarihi: ".date("d-m-Y", $yaz["baslangic"])." | ".date("d-m-Y", $yaz["bitis"]),
                                    "url"=> 'etkinlikModal(' . $yaz["id"]. ')',
                                    "onclick"=> 'etkinlikModal(' . $yaz["id"]. ')'
                                );
                            }
                    }
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function ebulten_formgonder($data){
        $model = $this->load->model("index_model");
        $gelen_email = $_POST['email'];
        if($gelen_email){
            $gelen_ip    =  $_SERVER["REMOTE_ADDR"];
            $tarih       = time();
            $mail_varmi     = count($this->sqlSorgu("SELECT * from ".PREFIX."ebulten where email= :email ",array(":email"=>$gelen_email)));
            $ip_varmi       = count($this->sqlSorgu("SELECT * from ".PREFIX."ebulten where ip = :id",array(":id"=>$gelen_ip)));
            if($mail_varmi==0 && $ip_varmi==0){
                $veriler = array(
                    "email"=>"$gelen_email",
                    "tarih"=>"$tarih",
                    "ip"=>"$gelen_ip",
                );
                $kayit_ekle = $model->veri_ekle("ebulten",$veriler);
                $sonuc["mesaj"] = "Kayıt Başarılı";
            }else if($mail_varmi>0){
                $sonuc["mesaj"] = "İşlem başarısız. Sistemde böyle bir mail adresi zaten kayıtlıdır.";
            }else if($ip_varmi>0){
                $sonuc["mesaj"] = "İşlem başarısız. Sisteme aynı ip üzerinden girişte bulunulmuştur.";
            }
        }else{
            $sonuc["mesaj"] = "Email adresinizi giriniz..";
        }

        /*
            <script type="text/javascript">
                function ebultengonder(){
                    var email = $(".ebultenemail").val();
                    $.ajax({
                        url : "{{SITE_URL}}genel/ebulten_formgonder",
                        type: "POST",
                        data : {email:email},
                        success: function(data, textStatus, jqXHR)
                        {
                            jsonData = JSON.parse(data);
                            $(".gelenmesaj").css("display","block");
                            $(".gelenmesaj").html(jsonData["mesaj"]);
                        }
                    });
                }
            </script>
        */
        echo json_encode($sonuc);
    }
    public function oncekisonrakimakale(){
        $model = $this->load->model("index_model");
        $seflink = $_POST["seflink"];

        $active_headlines = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id = b.makale_id WHERE b.lang = :lang and b.seflink= :seflink",array(":lang"=>$_SESSION["lang"],":seflink"=>$seflink));
        $headlines = $active_headlines[0]["makale_id"];
        $basligaAit = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id = b.makale_id WHERE b.lang = :lang order by b.makale_id ASC",array(":lang"=>$_SESSION["lang"]));

        $rankmiz = $this->find_array_in_array($active_headlines, $basligaAit);
        $rank = $rankmiz[0][0];
        $detaySayisi = count($basligaAit);
        $geri = $rank -1;
        $ileri = $rank +1;
        if($geri > -1){
            $geriAyrintiLink = $basligaAit[$geri]["seflink"];
            $geriAyrinti = $basligaAit[$geri];
            $geriAyrintiid = $basligaAit[$geri]["makale_id"];
        }else{
            $geriAyrintiLink = $active_headlines[0]["seflink"];
            $geriAyrinti = $active_headlines[0];
            $geriAyrintiid = $active_headlines[0]["makale_id"];
        }
        if($ileri < $detaySayisi){
            $ileriAyrintiLink = $basligaAit[$ileri]["seflink"];
            $ileriAyrinti = $basligaAit[$ileri];
            $ileriAyrintiid = $basligaAit[$ileri]["makale_id"];
        }else{
            $ileriAyrintiLink = $active_headlines[0]["seflink"];
            $ileriAyrinti = $active_headlines[0];
            $ileriAyrintiid = $active_headlines[0]["makale_id"];
        }
        ?>
            <nav aria-label="...">
              <ul class="pager">
                <li class="previous">
                    <a href="<?php echo SITE_URL;?><?php echo $geriAyrintiLink;?>"><span aria-hidden="true">&larr;</span> <?php echo $geriAyrinti["title"]?></a>
                </li>
                <li class="next">
                    <a href="<?php echo SITE_URL;?><?php echo $ileriAyrintiLink;?>"><?php echo $ileriAyrinti["title"]?> <span aria-hidden="true">&rarr;</span></a>
                </li>
              </ul>
            </nav>
            <?php if("sikintili"=="1"){?>

                <?php if($geriAyrintiid==$active_headlines[0]["makale_id"]){?>
                    <a class="btn btn-sm btn-default">İlk</a>
                <?php }else{?>
                     <a href="<?php echo SITE_URL;?><?php echo $geriAyrintiLink;?>" class="btn btn-sm btn-prev btn-default"><i class="fa fa-arrow-left"></i> <?php echo $geriAyrinti["title"]?></a>
                <?php }?>
                <?php if($ileriAyrintiid==$active_headlines[0]["makale_id"]){?>
                    <a class="btn btn-default">Son</a>
                <?php }else{?>
                    <a href="<?php echo SITE_URL;?><?php echo $ileriAyrintiLink;?>" class="btn btn-sm btn-next btn-default" style="float: right;"><?php echo $ileriAyrinti["title"]?> <i class="fa fa-arrow-right"></i></a>
                <?php }?>
            <?php }?>
        <?php
    }
    public function sonrakiSayfa(){
        $model = $this->load->model("index_model");
        $seflink = $_POST["seflink"];
        $yon = $_POST["yon"];

        $active_headlines = $model->hangiheadlines($seflink);
        $headlines = $active_headlines[0]["proje_id"];
        $basligaAit = $model->headlinesranksi(",9,");

        $rankmiz = $this->find_array_in_array($active_headlines, $basligaAit);
        $rank = $rankmiz[0][0];
        $detaySayisi = count($basligaAit);
        $geri = $rank -1;
        $ileri = $rank +1;
        if($geri > -1){
            $geriAyrinti = $basligaAit[$geri]["seflink"];
            $geriAyrintiid = $basligaAit[$geri]["proje_id"];
        }else{
            $geriAyrinti = $active_headlines[0]["seflink"];
            $geriAyrintiid = $active_headlines[0]["proje_id"];
        }
        if($ileri < $detaySayisi){
            $ileriAyrinti = $basligaAit[$ileri]["seflink"];
            $ileriAyrintiid = $basligaAit[$ileri]["proje_id"];
        }else{
            $ileriAyrinti = $active_headlines[0]["seflink"];
            $ileriAyrintiid = $active_headlines[0]["proje_id"];
        }
        ?>
            <?php if($geriAyrintiid==$active_headlines[0]["proje_id"]){?>
                <a class="btn btn-sm btn-default">İlk</a>
            <?php }else{?>
                 <a href="<?php echo SITE_URL;?><?php echo $geriAyrinti;?>" class="btn btn-sm btn-prev btn-default">Geri</a>
            <?php }?>
            <?php if($ileriAyrintiid==$active_headlines[0]["proje_id"]){?>
                <a class="btn btn-default">Son</a>
            <?php }else{?>
                <a href="<?php echo SITE_URL;?><?php echo $ileriAyrinti;?>" class="btn btn-sm btn-next btn-default">İleri</a>
            <?php }?>
        <?php
    }
    public function find_array_in_array($tekArray, $tumArray) {
        //$rankmiz = $this->find_array_in_array($tekArray, $tumArray);
        $keys = array_keys($tumArray, $tekArray[0]);
        $out = array();
        foreach ($keys as $key) {
            $add = true;
            $result = array();
            foreach ($tekArray as $i => $value) {
                if (!(isset($tumArray[$key + $i]) && $tumArray[$key + $i] == $value)) {
                    $add = false;
                    break;
                }
                $result[] = $key + $i;
            }
            if ($add == true) {
                $out[] = $result;
            }
        }
        return $out;
    }
    public function haberdevami(){
        $click = $_POST["click"];
        if($click > 1){
            $sonraki = $click * 15;
            $onceki = $sonraki - 15;
        }else{
            $sonraki = 15;
            $onceki = 15;
        }
        $sorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id=b.makale_id WHERE b.lang= :lang and a.status= :status order by a.pubDate DESC limit ".$onceki.",".$sonraki,array(":lang"=>$_SESSION["lang"],":status"=>1));
        ob_start();
        foreach ($sorgu as $key => $value) {
        ?>
            <div class="media">
                <div class="media-left">
                    <img src="<?php echo $this->islemController->resimcek($value["manset_resmi"],200,155,1);?>" alt="<?php echo $value["title"];?>" class="media-object"/>
                </div>
                <div class="media-body">
                    <h2 class="media-heading"><?php echo $value["title"];?></h2>
                    <p><?php echo $this->islemController->kisalt($value["description"],"250");?></p>

                    <div class="buttonlar">
                        <a class="teklif hidden" href="#"><i class="icon-pencil"></i> Teklif Ver</a>
                        <a class="content" href="<?php echo SITE_URL.$value["seflink"];?>"><i class="licon-arrow-right"></i> Detaylar</a>
                    </div>
                </div>
            </div>
            <hr>
        <?php
        }
        $sorguToplami = ob_get_clean();
        $sonuc["content"] = $sorguToplami;
        $sonuc["onceki"] = $onceki;
        $sonuc["sonraki"] = $sonraki;
        $sonuc["click"] = $click;
        if($sorguToplami==""){
            $sonuc["status"] = "false";
        }
        echo json_encode($sonuc);
    }
    public function yorumEkle(){
        $veriler = $_POST;
        $model = $this->load->model("index_model");

        $nowdate =  strtotime("now"). substr((string)microtime(), 1, 6);
        if($_POST["adi"]!="" and $_POST["email"]!="" and $_POST["guvenlik_kodu"]!=""){
            if($_POST["guvenlik_kodu"] == $_SESSION['guvenlik_kodu']){
                $veriler = array(
                    "adi"=>$_POST["adi"],
                    "email"=>$_POST["email"],
                    "yorum"=>$_POST["yorum"]
                    );
                $model->veri_ekle("yorumlar",$veriler);

                $sonuc["status"]="true";
                $sonuc["mesaj"]=$this->islemController->dilcek()["dil_yorumbasarili"];
                $sonuc["content"] = $veriler;
                $sonuc["kod"] = $_SESSION['random_number'];
                $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/000000/000000" class="guvenlikResim"/>  ';
            }else{
                $sonuc["status"]="false";
                $sonuc["mesaj"]=$this->islemController->dilcek()["dil_guvenlikkoduhatali"];
                $sonuc["content"] = $_POST;
                $sonuc["kod"] = $_SESSION['guvenlik_kodu'];
                $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/000000/000000" class="guvenlikResim"/>  ';
            }

        }else{
            $sonuc["status"]="false";
            $sonuc["mesaj"]=$this->islemController->dilcek()["dil_bosalanlaridoldurunuz"];
        }
        echo json_encode($sonuc);
    }
    public function yorum_ekle_makale(){
         $model = $this->load->model("index_model");
         $form = $this->load->otherClasses("Form");
         $form->post("makale_id");
         $form->post("adi");
         $form->post("yorum");
         $form->post("guvenlik_kodu");
         $form->post("alan_renk");
         $form->post("alan_guvenlik_renk");

         if($form->submit()){
            if($form->values["makale_id"]!="" and $form->values["adi"]!="" and $form->values["yorum"]!=""){
                if($_POST["guvenlik_kodu"] == $_SESSION['guvenlik_kodu']){
                    $veriler = array(
                        "makale_id"=>$form->values["makale_id"],
                        "adi"=>$form->values["adi"],
                        "yorum"=>$form->values["yorum"],
                        "tarih"=>strtotime("now"),
                        "durum"=>"0",
                        "okundu"=>"0"
                     );
                     $model->veri_ekle("yorumlar",$veriler);
                     $sonuc["status"] = "true";
                     $sonuc["mesaj"] = $this->islemController->dilcek()["dil_yorumbasarili"];
                 }else{
                     $sonuc["status"] = "false";
                     $sonuc["mesaj"] = $this->islemController->dilcek()["dil_guvenlikkoduhatali"];
                     $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/'.$form->values["alan_renk"].'/'.$form->values["alan_guvenlik_renk"].'" class="guvenlikResim"/>  ';
                 }
            }else{
                 $sonuc["status"] = "false";
                 $sonuc["mesaj"] = $this->islemController->dilcek()["dil_bosalanlaridoldurunuz"];
                 $sonuc["yeniResim"] = '<img src="'.SITE_URL.'genel/guvenlikGuncelle/'.$form->values["alan_renk"].'/'.$form->values["alan_guvenlik_renk"].'" class="guvenlikResim"/>  ';
            }
            echo json_encode($sonuc);
         }

    }
    public function dovizcek(){
        $url = "http://www.tcmb.gov.tr/kurlar/today.xml";
        $xml=simplexml_load_file($url);
        $json = json_decode(json_encode($xml),true);
        $data["dolar"] = $json["Currency"][0];
        $data["euro"] = $json["Currency"][3];
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    public function ligcek(){
        $url = "http://tff.org/default.aspx?pageID=142";
        $Baglan = $this->Baglan($url);
        preg_match_all('@<div id="ctl00_MPane_m_142_6657_ctnr_m_142_6657_Panel1">(.*?)</div>@si', $Baglan, $lig);

        print_r($lig[0][0]);
    }
    public function havadurumucek(){
        $url = "https://www.mgm.gov.tr/FTPDATA/analiz/sonSOA.xml";
        $xml=simplexml_load_file($url);
        $json = json_decode(json_encode($xml),true);
        print_r($json["sehirler"][21]);
    }
    public function sayfa_bulunamadi(){
        print_r("sayfa_bulunamadi");
        $this->view->render("other/error");
    }
}
