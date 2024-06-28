<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" / "
            target="_blank">
            <img src="{{ asset('/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold" style="font-size: large">Counter</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @auth
            @if(auth()->user()->level === 'admin')
            <!-- Menu for Admin -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard/*') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-7"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/laporan/*') ? 'active' : '' }}"
                    href="{{ route('admin.laporan.show', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-sm opacity-7">description</i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/profile/*') ? 'active' : '' }}"
                    href="{{ route('admin.profile.show', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-primary text-sm opacity-7"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            @elseif(auth()->user()->level === 'pegawai')
            <!-- Menu for Pegawai -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pegawai/dashboard/*') ? 'active' : '' }}"
                    href="{{ route('pegawai.dashboard', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-7"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pegawai/laporan/*') ? 'active' : '' }}"
                    href="{{ route('pegawai.laporan.show', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-sm opacity-7">description</i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pegawai/koin-counter/*') ? 'active' : '' }}"
                    href="{{ route('koin.counter', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-sm opacity-7">calculate</i>
                    </div>
                    <span class="nav-link-text ms-1">Koin Counter</span>
                </a>
            </li>

            

            <!-- <li class="nav-item">
                <a class="nav-link {{ request()->is('pegawai/notifications/*') ? 'active' : '' }}"
                    href="{{ route('pegawai.notifications.index', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-sm opacity-7">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notification</span>
                    <span class="badge badge-light">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
            </li> -->

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pegawai/profile*') ? 'active' : '' }}"
                    href="{{ route('pegawai.profile.show', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-primary text-sm opacity-7"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            @elseif(auth()->user()->level === 'nasabah')
            <!-- Menu for Nasabah -->

            <li class="nav-item">
                <a class="nav-link {{ request()->is('nasabah/dashboard/*') ? 'active' : '' }}"
                    href="{{ route('nasabah.dashboard', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-7"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('transactions/auto/*') ? 'active' : '' }}"
                    href="{{ route('transactions.auto', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-lg opacity-7">currency_exchange</i>
                    </div>
                    <span class="nav-link-text ms-1">Transfer Otomatis</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('transactions/history*') ? 'active' : '' }}"
                    href="{{ route('transactions.history', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-lg opacity-7">history</i>
                    </div>
                    <span class="nav-link-text ms-1">Riwayat Transaksi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                    href="{{ route('notifications.index', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-lg opacity-7">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                    <span class="badge badge-light">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Saldo</h6>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transactions.create') && request()->query('type') === 'withdrawal' ? 'active' : '' }}"
                    href="{{ route('transactions.create', ['type' =>'withdrawal', 'id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-lg opacity-7">local_atm</i>
                    </div>
                    <span class="nav-link-text ms-1">Tarik Saldo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transactions/create/deposit') ? 'active' : '' }}"
                    href="{{ route('transactions.create', ['type' =>'deposit', 'id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-lg opacity-7">savings</i>
                    </div>
                    <span class="nav-link-text ms-1">Deposit Saldo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transactions/create/transfer') ? 'active' : '' }}"
                    href="{{ route('transactions.create', ['type' =>'transfer', 'id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni material-icons text-primary text-lg opacity-7">swap_horiz</i>
                    </div>
                    <span class="nav-link-text ms-1">Transfer Saldo</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile/show') ? 'active' : '' }}"
                    href="{{ route('profile.show', ['id' => auth()->user()->id]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-7"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>


            <!-- <li class="nav-item">
                                <a class="nav-link " href="../pages/sign-in.html">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-single-copy-04 text-warning text-sm opacity-7"></i>
                                    </div>
                                    <span class="nav-link-text ms-1">Sign In</span>
                                </a>
                                </li> -->
            <!-- <li class="nav-item">
                                <a class="nav-link " href="{{ route('register') }}">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-collection text-info text-sm opacity-7"></i>
                                    </div>
                                    <span class="nav-link-text ms-1">Sign Up</span>
                                </a>
                                </li> -->
            @endif
            @endauth

            <!-- <li class="nav-item">
          <a class="nav-link " href="../pages/tables.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-7"></i>
            </div>
            <span class="nav-link-text ms-1">Tables</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/billing.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-success text-sm opacity-7"></i>
            </div>
            <span class="nav-link-text ms-1">Billing</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/virtual-reality.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-7"></i>
            </div>
            <span class="nav-link-text ms-1">Virtual Reality</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-7"></i>
            </div>
            <span class="nav-link-text ms-1">RTL</span>
          </a>
        </li> -->



        </ul>
    </div>
    <!-- <div class="sidenav-footer mx-3 ">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-50 mx-auto" src="{{ asset('/assets/img/illustrations/icon-documentation.svg') }}"
                alt="sidebar_illustration">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <h6 class="mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
                </div>
            </div>
        </div>
        <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard" target="_blank"
            class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
        <a class="btn btn-primary btn-sm mb-0 w-100"
            href="https://www.creative-tim.com/product/argon-dashboard-pro?ref=sidebarfree" type="button">Upgrade to
            pro</a>
    </div> -->
</aside>
