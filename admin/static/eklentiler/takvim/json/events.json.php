<?php
$db = new PDO("mysql:host=localhost;dbname=sinter_terasse;charset=utf8", "sinter_terasse", "807930Ege");

header('Content-type: text/json');
echo '[';
$separator = "";
$days = 16;

$etkinlikcek = $db->query("SELECT * FROM tlg_rezervasyon where onay=1 order by id ASC", PDO::FETCH_ASSOC);
     foreach( $etkinlikcek as $etkinlikyaz ){ 
    $detaycek=$db->prepare("SELECT * FROM tlg_odadil INNER JOIN tlg_oda ON tlg_oda.id = tlg_odadil.makale_id where tlg_odadil.lang='1' and tlg_oda.id='{$etkinlikyaz["oda"]}'");
    $detaycek->execute();
    $detay = $detaycek -> fetch(); 
$giris = $etkinlikyaz["giris"];
$cikis = $etkinlikyaz["cikis"];

$toplam = $cikis - $giris;
$toplamgun = date("d",$toplam);

    for ($index = 0; $index < $toplamgun; $index++) {
        $girisstamp = $giris * 1000;
        if($index == 0){
            echo '	{ "date": "'; echo $girisstamp;  echo '", "type": "meeting", "title": "'; echo $etkinlikyaz["adi"]." ".$etkinlikyaz["soyadi"]." | Oda : ".$detay["title"]; echo "<br>"; echo '", "description": "'; echo "Giriş Çıkış Tarihi: <strong>".date("d-m-Y", $etkinlikyaz["giris"])." | ".date("d-m-Y", $etkinlikyaz["cikis"])."</strong>";  echo '", "url": "'; echo "/pnl/form/rezervasyonoku/" . $etkinlikyaz["id"] ; echo '" },';
        }else{
            $eklenecek = ($index + 1) * 43200 * 1000;
            echo '	{ "date": "'; echo $girisstamp + $eklenecek;  echo '", "type": "meeting", "title": "'; echo $etkinlikyaz["adi"]." ".$etkinlikyaz["soyadi"]." | Oda : ".$detay["title"]; echo "<br>"; echo '", "description": "'; echo "Giriş Çıkış Tarihi: <strong>".date("d-m-Y", $etkinlikyaz["giris"])." | ".date("d-m-Y", $etkinlikyaz["cikis"])."</strong>";  echo '", "url": "'; echo "/pnl/form/rezervasyonoku/" . $etkinlikyaz["id"] ; echo '" },';
   
        }
    }
}
	
for ($i = 1 ; $i < $days; $i= 1 + $i * 2) {
	echo $separator;
	$initTime = 0;

	echo '	{ "date": "'; echo $initTime-7200000; echo '", "type": "meeting", "title": "Deneme1 '; echo $i; echo ' Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event3.com/" },';
	
	echo '	{ "date": "'; echo $initTime+10800000-2592000000; echo '", "type": "test", "title": "A very very long name for a f*cking project '; echo $i; echo ' events", "description": "description", "url": "http://www.event11.com/" }';
	$separator = ",";
}
echo ']';
?>