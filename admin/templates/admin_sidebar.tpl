<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element"> <span>
                     {% if SESSION.user_image|default %}
                        <img alt="image" class="" style="width: 164px;height: 48px;max-height: 80px;" src="{{SITE_URL}}uploads/logo.png" />
                    {% else %}
                        <img alt="image" class="" style="width: 164px;height: 48px;max-height: 80px;" src="{{SITE_URL}}uploads/logo.png" />
                    <!--<img alt="image" class="" src="http://cdn.admitad.com/campaign/images/2020/12/2/92-733097ba4136ecbf.png" style="width: 164px;height: 48px;max-height: 80px;"/>-->
                    {% endif %}
                             </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{SESSION.user_name|capitalize}}</strong>
                             </span> <span class="text-muted text-xs block"> {{SESSION.authority_name|default}}<b class="caret"></b></span> </span> </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <!--<li><a href="profile.html">Profile</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="mailbox.html">Mailbox</a></li>
                    <li class="divider"></li>-->
                    <li><a href="{{PANEL_URL}}admin/logout">Logout</a></li>
                </ul>
            </div>
            <div class="logo-element">
                Os+
            </div>
        </li>
        {% if SESSION.authority == 2  or SESSION.top_user == 1 %}
            <li><a href="{{PANEL_URL}}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a></li>
            <li><a href="{{PANEL_URL}}headlines"><i class="fa fa-diamond"></i> <span class="nav-label">Headlines</span></a></li>
            <li><a href="{{PANEL_URL}}categories"><i class="fa fa-diamond"></i> <span class="nav-label">Categories</span></a></li>
            <li><a href="{{PANEL_URL}}regions"><i class="fa fa-diamond"></i> <span class="nav-label">Regions</span></a></li>
            <li><a href="{{PANEL_URL}}stores"><i class="fa fa-diamond"></i> <span class="nav-label">Stores</span></a></li>
            <li><a href="{{PANEL_URL}}coupons"><i class="fa fa-diamond"></i> <span class="nav-label">Coupons</span></a></li>
            <li><a href="{{PANEL_URL}}users"><i class="fa fa-users"></i> <span class="nav-label">Mobile Users</span></a></li>

        {% endif %}
        {% if SESSION.authority == 2  or SESSION.top_user == 1 %}

            <li><a href="{{PANEL_URL}}products"><i class="fa fa-product-hunt"></i> <span class="nav-label">Products</span></a></li>
            <li><a href="{{PANEL_URL}}purchases"><i class="fa fa-tag"></i> <span class="nav-label">Purchases</span></a></li>
            <li><a href="{{PANEL_URL}}admin_users"><i class="fa fa-users"></i> <span class="nav-label">Admins</span></a></li>
            <li><a href="{{PANEL_URL}}devices"><i class="fa fa-phone"></i> <span class="nav-label">Devices</span></a></li>
            <li>
                <a href="{{PANEL_URL}}notifications"><i class="fa fa-bell"></i> <span class="nav-label">Notifications</span></a>
            </li>
            <li>
                <a href="{{PANEL_URL}}contacts"><i class="fa fa-comment-o"></i> <span class="nav-label">Contact Forms</span></a>
            </li>
            <li><a href="{{PANEL_URL}}settings" title="Ayarlar"><i class="fa fa-cogs"></i> <span class="nav-label">Settings</span></a></li>

        {% endif %}
        {% if SESSION.top_user == 1 %}
        <li>
            <a href="{{PANEL_URL}}version/update"><i class="fa fa-spinner"></i> <span class="nav-label">SQL Update</span></a>
        </li>
        {% endif %}
        <li>
            <a href="{{PANEL_URL}}admin/logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
        </li>
    </ul>

</div>
