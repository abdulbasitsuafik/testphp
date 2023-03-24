<?php
class Actions extends Controller{
    public function __construct() {
        parent::load();
        Session::init();
    }
    public function sqlSorgu($sql='',$array=''){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);
    }
    public function json_decode($json){
        return json_decode($json);
    }
    public function in_array($key,$array){
        if(in_array($key,$array)){
            return true;
        }else{
            return false;
        }
    }
    public function kisalt($data,$sayi){
        $form = $this->load->otherClasses("Form");
        if($data){ return $form->kisalt($data,$sayi); }
    }
    public function postcek($key){
        $form = $this->load->otherClasses("Form");
        $form->post($key);
        return $form->values[$key];
    }
    public function getcek($key){
        $form = $this->load->otherClasses("Form");
        $form->get($key);
        return $form->values[$key];
    }
    public function resimcek($resim,$w,$h,$zc=null,$q=null){
        if(file_exists("../".$resim)){
            $resim_yeni =  SITE_URL."".$resim;
            if($w!='')$resim_yeni.="/w".$w;
            if($h!='')$resim_yeni.="/h".$h;
            if($zc!='')$resim_yeni.="/zc".$zc;
            if($q!='')$resim_yeni.="/q".$q;
            return $resim_yeni;
        }else{
            $resim_yeni =  SITE_URL."thumb/upload/resimyok.jpg";
            if($w!='')$resim_yeni.="/w".$w;
            if($h!='')$resim_yeni.="/h".$h;
            if($zc!='')$resim_yeni.="/zc".$zc;
            return $resim_yeni;
        }
    }
    public function video_resim_getir($video_kod){
        $youtubevideo =$video_kod;
        $videokalite = "mqdefault"; //maxresdefault, sddefault, hqdefault, default, 3, 2, 1, 0
        if($youtubevideo){
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubevideo, $match)) {
                $video_id = $match[1];
            }
        }
        return "http://img.youtube.com/vi/".$video_id."/".$videokalite.".jpg";
    }
    public function video_iframe_getir($video_kod,$width,$height){
        $youtubevideo =$video_kod;
        $videokalite = "mqdefault"; //maxresdefault, sddefault, hqdefault, default, 3, 2, 1, 0
        if($youtubevideo){
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubevideo, $match)) {
                $video_id = $match[1];
            }
        }
        return '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
    }
    public function headlinesAgaci($ust_id=null,$head_id=null,$padding=null,$secili=null) {
        $headlines_sql = "SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by a.rank ASC";
        $headlines_sorgu =  $this->sqlSorgu($headlines_sql,array(":top_head_id"=>$head_id,":lang"=>1));?>
        <?php foreach ($headlines_sorgu as $key => $value){ ?>
            <option value="<?=$value["head_id"]?>" <?php if($value['head_id']==$secili){echo " selected ";} ?>  ><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $padding); echo $value["title"]; ?> </option>
            <?php $this->headlinesAgaci($value['top_head_id'],$value["head_id"],($padding+1), $secili); ?>
        <?php }
    }
    public function hotels($id = null){
        $return = $this->sqlSorgu("SELECT * from ".PREFIX."hotels WHERE id = :id",array(":id"=>$id));
        if ($return){
            return $return[0]["name"];
        }else{
            return $id;
        }

    }


}