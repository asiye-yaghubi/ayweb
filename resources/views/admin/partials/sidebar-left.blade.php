<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="/admin/theme/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}</div>
            <div class="email">{{auth()->user()->email}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ route('profile.index') }}"><i class="material-icons">person</i>{{__('home.Profile')}}</a></li>
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
        @if(auth()->user()->type=='admin')
        <ul class="list">
            <li class="header">{{__('home.Menu')}}</li>
            <li>
                <a href="{{Route('home')}}">
                    <i class="material-icons">home</i>
                    <span>{{__('home.Home')}}</span>
                </a>
            </li>
        @can('create_user')
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">group</i>
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
            @endcan
            <li>
                <a href="{{Route('post.index')}}">
                    <i class="material-icons">collections_bookmark</i>
                    <span>{{__('home.Post')}}</span>
                </a>
            </li>
            <li>
                <a href="{{Route('category.index')}}">
                    <i class="material-icons">format_indent_decrease</i>
                    <span>{{__('home.Category')}}</span>
                </a>
            </li>
            <li>
                <a href="{{Route('tag.index')}}">
                    <i class="material-icons">filter_vintage</i>
                    <span>{{__('home.Tag')}}</span>
                </a>
            </li>
            <li>
                <a href="{{Route('tag.index')}}">
                    <i class="material-icons">insert_emoticon</i>
                    <span>{{__('home.Icon')}}</span>
                </a>
            </li>
            
           
        </ul>
        @endif
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







