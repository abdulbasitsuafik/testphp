{% extends 'base.tpl' %}
{% block action_area %}
    <a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/edit')" class="btn btn-primary">Settings</a>
{% endblock %}
{% block body %}
<div class="row">
    <div class="col-md-12" style="text-align: center;margin-top:20%;">
        <a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/edit')" class="btn btn-primary btn-lg">Settings</a>
    </div>
    <div class="col-md-12" style="text-align: center;margin-top:20%;">
        <a href="{{PANEL_URL}}languages" class="btn btn-primary btn-lg">Languages</a>
    </div>
</div>

{% endblock %}
{% block new_scripts %}
<script type="text/javascript">
    $(document).ready(function(){

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
            var veri = window.JSON.stringify(list.nestable('serialize'));
            console.log(veri);
            $.ajax({
                method: 'POST',
                url: '{{PANEL_URL}}{{CONTROLLER}}/rankkaydet',
                data: { rank_liste: veri },
                datatype: 'json',
                success:function (data) {
                    data = $.trim(data);
                }
            });
        };
        // activate Nestable for list 1

        $('#nestable1').nestable('collapseAll',{
            group: 1,
            maxDepth: 15,
            collapsedClass:'dd-collapsed'
        }).on('change', function () {
            updateOutput($(this).data('output', $('#nestable-output')));
        }).nestable('expandAll');

        // output initial serialised data
        // updateOutput($('#nestable').data('output', $('#nestable-output')));
        // updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        // $('#nestable-menu').on('click', function (e) {
        //     var target = $(e.target),
        //         action = target.data('action');
        //     if (action === 'expand-all') {
        //         $('.dd').nestable('expandAll');
        //     }
        //     if (action === 'collapse-all') {
        //         $('.dd').nestable('collapseAll');
        //     }
        // });
    });
    //$("#collapse-11").hide();
    //$("#expand-1").show();



</script>
{% endblock %}