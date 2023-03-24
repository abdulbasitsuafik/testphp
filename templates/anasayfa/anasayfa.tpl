{% extends 'base.tpl' %}

{% block main %}
<p style="width:100%;text-align: center;"><img src="uploads/logo.png"></p>
<p style="width:100%;text-align: center;"><img src="uploads/yapimasamasinda.png"></p>
<p style="width:100%;text-align: center;"><span class="desc__content" >1. Coupons uygulamasını uygulama marketinden indir</span></p>
<div class="flexible-row pull-center mobile-store" style="width:100%;text-align: center;">
    <a href="https://apps.apple.com/tr/app/id1546478869"><figure><img src="https://www.atlagit.tech/uploads/app-store@2x.png" alt="App Store"></figure></a>
    <a href="https://play.google.com/store/apps/details?id=com.atlagit.atlagit"><figure><img src="https://www.atlagit.tech/uploads/google-play@2x.png" alt="Google Play"></figure></a>
</div>


<!--<script src="//95.173.186.135:5000/socket.io/socket.io.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script>
    var socket = io('http://95.173.186.135:5000',{secure:true});
    socket.on('connection', function(socket){
                          console.log("new client connected");
                       });
    // socket'te ki posts event'ını dinliyoruz, gelirse konsola yazdırıp bakacağız
    socket.on('posts', function (data) {
        console.log(data);
    });

    // eğer client tarafından socket'in posts event'ına daha göndermek isteseydik yine emit'i kullanacaktık
    socket.emit('posts', {
        'id': 5,
        'title': 'Test',
        'content': 'bu bir tesstir',
        'date': '2019-08-11 12:00:00'
    });
</script>
{% endblock %}
