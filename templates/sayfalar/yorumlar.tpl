{% extends 'base.tpl' %}

{% block main %}

    {% include 'sayfalar/dahil/content_headlines.tpl' %}

<style type="text/css">
.yourumekle {float: left;width: 100%;height: auto;text-align: left;margin-bottom: 20px;position: relative;z-index: 99;}
.yourumekle button{font-size: 16px;font-weight: 500;padding: 18px 40px 18px;margin-bottom: 4px;line-height: 1;display: inline-block;text-align: center;color: #ffffff;border: none;background-color: #8fc423;
border-radius: 30px;position: relative;box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);-webkit-transition: all 0.4s linear 0s;transition: all 0.4s linear 0s;text-decoration: none;margin-top: 30px;}
.yourumekle button:hover{background: #f47924}
.panel-default {
    border-color: #ddd;
    float: left;
    width: 100%;
}
   
</style>
    <section class="content-section">

                <div class="container">
                    {{islem.breadcrumbCek(active_page_details)}}
                    <div class="yourumekle">
                        <button data-toggle="modal" data-target="#formModal"><i class="fa fa-comment"></i>Yorum Ekle </button>
                    </div>
                        
                        <div class="clear"></div>

                        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="javascript:void(0)" method="POST" id="yorumEkle" class="form-horizontal" >
                                    <!-- Start Modal Header -->
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="formModalLabel">Yorum Ekle</h4>
                                    </div>
                                    <!-- End Modal Header -->
                                    <!-- Start Modal Body -->
                                    <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{lang.dil_adsoyad}}</label>
                                                <div class="col-sm-9">
                                                    <input name="adi" class="form-control" placeholder="{{lang.dil_adsoyad}}" required="" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{lang.dil_email}}</label>
                                                <div class="col-sm-9">
                                                    <input name="email" class="form-control" placeholder="{{lang.dil_email}}" required="" type="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{lang.dil_mesaj}}</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="5" name="yorum" class="form-control" placeholder="{{lang.dil_mesaj}}" required=""></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{lang.dil_guvenlikkodu}}</label>
                                                <div class="col-sm-4" id="guvenlikResim">
                                                    <img src="{{SITE_URL}}genel/guvenlikGuncelle/000000/000000" class="guvenlikResim" alt="chapta"/>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="guvenlik_kodu" class="form-control" placeholder="{{lang.dil_guvenlikkodu}}" required="" >
                                                </div>
                                            </div>



                                    </div>
                                    <!-- End Modal Content -->
                                    <!-- Start Modal Footer -->
                                    <div class="modal-footer">
                                        <div class="gelencevap" style="background:black;text-align: center;font-size:15px;padding:5px;color:yellow;display: none;"></div></br>
                                        <button type="button" onclick="yorumEkle()" class="btn btn-warning btn-block " id="yorumEkleBtn">{{lang.dil_gonder}}</button>
                                        
                                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Kapat</button>
                                    </div>
                                    <!-- End Modal Footer -->
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="accordion-box" id="accordion" style="padding: 0px;margin:0px;">

                            {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~prefix~"yorumlar WHERE durum = :durum order by id ASC",{":status":"1"}) %}

                            {% set liste_ranksi = 0 %}
                            {% for key,value in gelen_veri %}
                            {% set liste_ranksi = liste_ranksi + 1 %}

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapsediv{{liste_ranksi}}" class="{% if liste_ranksi == '1' %}collapsed{%endif%}"><i class="fa fa-comments mr-5" ></i> {{value.adi}} </a></h4>
                                </div>
                                <div id="collapsediv{{liste_ranksi}}" class="panel-collapse collapse {% if liste_ranksi == '1' %} in {%endif%} "  >
                                    <div class="panel-body">
                                        <span style="color: #4c4c4c;font-weight: bold; font-size: 13px;" >{{value.tarih}}</span>
                                        <div class="clear"></div>
                                        <p>{{value.yorum}}</p>
                                    </div>
                                </div>
                            </div>


                            {%endfor%}

                        </ul>

                    </div>
            </section>
<script>
    function yorumEkle(){
        var form = $("#yorumEkle").serialize();
        $.ajax({
            type: "POST",
            url: "{{SITE_URL}}genel/yorumEkle",
            data: form,
            success: function(data) {
              var jsonData = JSON.parse(data);
                console.log(jsonData);
                $(".gelencevap").css("display","block");
                $(".gelencevap").html(jsonData["mesaj"]);
                if(jsonData["status"]=="true"){
                    document.getElementById("yorumEkleBtn").disabled = true;
                }
                if(typeof jsonData["yeniResim"]!="undefined" || jsonData["yeniResim"]!=null){
                    $("#guvenlikResim").html(jsonData["yeniResim"]);
                }
            }
        });
    }
</script>


{% endblock %}