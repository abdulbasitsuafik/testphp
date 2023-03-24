<?php
class stores extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("stores_model");
        $this->coupons_model = $this->load->model("coupons_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->device_model = $this->load->model("device_model");
        $this->push_notification = $this->load->otherClasses("pushNotification");
        $this->notifications_model = $this->load->model("notifications_model");
    }

    public function index() {
        $form = $this->newform;
        $model = $this->newmodel;


        $data["title"] = "stores List";
//        $data["dashboard"] = false;
        $this->view->render("stores/index", $data);
    }
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $data = array(
                "name"=> $form->values['name'],
                "store_id"=>$form->values["store_id"],
                "description"=>$form->values["description"],
                "logo"=>$form->values["image"],
                "image"=>$form->values["image"],
                "large_image"=>$form->values["image"],
                "site_url"=>$form->values["site_url"],
                "status"=>$form->values["status"] =="active" ? 1 : 0,
                "currency"=>$form->values["currency"],
                "rating"=>$form->values["rating"],
                "activation_date"=>$form->values["activation_date"],
                "modified_date"=>$form->values["modified_date"],
            );
            $regions = ",".@implode(",", @$_POST["regions"]).",";
            $categories = ",".@implode(",", @$_POST["categories"]).",";
            $data["categories"] = $categories;
            $data["regions"] = $regions;
            if (@$form->values["status"]) {
                $data["status"] = $form->values["status"];
            } else {
                $data["status"] = 1;
            }
            if(@$_FILES){
                if (is_dir(USTDIZIN."uploads")) {
                } else {
                    mkdir(USTDIZIN."uploads",0777, true);
                }
                if (is_dir(USTDIZIN."uploads/stores" )) {
                } else {
                    mkdir( USTDIZIN."uploads/stores",0777, true);
                }
                $output_dir = "uploads/stores/";
                $index = "image";
                $nowdate =  strtotime("now"). substr((string)microtime(), 1, 6);
                $fileName = @$_FILES[$index]["name"];
                $type = @$_FILES[$index]["type"];
                if($type){
                    $uzanti=str_replace("image/","",$type);
                    $uzanti = strtolower(".".$uzanti);
                    if ($uzanti) {
                        $yeni_ad = $output_dir . $nowdate . $uzanti;
                        @copy(@$_FILES[$index]["tmp_name"],USTDIZIN.$yeni_ad);
                        $data["large_image"] = $yeni_ad;
                    }
                }
            }

            if ($posttype == "edit") {
                $data["id"] = @$form->values["b_id"];
                $kayıt = $model->edit($data);
                $response["status"] = true;
                $response["post"] = $_POST;
                $response["kayıt"] = $kayıt;
                $response["message"] = "Kayıt Başarılı 2";
                $response["content"] = $_POST;
                $response["files"] = $_FILES;
                $response["post_type"] = "edit";
                $response["get_table"] = true;
            } else {
                $model->add($data);
                $response["status"] = true;
                $response["message"] = "Registration Successful";
                $response["content"] = $_POST;
                $response["files"] = $_FILES;
                $response["get_table"] = true;
                $response["post_type"] = "add";
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
            $data["stores"] = $this->coupons_model->get_stores();
            $data["categories"] = $this->coupons_model->get_categories();
            $data["regions"] = $this->coupons_model->get_regions();
            ob_start();
            $this->view->render("stores/modal",$data,"1");
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
            $data["stores"] = $this->coupons_model->get_stores();
            $data["categories"] = $this->coupons_model->get_categories();
            $data["regions"] = $this->coupons_model->get_regions();
            ob_start();
            $this->view->render("stores/modal",$data,"1");
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
                    <a href="javascript:void(0)" onclick="change_status('<?php echo CONTROLLER;?>/status','<?php echo $value["id"];?>')" class="dropdown-item">
                        <div class="durumdegistirbuttons-<?php echo $value["id"];?>">
                            <?php if($value["status"] == 0){?>
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
                1 => 'name',
                2 => 'store_id',
                3 => 'description',
                4 => 'logo',
                5 => 'site_url',
                6 => 'status',
                7 => 'currency',
                8 => 'rating',
                9 => 'activation_date',
                10 => 'modified_date',
                11 => 'categories',
                12 => 'regions',
                13 => 'updated_by',
                14 => 'created_at',
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
                $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
                $sql.=" AND name LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
            $sql.=" AND logo LIKE '".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
            $sql.=" AND image LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
            $sql.=" AND large_image LIKE '".$requestData['columns'][4]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
            $sql.=" AND tags LIKE '".$requestData['columns'][5]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][6]['search']['value']) ){  //salary
            $sql.=" AND site LIKE '".$requestData['columns'][6]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][7]['search']['value']) ){  //salary
            $sql.=" AND updated_by LIKE '".$requestData['columns'][7]['search']['value']."%' ";
        }

        if( !empty($requestData['columns'][8]['search']['value']) ){  //salary
            $sql.=" AND created_at = '".strtotime($requestData['columns'][8]['search']['value'])."' ";
        }
            $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

            $makale_liste = $model->stores_list($sql);
            $toplammakale = $model->stores_list();
          //echo $sql;
            $durum = "";
            $data = array();
            foreach ($makale_liste as $key => $row) {

                    if($row["categories"]){
                        $categories_row = explode(",",$row["categories"]);
                        $categories_html = "";
                        foreach ($categories_row as $index => $item) {
                            $categories_html .= '<span class="badge badge-info ">'.$item.'</span> ';
                        }
                    }
                    if($row["regions"]){
                        $regions_row = explode(",",$row["regions"]);
                        $regions_html = "";
                        foreach ($regions_row as $index => $item) {
                            $regions_html .= '<span class="badge badge-info ">'.$item.'</span> ';
                        }
                    }
                    if($row["logo"]){
                        $logos = '<img style="height:48px;" src="'.$row["logo"].'"/>';
                    }else{
                        $logos = "";
                    }

                    // preparing an array
                       $nestedData=array();
                       $nestedData[] = $row["id"];
                       $nestedData[] = $row["name"];
                       $nestedData[] = $row["store_id"];
                       $nestedData[] = "";
                       $nestedData[] = $logos;
                       $nestedData[] = $row["site_url"];
                       $nestedData[] = $row["status"];
                       $nestedData[] = $row["currency"];
                       $nestedData[] = $row["rating"];
                       $nestedData[] = $row["activation_date"];
                       $nestedData[] = $row["modified_date"];
                       $nestedData[] = $categories_html;
                       $nestedData[] = $regions_html;


                       $nestedData[] = $row["updated_by"];

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
