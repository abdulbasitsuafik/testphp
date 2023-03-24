{% extends 'base.tpl' %}
{% block main %}

{{ islem.altsayfa_kontrol(active_page_details,true) }}
{% include 'sayfalar/dahil/content_headlines.tpl' %}
<section class="content_section">
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-sm-6 col-xs-12">
                <form class="form1" id="emailile" method="post">
                    <div class="form-group">
                        <label for="formalan_name1">E-Mail ile kurtar<small>*</small></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-mail-3" aria-hidden="true"></i></span>
                            <input type="hidden" name="sonsayfa" value="{{referer}}">
                            <input type="email" autocomplete="off" name="email" placeholder="E-Mail Adresi ile" required="" class="form-control enter" aria-required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" autocomplete="off" required="" class="btn btn-inter girisbutton" aria-required="true" onclick="parolaUnuttum()">Gönder</button>
                    </div>
                </form>
                <div class="col-xs-12 col-md-12"><div class="row"><div class="alert alert-danger gelencevap" role="alert" style="display: none;"></div></div></div>              
                <div class="input-group">
                    <div class="checkbox_liste">
                        <label for="inputid_70"><span></span><a href="{{SITE_URL}}uyelik/giris">Giriş Yap</a></label>
                    </div>
                </div> 
            </div>

</div>
</div>
</section>
<script type="text/javascript">
    function parolaUnuttum(){
        var form = $("#emailile").serialize();
        $.ajax({
            type: "POST",
            url: "{{SITE_URL}}uyelik/parolaUnuttum",
            data: form,
            success: function(data) {
              var gelenData = JSON.parse(data);
                console.log(gelenData);
                $(".gelencevap").css("display","block");
                $(".gelencevap").html(gelenData["mesaj"]);
                if(gelenData["status"]=="true"){
                    //setTimeout(function(){ location.href=gelenData["link"]; }, 2000); 
                }else if(gelenData["status"]=="false"){
                    //setTimeout(function(){ location.href=gelenData["link"] }, 2000);    
                }
            }
        });
    }
    $(".enter").keypress(function(e){
      if(e.which == "13"){
        $(".girisbutton").trigger("click");
      }
    });
</script>
{% endblock %}



