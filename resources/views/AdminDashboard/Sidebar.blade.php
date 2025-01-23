<aside class="navbar-aside shadow-sm" id="offcanvas_aside">
    <div class="aside-top" style="padding:0">
        <a href="{{ route('dashboard') }}" class="brand-wrap">
            <img src="{{ asset('backend/assets/logo.jpg') }}" class="logo pt-2" alt="Church Moratumulla" style="margin-left:80%; width:40px; height:auto;" />
        </a>

        <div>
            <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('dashboard') }}">
                    <i class="icon material-icons md-dashboard"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="menu-item has-submenu {{ request()->is('family/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-family_restroom"></i>
                    <span class="text">Family Management</span>
                </a>
                <div class="submenu {{ request()->is('family/*') ? 'show' : '' }}">
                    <a href="{{ route('family.list') }}" class="{{ request()->routeIs('family.list') ? 'active' : '' }}">
                        Family List
                    </a>
                    <a href="{{ route('member.list') }}" class="{{ request()->routeIs('family.list') ? 'active' : '' }}">
                        Members List
                    </a>
                </div>
            </li>

            <li class="menu-item {{ request()->routeIs('gift.list') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('gift.list') }}">
                    <i class="icon material-icons md-card_giftcard"></i>
                    <span class="text">Fund Management</span>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('filter.index') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('filter.index') }}">
                    <i class="icon material-icons md-filter_list"></i>
                    <span class="text">Filter Members</span>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('show.list') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('show.list') }}">
                    <i class="icon material-icons md-event"></i>
                    <span class="text">Birthdays and Anniversaries</span>
                </a>
            </li>

            <!--<li class="menu-item has-submenu {{ request()->is('gift/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-card_giftcard"></i>
                    <span class="text">Gift Management</span>
                </a>
                <div class="submenu {{ request()->is('gift/*') ? 'show' : '' }}">
                    <a href="{{ route('gift.create') }}" class="{{ request()->routeIs('gift.create') ? 'active' : '' }}">
                        Add Gift
                    </a>
                    <a href="{{ route('gift.list') }}" class="{{ request()->routeIs('gift.list') ? 'active' : '' }}">
                        List
                    </a>
                </div>
            </li>-->

           <li class="menu-item has-submenu {{ request()->is('reports/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-description"></i>
                    <span class="text">Reports</span>
                </a>
                <div class="submenu {{ request()->is('reports/*') ? 'show' : '' }}">
                    <a href="{{ route('reports.families') }}" class="{{ request()->routeIs('reports.families') ? 'active' : '' }}">Families</a>
                    <a href="{{ route('reports.members') }}" class="{{ request()->routeIs('reports.members') ? 'active' : '' }}">Members</a>
                    <a href="{{ route('reports.fund_list') }}" class="{{ request()->routeIs('reports.fund_list') ? 'active' : '' }}">Fund List</a>
                </div>
            </li>

            <li class="menu-item has-submenu {{ request()->is('messages/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-message"></i>
                    <span class="text">Messages</span>
                </a>
                <div class="submenu {{ request()->is('messages/*') ? 'show' : '' }}">
                    <a href="{{ route('admin.send_sms') }}" class="{{ request()->routeIs('admin.send_sms') ? 'active' : '' }}">Sent Messages</a>
                    <a href="{{ route('admin.viewSentMessages') }}" class="{{ request()->routeIs('admin.viewSentMessages') ? 'active' : '' }}">Message list</a>
                </div>
            </li>

            <li class="menu-item has-submenu {{ request()->is('settings/*') ? 'active' : '' }} {{ (session('role') === 'Super Admin' || session('role') === 'Admin') ? '' : 'd-none' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-settings"></i>
                    <span class="text">Settings</span>
                </a>
                <div class="submenu {{ request()->is('settings/*') ? 'show' : '' }}">
                    <a href="{{ route('settings.occupation') }}" class="{{ request()->routeIs('settings.occupation') ? 'active' : '' }}">Occupations</a>
                    <a href="{{ route('settings.religion') }}" class="{{ request()->routeIs('settings.religion') ? 'active' : '' }}">Religion</a>
                    <a href="{{ route('settings.areas') }}" class="{{ request()->routeIs('settings.areas') ? 'active' : '' }}">Areas</a>
                    <a href="{{ route('settings.contribution_types') }}" class="{{ request()->routeIs('settings.contribution_types') ? 'active' : '' }}">Contribution Types</a>
                    <a href="{{ route('settings.academic_qualifications') }}" class="{{ request()->routeIs('settings.academic_qualifications') ? 'active' : '' }}">Academic Qualifications</a>
                    <a href="{{ route('settings.held_in_council') }}" class="{{ request()->routeIs('settings.held_in_council') ? 'active' : '' }}">Head in Council</a>
                    <a href="{{ route('settings.users') }}" class="{{ request()->routeIs('settings.users') ? 'active' : '' }}">Users</a>
                </div>
            </li>


        </ul>
        <hr />
    </nav>
</aside>
