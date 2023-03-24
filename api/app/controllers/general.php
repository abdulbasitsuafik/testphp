<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class general extends Controller{
    public function __construct() {
        parent::__construct();
        Session::checkSession();
        $this->newmodel = $this->load->model("general_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        require("../admin/static/eklentiler/smtpmail/class.phpmailer.php");
        $this->email = new PHPmailer();
    }
    public function add_videos() {
        $form = $this->newform;
        $model = $this->newmodel;
        if($_POST) {
            $response = $this->videos_form_control($_POST,"add");
            echo json_encode($response);
        }
    }
    public function videos_form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        $languages = $model->active_languages();
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            if(@$form->values["status"]){
                $data["status"] = $form->values["status"];
            }else{
                $data["status"] = 1;
            }
            $nowdate_long =  strtotime("now"). substr((string)microtime(), 1, 6);
            $nowdate = strtotime("now");
            $data['file_path'] = $form->values['file_path'];
            $data['head_id'] = $form->values['b_id'];
            $data['title'] = $form->values['file_path'];
            $data['file_type'] = "video";
            $data['code'] = str_replace(".","",$nowdate_long);
            $data['rank'] = "1000";

            $table = $form->values["table"];
            if($posttype=="add"){
                $lastid = $model->add_files($data,$table);

                for ($index1 = 0; $index1 < count($languages); $index1++) {
                    $iindex1 = $index1 +1;
                    $dataAyrinti = array(
                        "title"=>@$form->values['title'],
                        "content"=>@$form->values['content'],
                        "head_id"=>@$form->values['b_id'],
                        "lang"=>$iindex1,
                        "code"=>str_replace(".","",$nowdate_long),
                    );
                    $model->add_files_detail($dataAyrinti,$table);
                }
            }
            $response["post_type"] = "edit";
            $response["get_table"] = false;
            $response["message"] = "Successful";
            $response["status"] = true;
            $response["content"] = $_POST;
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["content"] = $_POST;
        }
        return $response;
    }
    public function add_multimedia() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data["title"] = "Multimedia Ekle";
            $data["page_type"] = "add";
            $data["id"] = $form->values["id"];
            $data["files"] = @$model->get_files_list(@$data["id"]);

            ob_start();
            $this->view->render("general/modal_multimedia",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->plugins_form_control($_POST,"add");
                echo json_encode($response);
            }
        }

    }
    public function mail_design_and_send($emails=[],$subject=null,$message=array(),$design="standart"){
        $form_adi = $subject;
        $konu = $form_adi;
        ob_start();
        $data["form_name"] = $form_adi;
        $data["message"] = $message;
        $this->view->render("emails/".$design,$data);
        $mesaj = ob_get_clean();

        $mailcevap = $this->send_email($emails,$konu,$mesaj);
        return $mailcevap;
    }
    public function send_email($kime,$konu,$mesaj){
        $data["secure"] = "ssl";
        $data["host"] = "smtp.yandex.com";
        $data["port"] = "465";
        $data["username"] = "info@atlagit.tech";
        $data["pass"] = "6Cr?o81d";
        if($kime){
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            //$mail->Timeout = 20;
            $mail->SMTPDebug = 2; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
            $mail->Debugoutput = function($str, $level) {echo "";};
//            $mail->Debugoutput = "html";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = $data["secure"]; // Güvenli baglanti icin ssl normal baglanti icin tls
            $mail->Host = $data["host"]; // Mail sunucusuna ismi
            $mail->Port = $data["port"]; // Gucenli baglanti icin 465 Normal baglanti icin 587
            $mail->IsHTML(true);
            $mail->SetLanguage("tr", "phpmailer/language");
            $mail->CharSet  ="utf-8";
            $mail->Username = $data["username"]; // Mail adresimizin kullanicı adi
            $mail->Password = $data["pass"]; // Mail adresimizin sifresi
            $mail->SetFrom($data["username"],"Coupons" ); // Mail attigimizda gorulecek ismimiz
            $mail->AddAddress($kime[0]); // Maili gonderecegimiz kisi yani alici
            $sayi = count($kime);
            for($i = 1; $i<=$sayi;$i++){
                if($kime[$i]!=''){
                    $mail->AddBCC($kime[$i]);
                }
            }
            $mail->addReplyTo($kime[0], $kime[0]);
            $mail->Subject = $konu; // Konu basligi
            $mail->Body = $mesaj; // Mailin icerigi
            try {
                if(!$mail->Send()){
                    $sonuc["sonuc"] = "false";
                    $sonuc["sonucmesaj"] = 'Messsage Error';
                    $sonuc["data"] = $data;
                }else{
                    $sonuc["sonuc"]= "true";
                    $sonuc["sonucmesaj"] = 'Messsage successfully';
                    $sonuc["data"] = $data;
                }
            } catch (Exception $e) {
                $sonuc["sonuc"] = "false";
                $sonuc["sonucmesaj"] = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
                $sonuc["data"] = $data;
            }
        }else{
            $sonuc["response"] = false;
            $sonuc["message"] = 'Gönderilecek Mail Yok';
            $sonuc["data"] = $data;
        }
        return ($sonuc);
    }
    public function send_email2($kime,$konu,$mesaj){
//        $data["secure"] = "tls";
//        $data["host"] = "smtp.yandex.com";
//        $data["port"] = "587";
//        $data["username"] = "info@atlagit.tech";
//        $data["pass"] = "6Cr?o81d";
//        require("../smtptest/phpmailer/class.phpmailer.php");

        $data["secure"] = "tls";
        $data["host"] = "mail.tosbaapp.com";
        $data["port"] = "587";
        $data["username"] = "iletisim@tosbaapp.com";
        $data["pass"] = "Mz_k4i62";
        if($kime){
//            $mail = new PHPMailer(true);
            $mail = $this->email;
            $mail->SetLanguage("tr", 'PHPMailer-master/language');

            $mail->CharSet="utf-8";
            $mail->IsHTML(true);
            $mail->From = $data["username"];
            $mail->FromName = "Panel";
            $mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
            $mail->CharSet     = 'UTF-8';
            $mail->ContentType = 'text/html; charset=utf-8\r\n';
            $mail->Encoding    = '8bit';
            $mail->Host = $data["host"];
            $mail->Mailer   = "smtp";
            $mail->Password = $data["pass"];
            $mail->Username = $data["username"];
            $mail->SMTPSecure = 'false';
            $mail->SMTPAuth  =  "true";

            $mail->AddAddress($kime[0]); // Maili gonderecegimiz kisi yani alici
            $sayi = count($kime);
            for(@$i = @1; @$i<=@$sayi;@$i++){
                if(@$kime[$i]!=''){
                    $mail->AddBCC(@$kime[$i]);
                }
            }
            $mail->addReplyTo($kime[0], $kime[0]);
//            $mail->Subject = $konu; // Konu basligi
            $mail->Body = $mesaj; // Mailin icerigi

            $content = mb_convert_encoding($konu, 'UTF-8');

            $mail->Subject = json_encode($konu);


            try {
                if(!$mail->Send()){
                    $sonuc["response"] = false;
                    $sonuc["message"] = 'Mesaj Gönderilemedi';
                    $sonuc["data"] = $data;
                }else{
                    $sonuc["response"]= true;
                    $sonuc["message"] = 'Mesaj Gönderildi';
                    $sonuc["data"] = $data;
                }
                $mail->SmtpClose();
                $mail->ClearAddresses();
                $mail->ClearAttachments();
            } catch (Exception $e) {
                $sonuc["response"] = false;
                $sonuc["message"] = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
                $sonuc["data"] = $data;
            }


//            $mail->IsSMTP();
//            //$mail->Timeout = 20;
//            $mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
////            $mail->Debugoutput = function($str, $level) {echo "";};
//            //$mail->Debugoutput = "html";
//            $mail->SMTPAuth = true;
//            $mail->SMTPSecure = $data["secure"]; // Güvenli baglanti icin ssl normal baglanti icin tls
//            $mail->Host = $data["host"]; // Mail sunucusuna ismi
//            $mail->Port = $data["port"]; // Gucenli baglanti icin 465 Normal baglanti icin 587
//            $mail->IsHTML(true);
//            $mail->SetLanguage("tr", "phpmailer/language");
//            $mail->CharSet  ="utf-8";
//            $mail->Username = $data["username"]; // Mail adresimizin kullanicı adi
//            $mail->Password = $data["pass"]; // Mail adresimizin sifresi
//            $mail->SetFrom($data["username"],"Panel" ); // Mail attigimizda gorulecek ismimiz
//            $mail->AddAddress($kime[0]); // Maili gonderecegimiz kisi yani alici
//            $sayi = count($kime);
//            for(@$i = @1; @$i<=@$sayi;@$i++){
//                if(@$kime[$i]!=''){
//                    $mail->AddBCC(@$kime[$i]);
//                }
//            }
//            $mail->addReplyTo($kime[0], $kime[0]);
//            $mail->Subject = $konu; // Konu basligi
//            $mail->Body = $mesaj; // Mailin icerigi
//            try {
//                if(!$mail->Send()){
//                    $sonuc["response"] = false;
//                    $sonuc["message"] = 'MEsaj Gönderilemedi';
//                    $sonuc["data"] = $data;
//                }else{
//                    $sonuc["response"]= true;
//                    $sonuc["message"] = 'Mesaj Gönderildi';
//                    $sonuc["data"] = $data;
//                }
//            } catch (Exception $e) {
//                $sonuc["response"] = false;
//                $sonuc["message"] = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
//                $sonuc["data"] = $data;
//            }
        }else{
            $sonuc["response"] = false;
            $sonuc["message"] = 'Gönderilecek Mail Yok';
            $sonuc["data"] = $data;
        }
        return ($sonuc);
    }
    public function upload_files(){
        $form = $this->newform;
        $model = $this->newmodel;
        $image = $this->load->otherClasses("Resim");
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $table = @$form->values["table"];
            if (is_dir(USTDIZIN."uploads")) {
            } else {
                mkdir(USTDIZIN."uploads");
            }
            if (is_dir(USTDIZIN."uploads/" . @$form->values["table"])) {
            } else {
                mkdir( USTDIZIN."uploads/" . @$form->values["table"]);
            }
            $id = @$form->values["id"];
            $file_title = @$form->values["file_title"];
            $output_dir = "uploads/" . @$form->values["table"] . "/";
            $error = @$_FILES["myfile"]["error"];
            if (!is_array(@$_FILES["myfile"]['name'])) //single file
            {
                $nowdate = strtotime("now") . substr((string)microtime(), 1, 6);
                $fileName = @$_FILES["myfile"]["name"];
                $type = @$_FILES["myfile"]["type"];
                if($type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                    $uzanti="docx";
                }else if($type=="application/msword"){
                    $uzanti="doc";
                }else{
                    $uzanti=str_replace(["image/","application/"],"",$type);
                }
                $uzanti = strtolower(".".$uzanti);
                if ($uzanti){
                    $yeni_ad=$output_dir.$form->seo($fileName).$nowdate.$uzanti;
                    // resim boyutlandırma
                    $uzanti_replace = str_replace(".","",$uzanti);
                    $uzantilar = ["jpg","jpeg","png","gif"];
                    if (in_array($uzanti_replace,$uzantilar)){
                        @$image->load(@$_FILES["myfile"]["tmp_name"]);
                        $resimsekli = @$image->get_orientation();
                        if ($resimsekli == "landscape") {
                            $image->fit_to_width(900);
                        } else if ($resimsekli == "portrait") {
                            $image->fit_to_height(600);
                        }
                        $image->save(USTDIZIN.$yeni_ad);
                    }else{
                        @copy(@$_FILES["myfile"]["tmp_name"],USTDIZIN.$yeni_ad);
                    }

                    $data['file_path'] = $yeni_ad;
                    $data['head_id'] = $id;
                    $data['code'] = str_replace(".","",$nowdate);
                    $data['title'] = $nowdate.$uzanti;
                    $data['file_type'] = str_replace(".","",$uzanti);
                    if(@$form->values["status"]){
                        $data["status"] = @$form->values["status"];
                    }else{
                        $data["status"] = 1;
                    }
                    $data['rank'] = "1000";

                    $languages = $model->active_languages();
                    $result = $model->add_files($data,$table);

                    for ($index1 = 0; $index1 < count($languages); $index1++) {
                        $iindex1 = $index1 +1;
                        $dataAyrinti = array(
                            "title"=>"",
                            "content"=>"",
                            "head_id"=>$id,
                            "lang"=>$iindex1,
                            "code"=>str_replace(".","",$nowdate),
                        );
                        $model->add_files_detail($dataAyrinti,$table);
                    }


                    $response["status"] = true;
                    $response["message"] = "Registration Successful";
                    $response["uzanti"] = $uzanti;
                    $response["content"] = $type;
                    $response["get_table"] = false;
                    echo json_encode($response);
                }else{
                    $response["status"] = false;
                    $response["message"] = "Error";
                    $response["content"] = $_POST;
                    $response["get_table"] = false;
                    echo json_encode($response);
                }

            }
        }
    }
    public function delete_files(){
        if($_POST){
            $id = $_POST["id"];
            $table = $_POST["table"];
            $file_path = $_POST["file_path"];
            if (is_file(USTDIZIN.$file_path))
            {
                unlink(USTDIZIN.$file_path);
            }
            $model = $this->newmodel;
            $model->delete_files($id,$table);
            $response["status"] = true;
            $response["message"] = "Mission Complete";
            echo json_encode($response);
        }
    }
    public function files_rank(){
        if($_POST){
            $model = $this->newmodel;
            $id = @$_POST["id"];
            $rank = @$_POST["rank"];
            $table = @$_POST["table"];

            foreach ($rank as $key => $value) {
                if(!empty($value)){
                    $data["head_id"] = $id;
                    $data["code"] = $value;
                    $data["table"] = $table;
                    $data["rank"] = $key +1;
                    $model->files_rank($data);
                }
            }
            $response["status"] = true;
            $response["content"] = $_POST;
            $response["message"] = "Mission Complete";
            echo json_encode($response);
        }
    }
    public function all_files(){
        if($_POST){
            $id = @$_POST["id"];
            $table = @$_POST["table"];
            $grup = @$_POST["grup"];

            $data["id"] = $id;
            $data["images"] = $this->actions->sqlSorgu("SELECT * FROM ".PREFIX.$table."_files WHERE head_id = :id AND (file_type= :type OR file_type= :type2 OR file_type= :type3 OR file_type= :type4)   order by rank ASC",array(":id"=>$id,":type"=>'jpg',":type2"=>'png',":type3"=>'jpeg',":type4"=>'gif'));
            $data["files"] = $this->actions->sqlSorgu("SELECT * FROM ".PREFIX.$table."_files WHERE head_id = :id AND (file_type= :type OR file_type= :type2 OR file_type= :type3 OR file_type= :type4)   order by rank ASC",array(":id"=>$id,":type"=>'pdf',":type2"=>'doc',":type3"=>'docx',":type4"=>'csv'));
            $data["videos"] = $this->actions->sqlSorgu("SELECT * FROM ".PREFIX.$table."_files WHERE head_id = :id AND (file_type= :type) order by rank ASC",array(":id"=>$id,":type"=>"video"));
            $uzantilar = ["jpg","jpeg","png","gif"];
            $diger_uzantilar = ["pdf","doc","docx"];
            $data["table"] = $table;
            $this->view->render("general/ajax_multimedia",$data);
        }
    }
    public function modal_multimedia_detail(){
        if($_POST){
            $id = $_POST["id"];
            $table = @$_POST["table"];
            $model = $this->newmodel;
            $resim = $model->files_single($id,$table);
            $resimAyrinti = $model->files_detail_single($id,$table);
            $languages = $model->active_languages();

            $data["active_languages"] = $languages;
            $data["files_detail_single"] = $resimAyrinti;
            $data["files_single"] = @$resim[0];
            $data["table"] = @$table;
            ob_start();
            $this->view->render("general/modal_detail",$data,"1");
            $renderView = ob_get_clean();
            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }
    }
    public function files_detail_update() {
        $model = $this->newmodel;
        $form = $this->newform;
        if(@$_POST) {
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $dilsayisi = $model->active_languages();
            foreach ($dilsayisi as $index => $item) {
                $lang = "_" . $item["rank"];
                $data_lang['lang'] = $item["rank"];
                $data_lang['title'] = @$form->values['title' . $lang];
                $data_lang['content'] = @$form->values['content' . $lang];
                $data_lang['code'] = @$form->values['code' . $lang];
                $data_lang['table'] = @$form->values['table'];
                $deneme[] = $data_lang;
                $model->files_detail_update($data_lang);
            }
            $response["post_type"] = "edit";
            $response["status"] = true;
            $response["content"] = $_POST;
            $response["data"] = $deneme;
            $response["message"] = "Mission Complete";
            echo json_encode($response);
        }
    }

}
