<h4 class="solheadlines">{{lang.dil_urunheadlinesleri}}</h4>
<div class="solmenu menu-akordiyon">

    {% set top_head_id=active_main_id %}
    {{ islem.get_sidebar_menu({'top_head_id':top_head_id,'solbosluk':'0','active_page_details':active_page_details,"tablo":"headlines"}) }}

    <script type="text/javascript">
        $(document).ready(function () {
            $(".menu-akordiyon a").click(function () {
                $(this).parent("li").children("ul").slideUp("600");
                if ($(this).next("ul").css("display") == 'none') {
                    $(this).next("ul").slideDown("600");
                }
            });

            $(".menu-akordiyon li.active").parents('ul').css('display','block');
        });
    </script>
</div>
