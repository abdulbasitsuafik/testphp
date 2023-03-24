<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element"> <span>
                    {% if sessions.user_image|default %}
                        <img alt="image" class="img-circle" src="{{PANEL_URL}}{{sessions.user_image|default}}" style="width: 48px;height: 48px;"/>
                    {% else %}
                        <img alt="image" class="img-circle" src="{{THEME_PATH}}/assets/img/profile_small.jpg" />
                    {% endif %}
                             </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{sessions.user_name|capitalize}}</strong>
                             </span> <span class="text-muted text-xs block"> {{sessions.authority_name|default}}<b class="caret"></b></span> </span> </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <!--<li><a href="profile.html">Profile</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="mailbox.html">Mailbox</a></li>
                    <li class="divider"></li>-->
                    <li><a href="{{PANEL_URL}}admin/logout">Logout</a></li>
                </ul>
            </div>
            <div class="logo-element">
                CRM+
            </div>
        </li>

        <li><a href="{{PANEL_URL}}"><i class="fa fa-th-large"></i> <span class="nav-label">Sınav Oluşturma</span></a></li>

        <li>
            <a href="{{PANEL_URL}}admin/logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
        </li>
    </ul>

</div>
