{% extends 'base.tpl' %}
{% block main %}

{%set sayfa = islem.urlcek(1)%}
{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">

            <div class="tum_haberler_liste">
                {{islem.sayfalama("makale","10",islem.getcek("p"))}}
            </div>

        </div>
    </div>
</section>
<!--<button class="btn btn-lg btn-default devaminigoruntule" onclick="devaminigoruntule()"><i class="licon-arrow-down"></i> Devamını Görüntüle</button>-->
<script type="text/javascript">
    var click = 0;
    function devaminigoruntule(){
        click +=1;
        $.ajax({
          url: "{{SITE_URL}}genel/haberdevami",
          method: "POST",
          data: {click:click},
          success:function(data){
              jsonData = JSON.parse(data);
              console.log(jsonData);
              if(jsonData["status"]=="false"){
                $( ".devaminigoruntule" ).css("background","lightblue");
                $( ".devaminigoruntule" ).attr("disabled","disabled");
              }else{
                $( ".as_egitimler" ).append( jsonData["content"] );
              }
          }
        })
    }
</script>
{% endblock %}

