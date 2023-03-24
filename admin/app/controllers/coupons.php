<?php
class coupons extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("coupons_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->device_model = $this->load->model("device_model");
        $this->push_notification = $this->load->otherClasses("pushNotification");
        $this->notifications_model = $this->load->model("notifications_model");
    }

    public function index() {
        $form = $this->newform;
        $model = $this->newmodel;


        $data["title"] = "coupons List";
//        $data["dashboard"] = false;
        $this->view->render("coupons/index", $data);
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
                "short_name"=> $form->values['short_name'],
                "description"=> $form->values['description'],
                "start_date"=> $form->values['start_date'],
                "end_date"=> $form->values['end_date'],
                "promocode"=> $form->values['promocode'],
                "promolink"=> $form->values['promolink'],
                "discount"=> $form->values['discount'],
                "species"=> $form->values['species'],
                "code_type"=> $form->values['code_type'],
                "cashback"=> $form->values['cashback'],
                "source"=> $form->values['source'],
                "store_id"=> $form->values['store_id'],
                "rating"=> $form->values['rating'],
                "exclusive"=> $form->values['exclusive'],
                "language"=> $form->values['language'],
                "types"=> $form->values['types'],
                "coupon_id"=>$form->values["id"],
                "image"=>$form->values["image"],
            );

            if (@$form->values["status"]) {
                $data["status"] = $form->values["status"];
            } else {
                $data["status"] = 1;
            }
            if(@$_POST['regions']){
                $regions= ",".@implode(",", @$_POST['regions']).",";
            }else {
                $regions= "";
            }
            $data["categories"] = $regions;
            if(@$_POST['categories']){
                $categories= ",".@implode(",", @$_POST['categories']).",";
            }else {
                $categories= "";
            }
            $data["regions"] = $regions;
            $data["categories"] = $categories;
            if(@$_FILES){
                if (is_dir(USTDIZIN."uploads")) {
                } else {
                    mkdir(USTDIZIN."uploads",0777, true);
                }
                if (is_dir(USTDIZIN."uploads/coupons" )) {
                } else {
                    mkdir( USTDIZIN."uploads/coupons",0777, true);
                }
                $output_dir = "uploads/coupons/";
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
                        $data["logo"] = $yeni_ad;
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
            $data["stores"] = $this->newmodel->get_stores();
            $data["categories"] = $this->newmodel->get_categories();
            $data["regions"] = $this->newmodel->get_regions();
            ob_start();
            $this->view->render("coupons/modal",$data,"1");
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
            $data["stores"] = $this->newmodel->get_stores();
            $data["categories"] = $this->newmodel->get_categories();
            $data["regions"] = $this->newmodel->get_regions();
            ob_start();
            $this->view->render("coupons/modal",$data,"1");
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
            2 => 'short_name',
            3 => 'description',
            4 => 'start_date',
            5 => 'end_date',
            6 => 'promocode',
            7 => 'promolink',
            8 => 'discount',
            9 => 'species',
            10 => 'code_type',
            11 => 'cashback',
            12 => 'source',
            13 => 'rating',
            14 => 'exclusive',
            15 => 'language',
            16 => 'types',
            17 => 'coupon_id',
            18 => 'image',
            19 => 'categories',
            20 => 'store_id',
            21 => 'updated_by',
            22 => 'created_at',
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
            $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
            $sql.=" AND name LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
            $sql.=" AND start_date LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
            $sql.=" AND end_date LIKE '%".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
            $sql.=" AND promocode LIKE '%".$requestData['columns'][4]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
            $sql.=" AND promolink LIKE '%".$requestData['columns'][5]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][6]['search']['value']) ){  //salary
            $sql.=" AND discount LIKE '%".$requestData['columns'][6]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][7]['search']['value']) ){  //salary
            $sql.=" AND species LIKE '%".$requestData['columns'][7]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][8]['search']['value']) ){  //salary
            $sql.=" AND code_type LIKE '%".$requestData['columns'][8]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][9]['search']['value']) ){  //salary
            $sql.=" AND cashback LIKE '%".$requestData['columns'][9]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][10]['search']['value']) ){  //salary
            $sql.=" AND source LIKE '%".$requestData['columns'][10]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][11]['search']['value']) ){  //salary
            $sql.=" AND categories_id LIKE '%".$requestData['columns'][11]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][12]['search']['value']) ){  //salary
            $sql.=" AND stores_id LIKE '%".$requestData['columns'][12]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][13]['search']['value']) ){  //salary
            $sql.=" AND rating LIKE '%".$requestData['columns'][13]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][14]['search']['value']) ){  //salary
            $sql.=" AND language LIKE '%".$requestData['columns'][14]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][15]['search']['value']) ){  //salary
            $sql.=" AND types LIKE '%".$requestData['columns'][15]['search']['value']."%' ";
        }

        if( !empty($requestData['columns'][16]['search']['value']) ){  //salary
            $sql.=" AND updated_by LIKE '".$requestData['columns'][16]['search']['value']."%' ";
        }

        if( !empty($requestData['columns'][17]['search']['value']) ){  //salary
            $sql.=" AND created_at = '".strtotime($requestData['columns'][17]['search']['value'])."' ";
        }
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

        $makale_liste = $model->coupons_list($sql);
        $toplammakale = $model->coupons_list();
        //echo $sql;
        $durum = "";
        $data = array();
        foreach ($makale_liste as $key => $row) {
            // preparing an array
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

            $nestedData=array();
            $nestedData[] = $row["id"];
            $nestedData[] = $row["name"];
            $nestedData[] = $row["short_name"] ."---". $row["used_total"];
            $nestedData[] = $row["used_last"];
            $nestedData[] = $row["start_date"];
            $nestedData[] = $row["end_date"];
            $nestedData[] = $row["promocode"];
            $nestedData[] = $row["promolink"];
            $nestedData[] = $row["discount"] . "-- ".$row["discountInt"];
            $nestedData[] = $row["species"];
            $nestedData[] = $row["code_type"];
            $nestedData[] = $row["cashback"];
            $nestedData[] = $row["source"];
            $nestedData[] = $row["rating"];
            $nestedData[] = $row["exclusive"];
            $nestedData[] = $row["language"];
            $nestedData[] = $row["types"];
            $nestedData[] = $row["coupon_id"];
            $nestedData[] = $row["image"];
            $nestedData[] = $categories_html;
            $nestedData[] = $regions_html;
            $nestedData[] = $row["store_id"];

            $nestedData[] = $row["updated_by"];

            $nestedData[] = $row["created_at"]." -" . $row["updated_at"];
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
