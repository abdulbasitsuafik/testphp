<?php
class headlines extends Controller{
    public function __construct() {
        parent::__construct();
        Session::checkSession();
        $this->newmodel = $this->load->model("headlines_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->nestable_items_array = [];
        $this->nestable_items_for_plugins_array = [];
    }
    public function index(){
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST){
            $response = $this->form_control($_POST);
            echo json_encode($response);
        }else{
            $data["title"] = "Titles";
            $data["dashboard"] = false;

            ob_start();
            $this->nestable_items();
            $renderView = ob_get_clean();
            $data["nestable_items"] = $renderView;
            $this->view->render("headlines/index",$data);
        }
    }
    public function add() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data["title"] = "Add";
            $data["page_type"] = "add";
            $data["data"]["top_head_id"] = @$form->values["id"];

            $data["languages"] = $model->active_languages();
            $data["all_headlines"] = $model->all_headlines();
            $data["title"] = [];
            ob_start();
            $this->view->render("headlines/modal",$data,"1");
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
            $data["title"] = "Edit";
            $data["page_type"] = "edit";
            $data["id"] =@$form->values["id"];
            $data["data"] = $model->get_single($data["id"])[0];

            $data["language_content"] = $model->headlines_languages_join($data["id"]);
            $data["languages"] = $model->active_languages();
            $data["all_headlines"] = $model->all_headlines();
            $data["resimList"] = $model->resimList($data["id"]);
            $data["popuplar"] = $model->popupList();
            $data["bannerler"] = $model->bannerList();
            $data["galeriler"] = $model->galeriList();
            $data["formlar"] = $model->formList();
            ob_start();
            $this->view->render("headlines/modal",$data,"1");
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
            $dilsayisi = $model->active_languages();
            $headlinesSayisi = count($model->all_headlines());
            if (@$_FILES){
                $output_dir = "uploads/headlines/";
                if(is_dir(USTDIZIN."uploads")){ }else{
                    mkdir(USTDIZIN."uploads");
                }
                if(is_dir(USTDIZIN.$output_dir)){ }else{
                    mkdir(USTDIZIN.$output_dir);
                }

                foreach ($_FILES as $index => $FILE) {
                    $nowdate =  strtotime("now"). substr((string)microtime(), 1, 6);
                    $fileName = @$_FILES[$index]["name"];
                    $type = @$_FILES[$index]["type"];
                    $uzanti=str_replace("image/","",$type);
                    $uzanti = strtolower(".".$uzanti);

                    $yeni_ad=$output_dir.$form->seo($fileName).$nowdate.$uzanti;
                    @copy(@$_FILES[$index]["tmp_name"],USTDIZIN.$yeni_ad);
                }

            }

            $degisiklikTarihi =  strtotime("now");
            if(@$form->values['link_selected']==""){
                $link = "";
            }if(@$form->values['link_selected']=="ic"){
                $link = @$form->values['in_link'];
            }else if(@$form->values['link_selected']=="dis"){
                $link = @$form->values['dislink'];
            }
            if(@$_POST['galery_id']){
                $galeriidler= ",".@implode(",", @$_POST['galery_id']).",";
            }else {
                $galeriidler= "";
            }
            if(@$form->values['top_head_id']){
                $get_single_head = $model->get_single(@$form->values['top_head_id']);
                if(@$get_single_head){
                    if($get_single_head[0]["main_head"]){
                        $main_head = $get_single_head[0]["main_head"];
                    }else{
                        $main_head = $get_single_head[0]["id"];
                    }
                }else{
                    $main_head = 0;
                }
            }else{
                $main_head = 0;
            }
            $data= array(
                "top_head_id" => @$form->values['top_head_id'],
                "image" => @$yeni_ad,
                "main_head" => @$main_head,
                "ranks" => $headlinesSayisi+1,
                "bottom_status" => 1,
                "link" =>  $link,
                "inlink_type" => @$form->values['inlink_type'],
                "link_opening" => @$form->values['link_opening'],
                "link_selected" => @$form->values['link_selected'],
                "ek" => @$form->values['ek'],
                "updated_at" => $degisiklikTarihi
            );
            $data['form_id'] = @$form->values['form_id'];
            $data['galery_id'] = $galeriidler;
            $data['slide_id'] = @$form->values['slide_id'];
            $data['popup_id'] = @$form->values['popup_id'];
            if(@$form->values["status"]){
                $data["status"] = $form->values["status"];
            }elseif(@$form->values["status"]==0) {
                $data["status"] = 0;
            }else{
                $data["status"] = 1;
            }

            if($posttype=="add"){
                $data_lang["head_id"] = $model->add($data);
                $response["post_type"] = "add";
            }else if($posttype=="edit"){
                $data["head_id"] = @$form->values["b_id"];
                $data_lang["head_id"] = @$form->values["b_id"];
                $response["post_type"] = "edit";
                $model->edit($data);
            }

            foreach ($dilsayisi as $index => $item) {
                $lang = "_".$item["ranks"];

                if(@$form->values['seflink']==""){
                    $seflink = @$form->seo(@$form->values['title'.$lang]);
                }else{
                    $seflink = @$form->seo(@$form->values['seflink'.$lang]);
                }
                if(!empty(@$form->values['title'.$lang])){
                    $title = @$form->values['title'.$lang];
                }else{
                    $title = @$form->values['title'.$lang];
                }
                if(!empty(@$form->values['description'.$lang])){
                    $description = @$form->values['description'.$lang];
                }else{
                    $description = @$form->values['title'.$lang];
                }
                if(!empty(@$form->values['keywords'.$lang])){
                    $keywords = @$form->values['keywords'.$lang];
                }else{
                    $keywords = @$form->values['title'.$lang];
                }
                $sefkontrol = $this->kontrol($seflink)["status"];

                $data_lang['lang'] = $item["ranks"];
                $data_lang['title'] = @$title;
                $data_lang['description'] = @$description;
                $data_lang['keywords'] = @$keywords;
                $data_lang['content'] = @$form->values['content'.$lang];
                $data_lang['ek_description'] = @$form->values['ek_description'.$lang];

                if($this->kontrol($seflink)["id"]==@$form->values["b_id"] || $sefkontrol==false){
                    $data_lang['seflink'] = $seflink;
                }else if($sefkontrol==true){
                    $seflinkeki = "-".strtotime("now").substr((string)microtime(), 1, 6);
                    $data_lang['seflink'] = $seflink.$seflinkeki;
                }

                if($posttype=="add"){
                    $model->add_lang($data_lang);
                    $response["get_table"] = true;
                }else if($posttype=="edit"){
                    $model->edit_lang($data_lang);
                    $response["get_table"] = false;
                }
            }


            $response["message"] = "Successful";
            $response["status"] = true;
            $response["post_type"] = $posttype;
            $response["content"] = $POST;
            $response["files"] = $_FILES;
            $response["data"] = $data;
            $response["data_lang"] = $data_lang;
            if(!empty($resim)){
                $response["yeniResim"] = $yeni_ad;
            }
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["content"] = $_POST;
            $response["files"] = $_FILES;
        }
        return $response;
    }
    public function change_status(){
        $form = $this->newform;
        $model = $this->newmodel;
        if (@$_POST){
            $id = $_POST["id"];
            $type = @$_POST["type"];
            if($type=="sub_status"){
                $get_single = $model->get_single($id);
                $status = $model->change_sub_status($id,$get_single[0]["bottom_status"]);
                $response["status"] = $status;
            }elseif($type=="first_sub_status"){
                $get_single = $model->get_single($id);
                $status = $model->change_first_sub_status($id,$get_single[0]["first_bottom_head"]);
                $response["status"] = $status;
            }else{
                $get_single = $model->get_single($id);
                $status = $model->change_status($id,$get_single[0]["status"]);
                $response["status"] = $status;
            }

            echo json_encode($response);
        }
    }
    public function delete($id=null)
    {
        $form = $this->newform;
        $model = $this->newmodel;
        if (@$_POST) {
            $id = $_POST["id"];
            $model->delete($id);
            $response["message"] ="Successful";
            $response["status"] =true;
            echo json_encode($response);
        }
    }
    public function islemler($data,$sub_headers){
        ob_start();
        $data["sub_headers"] = $sub_headers;
        $this->view->render("headlines/list_actions",$data,"1");

        $renderView = ob_get_clean();
        return $renderView;
    }
    public function nestable_items($ustid=null){
        $array = [];
        if($ustid==""){$ustid = 0;}
        $headlines_sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE b.lang = ".DEFAULT_LANG." ";
        if($ustid!=''){
            $headlines_sql.=" and a.top_head_id = :top_head_id ";
            $array = array(":top_head_id"=>$ustid);
        }
        $headlines_sql.= " order by a.ranks ASC";

        $headlines_sorgu =  $this->actions->sqlSorgu($headlines_sql,$array);
        ?>
        <?php foreach ($headlines_sorgu as $key => $value) {
            if (!in_array($value["id"],$this->nestable_items_array)) {
                $this->nestable_items_array[] = $value["id"];
                $alt_headlines_varmi = $this->actions->sqlSorgu("SELECT * FROM " . PREFIX . "headlines WHERE  top_head_id = :top_head_id ", array(":top_head_id" => $value['head_id']));
                if (count($alt_headlines_varmi) > 0) {
                    $altvar = "1";
                }
                ?>
                <li class="dd-item dd3-item " id="tableline-<?php echo $value["head_id"];?>" data-id="<?= $value['head_id'] ?>">
                    <div class="dd-handle dd3-handle"><i class="fa fa-arrows"></i></div>
                    <div class="dd3-content" <?php if($value["status"]!=1){?>style="background: #96d6e4;
  background: -webkit-linear-gradient(top, #96d6e4 0%, #eee 100%);
  background:    -moz-linear-gradient(top, #96d6e4 0%, #eee 100%);
  background:         linear-gradient(top, #96d6e4 0%, #eee 100%);"<?php }?>>

                        <?php echo $value['title']; ?>
                        <?php if($value["status"]!=1){?> <span class="label label-primary">passive</span> <?php }?>
                        <?php echo $this->islemler($value, @$altvar); ?>
                    </div>
                    <?php if (count($alt_headlines_varmi) > 0) { ?>
                        <ol class="dd-list">
                            <?= $this->nestable_items(@$value['head_id']); ?>
                        </ol>
                    <?php } ?>
                </li>
                <?php $altvar = ""; ?>
            <?php }
        }
    }
    public function add_plugins_islemler($value){
        ob_start();
        ?>
        <div class="btn-group pull-right">
            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-<?php echo $value["id"];?>">Actions <span class="caret"></span> </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0)" onclick="item_delete('<?php echo CONTROLLER;?>/plugin_delete','<?php echo $value["id"];?>')" class="dropdown-item"> <span class="fa fa-trash"> </span> Delete</a>
                </li>
            </ul>
        </div>
        <?php
        $renderView = ob_get_clean();
        return $renderView;
    }
    public function nestable_items_for_plugins($ustid=null){
        if($ustid==""){$ustid = 0;}
        $headlines_sorgu =  $this->actions->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_plugins b ON a.id = b.head_id WHERE b.head_id = :head_id order by b.ranks ASC",array(":head_id"=>$ustid));
        foreach ($headlines_sorgu as $key => $value) {
            if (!in_array($value["id"],$this->nestable_items_for_plugins_array)) {
                $json = json_decode($value['json'],true);?>
                <li class="dd-item dd3-item " id="tableline-<?php echo $value["id"];?>" data-id="<?= $value['id'] ?>"
                    id="head_id_<?= $value['head_id'] ?>">
                    <!--<div class="dd-handle dd3-handle"><i class="fa fa-arrows"></i></div>-->
                    <div class="dd3-content">rank = (<?php echo $value["ranks"];?>) / <?php echo (str_replace(".tpl", "", $value["tpl_path"]));?>
                        <?php echo $this->add_plugins_islemler($value); ?>
                    </div>
                </li>
                <?php $altvar = ""; ?>
            <?php }
        }
    }
    public function add_plugins() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data["title"] = "Add";
            $data["page_type"] = "add";
            $data["id"] = $form->values["id"];

            $data["modul"] = $model->headlineslar_join($data["id"]);
            $data["headlineslar"] = $model->main_headList();
            $data["plugins_folders"] = $this->plugins_folders();


            ob_start();
            $this->nestable_items_for_plugins($data["id"]);
            $renderView = ob_get_clean();
            $data["nestable_items_for_plugins"] = $renderView;

            ob_start();
            $this->view->render("headlines/modal_plugins",$data,"1");
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
    public function plugins_form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            if(@$form->values["status"]){
                $data["status"] = $form->values["status"];
            }else{
                $data["status"] = 1;
            }

            $bottom_headlar = $model->alt_headlineslar_single($form->values['head_id']);
            $modulTek = $model->modulTek($form->values['head_id']);

            $data['head_id'] = $form->values['head_id'];
            $data['tpl_path'] = $form->values['tpl_path'];
            $data['folder'] = $form->values['folder'];
            $data['ranks'] = count($modulTek) +1;
            $data['common_plugin'] = $form->values['altauygula'];

            if($posttype=="add"){
                $model->add_plugins($data);
                if($form->values['altauygula']==1){
                    foreach ($bottom_headlar as $key => $value) {
                        $data_alt['head_id'] = $value['head_id'];
                        $data_alt['tpl_path'] = $form->values['tpl_path'];
                        $data_alt['folder'] = $form->values['folder'];
                        $data_alt['ranks'] = 0;
                        $data_alt['common_plugin'] = $form->values['altauygula'];
                        $model->add_plugins($data_alt);
                    }
                }
            }else if($posttype=="edit"){
                $model->edit_plugins($data);
            }
            $response["get_table"] = true;
            $response["message"] = "Successful";
            $response["status"] = true;
            $response["content"] = $_POST;
            $response["files"] = $_FILES;
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["content"] = $_POST;
            $response["files"] = $_FILES;
        }
        return $response;
    }
    public function plugins_folders(){
        ob_start();
        $folder_adi = "anasayfa";
        $veri_yolu = "moduller/".$folder_adi;
        $folder_yolu = FRONTEND_PLUGINS_ROAD.$folder_adi;
        $dir = FRONTEND_PLUGINS_ROAD;
        if(is_dir($dir)){
            if($handle = opendir($dir)){
                while(($file = readdir($handle)) !== false){
                    if($file != "." && $file != ".." && !strpos($file, ".tpl") && !strpos($file, ".html") && $file != "Thumbs.db"/*Bazı sinir bozucu windows dosyaları.*/)
                    {
                        $file_adi = ucwords($file);?>
                        <option value="<?php echo $file;?>" ><?php echo $file_adi;?></option>
                    <?php
                    }
                }
                closedir($handle);
            }
        }
        $renderView = ob_get_clean();
        return $renderView;
    }
    public function plugins_files(){
        $folder_yolu = FRONTEND_PLUGINS_ROAD;
        $folder_adi = $_REQUEST['id'];
//        echo $folder_yolu.$folder_adi;
        ?>
        <option value="">Dosya seçin</option>
        <?php
        $dirr = opendir($folder_yolu.$folder_adi);
        while (($dosya = readdir($dirr)) !== false)
        {
            if(! is_dir($dosya) && strstr($dosya, ".tpl")){
                $dosya_adi = ucwords(str_replace(".tpl","",$dosya));
                ?>
                <option value="<?php echo $dosya;?>"><?php echo $dosya_adi;?></option>
            <?php }

        }
        closedir($dirr);
    }

    public function plugin_delete(){
        $form = $this->newform;
        $model = $this->newmodel;
        if (@$_POST) {
            $id = $_POST["id"];
            $model->plugin_delete($id);
            $response["message"] ="Successful";
            $response["status"] =true;
            $response["get_table"] =true;
            echo json_encode($response);
        }
    }
    public function in_links(){
        $sekil = @$_POST["sekil"];
        $secili = @$_POST["secili"];
        ?>
        <option value="">Seçim Yapınız</option>
        <?php
        if($sekil=="headlines"){
            $this->actions->headlinesAgaci("0","","0",$secili);
        }else if($sekil=="headlines"){
            $this->actions->headlinesAgaci("0","","0",$secili);
        }else if($sekil=="haber"){
            $this->actions->makaleAgaci($secili);
        }else if($sekil=="urun"){
            $this->actions->urunAgaci($secili);
        }
    }
    public function rankkaydet(){
        $model = $this->newmodel;
        $rank_liste = @$_REQUEST['rank_liste'];
        $rank_liste = json_decode($rank_liste);
        $veriler = $this->ranklari_ayarla(array("rank_liste"=>$rank_liste,"gelen_rank"=>-1,"top_head_id"=>"0"));
        foreach ($veriler as $position => $item){
            if($item['id']!='') {
                if(@$item['top_head_id']){
                    $get_single_head = $model->get_single(@$item['top_head_id']);
                    if(@$get_single_head){
                        if($get_single_head[0]["main_head"]){
                            $main_head = $get_single_head[0]["main_head"];
                        }else{
                            $main_head = $get_single_head[0]["id"];
                        }
                    }else{
                        $main_head = 0;
                    }
                }else{
                    $main_head = 0;
                }
                $sonuc = $model->rank_kaydet(array(
                    "id" => $item['id'],
                    "top_head_id" => $item['top_head_id'],
                    "main_head" => @$main_head,
                    "ranks" => $position
                ));
                //  echo $item['id']."=>".$position." // ";
            }
        }
        if($sonuc){
            echo'1';
        }else{
            echo '2';
        }
    }
    public function ranklari_ayarla($veriler=null){
        $rank_liste = @$veriler['rank_liste'];
        $ranklar    = @$veriler['ranklar'];
        $gelen_rank = @$veriler['gelen_rank'];
        $ustid      = @$veriler['top_head_id'];
        foreach ($rank_liste as $position => $item)
        {
            $gelen_rank ++;
            $ranklar[] =  array("id"=>$item->id,"top_head_id"=>$ustid,"ranks"=>$gelen_rank);
            if(!empty($item->children)){
                $ranklar =  $this->ranklari_ayarla(array("ranklar"=>$ranklar,"rank_liste"=>$item->children,"gelen_rank"=>$gelen_rank,"top_head_id"=>$item->id));
                $gelen_rank = $gelen_rank + count($item->children);
            }
        }
        return $ranklar;
    }
    public function kontrol($seflink){
        $headlines = $this->actions->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE a.status= :status and b.seflink = :seflink  order by a.id ASC",array(":status"=>1,":seflink"=>$seflink));
        $products = $this->actions->sqlSorgu("SELECT * FROM ".PREFIX."products a JOIN ".PREFIX."products_langs b ON a.id = b.head_id WHERE a.status= :status and b.seflink = :seflink  order by a.id ASC",array(":status"=>1,":seflink"=>$seflink));
        $posts = $this->actions->sqlSorgu("SELECT * FROM ".PREFIX."posts a JOIN ".PREFIX."posts_langs b ON a.id = b.head_id WHERE a.status= :status and b.seflink = :seflink order by a.id ASC",array(":status"=>1,":seflink"=>$seflink));

        if(count($headlines)){
            return array("status"=>true,"id"=>$headlines[0]["head_id"]);
        }else if(count($products)){
            return array("status"=>true,"id"=>$products[0]["head_id"]);
        }else if(count($posts)){
            return array("status"=>true,"id"=>$posts[0]["head_id"]);
        }else{
            return false;
        }
    }

}
