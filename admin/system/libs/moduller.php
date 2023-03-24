<?php
//session_start();
$rota = array(
    "moduller"=>array(
        array(
          "adi" => "Başlıklar Veritabanı",
          "id" => "0",
          "table" => PREFIX."headlines",
          "table_resim" => PREFIX."headlines_resim",
          "table_video" => PREFIX."headlines_video",
          "table_dosya" => PREFIX."headlines_dosya",
          "join" => "head_id",
          "dil" => true,
          "ust" => "top_head_id"
        ),
        array(
          "adi" => "Haberler Veritabanı",
          "id" => "1",
          "table" => PREFIX."makale",
          "table_resim" => PREFIX."makale_resim",
          "table_video" => PREFIX."makale_video",
          "table_dosya" => PREFIX."makale_dosya",
          "join" => "makale_id",
          "dil" => true,
          "ust" => "head_ids"
        ),
        array(
            "adi" => "Galeri Veritabanı",
          "id" => "2",
          "table" => PREFIX."galeri",
          "table_resim" => PREFIX."galeri_resim",
          "table_video" => PREFIX."galeri_video",
          "table_dosya" => PREFIX."galer,_dosya",
          "join" => "galery_id",
          "dil" => true
        ),
        array(
            "adi" => "Kadrolar Veritabanı",
          "id" => "3",
          "table" => PREFIX."kisi",
          "join" => "kisi_id",
          "dil" => true,
          "ust" => "kadro_id"
        ),
        array(
            "adi" => "Ürünler Veritabanı",
          "id" => "4",
          "table" => PREFIX."urun",
          "table_resim" => PREFIX."urun_resim",
          "table_video" => PREFIX."urun_video",
          "table_dosya" => PREFIX."urun_dosya",
          "join" => "urun_id",
          "dil" => true,
          "ust" => "head_id"
        ),
        array(
            "adi" => "Referanslar Veritabanı",
          "id" => "5",
          "table" => PREFIX."referanslar",
          "join" => "id",
          "dil" => false
        ),
        array(
            "adi" => "Slaytlar Veritabanı",
          "id" => "6",
          "table" => PREFIX."slayt",
          "join" => "slide_id",
          "dil" => true,
          "ust" => "sayfa_no"
        ),
        array(
            "adi" => "SSS Veritabanı",
          "id" => "7",
          "table" => PREFIX."sss",
          "join" => "sss_id",
          "dil" => true
        ),
        array(
            "adi" => "Şube Veritabanı",
          "id" => "8",
          "table" => PREFIX."sube",
          "join" => "sube_id",
          "dil" => false
        ),
        array(
            "adi" => "Yazarlar Veritabanı",
          "id" => "9",
          "table" => PREFIX."yazarlar",
          "join" => "id",
          "dil" => false
        ),
        array(
            "adi" => "Yorumlar Veritabanı",
          "id" => "10",
          "table" => PREFIX."yorumlar",
          "join" => "id",
          "durum" => "1",
          "dil" => false
        ),
          
    )
);
$_SESSION['moduller'] = "";