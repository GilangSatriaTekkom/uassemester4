<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/assets/img/favicon.png') }}">
    <title>
        Argon Dashboard 2 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @extends('layouts.navbar')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="main-content position-relative max-height-vh-100 h-100">
        <div class="container-fluid py-4 h-75">
            <div class="row h-75">
                <div class="col-md-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card">
                                    <div class="card-header">Edit Laporan</div>

                                    <div class="card-body">
                                        @if ($laporan)
                                            <form method="POST"
                                                action="{{ route('admin.laporan.update', ['id' => $user->id, 'id_laporan' => $laporan->Id_laporan]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="date" class="form-control" id="tanggal"
                                                        name="tanggal" value="{{ $laporan->tanggal }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jam">Jam</label>
                                                    <input type="time" class="form-control" id="jam"
                                                        name="jam" value="{{ $laporan->jam }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_pegawai">Nama Pegawai</label>
                                                    <select class="form-control" id="nama_pegawai" name="nama_pegawai">
                                                        @foreach ($users as $pegawai)
                                                            @if ($pegawai->level == 'pegawai')
                                                                <option value="{{ $pegawai->id }}"
                                                                    {{ $laporan->id_pegawai == $pegawai->id ? 'selected' : '' }}>
                                                                    {{ $pegawai->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_nasabah">Nama Nasabah</label>
                                                    <select class="form-control" id="nama_nasabah" name="nama_nasabah">
                                                        @foreach ($users as $nasabah)
                                                            @if ($nasabah->level == 'nasabah')
                                                                <option value="{{ $nasabah->id }}"
                                                                    {{ $laporan->id_nasabah == $nasabah->id ? 'selected' : '' }}>
                                                                    {{ $nasabah->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah_koin_100">Jumlah Koin 100</label>
                                                    <input type="number" class="form-control" id="jumlah_koin_100"
                                                        name="jumlah_koin_100" value="{{ $laporan->jumlah_koin_100 }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah_koin_200">Jumlah Koin 200</label>
                                                    <input type="number" class="form-control" id="jumlah_koin_200"
                                                        name="jumlah_koin_200" value="{{ $laporan->jumlah_koin_200 }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah_koin_500">Jumlah Koin 500</label>
                                                    <input type="number" class="form-control" id="jumlah_koin_500"
                                                        name="jumlah_koin_500" value="{{ $laporan->jumlah_koin_500 }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah_koin_1000">Jumlah Koin 1000</label>
                                                    <input type="number" class="form-control" id="jumlah_koin_1000"
                                                        name="jumlah_koin_1000"
                                                        value="{{ $laporan->jumlah_koin_1000 }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah_rupiah">Jumlah Rupiah</label>
                                                    <input type="number" class="form-control" id="jumlah_rupiah"
                                                        name="jumlah_rupiah" value="{{ $laporan->jumlah_rupiah }}"
                                                        readonly>
                                                </div>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#confirmUpdateModal">Save</button>
                                            </form>
                                        @else
                                            <div class="alert alert-danger">
                                                Data laporan tidak ditemukan.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Konfirmasi Update -->
                    <div class="modal fade" id="confirmUpdateModal" tabindex="-1"
                        aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmUpdateModalLabel">Konfirmasi Update</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin melakukan update data?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.querySelector('form').submit();">Ya, Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Argon Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
                        onclick="sidebarType(this)">Dark</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free
                    Download</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const koin100 = document.getElementById('jumlah_koin_100');
            const koin200 = document.getElementById('jumlah_koin_200');
            const koin500 = document.getElementById('jumlah_koin_500');
            const koin1000 = document.getElementById('jumlah_koin_1000');
            const jumlahRupiah = document.getElementById('jumlah_rupiah');

            function calculateTotal() {
                const total = (parseInt(koin100.value) || 0) * 100 +
                    (parseInt(koin200.value) || 0) * 200 +
                    (parseInt(koin500.value) || 0) * 500 +
                    (parseInt(koin1000.value) || 0) * 1000;
                jumlahRupiah.value = total;
            }

            koin100.addEventListener('input', calculateTotal);
            koin200.addEventListener('input', calculateTotal);
            koin500.addEventListener('input', calculateTotal);
            koin1000.addEventListener('input', calculateTotal);

            calculateTotal();
        });
    </script>
</body>

</html>
