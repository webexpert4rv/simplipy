<aside class="dash_bar">
    <div class="remove_menu"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="profile_col clearfix">
        <span class="pf_img">
              @if(\App\SystemFile::getImageUrl(\Auth::user()->userProfile, 'profile_pic') != "")
                <img src="{{ \App\SystemFile::getImageUrl(\Auth::user()->userProfile, 'profile_pic')}}">
            @else
                <img src="{{ asset('images/user-img.jpg') }}">
            @endif
        </span>
    </div>
    <div class="side_menu">
        <div class="user-name">
            <span class="pf-name">{{ \Auth::user()->userProfile->first_name }} {{ \Auth::user()->userProfile->last_name }}</span>
            <p>{{ \Auth::user()->userProfile->address}}</p>
        </div>
        <ul class="nav navbar-nav">
            <li class="{{ Route::getFacadeRoot()->current()->uri() == 'home' || Route::getFacadeRoot()->current()->uri() == 'campaigns/explore' ? 'active' : ''}}">
                <a class="sb_link submenu_1" href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i>Home<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
            </li>
            <li class="{{ Route::getFacadeRoot()->current()->uri() == 'profile' ? 'active' : ''}}">
                <a class="sb_link submenu_2" href="{{ url('/profile') }}"><i class="fa fa-user" aria-hidden="true"></i>My Profile<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
            </li>

            @if(\Auth::user()->isInfluencer())
                <li class="{{ Route::getFacadeRoot()->current()->uri() == 'social-signup' ? 'active' : ''}}">
                    <a class="sb_link submenu_2" href="{{ url('social-signup') }}"><i class="fa fa-external-link" aria-hidden="true"></i>My Social Accounts<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
                </li>
                <li class="{{ Route::getFacadeRoot()->current()->uri() == 'my-prefereneces' ? 'active' : ''}}">
                    <a class="sb_link submenu_2" href="#"><i class="fa fa-cogs" aria-hidden="true"></i>My Preferences<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
                </li>
                <li class="{{ Route::getFacadeRoot()->current()->uri() == 'history-stats' ? 'active' : ''}}">
                    <a class="sb_link submenu_2" href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>History and Statistics<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
                </li>
            @else
                <li class="{{ Route::getFacadeRoot()->current()->uri() == 'campaigns/notifications' ? 'active' : ''}}">
                    <a class="sb_link submenu_2" href="{{ url('campaigns/notifications') }}"><i class="fa fa-external-link" aria-hidden="true"></i>Notifications / Actions<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
                </li>
                <li  class="{{ Route::getFacadeRoot()->current()->uri() == 'campaigns/reports' ? 'active' : ''}}">
                    <a class="sb_link submenu_2" href="{{ url('campaigns/reports') }}"><i class="fa fa-cogs" aria-hidden="true"></i>Campaign Reports<i class="fa fa-angle-right arrow_right" aria-hidden="true"></i></a>
                </li>
            @endif
        </ul>
    </div>
</aside>