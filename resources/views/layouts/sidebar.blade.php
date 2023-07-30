<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo-untar.png') }}" class="navbar-brand-img h-100 center" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tentang Kami</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'news' ? 'active' : '' }}" href="{{ route('news') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-newspaper text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Berita</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'conversations.show' ? 'active' : '' }}" href="{{ route('conversations.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-comments text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Percakapan</span>
                </a>
            </li>
            @if (Auth::check() && Auth::User()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link in_array(Route::currentRouteName(), ['missing-questions.index', 'missing-questions.show']) ? 'active' : '' }}" href="{{ route('missing-questions.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-question text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pertanyaan asing</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['categories.index', 'categories.create', 'categories.edit']) ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-book text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pengetahuan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['users.index', 'users.create', 'users.edit']) ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-user text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</aside>