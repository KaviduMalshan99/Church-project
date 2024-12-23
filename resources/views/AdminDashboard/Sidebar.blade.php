<aside class="navbar-aside shadow-sm" id="offcanvas_aside">
    <div class="aside-top" style="padding:0">
        <a href="{{ route('dashboard') }}" class="brand-wrap">
            <img src="{{ asset('frontend/assets/images/logo/preloader-new1.png') }}" class="logo" alt="DK-Mart" style="margin-left:80%;" />
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

            <li class="menu-item has-submenu {{ request()->is('church/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-home"></i>
                    <span class="text">Church Management</span>
                </a>
                <div class="submenu {{ request()->is('church/*') ? 'show' : '' }}">
                    <a href="{{ route('church.main') }}" class="{{ request()->routeIs('church.main') ? 'active' : '' }}">
                        Main Church Management
                    </a>
                    <a href="{{ route('church.sub') }}" class="{{ request()->routeIs('church.sub') ? 'active' : '' }}">
                        Sub Church Management
                    </a>
                </div>
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
                </div>
            </li>

            <li class="menu-item has-submenu {{ request()->is('member/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-people"></i>
                    <span class="text">Member Management</span>
                </a>
                <div class="submenu {{ request()->is('member/*') ? 'show' : '' }}">
                    <a href="{{ route('member.list') }}" class="{{ request()->routeIs('member.list') ? 'active' : '' }}">
                        Members List
                    </a>
                </div>
            </li>

            <li class="menu-item has-submenu {{ request()->is('gift/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-card_giftcard"></i>
                    <span class="text">Gift Management</span>
                </a>
                <div class="submenu {{ request()->is('gift/*') ? 'show' : '' }}">
                    <a href="{{ route('gift.list') }}" class="{{ request()->routeIs('gift.list') ? 'active' : '' }}">
                        Gift List
                    </a>
                </div>
            </li>

            <li class="menu-item has-submenu {{ request()->is('reports/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-description"></i>
                    <span class="text">Reports</span>
                </a>
                <div class="submenu {{ request()->is('reports/*') ? 'show' : '' }}">
                    <a href="{{ route('reports.customers') }}" class="{{ request()->routeIs('reports.customers') ? 'active' : '' }}">Customers</a>
                    <a href="{{ route('reports.products') }}" class="{{ request()->routeIs('reports.products') ? 'active' : '' }}">Products</a>
                    <a href="{{ route('reports.affiliate') }}" class="{{ request()->routeIs('reports.affiliate') ? 'active' : '' }}">Affiliate Customers</a>
                    <a href="{{ route('reports.bank') }}" class="{{ request()->routeIs('reports.bank') ? 'active' : '' }}">Affiliate Bank Details</a>
                    <a href="{{ route('reports.vendors') }}" class="{{ request()->routeIs('reports.vendors') ? 'active' : '' }}">Vendors</a>
                </div>
            </li>

            <li class="menu-item has-submenu {{ request()->is('settings/*') ? 'active' : '' }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-settings"></i>
                    <span class="text">Settings</span>
                </a>
                <div class="submenu {{ request()->is('settings/*') ? 'show' : '' }}">
                    <a href="{{ route('settings.company') }}" class="{{ request()->routeIs('settings.company') ? 'active' : '' }}">Manage Company</a>
                    <a href="{{ route('settings.users') }}" class="{{ request()->routeIs('settings.users') ? 'active' : '' }}">Users</a>
                    <a href="{{ route('settings.roles') }}" class="{{ request()->routeIs('settings.roles') ? 'active' : '' }}">Role List</a>
                </div>
            </li>
        </ul>
        <hr />
    </nav>
</aside>
