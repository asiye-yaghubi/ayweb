<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="/admin/theme/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
            <div class="email">john.doe@example.com</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">{{__('home.Menu')}}</li>
            <li class="active">
                <a href="index.html">
                    <i class="material-icons">home</i>
                    <span>{{__('home.Home')}}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">accessibility</i>
                    <span>{{__('home.Management Users')}}</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{Route('permission.index')}}" class=" waves-effect waves-block">{{__("home.Permissions")}}</a>
                    </li>
                    <li>
                        <a href="{{Route('role.index')}}" class=" waves-effect waves-block">{{__("home.Roles")}}</a>
                    </li>
                    <li>
                        <a href="{{Route('user.index')}}" class=" waves-effect waves-block">{{__("home.Users")}}</a>
                    </li>
                    
                </ul>
            </li>
           
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    {{-- <div class="legal">
        <div class="copyright">
            &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div> --}}
    <!-- #Footer -->
</aside>