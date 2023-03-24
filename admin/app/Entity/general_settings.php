<?php
/**
* @Entity
* @Table(name="general_settings", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class general_settings{
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;
    /** @Column(type="string",  nullable=true) */
    protected $izin_tipi;
    /** @Column(type="integer",  nullable=true) */
    protected $tema;
    /** @Column(type="integer",  nullable=true) */
    protected $yayin_durumu;
    /** @Column(type="text",  nullable=true) */
    protected $analytics;
    /** @Column(type="string",  nullable=true) */
    protected $facebook;
    /** @Column(type="string",  nullable=true) */
    protected $twitter;
    /** @Column(type="string",  nullable=true) */
    protected $whatsapp;
    /** @Column(type="string",  nullable=true) */
    protected $googleplus;
    /** @Column(type="string",  nullable=true) */
    protected $linkedin;
    /** @Column(type="string",  nullable=true) */
    protected $pinterest;
    /** @Column(type="string",  nullable=true) */
    protected $skype;
    /** @Column(type="string",  nullable=true) */
    protected $youtube;
    /** @Column(type="string",  nullable=true) */
    protected $instagram;
    /** @Column(type="text",  nullable=true) */
    protected $adres1;
    /** @Column(type="text",  nullable=true) */
    protected $adres2;
    /** @Column(type="text",  nullable=true) */
    protected $adres3;
    /** @Column(type="string",  nullable=true) */
    protected $email;
    /** @Column(type="string",  nullable=true) */
    protected $telefon;
    /** @Column(type="string",  nullable=true) */
    protected $fax;
    /** @Column(type="string",  nullable=true) */
    protected $gsm;
    /** @Column(type="string",  nullable=true) */
    protected $latitude;
    /** @Column(type="string",  nullable=true) */
    protected $langitude;
    /** @Column(type="string",  nullable=true) */
    protected $logo;
    /** @Column(type="string",  nullable=true) */
    protected $footer_logo;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_secim;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_konum;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi_bg;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi_renk;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi_width;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi_height;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi_font;
    /** @Column(type="string",  nullable=true) */
    protected $telif_resmi_yazi_font_size;
    /** @Column(type="string",  nullable=true) */
    protected $favicon;
    /** @Column(type="string",  nullable=true) */
    protected $route;
    /** @Column(type="string",  nullable=true) */
    protected $telif;
    /** @Column(type="text",  nullable=true) */
    protected $harita;
    /** @Column(type="text",  nullable=true) */
    protected $formmail_alicilar;
    /** @Column(type="string",  nullable=true) */
    protected $formmail_host;
    /** @Column(type="string",  nullable=true) */
    protected $formmail_mail;
    /** @Column(type="string",  nullable=true) */
    protected $formmail_sifre;
    /** @Column(type="string",  nullable=true) */
    protected $formmail_secure;
    /** @Column(type="string",  nullable=true) */
    protected $formmail_port;
    /** @Column(type="string",  nullable=true) */
    protected $telefon1;
    /** @Column(type="string",  nullable=true) */
    protected $telefon2;
    /** @Column(type="string",  nullable=true) */
    protected $telefon3;
    /** @Column(type="string",  nullable=true) */
    protected $telefon4;
    /** @Column(type="string",  nullable=true) */
    protected $telefon5;
    /** @Column(type="string",  nullable=true) */
    protected $mobil_telefon;
    /** @Column(type="string",  nullable=true) */
    protected $mobil_email;
    /** @Column(type="string",  nullable=true) */
    protected $mobil_harita;
    /** @Column(type="text",  nullable=true) */
    protected $aktif_menuler;
    /** @Column(type="string",  nullable=true) */
    protected $unvani;
    /** @Column(type="string",  nullable=true) */
    protected $ana_header;
    /** @Column(type="string",  nullable=true) */
    protected $ic_header;
    /** @Column(type="string",  nullable=true) */
    protected $footer;
    /** @Column(type="string",  nullable=true) */
    protected $haber_top_head_id;
    /** @Column(type="string",  nullable=true) */
    protected $updated_at;
    /** @Column(type="string",  nullable=true) */
    protected $cikti_tarihi;
    /** @Column(type="integer",  nullable=true) */
    protected $payment_method;
    /** @Column(type="string",  nullable=true) */
    protected $active_android_version;
    /** @Column(type="string",  nullable=true) */
    protected $active_ios_version;

}

//vendor/bin/doctrine orm:schema-tool:create
