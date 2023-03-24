{% extends 'base.tpl' %}
{% block main %}

{{ islem.altsayfa_kontrol(active_page_details,true) }}
{% include 'sayfalar/dahil/content_headlines.tpl' %}
{% set iller = islem.sqlSorgu("SELECT * FROM "~prefix~"iller order by headlines ASC") %}
<section class="content_section">
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-sm-6 col-xs-12">
                <form class="form1" id="girisyap" method="post">
                	<h2>ZATEN ÜYEYİM</h2>
                    <div class="form-group">
                        <label for="formalan_name1">E-Mail <small>*</small></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-mail-3" aria-hidden="true"></i></span>
                            <input type="hidden" name="sonsayfa" value="{{referer}}">
                            <input type="email" autocomplete="off" name="username" placeholder="E-Mail Adresiniz" required="" class="form-control enter" aria-required="true">
                        </div>
                    </div>
                    <pre>
                    </pre>
                    <div class="form-group">
                        <label for="formalan_name1">Parola <small>*</small></label>
                        <div class="input-group">
							<span class="input-group-addon"><i class="icon-lock-8" aria-hidden="true"></i></span>
	                        <input type="password" autocomplete="off" name="password" placeholder="Parola" required="" class="form-control enter" aria-required="true">
                    	</div>
                    </div>
                    <div class="form-group">
                        <button type="button" autocomplete="off" required="" class="btn btn-inter girisbutton" aria-required="true" onclick="girisYap()">Giris Yap</button>
                    </div>
                </form>
                <div class="input-group">
                    <div class="checkbox_liste">
                        <label for="inputid_70"><span></span><a href="{{SITE_URL}}uyelik/unuttum">Şifremi unuttum</a></label>
                    </div>
                </div> 
                <a href="{{facebookLoginUrl}}"><img src="{{SITE_URL}}resimler/facebook_login.png" style="max-width: 215px;" alt="facebook"></a>
                <a href="{{googleLoginUrl}}"><img src="{{SITE_URL}}resimler/google_login.png" style="max-width: 215px;" alt="google"></a>
                
                <div class="col-xs-12 col-md-12"><div class="row"><div class="alert formAlert_11 alert-danger" role="alert" style="display: none;"></div></div></div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <form class="form1" method="post" id="uyeol">
                	<h2>ÜYE DEĞİLSENİZ</h2>
                    <div class="col-xs-12 col-md-12"><div class="row"><div class="alert formAlert_10" role="alert" style="display: none;"></div></div></div>
                    <div class="form-group">
                        <label for="formalan_name1" id="labelid_65">Adınız Soyadınız <small>*</small></label>
                        <div class="input-group">
                        	<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        	<input type="text" autocomplete="off" name="adi" id="inputid_65" placeholder="Adınız Soyadınız" required="required" class="form-control" aria-required="true">
                    	</div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_65" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formalan_name1" id="labelid_66">Email <small>*</small></label>
                        <div class="input-group">
                        	<span class="input-group-addon"><i class="icon-mail-3" aria-hidden="true"></i></span>
                        	<input type="email" autocomplete="off" name="email" id="inputid_66" placeholder="Email" required="required" class="form-control" aria-required="true">
                    	</div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_66" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formalan_name1" id="labelid_67">Telefon <small>*</small></label>
                        <div class="input-group">
                        	<span class="input-group-addon"><i class="icon-phone" aria-hidden="true"></i></span>
                        	<input type="text" id="inputid_67" required="required" placeholder="Telefon" class="form-control" data-inputmask='"mask": "0(999) 999-9999"' data-mask>
						</div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_67" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formalan_name1" id="labelid_76">Hangi ilde Yaşıyorsunuz? <small>*</small></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe" aria-hidden="true"></i></span>
                            <select name="il" class="form-control selectpicker" data-live-search="true" title="Lütfen Seçiniz...">
                                <option value="">Seçim Yapınız</option>
                                {% for value in iller %}
                                <option value="{{value.id}}">{{value.headlines}}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_76" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formalan_name1" id="labelid_68">Parola <small>*</small></label>
                        <div class="input-group">
                        	<span class="input-group-addon"><i class="icon-lock-8" aria-hidden="true"></i></span>
                        	<input type="password" autocomplete="off" name="parola" id="inputid_68" placeholder="Parola" required="required" class="form-control" aria-required="true">
						</div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_68" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formalan_name1" id="labelid_69">Parola Tekrar<small>*</small></label>
                        <div class="input-group">
                        	<span class="input-group-addon"><i class="icon-lock-8" aria-hidden="true"></i></span>
                        	<input type="password" autocomplete="off" name="parola_tekrar" id="inputid_69" placeholder="Parola" required="required" class="form-control" aria-required="true">
                    	</div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_69" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                             <div class="guvenlik_resim" id="guvenlikResim">
                                 <img src="{{SITE_URL}}genel/guvenlikGuncelle/000/000" class="guvenlikResim" alt="güvenlik" />
                             </div>
                             <div class="guvenlik_input">
                                 <input type="hidden" name="alan_renk" value="000">
                                 <input type="hidden" name="alan_guvenlik_renk" value="000">
                                 <input type="text" class="form-control" required="required" name="guvenlik_kodu" placeholder="Güvenlik Kodu">
                             </div> 
                     </div>
                    <div class="form-group">
                    	<div class="input-group">
                    		<div class="checkbox_liste">
                    			<input type="checkbox" id="inputid_70" name="onayladim" required="required" value="1"> 
                    			<label for="inputid_70"><span></span><a href="javascript:void(0)" data-toggle="modal" data-target="#uyelikSozlesmesi">Üyelik sözleşmesi</a><b>'ni okudum kabul ediyorum.</b></label>
                    		</div>
                    	</div>                        
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="row">
                                <span class="help-block" id="uyariid_70" style="position: absolute;"></span>    
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        
                        <button type="button" id="submit_10" autocomplete="off" class="btn btn-inter" onclick="uyeOl()">Kayıt Ol</button>
                    </div>
                </form>
                <div class="col-xs-12 col-md-12"><div class="row"><div class="alert formAlert_10" role="alert" style="display: none;"></div></div></div>
                <script>    
                    $(".enter").keypress(function(e){
                      if(e.which == "13"){
                        $(".girisbutton").trigger("click");
                      }
                    });    
                    function uyeOl(){
                        var form = $("#uyeol").serialize();
                        var formid = document.getElementById("uyeol");
                        var mecburiAlanlar = [];
                        var mecburiAlanlarid = [];
                        var tumalanlar = [];
                        var deger;
                            for(var i=0; i < formid.elements.length; i++){   
                              if(formid.elements[i].value === '' && formid.elements[i].hasAttribute('required')){
                                mecburiAlanlar.push(formid.elements[i].name); 
                              }
                              if(formid.elements[i].value === '' && formid.elements[i].hasAttribute('required')){
                                mecburiAlanlarid.push(formid.elements[i].id); 
                              }
                              tumalanlar.push(formid.elements[i].id); 
                            }
                            mecburiAlanlar.push("inputid_70");
                            mecburiAlanlarid.push("70");
                        $.ajax({
                            type: "POST",
                            url: "{{SITE_URL}}uyelik/uyeolrun",
                            data: form,
                            beforeSend: function( xhr ) {
                                $(".formAlert_10").css("display","block");
                                $(".formAlert_10").html("Kontrol ediliyor");
                                $(".formAlert_10").addClass("alert-danger");
                                $('.gonderilmedi').each(function(i, obj) {
                                    obj.classList.remove("gonderilmedi");
                                });
                            },
                            success: function(data) { 
                                try
                                {
                                   jsonData = JSON.parse(data);
                                   //console.log(jsonData);
                                   if(jsonData["status"]=="false"){
                                       document.getElementById("submit_10").disabled = false;
                                        $.each(mecburiAlanlarid, function( index, value ) {
                                            deger = value.replace("inputid_","");
                                            $("#inputid_"+deger).addClass("gonderilmedi");
                                            $("#labelid_"+deger).addClass("gonderilmedi");
                                            $("#uyariid_"+deger).css("display","block");
                                            $("#uyariid_"+deger).addClass("gonderilmedi");
                                            $("#uyariid_"+deger).html(jsonData["alanMesajı"]);                                      
                                        });
                                        $(".formAlert_10").addClass("alert-success");
                                        $(".formAlert_10").html(jsonData["genelMesaj"]);
                                        //document.getElementById("submit_"+id).disabled = false;
                                        if(typeof jsonData["yeniResim"]!="undefined" || jsonData["yeniResim"]!=null){
                                            $("#guvenlikResim").html(jsonData["yeniResim"]);
                                        }
                                    }else{
                                        $.each(tumalanlar, function( index, value ) {
                                            deger = value.replace("inputid_","");
                                            $("#inputid_"+deger).removeClass("gonderilmedi");
                                            $("#labelid_"+deger).removeClass("gonderilmedi");
                                            $("#uyariid_"+deger).removeClass("gonderilmedi");
                                            $("#uyariid_"+deger).html("");
                                            $("#uyariid_"+deger).css("display","block");
                                            $("#inputid_"+deger).addClass("gonderildi");
                                            $("#labelid_"+deger).addClass("gonderildi");
                                            $("#uyariid_"+deger).addClass("gonderildi");
                                            $("#uyariid_"+deger).html(jsonData["alanMesajı"]);                                      
                                        });
                                        $(".formAlert_10").addClass("alert-success");
                                        $(".formAlert_10").html(jsonData["genelMesaj"]);   
                                        if(typeof jsonData["yeniResim"]!="undefined" || jsonData["yeniResim"]!=null){
                                            $("#guvenlikResim").html(jsonData["yeniResim"]);
                                        }                               
                                        document.getElementById("submit_10").disabled = true;
                                    }
                                }
                                catch(e)
                                {
                                  //console.log(data);
                                } 
                            }
                        });
                    }
                    function girisYap(){
                        var form = $("#girisyap").serialize();
                        $.ajax({
                            type: "POST",
                            url: "{{SITE_URL}}uyelik/girisyap",
                            data: form,
                            success: function(data) {
                              var gelenData = JSON.parse(data);
                                console.log(gelenData);
                                $(".formAlert_11").css("display","block");
                                $(".formAlert_11").html(gelenData["mesaj"]);
                                if(gelenData["status"]=="true"){
                                    location.href = gelenData["link"];
                                }
                            }
                        });
                    }
                </script>
</div>

</div>
</div>
</section>

<div id="uyelikSozlesmesi" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-body">
<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><span style="font-size:x-large"><strong>&Uuml;YELİK S&Ouml;ZLEŞMESİ </strong></span></span></span></span></p>

<p><span style="font-family:Verdana,sans-serif"><strong>1. Taraflar </strong></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>a)</strong></span><span style="font-family:Verdana,sans-serif"> </span> <a href="http://www.intercheckup.com/"><span style="color:#0000ff"><span style="font-family:Verdana,sans-serif"><u>www.intercheckup.com</u></span></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesinin faaliyetlerini y&uuml;r&uuml;ten Sırakapılar mahallesi 493 sokak numara 4/f Merkezefendi/DENİZLİ adresinde mukim Densis Bilişim Teknolojileri ve Aracılık Hizmetleri (Bundan b&ouml;yle &ldquo;intercheckup&rdquo; olarak anılacaktır). </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>b)</strong></span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u> www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesine &uuml;ye olan internet kullanıcısı (&quot;&Uuml;ye&quot;) </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>2. S&ouml;zleşmenin Konusu </strong></span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif">İşbu S&ouml;zleşme&rsquo;nin konusu İntercheckup&rsquo;ın sahip olduğu internet sitesi</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">&lsquo;dan &uuml;yenin faydalanma şartlarının belirlenmesidir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3. Tarafların Hak ve Y&uuml;k&uuml;ml&uuml;l&uuml;kleri </strong></span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.1.</strong></span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">&Uuml;ye,</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesine &uuml;ye olurken verdiği kişisel ve diğer sair bilgilerin kanunlar &ouml;n&uuml;nde doğru olduğunu, İntercheckup&#39;ın bu bilgilerin ger&ccedil;eğe aykırılığı nedeniyle uğrayacağı t&uuml;m zararları aynen ve derhal tazmin edeceğini beyan ve taahh&uuml;t eder. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.2.</strong></span><span style="font-family:Verdana,sans-serif"> &Uuml;ye, İntercheckup tarafından kendisine verilmiş olan şifreyi başka kişi ya da kuruluşlara veremez, &uuml;yenin s&ouml;z konusu şifreyi kullanma hakkı bizzat kendisine aittir. Bu sebeple doğabilecek t&uuml;m sorumluluk ile &uuml;&ccedil;&uuml;nc&uuml; kişiler veya yetkili merciler tarafından İntercheckup&#39;a karşı ileri s&uuml;r&uuml;lebilecek t&uuml;m iddia ve taleplere karşı, İntercheckup&#39;ın s&ouml;z konusu izinsiz kullanımdan kaynaklanan her t&uuml;rl&uuml; tazminat ve sair talep hakkı saklıdır. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.3.</strong></span><span style="font-family:Verdana,sans-serif"> &Uuml;ye</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesini kullanırken yasal mevzuat h&uuml;k&uuml;mlerine riayet etmeyi ve bunları ihlal etmemeyi baştan kabul ve taahh&uuml;t eder. Aksi takdirde, doğacak t&uuml;m hukuki ve cezai y&uuml;k&uuml;ml&uuml;l&uuml;kler tamamen ve m&uuml;nhasıran &uuml;yeyi bağlayacaktır. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.4.</strong></span><span style="font-family:Verdana,sans-serif"> &Uuml;ye,</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesini hi&ccedil;bir şekilde kamu d&uuml;zenini bozucu, genel ahlaka aykırı, başkalarını rahatsız ve taciz edici şekilde, yasalara aykırı bir ama&ccedil; i&ccedil;in, başkalarının fikri ve telif haklarına tecav&uuml;z edecek şekilde kullanamaz. Ayrıca, &uuml;ye başkalarının hizmetleri kullanmasını &ouml;nleyici veya zorlaştırıcı faaliyet (spam, virus, truva atı, vb.) ve işlemlerde bulunamaz. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.5.</strong></span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u> www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesinde &uuml;yeler tarafından beyan edilen, yazılan, kullanılan fikir ve d&uuml;ş&uuml;nceler, tamamen &uuml;yelerin kendi kişisel g&ouml;r&uuml;şleridir ve g&ouml;r&uuml;ş sahibini bağlar. Bu g&ouml;r&uuml;ş ve d&uuml;ş&uuml;ncelerin İntercheckup&#39;la hi&ccedil;bir ilgi ve bağlantısı yoktur. İntercheckup&#39;ın &uuml;yenin beyan edeceği fikir ve g&ouml;r&uuml;şler nedeniyle &uuml;&ccedil;&uuml;nc&uuml; kişilerin uğrayabileceği zararlardan ve &uuml;&ccedil;&uuml;nc&uuml; kişilerin beyan edeceği fikir ve g&ouml;r&uuml;şler nedeniyle &uuml;yenin uğrayabileceği zararlardan dolayı herhangi bir sorumluluğu bulunmamaktadır. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.6.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup, &uuml;ye verilerinin yetkisiz kişilerce okunmasından ve &uuml;ye yazılım ve verilerine gelebilecek zararlardan dolayı sorumlu olmayacaktır. &Uuml;ye,</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesinin kullanılmasından dolayı uğrayabileceği herhangi bir zarar y&uuml;z&uuml;nden İntercheckup&#39;dan tazminat talep etmemeyi peşinen kabul etmiştir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.7.</strong></span><span style="font-family:Verdana,sans-serif"> &Uuml;ye, diğer internet kullanıcılarının yazılımlarına ve verilerine izinsiz olarak ulaşmamayı veya bunları kullanmamayı kabul etmiştir. Aksi takdirde, bundan doğacak hukuki ve cezai sorumluluklar tamamen &uuml;yeye aittir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.8.</strong></span><span style="font-family:Verdana,sans-serif"> İşbu &uuml;yelik s&ouml;zleşmesi i&ccedil;erisinde sayılan maddelerden bir ya da birka&ccedil;ını ihlal eden &uuml;ye işbu ihlal nedeniyle cezai ve hukuki olarak şahsen sorumlu olup, İntercheckup&rsquo;ı bu ihlallerin hukuki ve cezai sonu&ccedil;larından ari tutacaktır. Ayrıca; işbu ihlal nedeniyle, olayın hukuk alanına intikal ettirilmesi halinde, İntercheckup&#39; ın &uuml;yeye karşı &uuml;yelik s&ouml;zleşmesine uyulmamasından dolayı tazminat talebinde bulunma hakkı saklıdır. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.9.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup&#39;ın her zaman tek taraflı olarak gerektiğinde &uuml;yenin &uuml;yeliğini silme, m&uuml;şteriye ait dosya, belge ve bilgileri silme hakkı vardır. &Uuml;ye işbu tasarrufu &ouml;nceden kabul eder. Bu durumda, İntercheckup&#39;ın hi&ccedil;bir sorumluluğu yoktur. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.10.</strong></span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u> www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesi yazılım ve tasarımı İntercheckup m&uuml;lkiyetinde olup, bunlara ilişkin telif hakkı ve/veya diğer fikri m&uuml;lkiyet hakları ilgili kanunlarca korunmakta olup, bunlar</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">&uuml;ye tarafından izinsiz kullanılamaz, iktisap edilemez ve değiştirilemez. Bu web sitesinde adı ge&ccedil;en başkaca şirketler ve &uuml;r&uuml;nleri sahiplerinin ticari markalarıdır ve ayrıca fikri m&uuml;lkiyet hakları kapsamında korunmaktadır. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.11.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup tarafından</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesinin iyileştirilmesi, geliştirilmesine y&ouml;nelik olarak ve/veya yasal mevzuat &ccedil;er&ccedil;evesinde siteye erişmek i&ccedil;in kullanılan İnternet servis sağlayıcısının adı ve Internet Protokol (IP) adresi, Siteye erişilen tarih ve saat, sitede bulunulan sırada erişilen sayfalar ve siteye doğrudan bağlanılmasını sağlayan Web sitesinin Internet adresi gibi birtakım bilgiler toplanabilir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.12.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup kullanıcılarına daha iyi hizmet sunmak, &uuml;r&uuml;nlerini ve hizmetlerini iyileştirmek, sitenin kullanımını kolaylaştırmak i&ccedil;in kullanımını kullanıcılarının &ouml;zel tercihlerine ve ilgi alanlarına y&ouml;nelik &ccedil;alışmalarda &uuml;yelerin kişisel bilgilerini kullanabilir. İntercheckup, &uuml;yenin</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><a href="http://www.hepsiburada.com/" target="_blank"><span style="color:#0000ff"><u>www.intercheckup.com </u></span></a><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">internet sitesi &uuml;zerinde yaptığı hareketlerin kaydını bulundurma hakkını saklı tutar. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.13.</strong></span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">İntercheckup&rsquo;a</span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">&uuml;ye olan kişi, y&uuml;r&uuml;rl&uuml;kte bulunan ve/veya y&uuml;r&uuml;rl&uuml;ğe alınacak uygulamalar kapsamında İntercheckup ve Densis Bilişim Teknolojileri(DENSİS) iştiraki olan t&uuml;m şirketler tarafından kendisine &uuml;r&uuml;n ve hizmet tanıtımları, reklamlar, kampanyalar, avantajlar, anketler ve diğer m&uuml;şteri memnuniyeti uygulamaları sunulmasına izin verdiğini beyan ve kabul eder. &Uuml;ye, İntercheckup&rsquo;ya &uuml;ye olurken ve/veya başka yollarla ge&ccedil;mişte vermiş olduğu ve/veya gelecekte vereceği kişisel ve alışveriş bilgilerinin ve alışveriş ve/veya t&uuml;ketici davranış bilgilerinin yukarıdaki ama&ccedil;larla toplanmasına, DENSİS iştiraki olan t&uuml;m şirketler ile paylaşılmasına, İntercheckup ve DENSİS iştiraki olan t&uuml;m şirketler tarafından kullanılmasına ve arşivlenmesine izin verdiğini beyan ve kabul eder. &Uuml;ye aksini bildirmediği s&uuml;rece &uuml;yeliği sona erdiğinde de verilerin toplanmasına, DENSİS iştiraki olan t&uuml;m şirketler ile paylaşılmasına, İntercheckup ve DENSİS iştiraki olan t&uuml;m şirketler tarafından kullanılmasına ve arşivlenmesine izin verdiğini beyan ve kabul eder. &Uuml;ye aksini bildirmediği s&uuml;rece İntercheckup ve DENSİS iştiraki olan t&uuml;m şirketlerin kendisi ile internet, telefon, SMS, vb iletişim kanalları kullanarak irtibata ge&ccedil;mesine izin verdiğini beyan ve kabul eder. &Uuml;ye yukarıda bahsi ge&ccedil;en bilgilerin toplanması, paylaşılması, kullanılması, arşivlenmesi ve kendisine erişilmesi nedeniyle doğrudan ve/veya dolaylı maddi ve/veya manevi menfi ve/veya m&uuml;sbet, velhasıl herhangi bir zarara uğradığı konusunda talepte bulunmayacağını ve İntercheckup ve DENSİS iştiraki olan şirketleri sorumlu tutmayacağını beyan ve kabul eder. &Uuml;ye veri paylaşım tercihlerini değiştirmek isterse, bu talebini İntercheckup&rsquo;ın m&uuml;şteri hizmetleri &ccedil;ağrı merkezlerine iletebilir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.14.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup, &uuml;yenin kişisel bilgilerini yasal bir zorunluluk olarak istendiğinde veya (a) yasal gereklere uygun hareket etmek veya İntercheckup&rsquo;a tebliğ edilen yasal işlemlere uymak; (b) İntercheckup ve İntercheckup web sitesi ailesinin haklarını ve m&uuml;lkiyetini korumak ve savunmak i&ccedil;in gerekli olduğuna iyi niyetle kanaat getirdiği hallerde a&ccedil;ıklayabilir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.15.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup web sitesinin virus ve benzeri ama&ccedil;lı yazılımlardan arındırılmış olması i&ccedil;in mevcut imkanlar dahilinde tedbir alınmıştır. Bunun yanında nihai g&uuml;venliğin sağlanması i&ccedil;in kullanıcının, kendi virus koruma sistemini tedarik etmesi ve gerekli korunmayı sağlaması gerekmektedir. Bu bağlamda &uuml;ye İntercheckup web sitesi&#39;ne girmesiyle, kendi yazılım ve işletim sistemlerinde oluşabilecek t&uuml;m hata ve bunların doğrudan ya da dolaylı sonu&ccedil;larından kendisinin sorumlu olduğunu kabul etmiş sayılır. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.16.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup, sitenin i&ccedil;eriğini dilediği zaman değiştirme, kullanıcılara sağlanan herhangi bir hizmeti değiştirme ya da sona erdirme veya İntercheckup web sitesi&#39;nde kayıtlı kullanıcı bilgi ve verilerini silme hakkını saklı tutar. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.17.</strong></span><span style="font-family:Verdana,sans-serif"> İntercheckup, &uuml;yelik s&ouml;zleşmesinin koşullarını hi&ccedil;bir şekil ve surette &ouml;n ihbara ve/veya ihtara gerek kalmaksızın her zaman değiştirebilir, g&uuml;ncelleyebilir veya iptal edebilir. Değiştirilen, g&uuml;ncellenen ya da y&uuml;r&uuml;rl&uuml;kten kaldırılan her h&uuml;k&uuml;m , yayın tarihinde t&uuml;m &uuml;yeler bakımından h&uuml;k&uuml;m ifade edecektir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.18.</strong></span><span style="font-family:Verdana,sans-serif"> Taraflar, İntercheckup&#39;a ait t&uuml;m bilgisayar kayıtlarının tek ve ger&ccedil;ek m&uuml;nhasır delil olarak, HUMK madde 287&#39;ye uygun şekilde esas alınacağını ve s&ouml;z konusu kayıtların bir delil s&ouml;zleşmesi teşkil ettiği hususunu kabul ve beyan eder. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>3.19.</strong></span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif"> </span><span style="font-family:Verdana,sans-serif">İntercheckup, iş bu &uuml;yelik s&ouml;zleşmesi uyarınca, &uuml;yelerinin kendisinde kayıtlı elektronik posta adreslerine bilgilendirme mailleri ve cep telefonlarına bilgilendirme SMS&rsquo;leri g&ouml;nderme yetkisine sahip olmakla beraber, &uuml;ye işbu &uuml;yelik s&ouml;zleşmesini onaylamasıyla beraber bilgilendirme maillerinin elektronik posta adresine ve bilgilendirme SMS&rsquo;lerinin cep telefonuna g&ouml;nderilmesini kabul etmiş sayılacaktır. </span><span style="color:#000000"><span style="font-family:Verdana,sans-serif">&Uuml;ye mail ve/veya SMS almaktan vazge&ccedil;mek istemesi durumunda info@intercheckup.com adresine mail atarak veya iletişim b&ouml;l&uuml;m&uuml;nden irtibata ge&ccedil;erek mail ve/veya SMS g&ouml;nderim iptal işlemini ger&ccedil;ekleştirebilecektir.</span></span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>4. S&ouml;zleşmenin Feshi </strong></span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif">İşbu s&ouml;zleşme &uuml;yenin &uuml;yeliğini iptal etmesi veya İntercheckup tarafından &uuml;yeliğinin iptal edilmesine kadar y&uuml;r&uuml;rl&uuml;kte kalacaktır. İntercheckup &uuml;yenin &uuml;yelik s&ouml;zleşmesinin herhangi bir h&uuml;km&uuml;n&uuml; ihlal etmesi durumunda &uuml;yenin &uuml;yeliğini iptal ederek s&ouml;zleşmeyi tek taraflı olarak feshedebilecektir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>5. İhtilaflerin Halli </strong></span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif">İşbu s&ouml;zleşmeye ilişkin ihtilaflerde Denizli Mahkemeleri ve İcra Daireleri yetkilidir. </span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif"><strong>6. Y&uuml;r&uuml;rl&uuml;k </strong></span></span></span></p>

<p><span style="font-family:Times New Roman,serif"><span style="font-size:medium"><span style="font-family:Verdana,sans-serif">&Uuml;yenin, &uuml;yelik kaydı yapması &uuml;yenin &uuml;yelik s&ouml;zleşmesinde yer alan t&uuml;m maddeleri okuduğu ve &uuml;yelik s&ouml;zleşmesinde yer alan maddeleri kabul ettiği anlamına gelir. İşbu S&ouml;zleşme &uuml;yenin &uuml;ye olması anında akdedilmiş ve karşılıklı olarak y&uuml;r&uuml;rl&uuml;l&uuml;ğe girmiştir. </span></span></span></p>

<p>&nbsp;</p>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
</div>
</div>

</div>
</div>
{% endblock %}



