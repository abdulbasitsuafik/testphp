<?php
class Rss extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);  
    }
    public function index(){
        date_default_timezone_set('Europe/Istanbul');
        $model = $this->load->model("index_model");
        $haber_liste = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id = b.makale_id order by b.makale_id ASC");
        $urun_liste = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun a JOIN ".PREFIX."urun_dil b ON a.id = b.urun_id order by a.id ASC");
        $ayar = $model->ayarList();
        $siteAdresi = SITE_URL;

        header('Content-type: application/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" version="2.0">';
        echo "<channel>\n";
        echo "<title>".$ayar[0]['title']."</title>\n";
        echo "<atom:link href='".$siteAdresi."rss/' rel='self' type='application/rss+xml'/>\n";
        echo "<link>".$siteAdresi."</link>\n";
        echo "<description>".$ayar['description']."</description>\n";
        echo "<lastBuildDate>Thu, 21 Aug 2017 00:37:50 +0200</lastBuildDate>\n";
        echo "<language>tr-TR</language>\n";
        echo "<sy:updatePeriod>hourly</sy:updatePeriod>\n";
        echo "<sy:updateFrequency>1</sy:updateFrequency>\n";
        echo "<generator>".$siteAdresi."</generator>\n";

        foreach ($haber_liste as $key => $value){
            $resimler = $this->sqlSorgu("SELECT * FROM ".PREFIX."resim WHERE makale_id= :makale_id",array(":makale_id"=>$value["makale_id"]));
            $link = $siteAdresi.$value["seflink"];
            $description = $value['description'];
            if(strlen($description)>150){$description = mb_substr($description,"0","150",UTF8)."[..]";}         

            $title=str_replace("&", " ve ", strip_tags($value["title"]));
            $spotbul=$value['description'];
            $uzunluk=strlen($spotbul);
            if($uzunluk>150){
                $spot=mb_substr($spotbul,0,150,"UTF-8").'..';
            }else{
                $spot=$spotbul;
            }
            if(!empty($value['manset_resmi'])){
                $resim=$siteAdresi.$value['manset_resmi'];
            }else{
                $resim=$siteAdresi."resimler/resimyok.jpg";
            }
            if(empty($resim)){$resim = "resimler/resimyok.jpg";}
            $pubDate = date("r", $value['pubDate']);
            echo'
<item>
<title>'.$title.'</title>
<link>'.$link.'</link>
<guid>'.$link.'</guid>';
            echo "<image>\n";
            echo "<title>". $title ."</title>\n";
            echo "<url>".$resim."</url>\n";
            echo "<link>".$link."</link>\n";
            echo "<width>300</width>\n";
            echo "<height>225</height>\n";
            echo "</image>\n";

            echo '
<description>
<![CDATA[
'.$spot.'
]]>
</description>
<pubDate>'.$pubDate.'</pubDate>
</item>';
        }
        foreach ($urun_liste as $key => $value){
            $link = $siteAdresi.$value["seflink"];
            $description = $value['description'];
            if(strlen($description)>150){$description = mb_substr($description,"0","150",UTF8)."[..]";}
            $resim = $value['urun_resmi'];            

            $title=str_replace("&", " ve ", strip_tags($value["title"]));
            $spotbul=$value['description'];
            $uzunluk=strlen($spotbul);
            if($uzunluk>150){
                $spot=mb_substr($spotbul,0,150,"UTF-8").'..';
            }else{
                $spot=$spotbul;
            }
            if(!empty($value['urun_resmi'])){
                $resim=$siteAdresi.$value['urun_resmi'];
            }else{
                $resim=$siteAdresi."resimler/resimyok.jpg";
            }
            if(empty($resim)){$resim = "resimler/resimyok.jpg";}
            $pubDate = date("r", $value['pubDate']);
            echo'
<item>
<title>'.$title.'</title>
<link>'.$link.'</link>
<guid>'.$link.'</guid>';
            echo "<image>\n";
            echo "<title>". $title ."</title>\n";
            echo "<url>".$resim."</url>\n";
            echo "<link>".$link."</link>\n";
            echo "<width>300</width>\n";
            echo "<height>225</height>\n";
            echo "</image>\n";

            echo '
<description>
<![CDATA[
'.$spot.'
]]>
</description>
<pubDate>'.$pubDate.'</pubDate>
</item>';
        }
        echo'</channel>
</rss>';
    }

}
