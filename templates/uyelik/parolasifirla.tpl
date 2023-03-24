{% extends 'base.tpl' %}
{% block main %}

{{ islem.altsayfa_kontrol(active_page_details,true) }}
{% include 'sayfalar/dahil/content_headlines.tpl' %}
<section class="content_section">
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-sm-6 col-xs-12">
                <form class="form1" action="javascript:void(0)" method="POST" id="parolaSifirla">
                    <div class="form-group">
                        <label for="formalan_name1">Parola<small>*</small></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                            <input type="hidden" name="sonsayfa" value="{{referer}}">
                            <input type="hidden" name="kod" value="{{islem.getcek('kod')}}" class="form-control enter">
        					<input type="hidden" name="id" value="{{islem.getcek('id')}}" class="form-control enter">
                             <input type="password" name="parola" class="form-control enter" required="required" placeholder="Parola" aria-required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="formalan_name1">Parola Tekrar<small>*</small></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                            <input type="password" name="parolatekrar" class="form-control enter" required="required" placeholder="Parola" aria-required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" autocomplete="off" required="" class="btn btn-inter girisbutton" aria-required="true" onclick="parolaSifirla()">Değiştir</button>
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
    function parolaSifirla(){
        var form = $("#parolaSifirla").serialize();
        $.ajax({
            type: "POST",
            url: "{{SITE_URL}}uyelik/parolaSifirlaRun",
            data: form,
            success: function(data) {
              var gelenData = JSON.parse(data);
                console.log(gelenData);
                $(".gelencevap").css("display","block");
                 $(".gelencevap").html(gelenData["mesaj"]);
                if(gelenData["status"]=="true"){
                    //location.href=gelenData["link"];
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



