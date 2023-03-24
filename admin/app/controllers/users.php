<?php
class Users extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("users_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->device_model = $this->load->model("device_model");
        $this->push_notification = $this->load->otherClasses("pushNotification");
        $this->SystemTools = $this->load->otherClasses("SystemTools");
        $this->notifications_model = $this->load->model("notifications_model");
    }
    public function getCode(){
        $new_code = $this->SystemTools->uniqidReal(8);
        echo json_encode(["data"=>strtoupper($new_code)]);
    }
    public function index() {
        $form = $this->newform;
        $model = $this->newmodel;

        $roles = $model->get_user_roles();

        $data["title"] = "Mobile App's Users";
        $data["roles"] = $roles;
//        $data["dashboard"] = false;
        $this->view->render("users/index", $data);
    }
    public function zero_users() {
        $d = new DateTime();
        $new_month = $d->format('m');
        $new_year = $d->format('Y');
        $ask_montly["month"] = $new_month;
        $ask_montly["year"] = $new_year;
        $get_users_points_monthly = $this->newmodel->get_users_points_monthly($ask_montly);
        if(count($get_users_points_monthly) == 0){
            $get_list_user_order_point = $this->newmodel->get_list_user_order_point();
            foreach ($get_list_user_order_point as $index => $item) {
                $data["user"] = $item["id"];
                $data["point"] = $item["point"];
                $data["month"] = $new_month;
                $data["year"] = $new_year;
                $this->newmodel->add_users_points_monthly($data);
                $this->newmodel->update_just_point(["user"=>$item["id"],"point"=>0]);
            }
            $response["status"] = true;
            $response["title"] = "İşlem Başarılı";
            $response["message"] = "İşlem Başarılı";
        }else{
            $response["status"] = false;
            $response["title"] = "İşlem bu ay gerçekleştirildi";
            $response["message"] = "Lütfen Bir sonraki ay tekrar deneyiniz.";
        }
        echo json_encode($response);
    }
    public function send_notification($data,$reg_ids=[]){
//        $data = [
//            "title"=>"Deneme Bildirim",
//            "desc"=>"Deneme Bildirim açıklama",
//            "banner"=>"https://www.tolgaege.com/tosbaexams/admin/static/temalar/default/assets/logo.gif",
//            "detail_id"=>"",
//        ];
//        $all_androids = $this->device_model->find_device(["os_type"=>"android"]);
//        $reg_ids = [];
//        foreach ($all_androids as $index => $item) {
//            $reg_ids[] = $item["push_token"];
//        }
        $return = $this->push_notification->sendAndoid($data,$reg_ids);
        return $return;
    }
    public function notification_form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $user_id = $form->values['user_id'];
            if($user_id){
                $all_androids = $this->device_model->find_device(["user"=>$user_id]);
                if($all_androids){
                    $data = array(
                        "title" => $form->values['title'],
                        "body" => $form->values['body'],
                        "image" => $form->values['image'],
                        "created_at"=>$created_at,
                        "updated_at"=>$created_at,
                        "readed"=>0
                    );
                    $insert_id = $this->notifications_model->add($data);

                    $newdata = [
                        "title"=>$form->values['title'],
                        "desc"=>$form->values['body'],
                        "banner"=>$form->values['image'],
                        "detail_id"=>"",
                    ];

                    $reg_ids = [];
                    $userdata = [];
                    $get_user = $this->newmodel->get_single($user_id);
                    $reg_ids[] = $all_androids[0]["push_token"];
                    $userdata = [
                        "user_id"=>$all_androids[0]["user"],
                        "notification_id"=>$insert_id,
                        "favorite"=>0,
                        "readed"=>0
                    ];
                    $this->notifications_model->add_to_user($userdata);
                    $response = $this->send_notification($newdata,$reg_ids);
                    $response["status"] = true;
                    $response["message"] = "Kullanıcıya Bildirim iletildi";
                    $response["content"] = $_POST;
                    $response["response"] = $response;
                }else{
                    $response["status"] = false;
                    $response["message"] = "Kullanıcı Cihazı Kapalı";
                    $response["content"] = $_POST;
                }
            }else{
                $response["status"] = false;
                $response["message"] = "Kullanıcı Mevcut Değil";
                $response["content"] = $_POST;
            }
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks";
            $response["content"] = $_POST;
        }
        return @$response;
    }
    public function notification_add() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data = [];
            $data["user_id"] = $form->values["id"];
            ob_start();
            $this->view->render("users/notifications_modal",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->notification_form_control($_POST,"add");
                echo json_encode($response);
            }
        }

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
                $authority_name = "Staff";
            }else if($form->values['authority'] == 1){
                $authority_name = "Super User";
            }else if($form->values['authority'] == 2){
                $authority_name = "Admin";
            }else{
                $authority_name = "";
            }

            $data = array(
                "name"=> $form->values['name'],
                "surname"=> $form->values['surname'],
                "full_name"=> $form->values['name']." ".$form->values['surname'],
                "username" => $form->values['username'],
                "phone" => $form->values['phone'],
//                "role" => $form->values['role'],
//                "ads_enabled" => $form->values['ads_enabled'],
                "my_ref_code" => $form->values['my_ref_code'],
//                "premium_competition" => $form->values['premium_competition'],
//                "teacher_agreement" => $form->values['teacher_agreement'],
//                "city" => $form->values['city'],
//                "town" => $form->values['town'],
//                "school" => $form->values['school'],
//                "class" => $form->values['class'],
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
                $output_dir = "upload/users/";

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
                        $data["password"] = password_hash($form->values['password'], PASSWORD_DEFAULT);
//                        $data["point"] = $form->values['point'];
                        $model->edit($data);
                        $response["status"] = true;
                        $response["message"] = "Kayıt Başarılı 1";
                        $response["content"] = $_POST;
                        $response["post_type"] = "edit";
                        $response["files"] = $_FILES;
                        $response["get_table"] = true;
                    }else{
                        $response["status"] = false;
                        $response["content"] = $_POST;
                        $response["message"] = "Şifreler Eşleşmiyor";
                    }
                }else{
                    $data["email"] = $form->values['email'];
//                    $data["point"] = $form->values['point'];
                    $kayıt = $model->edit($data);
                    $response["status"] = true;
                    $response["post"] = $_POST;
                    $response["kayıt"] = $kayıt;
                    $response["message"] = "Kayıt Başarılı 2";
                    $response["content"] = $_POST;
                    $response["files"] = $_FILES;
                    $response["post_type"] = "edit";
                    $response["get_table"] = true;
                }
            } else {
                if(@count($emailVarmi) > 0) {
                    $response["status"] = false;
                    $response["message"] = "Try another email address!";
                }else{
                    if ($form->values['password'] == $form->values['password_repeat']) {
                        $data["password"] = password_hash($form->values['password'], PASSWORD_DEFAULT);
                        $data["email"] = $form->values['email'];
                        $model->add($data);
                        $response["status"] = true;
                        $response["message"] = "Registration Successful";
                        $response["content"] = $_POST;
                        $response["files"] = $_FILES;
                        $response["get_table"] = true;
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
            $this->view->render("users/modal",$data,"1");
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


            $get_user_purchases = $model->get_user_purchases($data["id"]);

            $data["get_user_purchases"] = $get_user_purchases;

            ob_start();
            $this->view->render("users/modal",$data,"1");
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


//            $users_list = $model->users_list();
//            foreach ($users_list as $index => $item) {
//                $data["phone"] = str_replace("+9","9",@$item["phone_number"]);
//                $data["id"] = @$item["id"];
//                $model->edit($data);
//            }

            echo json_encode($response);
        }
    }
    public function purchases_status(){
        $model = $this->newmodel;
        if ($_POST){
            $id = $_POST["id"];

            $get_single = $model->get_single_purchases($id);
            $status = $model->purchases_status($id,$get_single[0]["used"]);
            $response["status"] = $status;
            echo json_encode($response);
        }
    }
    public function delete($id=null)
    {
//        $form = $this->newform;
        $model = $this->newmodel;
        if ($_POST) {
            $id = $_POST["id"];
            $model->delete($id);
            $response["status"] =true;
            $response["message"] ="Silme işlemi başarılı";
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
                <td><?php echo $value['full_name']?></td>
                <td><?php echo $value['username']?></td>
                <td><?php echo $value['email']?></td>
                <td><?php echo $value['role'] == 3 ? "Student" : "Teacher" ?></td>
                <td><?php echo $value['created_at'];?></td>
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
                <li><a href="javascript:void(0)" onclick="modalGetir('<?php echo CONTROLLER;?>/notification_add','<?php echo $value["id"];?>')" class="dropdown-item"><span class="fa fa-sticky-note"> </span> Send Notification</a></li>
                <li>
                    <a href="javascript:void(0)" onclick="item_delete('<?php echo CONTROLLER;?>/delete','<?php echo $value["id"];?>')" class="dropdown-item"> <span class="fa fa-trash"> </span> Delete</a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="change_status('<?php echo CONTROLLER;?>/change_status','<?php echo $value["id"];?>')" class="dropdown-item">
                        <div class="durumdegistirbuttons-<?php echo $value["id"];?>">
                            <?php if($value["blocked"] == 0){?>
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
        $model = $this->newmodel;
        $data["usersList"] = $model->usersList();
        $data["yetkiList"] = $model->yetkiList();

        $this->view->render("users/authority",$data);
    }


    public function sil($id)
    {
        $id= $_POST["id"];
        $model = $this->newmodel;
        $model->sil($id);
    }
    public function durum(){
        $id = $_POST["id"];
        $durum = $_POST["status"];
        $model = $this->newmodel;
        $model->durum($id,$durum);
    }

    public function yetkiSil($id)
    {
        $model = $this->newmodel;
        $model->yetkiSil($id);
        header('location: '.$_SERVER['HTTP_REFERER']);
    }
    public function dataListe() {
        $model = $this->newmodel;
        $requestData= $_REQUEST;

        $columns = array(
        // datatable column index  => database column name
                0 =>'id',
                1 => 'full_name',
                2=> 'email',
                3 => 'phone_number',
                4 => 'role',
                5 => 'created_at',
                6 => 'point',
                7 => ''
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
                $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
                $sql.=" AND full_name LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
                $sql.=" AND email LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
                $sql.=" AND phone_number LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
//                $sql.=" AND role = '".strtotime($requestData['columns'][4]['search']['value'])."%' ";
                $sql.=" AND role = '".$requestData['columns'][4]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
                $sql.=" AND created_at = '".$requestData['columns'][5]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][6]['search']['value']) ){  //salary
//                $sql.=" AND role = '".strtotime($requestData['columns'][4]['search']['value'])."%' ";
            $sql.=" AND point = '".$requestData['columns'][6]['search']['value']."' ";
        }
            $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

            $makale_liste = $model->users_list($sql);
            $toplammakale = $model->users_list();
          //echo $sql;
            $durum = "";
            $data = array();
            foreach ($makale_liste as $key => $row) {
                        if($row["blocked"]=="0"){$status="Aktif";$renk = "btn-warning";}else{$status="Pasif";$renk = "btn-default";}
                        if($row["role"]=="1"){
                            $yetki = "Authenticated";
                        }else if($row["role"]=="2"){
                            $yetki = "Public";
                        }else if($row["role"]=="3"){
                            $yetki = "Student";
                        }else{$yetki = "Teacher";}

                        $model_device = $this->device_model->find_device(["user"=>$row["id"]]);
                        if($model_device){
                            $new_device_version = $model_device[0]["os_type"]." - ".$model_device[0]["app_version"];
                        }else{
                            $new_device_version = "";
                        }
                    // preparing an array
                       $nestedData=array();
                       $nestedData[] = $row["id"];
                       $nestedData[] = $row["full_name"];
                       $nestedData[] = $model_device[0]["device_id"];
                       $nestedData[] = $model_device[0]["access_token"];
                       $nestedData[] = $row["email"];
                       $nestedData[] = $row["phone_number"];
                       $nestedData[] = $row["language"];
                       $nestedData[] = $new_device_version;
                       $nestedData[] = $row["created_at"];
                       $nestedData[] = $this->islemler($row);

                       $data[] = $nestedData;
               }

        $totaldata = @count($toplammakale);
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
