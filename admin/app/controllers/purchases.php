<?php
class Purchases extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("purchases_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->device_model = $this->load->model("device_model");
        $this->push_notification = $this->load->otherClasses("pushNotification");
        $this->notifications_model = $this->load->model("notifications_model");
    }

    public function index() {
        $form = $this->newform;
        $model = $this->newmodel;

        $roles = $model->get_user_roles();

        $data["title"] = "purchases List";
        $data["roles"] = $roles;
//        $data["dashboard"] = false;
        $this->view->render("purchases/index", $data);
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
                "role" => $form->values['role'],
                "ads_enabled" => $form->values['ads_enabled'],
//                "premium_competition" => $form->values['premium_competition'],
                "teacher_agreement" => $form->values['teacher_agreement'],
                "city" => $form->values['city'],
                "town" => $form->values['town'],
                "school" => $form->values['school'],
                "class" => $form->values['class'],
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
                if (is_dir("upload/purchases" )) {
                } else {
                    mkdir( "upload/purchases");
                }
                $output_dir = "upload/purchases/";

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

            if($form->values["premium_competition"]==1){
                $add_to_cart_data = [
                    "user"=> @$form->values["b_id"],
                    "product"=> 1,
                    "used"=> 0,
                    "payment"=> 1,
                ];
                $d = new DateTime();
                $add_to_cart_data["start_date"] = $d->format("Y-m-d H:i:s");
                $date = new DateTime();

                $premium_month = $form->values["premium_month"];
                if ($premium_month){
                    $new_premium_month = $premium_month * 30;
                    $date->add(new DateInterval('P'.$new_premium_month.'D'));
                    $add_to_cart_data["end_date"] = $date->format("Y-m-d H:i:s");
                }else{
                    $date->add(new DateInterval('P90D'));
                    $add_to_cart_data["end_date"] = $date->format("Y-m-d H:i:s");
                }
                $add_to_purchases = $this->newmodel->add_to_cart($add_to_cart_data);
            }
            if($form->values["key_competition"]==1){
                $add_to_cart_key_data = [
                    "user"=> @$form->values["b_id"],
                    "product"=> 3,
                    "used"=> 0,
                    "payment"=> 1,
                ];

                $key_adet = $form->values["key_count"];
                if ($key_adet){
                    for ($i=0;$i < $key_adet;$i++){
                        $add_to_purchases = $this->newmodel->add_to_cart($add_to_cart_key_data);
                    }
                }else{
                    $add_to_purchases = $this->newmodel->add_to_cart($add_to_cart_key_data);
                }
            }
            if($form->values["ticket_competition"]==1){
                $add_to_cart_ticket_data = [
                    "user"=> @$form->values["b_id"],
                    "product"=> 2,
                    "used"=> 0,
                    "payment"=> 1,
                ];

                $key_adet = $form->values["ticket_count"];
                if ($key_adet){
                    for ($i=0;$i < $key_adet;$i++){
                        $add_to_purchases = $this->newmodel->add_to_cart($add_to_cart_ticket_data);
                    }
                }else{
                    $add_to_purchases = $this->newmodel->add_to_cart($add_to_cart_ticket_data);
                }
            }

            if ($posttype == "edit") {
                $data["id"] = @$form->values["b_id"];
                if($form->values['password']){
                    if ($form->values['password'] == $form->values['password_repeat']) {
                        $data["password"] = password_hash($form->values['password'], PASSWORD_DEFAULT);
                        $data["point"] = $form->values['point'];
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
                    $data["point"] = $form->values['point'];
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
            $this->view->render("purchases/modal",$data,"1");
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
            $data["premium"] = $model->get_purchases(["user"=>$data["id"],"payment"=>1,"used"=>0,"product"=>1]) ? 1 : 0;

            $cities = $this->newmodel->get_cities();
            $new_cities = [];
            foreach ($cities as $index => $city) {
                $new_cities[] = [
                    "id"=>$city["IL_ID"],
                    "baslik"=>$city["IL_ADI"]
                ];
            }

            $classes = $this->newmodel->get_classes();
            $lessons = $this->newmodel->get_lessons();
            $data["cities"] = $new_cities;
            $data["classes"] = $classes;
            $data["lessons"] = $lessons;
            $data["cozdugu_testler"] = $this->newmodel->get_purchases_sessions($form->values["id"]);

            $get_user_purchases = $model->get_user_purchases($data["id"]);

            $data["get_user_purchases"] = $get_user_purchases;

            ob_start();
            $this->view->render("purchases/modal",$data,"1");
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


//            $purchases_list = $model->purchases_list();
//            foreach ($purchases_list as $index => $item) {
//                $data["phone"] = str_replace("+9","9",@$item["phone_number"]);
//                $data["id"] = @$item["id"];
//                $model->edit($data);
//            }

            echo json_encode($response);
        }
    }
    public function used_status(){
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
                    <a href="javascript:void(0)" onclick="change_status('<?php echo CONTROLLER;?>/used_status','<?php echo $value["id"];?>')" class="dropdown-item">
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

    public function dataListe() {
        $model = $this->newmodel;
        $requestData= $_REQUEST;

        $columns = array(
        // datatable column index  => database column name
                0 =>'id',
                1 => 'user',
                2=> 'vehicle_id',
                3 => 'product',
                4 => 'start_date',
                5 => 'end_date',
                6 => 'used',
                7 => 'payment',
                8 => 'drive_id',
                9 => 'created_at'
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
                $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
                $sql.=" AND user LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
                $sql.=" AND vehicle_id LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
                $sql.=" AND product LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
                $sql.=" AND start_date = '".strtotime($requestData['columns'][4]['search']['value'])."' ";
//                $sql.=" AND start_date = '".$requestData['columns'][4]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
//                $sql.=" AND end_date = '".$requestData['columns'][5]['search']['value']."' ";
            $sql.=" AND end_date = '".strtotime($requestData['columns'][5]['search']['value'])."' ";
        }
        if( !empty($requestData['columns'][6]['search']['value']) ){  //salary
                $sql.=" AND used = '".$requestData['columns'][6]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][7]['search']['value']) ){  //salary
                $sql.=" AND payment = '".$requestData['columns'][7]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][8]['search']['value']) ){  //salary
            $sql.=" AND drive_id = '".($requestData['columns'][8]['search']['value'])."' ";
        }
        if( !empty($requestData['columns'][9]['search']['value']) ){  //salary
            $sql.=" AND created_at = '".strtotime($requestData['columns'][9]['search']['value'])."' ";
        }
            $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

            $makale_liste = $model->purchases_list($sql);
            $toplammakale = $model->purchases_list();
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
                       $nestedData[] = $row["user"];
                       $nestedData[] = $row["payment_method"];
                       $nestedData[] = $row["card_id"];
                       $nestedData[] = $row["vehicle_id"];
                       $nestedData[] = $row["product"];
                       $nestedData[] = $row["custom_price"];
                        $nestedData[] = $row["start_date"];
                       $nestedData[] = $row["end_date"];
                        $nestedData[] = $row["drive_id"];
                       $nestedData[] = $row["used"]." ".$row["vehicle_status"];
                       $nestedData[] = $row["payment"];
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
