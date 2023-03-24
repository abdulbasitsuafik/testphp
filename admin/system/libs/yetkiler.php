<?php
if (!session_id()) {
//    ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
//    ini_set('session.gc_probability', 1);
    session_start();
}
$yetkiler_tumu = array(
    "controller_listesi"=>array(
        array(
            "headlines"=>"Title Keywords Açıklama",
            "c_isim"=>"titleKeywords",
            "islemler"=>array(
                array("headlines"=>"Title Keywords Açıklama","m_isim"=>"/tumu"),
            )
        ),
        array(
            "headlines"=>"Başlıklar",
            "c_isim"=>"headlines",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),        
        array(
            "headlines"=>"Slaytlar",
            "c_isim"=>"slayt",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Haberler",
            "c_isim"=>"makale",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),        
        array(
            "headlines"=>"Ürünler",
            "c_isim"=>"urun",
            "islemler"=>array(
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Hizmetler",
            "c_isim"=>"hizmet",
            "islemler"=>array(
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Projeler",
            "c_isim"=>"proje",
            "islemler"=>array(
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"headlinesler",
            "c_isim"=>"headlines",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Reklamlar",
            "c_isim"=>"reklamlar",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
                array("headlines"=>"Açılır Pencere (Popup)","m_isim"=>"/popupekle"),
                array("headlines"=>"Reklam Grubu","m_isim"=>"/grupekle"),
                array("headlines"=>"Reklam Alanı","m_isim"=>"/alanekle"),
            )
        ),
        array(
            "headlines"=>"Site Ayarları",
            "c_isim"=>"ayar",
            "islemler"=>array(
                array("headlines"=>"Genel Ayarlar","m_isim"=>"/genel"),
                array("headlines"=>"Seo Ayarları","m_isim"=>"/seo"),
                array("headlines"=>"İletişim Bilgileri","m_isim"=>"/iletisim"),
                array("headlines"=>"Sosyal Medya Bilgileri","m_isim"=>"/sosyal"),
            )
        ),
        array(
            "headlines"=>"Galeri",
            "c_isim"=>"galeri",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"kadro",
            "c_isim"=>"kadro",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Referanslar",
            "c_isim"=>"referanslar",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Anketler",
            "c_isim"=>"anket",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),    
        array(
            "headlines"=>"Yorumlar",
            "c_isim"=>"yorumlar",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),  
        array(
            "headlines"=>"SSS",
            "c_isim"=>"sss",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Kullanıcılar",
            "c_isim"=>"kullanici",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Formlar",
            "c_isim"=>"formlar",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Etkinlik Takvimi",
            "c_isim"=>"etkinlik",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),               
        array(
            "headlines"=>"Rezervasyonlar",
            "c_isim"=>"rezervasyon",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Şubeler",
            "c_isim"=>"sube",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),
        array(
            "headlines"=>"Değişenler",
            "c_isim"=>"degisen",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),        
        array(
            "headlines"=>"Gösterge Tablosu",
            "c_isim"=>"panel",
            "islemler"=>array(
                array("headlines"=>"İstatistikler","m_isim"=>"/anasayfa")
            )
        ),
        array(
            "headlines"=>"Yazarlar",
            "c_isim"=>"yazarlar",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
                array("headlines"=>"Yazı Ekle","m_isim"=>"/yaziekle"),
                array("headlines"=>"Yazı Listele","m_isim"=>"/yazilistele"),
            )
        ),               
        array(
            "headlines"=>"E-Gazeteler",
            "c_isim"=>"egazete",
            "islemler"=>array(
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ), 
        array(
            "headlines"=>"Evlenenler",
            "c_isim"=>"evlenen",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ), 
        array(
            "headlines"=>"Vefat Edenler",
            "c_isim"=>"vefateden",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ), 
        array(
            "headlines"=>"Marka",
            "c_isim"=>"marka",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),  
        array(
            "headlines"=>"Model",
            "c_isim"=>"modell",
            "islemler"=>array(
                array("headlines"=>"Listele","m_isim"=>"/liste"),
                array("headlines"=>"Ekle","m_isim"=>"/ekle"),
                array("headlines"=>"Düzenle","m_isim"=>"/duzenle"),
                array("headlines"=>"Sil","m_isim"=>"/sil"),
            )
        ),       
    )
);
$_SESSION['yetki_listesi'] = "";