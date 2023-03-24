<div class="btn-group pull-right">
    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-{{head_id}}">Actions <span class="caret"></span> </button>
    <ul class="dropdown-menu">
        <li><a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/add','{{head_id}}')" class="dropdown-item"><span class="fa fa-arrow-down"> </span> Add Sub headers</a></li>
        <li><a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/edit','{{head_id}}')" class="dropdown-item"><span class="fa fa-edit"> </span> Edit</a></li>
        <li><a href="javascript:void(0)" onclick="item_delete('{{CONTROLLER}}/delete','{{head_id}}','{{sub_headers}}')" class="dropdown-item"> <span class="fa fa-trash"> </span> Delete</a></li>
        <li>
            <a href="javascript:void(0)" onclick="change_status('{{CONTROLLER}}/change_status','{{head_id}}')" class="dropdown-item">
                <div class="durumdegistirbuttons-{{head_id}}">
                    {% if status == "1" %}
                    <span class=" tooltip-buttonicon-eye ">
                        <span class="fa fa-eye"></span>
                        Passive
                    </span>
                    {% else %}
                    <span class=" tooltip-buttonicon-eye ">
                        <span class="fa fa-eye-slash"></span>
                        Active
                    </span>
                    {% endif %}
                </div>
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li><a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/add_plugins','{{head_id}}')" class="dropdown-item"><span class="fa fa-paint-brush"> </span> Modül Ekle</a></li>
        <li><a href="javascript:void(0)" onclick="modalGetir('general/add_multimedia','{{head_id}}')" class="dropdown-item"><span class="fa fa-camera"> </span> Multimedya Ekle</a></li>

        <li role="separator" class="divider"></li>

        <li>
            <a href="javascript:void(0)" onclick="change_status('{{CONTROLLER}}/change_status','{{head_id}}','sub_status')" class="dropdown-item">
                <div class="sub_statusdegistirbuttons-{{head_id}}">
                    {% if bottom_status == "1" %}
                    <span class=" tooltip-buttonicon-eye ">
                        <span class="fa fa-eye"></span>
                        Alt Başlıkları Gizle
                    </span>
                    {% else %}
                    <span class=" tooltip-buttonicon-eye ">
                        <span class="fa fa-eye-slash"></span>
                        Alt Başlıkları Göster
                    </span>
                    {% endif %}
                </div>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="change_status('{{CONTROLLER}}/change_status','{{head_id}}','first_sub_status')" class="dropdown-item">
                <div class="first_sub_statusdegistirbuttons-{{head_id}}">
                    {% if first_bottom_head == "1" %}
                    <span class=" tooltip-buttonicon-eye ">
                        <span class="fa fa-eye"></span>
                        İlk Alt Başlığı Gizle
                    </span>
                    {% else %}
                    <span class=" tooltip-buttonicon-eye ">
                        <span class="fa fa-eye-slash"></span>
                        İlk Alt Başlığı Göster
                    </span>
                    {% endif %}
                </div>
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li><a href="{{PANEL_URL}}headlines/kopyala/{{head_id}}" onclick="return confirm('Kopyalamak istediğinize emin misiniz?')"><span class="fa fa-copy"> </span> Başlığı Kopyala</a></li>

    </ul>
</div>