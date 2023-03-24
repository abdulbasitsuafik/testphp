<?php
class Admin_users extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("admin_users_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
    }

    public function index() {
        $form = $this->newform;
        $model = $this->newmodel;
            $data["title"] = "Users List";
            $data["dashboard"] = false;
            $this->view->render("admin_users/index", $data);
    }
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $emailVarmi = $model->email_control($form->values['email']);
            if ($form->values['authority'] == 0){
                $authority_name = "Editor";
            }else if($form->values['authority'] == 1){
                $authority_name = "Super User";
            }else if($form->values['authority'] == 2){
                $authority_name = "Admin";
            }else{
                $authority_name = "";
            }

            $data = array(
                "name" => $form->values['name'],
                "username" => $form->values['username'],
                "phone" => $form->values['phone'],
                "authority" => $form->values['authority'],
                "authority_name" => $authority_name,
            );

            if (@$form->values["status"]) {
                $data["status"] = $form->values["status"];
            } else {
                $data["status"] = 1;
            }
            if(@$_FILES){
                if (is_dir("upload")) {
                } else {
                    mkdir("upload");
                }
                if (is_dir("upload/users" )) {
                } else {
                    mkdir( "upload/users");
                }
                $output_dir = "upload/admin_users/";

                $fileName = @$_FILES["image"]["name"];
                $nowdate = strtotime("now") . substr((string)microtime(), 1, 6);
                $uzanti = explode(".",$fileName);
                $uzanti = strtolower(".".end($uzanti));
                if ($uzanti) {
                    $yeni_ad = $output_dir . $nowdate . $uzanti;
                    @copy(@$_FILES["image"]["tmp_name"],$yeni_ad);
                    $data["image"] = $yeni_ad;
                    $data["image"] = $yeni_ad;
                }

            }

            if ($posttype == "edit") {
                $data["id"] = @$form->values["b_id"];
                if($form->values['password']){
                    if ($form->values['password'] == $form->values['password_repeat']) {
                        $data["password"] = md5($form->values['password']);
                        $model->edit($data);
                        $response["status"] = true;
                        $response["message"] = "Registration Successful";
                        $response["content"] = $_POST;
                        $response["files"] = $_FILES;
                        $response["get_table"] = true;
                        $response["post_type"] = "edit";
                    }else{
                        $response["status"] = false;
                        $response["content"] = $_POST;
                        $response["message"] = "Şifreler Eşleşmiyor";
                    }
                }else{
                    $data["email"] = $form->values['email'];
                    $model->edit($data);
                    $response["status"] = true;
                    $response["message"] = "Registration Successful";
                    $response["content"] = $_POST;
                    $response["files"] = $_FILES;
                    $response["get_table"] = true;
                    $response["post_type"] = "edit";
                }
            } else {
                if(@count($emailVarmi) > 0) {
                    $response["status"] = false;
                    $response["message"] = "Try another email address!";
                }else{
                    if ($form->values['password'] == $form->values['password_repeat']) {
                        $data["password"] = md5($form->values['password']);
                        $data["email"] = $form->values['email'];
                        $model->add($data);
                        $response["status"] = true;
                        $response["message"] = "Registration Successful";
                        $response["content"] = $_POST;
                        $response["files"] = $_FILES;
                        $response["get_table"] = true;
                        $response["refresh"] = true;
                        $response["post_type"] = "add";
                    } else {
                        $response["status"] = false;
                        $response["content"] = $_POST;
                        $response["message"] = "Şifreler Eşleşmiyor";
                    }
                }
            }

        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["content"] = $_POST;
        }
        return @$response;
    }
    public function add() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data = [];
            ob_start();
            $this->view->render("admin_users/modal",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->form_control($_POST,"add");
                echo json_encode($response);
            }
        }

    }
    public function edit() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }

            $data["id"] = $form->values["id"];
            $data["data"] = $model->get_single($data["id"])[0];
            ob_start();
            $this->view->render("admin_users/modal",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->form_control($_POST,"edit");
                echo json_encode($response);
            }
        }

    }
    public function change_status(){
        $form = $this->newform;
        $model = $this->newmodel;
        if ($_POST){
            $id = $_POST["id"];

            $get_single = $model->get_single($id);
            $status = $model->change_status($id,$get_single[0]["status"]);
            $response["status"] = $status;
            echo json_encode($response);
        }
    }
    public function delete($id=null)
    {
        $form = $this->newform;
        $model = $this->newmodel;
        if($_POST){
            $id = $_POST["id"];
            $model->delete($id);
            $response["status"] = true;
            $response["message"] = "Silme işlemi başarılı";
            $response["refresh"] = true;
            echo json_encode($response);
        }
    }
    public function get_table(){
        ob_start();
        $model = $this->newmodel;
        $sorgu = $model->get_list();
        foreach ($sorgu as $key => $value){
            ?>
            <tr id="tableline-<?php echo $value["id"];?>">
                <td><?php echo $value['name']?></td>
                <td><?php echo $value['username']?></td>
                <td><?php echo $value['email']?></td>
                <td><?php echo $value['authority_name']?></td>
                <td><?php echo date("d-m-Y H:i",$value['created_at']);?></td>
                <td>
                    <?php echo $this->islemler($value);?>
                </td>
            </tr>
        <?php }
        $renderView = ob_get_clean();
        $reponse["renderView"] = $renderView;
        echo json_encode($reponse);
    }
    public function islemler($value){
        ob_start();
        ?>
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-<?php echo $value["id"];?>">Actions <span class="caret"></span> </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" onclick="modalGetir('<?php echo CONTROLLER;?>/edit','<?php echo $value["id"];?>')" class="dropdown-item"><span class="fa fa-edit"> </span> Edit</a></li>
                <li>
                    <a href="javascript:void(0)" onclick="item_delete('<?php echo CONTROLLER;?>/delete','<?php echo $value["id"];?>')" class="dropdown-item"> <span class="fa fa-trash"> </span> Delete</a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="change_status('<?php echo CONTROLLER;?>/change_status','<?php echo $value["id"];?>')" class="dropdown-item">
                        <div class="durumdegistirbuttons-<?php echo $value["id"];?>">
                            <?php if($value["status"] == 1){?>
                                <span class=" tooltip-buttonicon-eye ">
                                    <span class="fa fa-eye"></span>
                                    Passive
                                </span>
                            <?php }else{ ?>
                                <span class=" tooltip-buttonicon-eye ">
                                    <span class="fa fa-eye-slash"></span>
                                    Active
                                </span>
                            <?php } ?>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <?php
        $renderView = ob_get_clean();
        return $renderView;
    }

    public function authority() {
        $model = $this->load->model("users_model");
        $data["usersList"] = $model->usersList();
        $data["yetkiList"] = $model->yetkiList();

        $this->view->render("admin_users/authority",$data);
    }

    public function ekle() {
        $model = $this->load->model("users_model");
        $data["yetkiList"] = $model->yetkiList();
        $data["ustusers"] = $model->usersSor($_SESSION["userId"]);

        $this->view->render("admin_users/add",$data);
    }

  public function ekleRun(){
        $form = $this->load->otherClasses('Form');
        $form   ->post('adi');
        $form   ->post('users_adi');
        $form   ->post('email');
        $form   ->post('parola');
        $form   ->post('parolatekrar');
        $form   ->post('yetki');
        $form   ->post('izinler');
        $form   ->post('telefon');
        $form   ->post('gsm');

        if($form->submit()){
            $model = $this->load->model("users_model");

            $yetki_listesi =@ $_SESSION['yetki_listesi'];
            foreach ($yetki_listesi['controller_listesi'] as $key => $value){
                foreach ($value['islemler'] as $key2 => $value2){
                    $yetkii[] = $value['c_isim'].$value2['m_isim'];
                }
            }
            if($_POST['yetki']=='1'){
                $izinler["izinler"] = $yetkii;
                $izin = json_encode($izinler);
            }else if($_POST['yetki']=='0'){
                $izinler["izinler"]= $_POST['izinler'];
                $izin = json_encode($izinler);
            }
            if($form->values['adi'] and $form->values['email'] and $form->values['parola'] and $form->values['parolatekrar']){
                $emailVarmi = $model->mailVarmi($form->values['email']);
                if(@count($emailVarmi) > 0){
                    $sonuc["status"] = "false";
                    $sonuc["description"] = "Mail Adresi Kayıtlı Lütfen başka bir mail adresi deneyiniz...";
                }else{
                    if($form->values['parola'] == $form->values['parolatekrar']){
                        $data= array(
                            "adi" => $form->values['adi'],
                            "users_adi" => $form->values['users_adi'],
                            "email" => $form->values['email'],
                            "telefon" => $form->values['telefon'],
                            "gsm" => $form->values['gsm'],
                            "parola" => md5($form->values['parola']),
                            "yetki" => $form->values['yetki'],
                            "durum" => 1,
                            "user_izinler" => $izin,
                            "kayit_tarihi" => strtotime("now"),
                            "ust_users" =>@ $_SESSION["userId"]
                        );
                        $model->ekleRun($data);
                        $sonuc["status"] = "true";
                        $sonuc["content"] = $_POST;
                        $sonuc["description"] = "Registration Successful";
                        $sonuc["yonlendir"] = PANEL_URL."admin_users/liste";
                    }else{
                        $sonuc["status"] = "false";
                        $sonuc["content"] = $_POST;
                        $sonuc["yetki"] = $yetkii;
                        $sonuc["description"] = "Şifreler Eşleşmiyor";
                    }
                }
            }else{
                $sonuc["status"] = "false";
                $sonuc["description"] = "Fill in the blanks...";
                $sonuc["content"] = $_POST;
                $sonuc["yetki"] = $yetkii;
            }
            echo json_encode($sonuc);
        }
    }



     public function yetkiekleRun(){
        $form = $this->load->otherClasses('Form');
        $form   ->post('adi');

        if($form->submit()){
            $model = $this->load->model("users_model");
            $data= array(
                "yetki" => $form->values['adi']
            );
            $model->yetkiEkleRun($data);
        }
        header('location: '.$_SERVER['HTTP_REFERER']);
    }

    public function duzenle($id){
        $model = $this->load->model("users_model");
        $data["users"] = $model->usersListSingle($id);
        $data["yetki"] = $model->yetkiList();
        $data["ustusers"] = $model->usersSor($_SESSION["userId"]);
        if($_SESSION["ust_users"]!=$id or $_SESSION["userId"]==$id ){
            $this->load->view("panel/header");
            $this->load->view("panel/admin_users/duzenle",$data);
            $this->load->view("panel/footer");
        }else{
            echo "<h3>Yetkili Değilssiniz</h3>";
            header('location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    public function duzenleRun($id) {
        $model = $this->load->model("users_model");
        $form = $this->load->otherClasses('Form');
        $form   ->post('users_adi');
        $form   ->post('adi');
        $form   ->post('parola');
        $form   ->post('parolatekrar');
        $form   ->post('email');
        $form   ->post('yetki');
        $form   ->post('telefon');
        $form   ->post('gsm');

        if($form->submit()){
            $data = array();
            $data['usersid'] = $id;
            $data['users_adi'] = $form->values['users_adi'];
            $data['adi'] = $form->values['adi'];
            $data2['parola'] = $form->values['parola'];
            $data2['parolatekrar'] = $form->values['parolatekrar'];
            $data['email'] = $form->values['email'];
            $data['telefon'] = $form->values['telefon'];
            $data['gsm'] = $form->values['gsm'];

            $yetki_listesi =@$_SESSION['yetki_listesi'];
            foreach ($yetki_listesi['controller_listesi'] as $key => $value){
                foreach ($value['islemler'] as $key2 => $value2){
                    $yetkii[] = $value['c_isim'].$value2['m_isim'];
                }
            }
            if($_POST['yetki']=='1'){
                $izinler["izinler"] = $yetkii;
                $izin = json_encode($izinler);
            }else if($_POST['yetki']=='0'){
                $izinler["izinler"]= $_POST['izinler'];
                $izin = json_encode($izinler);
            }

            $data['yetki'] = $form->values['yetki'];
            $data['user_izinler'] = $izin;

            if($data2["parola"]!=""){
                $data['parola'] = md5($form->values['parola']);
            }



            $result = $model->duzenleRun($data);
            header('location: '.PANEL_URL. 'admin_users/duzenle/'.$id);
        }
    }


    public function yetkiduzenle($id){
        $model = $this->load->model("users_model");
        $modulmodel = $this->load->model("modul_model");
        $data["yetki"] = $model->yetkiListSingle($id);
        $data["moduller"] = $modulmodel->modulListAsc();
        $data["islemList"] = $modulmodel->islemList();

        $this->load->view("panel/header");
        $this->load->view("panel/admin_users/yetkiduzenle",$data);
        $this->load->view("panel/footer");
    }

    public function yetkiduzenleRun($id) {
        $model = $this->load->model("users_model");
        $form = $this->load->otherClasses('Form');
        $form   ->post('adi');
        $form   ->post('izinler');

        if($form->submit()){
            // checboxlara virgül ekle
                $izinler["izinler"]= $_POST['izinler'];
            //
            $izin = json_encode($izinler);
            $data = array();
            $data['yetkiid'] = $id;
            $data['yetki'] = $form->values['adi'];
            $data['grup_izinler'] = $izin;

            $result = $model->yetkiduzenleRun($data);
            header('location: '.PANEL_URL. 'admin_users/yetkiduzenle/'.$id);
        }
    }

     public function hesap(){
        $model = $this->load->model("users_model");
        $id = Session::get("userId");
        $data["users"] = $model->usersListSingle($id);
        $data["yetki"] = $model->yetkiList();

        $this->load->view("panel/header");
        $this->load->view("panel/admin_users/hesap",$data);
        $this->load->view("panel/footer");
    }


    public function hesapRun() {
        $model = $this->load->model("users_model");
        $form = $this->load->otherClasses('Form');
        $form   ->post('users_adi');
        $form   ->post('adi');
        $form   ->post('parola');
        $form   ->post('parolatekrar');
        $form   ->post('email');
        $form   ->post('yetki');
        $form   ->post('parola_sifirla');

        if($form->submit()){
            $data = array();
            $data['usersid'] = Session::get("userId");
            $data['users_adi'] = $form->values['users_adi'];
            $data['adi'] = $form->values['adi'];
            $data2['parola'] = $form->values['parola'];
            $data2['parolatekrar'] = $form->values['parolatekrar'];
            $data['email'] = $form->values['email'];
            $data['parola_sifirla'] = $form->values['parola_sifirla'];


            if($data2["parola"]==$data2["parolatekrar"]){
                $data['parola'] = md5($form->values['parola']);
            }else{
                return false;
            }


            $result = $model->hesapRun($data);
            header('location: '.PANEL_URL. 'admin_users/hesap');
        }
    }


    public function sil($id)
    {
        $id= $_POST["id"];
        $model = $this->load->model("users_model");
        $model->sil($id);
    }
    public function durum(){
        $id = $_POST["id"];
        $durum = $_POST["status"];
        $model = $this->load->model("users_model");
        $model->durum($id,$durum);
    }

    public function yetkiSil($id)
    {
        $model = $this->load->model("users_model");
        $model->yetkiSil($id);
        header('location: '.$_SERVER['HTTP_REFERER']);
    }
    public function dataListe() {
        $model = $this->load->model("users_model");
        $requestData= $_REQUEST;

        $columns = array(
        // datatable column index  => database column name
                0 =>'id',
                1 => 'adi',
                2=> 'email',
                3 => 'durum',
                4 => 'yetki',
                5 => 'kayit_tarihi',
                6 => ''
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
                $sql.=" AND id LIKE '".$requestData['columns'][0]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
                $sql.=" AND adi LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
                $sql.=" AND email LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
                $sql.=" AND durum LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
                $sql.=" AND yetki LIKE '".strtotime($requestData['columns'][4]['search']['value'])."%' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
                $sql.=" AND kayit_tarihi LIKE '".strtotime($requestData['columns'][5]['search']['value'])."%' ";
        }
        $sql2 = $sql;

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

        $makale_liste = $model->userslar($sql);
        $toplammakale = $model->userslar($sql2);
          //echo $sql;
            $data = array();
            foreach ($makale_liste as $key => $row) {
                        if($row["status"]=="1"){$status="Aktif";$renk = "btn-warning";}else{$status="Pasif";$renk = "btn-default";}
                        if($row["yetki"]=="1"){$yetki = "Üst users";}else{$yetki = "Sınırlı users";}
                        if($_SESSION["ust_users"]!=$row["id"] and@$_SESSION["userId"]==$row["ust_users"] or $row["id"]==$_SESSION["userId"] or@$_SESSION["ana_users"]==1){
                        $islemler = ' <div class="btn-group pull-right">
                            <button type="button" class="btn '.$renk.' dropdown-toggle btn-sm" data-toggle="dropdown">Actions <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="../admin_users/duzenle/'.$row["id"].'"><span class="glyph-icon tooltip-button icon-edit"> </span> Düzenle</a></li>
                                    <li><a href="javascript:void(0)" onclick="sil('.$row["id"].')"> <span class="glyph-icon tooltip-button icon-close"> </span> Sil</a></li>';
                        $islemler.= '<li><a href="javascript:void(0)" onclick="durum('.$row["id"].','.$row["status"].')">';
                                        if($row["status"]=="1"){
                                            $islemler.= '<span class="glyph-icon tooltip-buttonicon-eye icon-eye"> Passive</span>';
                                        }else{
                                            $islemler.= '<span class="glyph-icon tooltip-buttonicon-eye icon-eye-slash"> Active</span>';
                                        }
                        $islemler.= '</a></li>
                                </ul>
                         </div>';
                        }else{$islemler="Yetkili Değilsiniz";}
                    // preparing an array
                       $nestedData=array();
                       $nestedData[] = $row["id"];
                       $nestedData[] = mb_substr($row["adi"],"0","200",UTF8);
                       $nestedData[] = $row["email"];
                       $nestedData[] = $durum;
                       $nestedData[] = $yetki;
                       $nestedData[] = date('d-m-Y',$row["kayit_tarihi"]);
                       $nestedData[] = $islemler;

                       $data[] = $nestedData;
               }

        $totaldata = @count($makale_liste);
        $totalfiltered = @count($toplammakale);

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal"    => intval( $totaldata ),  // total number of records
            "recordsFiltered" => intval( $totalfiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );
        echo json_encode($json_data);
        //print_r($json_data);
    }

}
