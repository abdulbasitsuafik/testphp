<?php
class products extends Controller{
    public function __construct() {
        parent::__construct();
        Session::checkSession();
        $this->newmodel = $this->load->model("products_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
    }

    public function index(){
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST){
            $response = $this->form_control($_POST);
            echo json_encode($response);
        }else{
            $data["dashboard"] = true;
            $data["title"] = "Ürün";
            $data["lessons"] = $model->get_lessons();
            $this->view->render("products/index",$data);
        }
    }
    public function edit() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }

            $data["title"] = "Ürün";
            $data["id"] = $form->values["id"];
            $data["data"] = $model->get_single($data["id"])[0];
            $data["lessons"] = $model->get_lessons();
            ob_start();
            $this->view->render("products/edit",$data,"1");
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
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $data["name"] = @$form->values["name"];
            $data["type"] = @$form->values["type"];
            $data["description"] = @$form->values["description"];
            $data["price"] = @$form->values["price"];
            $data["per_price"] = @$form->values["per_price"];
            $data["period"] = @$form->values["period"];
            $data["sku"] = @$form->values["sku"];
            $data["image"] = @$form->values["image"];
            $data["color"] = @$form->values["color"];
            $data["ios_id"] = @$form->values["ios_id"];
            if($posttype=="edit"){
                $data["id"] = @$form->values["b_id"];
                $model->edit($data);
                $response["post_type"] = "edit";
            }else{
                $model->add($data);
                $response["post_type"] = "add";
                $response["refresh"] = true;
            }

            $response["status"] = true;
            $response["message"] = "Kayıt Başarılı";
            $response["content"] = $_POST;
            $response["get_table"] = true;
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["content"] = $_POST;
        }
        return $response;
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
        if ($_POST) {
            $id = $_POST["id"];
            $model->delete($id);
        }
    }
    public function get_table(){
        ob_start();
        $model = $this->newmodel;
        $sorgu = $model->get_list();
        foreach ($sorgu as $key => $value){
            ?>

            <tr id="tableline-<?php echo $value["id"];?>">
                <td><?php echo $value['id']?></td>
                <td><?php echo $value['name']?></td>
                <td><?php echo $value['type']?></td>
                <td><?php echo $value['description']?></td>
                <td><?php echo $value['price']?></td>
                <td><?php echo $value['per_price']?></td>
                <td><?php echo $value['period']?></td>
                <td><?php echo $value['sku']?></td>
                <td><?php echo $value['image']?></td>
                <td><?php echo $value['color']?></td>
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
}
