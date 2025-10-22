<div>
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <span class="user-icon">
                    <img src="{{ $user->picture }}" alt="" />
                </span>
                <span class="user-name">{{ $user->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="dw dw-user1"></i>Tài khoản</a>
                <a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="dw dw-settings2"></i>Cài đặt chung</a>
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                        class="dw dw-logout"></i>Đăng xuất</a>
                <form action="{{ route('admin.logout') }}" id="logout-form" method="POST">
                    @csrf
                </form>
            </div>
        </div>
    </div> 
</div>
