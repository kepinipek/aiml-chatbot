<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}" id="navbarBlur"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('home')}}">Tentang Kami</a></li>
                @if ($title != '')
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
                @endif
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">{{ $title }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        @if (Auth::check())
                            <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="nav-link text-white font-weight-bold px-0">
                                    <span class="mb-0 btn btn-outline-light">Log out</span>
                                </a>
                            </form>
                        @else
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="email" required autofocus />
                                    </div>
                                    <div class="col-auto">
                                        <input id="password" class="form-control" type="password" name="password" placeholder="pasword" required autocomplete="current-password" />
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="mb-0 btn btn-outline-light btn-md ">Login</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>