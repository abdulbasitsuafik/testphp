{% extends 'base.tpl' %}
{% block main %}

{% include 'sayfalar/dahil/haber_headlines.tpl' %}
{{islem.hitArtir(active_page_details.makale_id)}}
<link href="{{THEME_PATH}}assets/css/makale_yorum.css" rel="stylesheet">
<section class="content_section">
    <div class="container">
        <div class="row">

            <div class="haberdetay_liste">
              <div class="col-md-12 col-sm-12 col-xs-12">                
                    {{islem.breadcrumbCek(active_page_details)}}
                    <div id="oncekisonraki"></div>
                  </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="liste">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="resim">
                                    <a data-fancybox="gallery" data-srcset="" data-width="" data-height="" data-caption="{{active_page_details.title}}" href="{{SITE_URL}}{{active_page_details.manset_resmi}}">
                                        <img src="{{islem.resimcek(active_page_details['manset_resmi'],900,400)}}" alt="{{active_page_details.title}}" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="description">
                                    <h1>{{active_page_details.title}}</h1>
                                    <h3>{{active_page_details.description}}</h3>
                                    <p>{{active_page_details.content}}</p>
                                </div>
                                <div class="yorumlar" style="display: none;">
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1" id="logout">
                                            <div class="page-header">
                                                <h3 class="reviews">Yorumlar</h3>
                                            </div>
                                            <div class="comment-tabs">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Yorumlar</h4></a></li>
                                                    <li><a href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Yorum Ekle</h4></a></li>
                                                </ul>            
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="comments-logout">   
                                                    {% set yorumlar = islem.sqlSorgu("SELECT * FROM "~prefix~"yorumlar WHERE makale_id= :makale_id and status= :status order by tarih DESC",{":makale_id":active_page_details.makale_id,":status":1}) %}
                                                        <ul class="media-list">
                                                            {% for value in yorumlar %}
                                                              <li class="media">
                                                                <a class="pull-left" href="#">
                                                                  <img class="media-object img-circle" src="{{SITE_URL}}resimler/user.png" alt="profile">
                                                                </a>
                                                                <div class="media-body">
                                                                  <div class="well well-lg">
                                                                      <h4 class="media-heading text-uppercase reviews">{{value.adi}}</h4>
                                                                      <ul class="media-date text-uppercase reviews list-inline">
                                                                        <li class="dd">{{islem.tarih("d. m. Y",value.tarih)}}</li>
                                                                      </ul>
                                                                      <p class="media-comment">
                                                                        Yorum
                                                                      </p>
                                                                  </div>              
                                                                </div>
                                                              </li>  
                                                            {% endfor %}  
                                                        </ul> 
                                                    </div>
                                                    <div class="tab-pane" id="add-comment">
                                                        <form action="#" method="post" class="form-horizontal" id="commentForm" role="form"> 
                                                            <div class="form-group">
                                                                <label for="email" class="col-sm-2 control-label">{{lang.dil_adsoyad}}</label>
                                                                <div class="col-sm-10">
                                                                  <input type="text" class="form-control" name="adi"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email" class="col-sm-2 control-label">{{lang.dil_yorum}}</label>
                                                                <div class="col-sm-10">
                                                                  <textarea class="form-control" name="yorum" id="addComment" rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                 <label for="email" class="col-sm-2 control-label">{{lang.dil_yorum}}</label>
                                                                 <div class="col-sm-3" id="guvenlikResimYenile">
                                                                    <img src="{{SITE_URL}}genel/guvenlikGuncelle/000000/cccccc" class="guvenlikResim">
                                                                 </div>
                                                                 <div class="col-sm-5">
                                                                    <input type="hidden" name="alan_renk" value="000000">
                                                                    <input type="hidden" name="alan_guvenlik_renk" value="cccccc">
                                                                    <input type="hidden" name="makale_id" value="{{active_page_details.makale_id}}">
                                                                    <input type="text" class="form-control" name="guvenlik_kodu" placeholder="{{lang.dil_guvenlikkodu}}" >
                                                                 </div>
                                                             </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-2 col-sm-10">  
                                                                    <p class="sonucgetir" style="display: none;border: 1px dotted;padding: 5px;border-radius: 10px;font-size: 11px;"></p>                  
                                                                    <button onclick="yorum_ekle_makale()" class="btn btn-success btn-circle text-uppercase" type="button" id="submitComment"><span class="fa fa-send"></span> {{lang.dil_yorumgonder}}</button>
                                                                </div>
                                                            </div>            
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     {% include 'sayfalar/dahil/content_resim.tpl' %}
                     {% include 'sayfalar/dahil/content_dosya.tpl' %}
                     {% include 'sayfalar/dahil/content_video.tpl' %}

                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    {% set head_ids = active_page_details.head_ids %}
                    {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~prefix~"makale a JOIN "~prefix~"makale_dil b ON a.id=b.makale_id WHERE b.lang= :lang and a.head_ids LIKE :head_ids order by a.pubDate DESC limit 15",{":lang":sessions.dil,":head_ids":head_ids}) %}
                    {% for key,value in gelen_veri %}
                        <div class="tum-liste">
                            <div class="resim"><img src="{{islem.resimcek(value.manset_resmi,300,100,1)}}" alt="{{value.headlines}}" /></div>
                            <div class="description">
                                <h3>{{islem.kisalt(value.headlines,70)}}</h3>
                                <h4>{{islem.kisalt(value.description,50)}}</h4>
                                <a href="{{SITE_URL}}{{value.seflink}}">{{lang.dil_icerigiincele}}</a>
                            </div>
                        </div>
                    {%endfor%}
                </div>
            </div>

        </div>
    </div>
</section>   
<script type="text/javascript">
    function yorum_ekle_makale(){
        var form = $("#commentForm").serialize();
        $.ajax({
          method: "POST",
          url: "{{SITE_URL}}genel/yorum_ekle_makale",
          data: form,
          success:function(data){
              var jsonData = JSON.parse(data);
              console.log(jsonData);
              $(".sonucgetir").css("display","block");
              $(".sonucgetir").html(jsonData["mesaj"]);
              if(jsonData["status"]=="false"){
                 $("#guvenlikResimYenile").html(jsonData["yeniResim"]);
              }
          }
        })
    }
    oncekisonraki("{{active_page_details.seflink}}");
    function oncekisonraki(seflink){
        $.ajax({
          method: "POST",
          url: "{{SITE_URL}}genel/oncekisonrakimakale",
          data:{seflink:seflink},
          success:function(data){
              $("#oncekisonraki").html(data);
          }
        })
    }
</script>       
{% endblock %}



