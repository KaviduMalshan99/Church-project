<header class="main-header navbar shadow-sm">
    <div class="col-search">
       
    </div>
    <div class="col-nav">
        <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
        <ul class="nav">
           <!-- <li class="nav-item dropdown"> 
                 <a class="nav-link btn-icon dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="material-icons md-notifications animation-shake"></i>
                          <span class="badge rounded-pill">
                                {{ count(session('notifications', [])) }}
                          </span>
                 </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                      @if(session('notifications') && count(session('notifications')) > 0)
                         @foreach(session('notifications') as $notification)
                              <li class="dropdown-item">
                                      {{ $notification }}
                               </li>
                       @endforeach
                    <li>
                       <form method="POST" action="{{ route('notifications.clear') }}" class="text-center mt-2">
                           @csrf
                             <button type="submit" class="btn btn-sm btn-danger">Clear All</button>
                       </form>
                    </li>
                      @else
                           <li class="dropdown-item text-muted">No notifications</li>
                     @endif
                </ul>
            </li>-->
            <li class="nav-item">
                <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
             </li>

            <li class="dropdown nav-item" style="position: relative;">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="{{ asset('backend/assets/imgs/people/avatar-2.png') }}" alt="User" />
                    <span class="d-none d-md-inline">{{ session('name', 'Guest') }}</span>
                </a>
                
                <!-- Dropdown menu for logout -->
                <div class="dropdown-menu" style="left: -20px; top:55px" aria-labelledby="dropdownAccount">
                    @if (session('email') !== 'admin@example.com')
                        <a class="dropdown-item text-danger" href="{{ route('profile.show') }}">
                            <i class="material-icons md-person"></i> Profile
                        </a>
                    @endif

                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="material-icons md-exit_to_app"></i> Logout
                    </a>
                    <!-- Hidden logout form -->
                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
    </div>
</header>
