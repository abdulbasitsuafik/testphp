
<div class="modal fade bd-example-modal-lg modalGetir-" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Users
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <style>
                    .select2-close-mask{
                        z-index: 2099;
                    }
                    .select2-dropdown{
                        z-index: 3051;
                    }
                </style>
                <form method="post" action="javascript:void(0)" class="post_gonder100" id="post_gonder100" enctype="multipart/form-data">
                    <input type="hidden" name="b_id" value="{{data.id}}">
                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="myTab">
                            <li role="presentation" class="active">
                                <a href="#first" aria-controls="first" role="tab" data-toggle="tab">
                                    Kullanıcı bilgileri
                                </a>
                            </li>
                           <!-- <li role="presentation">
                                <a href="#second" aria-controls="second" role="tab" data-toggle="tab">
                                    Çanta
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#uc" aria-controls="second" role="tab" data-toggle="tab">
                                    Çözdüğü testler
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#dort" aria-controls="second" role="tab" data-toggle="tab">
                                    Diğer
                                </a>
                            </li>-->
                        </ul>
                        <!-- Tab panes -->

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="first">
                                <div class="row" style="margin-top: 20px;">
                                    {% include ""~CONTROLLER~"/form.tpl" %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane " id="second">
                                <div class="row" style="margin-top: 20px;">
                                    <table class="table table-bordered dataTables-example-">
                                        <thead>
                                            <th>Ürün Adı</th>
                                            <th>Ödeme Durumu</th>
                                            <th>Kullanım Durumu</th>
                                            <th>Başlangıç Bitiş</th>
                                            <th>Oluşturma Tarihi</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                        {% for value in get_user_purchases %}
                                            <tr>
                                                <td>{{value.id}} - {{value.product_name}}</td>
                                                <td>{{value.payment}}</td>
                                                <td>{{value.used ==1 ? "Kullanıldı" : "Aktif"}}</td>
                                                <td>{{value.start_date}} - {{value.end_date}}</td>
                                                <td>{{value.created_at}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-{{value.id}}">Actions <span class="caret"></span> </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="change_status('{{CONTROLLER}}/purchases_status','{{value.id}}')" class="dropdown-item"> <span class="fa fa-eye"> </span> Durum Değiştir</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        {% endfor %}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="uc">
                                <div class="row" style="margin-top: 20px;">
                                    <table class="table table-bordered dataTables-example-">
                                        <thead>
                                        <th>Sınav</th>
                                        <th>Doğru</th>
                                        <th>Yanlış</th>
                                        <th>Net</th>
                                        <th>Puan</th>
                                        <th>Zaman</th>
                                        <th>Tarih</th>
                                        <th>Actions</th>
                                        </thead>
                                        <tbody>
                                        {% set sinav = 0 %}
                                        {% set dogru = 0 %}
                                        {% set yanlis = 0 %}
                                        {% set net = 0 %}
                                        {% for value in cozdugu_testler %}
                                            <tr id="tableline-{{value.id}}">
                                                <td>{{value.exam}}</td>
                                                <td>{{value.correct}}</td>
                                                <td>{{value.incorrect}}</td>
                                                <td>{{value.net}}</td>
                                                <td>{{value.point}}</td>
                                                <td>{{value.general_time}} sn.</td>
                                                <td>{{value.created_at}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-{{value.id}}">Actions <span class="caret"></span> </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="item_delete('{{CONTROLLER}}/sinav_sil','{{value.id}}')" class="dropdown-item"> <span class="fa fa-trash"> </span> Sınavı Sil</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            {% set sinav = sinav + 1 %}
                                            {% set dogru = dogru + value.correct %}
                                            {% set yanlis = yanlis + value.incorrect %}
                                            {% set net = net + value.net %}
                                        {% endfor %}
                                        </tbody>
                                        <thead>
                                        <th>Sınav</th>
                                        <th>Doğru</th>
                                        <th>Yanlış</th>
                                        <th>Net</th>
                                        <th>Puan</th>
                                        <th>Zaman</th>
                                        <th>Tarih</th>
                                        <th>Actions</th>
                                        </thead>
                                        <thead>
                                            <th>Toplam Sınav : {{sinav}}</th>
                                            <th>Toplam Doğru : {{dogru}}</th>
                                            <th>Toplam Yanlış : {{yanlis}}</th>
                                            <th>Toplam Net : {{net}}</th>
                                            <th>Toplam Puan : {{data.point}}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="dort">
                                <div class="row" style="margin-top: 20px;">

                                </div>
                            </div>
                        </div>



                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder100')">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.dataTables-example-').DataTable({
            pageLength: 100,
            responsive: true,
            //dom: '<"html5buttons"B>lTfgitp',
            // dom: 'lTfgitp',
            dom: '<"html5buttons"B>lTfgtpi',
            buttons: [
                { extend: 'copy'},
                { extend: 'csv'},
                { extend: 'excel', title: 'ExampleFile'},
                { extend: 'pdf', title: 'ExampleFile'},

                { extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                    }
                }
        ],
        });
    });

</script>
