<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if(auth()->user()->level === 'admin')
                                <!-- Menu for Admin -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard', ['id' => auth()->user()->id]) }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.laporan.show', ['id' => auth()->user()->id]) }}">Laporan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.profile.show', ['id' => auth()->user()->id]) }}">Profile</a>
                                </li>
                            @elseif(auth()->user()->level === 'pegawai')
                                <!-- Menu for Pegawai -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pegawai.dashboard', ['id' => auth()->user()->id]) }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pegawai.laporan.show', ['id' => auth()->user()->id]) }}">Laporan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('koin.counter', ['id' => auth()->user()->id]) }}">Koin Counter</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pegawai.profile.show', ['id' => auth()->user()->id]) }}">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pegawai.notifications.index', ['id' => auth()->user()->id]) }}">
                                        Notifications <span class="badge badge-light">{{ Auth::user()->unreadNotifications->count() }}</span>
                                    </a>
                                </li>
                            @elseif(auth()->user()->level === 'nasabah')
                                <!-- Menu for Nasabah -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('nasabah.dashboard', ['id' => auth()->user()->id]) }}">Dashboard</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Saldo
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('transactions.create', ['type' =>'withdrawal', 'id' => auth()->user()->id]) }}">Tarik Saldo</a>
                                        <a class="dropdown-item" href="{{ route('transactions.create', ['type' =>'deposit', 'id' => auth()->user()->id]) }}">Deposit Saldo</a>
                                        <a class="dropdown-item" href="{{ route('transactions.create', ['type' =>'transfer', 'id' => auth()->user()->id]) }}">Kirim Saldo</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('transactions.auto', ['id' => auth()->user()->id]) }}">Transfer Otomatis</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('transactions.history', ['id' => auth()->user()->id]) }}">Riwayat Transaksi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('notifications.index', ['id' => auth()->user()->id]) }}">
                                        Notifications <span class="badge badge-light">{{ Auth::user()->unreadNotifications->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.show', ['id' => auth()->user()->id]) }}">Profile</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
</body>
</html>
