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
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <title>
        @if(session('type') == 'withdrawal')
        Tarik Saldo
        @elseif(session('type') == 'deposit')
        Deposit Saldo
        @elseif(session('type') == 'transfer')
        Transfer Saldo
        @else
        Saldo
        @endif
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

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @extends('layouts.navbar')

    <main class="main-content position-relative border-radius-lg ">
        @include('layouts.top_navbar')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4" style="padding: 40px;">
                        <div class="card-header pb-0">
                            <h6>
                                Penghitung Koin
                            </h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="align-items-center mb-0">

                                
   

                                <!-- <div class="form-check">
                                    <input type="checkbox" id="limitCheckbox" class="form-check-input"
                                        onclick="toggleLimitInput()">
                                    <label for="limitCheckbox" class="form-check-label">Enable Limit</label>
                                </div>

                                <div class="form-group hidden" id="limitInputContainer">
                                    <label for="limitInput">Limit</label>
                                    <input type="number" id="limitInput" class="form-control">
                                </div> -->

                                <div id="statusIndicator" class="mt-3">
                                    <!-- Status will be dynamically inserted here -->
                                </div>

                                <div class="d-flex justify-content-between">
                                    <form method="POST" action="{{ route('controlRelay') }}">
                                        @csrf
                                        <input type="hidden" name="action" value="start">
                                        <button type="submit" class="btn btn-primary mt-3">Start Machine</button>
                                    </form>

                                    <form method="POST" action="{{ route('controlRelay') }}">
                                        @csrf
                                        <input type="hidden" name="action" value="stop">
                                        <button type="submit" class="btn btn-danger mt-3">Stop Machine</button>
                                    </form>
                                </div>

                                <h3 class="mt-5 p-3">Update Laporan</h3>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Coin 100: <span id="coin100" class="">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Coin 200: <span id="coin200" class="">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Coin 500: <span id="coin500" class="">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Coin 1000: <span id="coin1000" class="">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total Amount: <span id="totalAmount" class="">0</span>
                                    </li>
                                </ul>

                                

                                <form method="POST" action="{{ route('updateReport', ['id' => $user->id]) }}" class="mt-3">
    @csrf

    <!-- Input hidden untuk nama pegawai -->
    <input type="hidden" id="nama_pegawai" name="nama_pegawai" value="{{ Auth::user()->name }}">

    <!-- Input untuk nama nasabah -->
    <div class="form-group">
        <label for="nama_nasabah">Nama Nasabah</label>
        <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" value="{{ old('nama_nasabah') }}" required>
    </div>

    <!-- Flex container for buttons -->
    
</form>

<div class="d-flex justify-content-between mt-3">
        <button type="submit" class="btn btn-success">Update</button>
        <form method="POST" action="{{ route('resetCounter') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Reset Counter</button>
        </form>
    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer pt-3">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                © <script>
                                    document.write(new Date().getFullYear())

                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                    Tim</a>
                                for a better web.
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                        target="_blank">Creative Tim</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                        target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                        target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                        target="_blank">License</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
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
                <div class="d-flex my-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
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
    <script src="{{ asset('/assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>

    <!-- scipt COunter -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch initial coin counts
            updateCoinCounts();
            setInterval(fetchCoinCounts, 1000); // Fetch data every 10 seconds
        });

        function updateCoinCounts() {
            fetch('/coin-counts')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('coin100').innerText = data.coin100;
                    document.getElementById('coin200').innerText = data.coin200;
                    document.getElementById('coin500').innerText = data.coin500;
                    document.getElementById('coin1000').innerText = data.coin1000;
                    document.getElementById('totalAmount').innerText = data.totalAmount;
                })
                .catch(error => console.error('Error fetching coin counts:', error));
        }

        setInterval(updateCoinCounts, 1000); // Update coin counts every 5 seconds

        function controlRelay(action) {
            fetch(`/controlRelay/${action}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    updateStatusIndicator(data.status);
                });
        }

        function updateStatusIndicator(status) {
            const statusIndicator = document.getElementById('statusIndicator');
            statusIndicator.innerHTML = status === 1 ? '<p>Alat Menyala</p>' : '<p>Alat Mati</p>';
        }

        // Initialize status on page load
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/getStatus')
                .then(response => response.json())
                .then(data => {
                    updateStatusIndicator(data.status);
                });
        });

        // Example of how to call controlRelay function
        document.getElementById('startMachineBtn').addEventListener('click', function () {
            controlRelay('start');
        });

        document.getElementById('stopMachineBtn').addEventListener('click', function () {
            controlRelay('stop');
        });

        document.getElementById('resetCounterForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form from submitting normally

            if (confirm('Apakah Anda yakin untuk mereset counter?')) {
                console.log('User confirmed reset');
                fetch(this.action, {
                        method: this.method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        console.log('Fetch completed', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data', data);
                        if (data.message) {
                            toastr.success(data.message); // Show success message
                            updateCoinCounts(); // Update coin counts if necessary
                            // Redirect back to previous page
                            window.history.back();
                        } else {
                            toastr.error('Gagal mereset counter.'); // Show error message
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('Terjadi kesalahan saat mereset counter.'); // Show error message
                    });
            } else {
                console.log('User canceled reset');
            }
        });



        // Function to toggle input based on checkbox
        function toggleLimitInput() {
            var limitInputContainer = document.getElementById('limitInputContainer');
            if (limitInputContainer.classList.contains('hidden')) {
                limitInputContainer.classList.remove('hidden');
            } else {
                limitInputContainer.classList.add('hidden');
            }
        }

        function startMachine() {
            const employeeName = "{{ Auth::user()->name }}";
            const limitInput = document.getElementById('limitInput').value;
            const limitCheckbox = document.getElementById('limitCheckbox').checked;

            // Send data to ESP8266
            fetch('/start-machine', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        employeeName,
                        limitInput,
                        limitCheckbox
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Alat dijalankan');
                        updateCoinCounts();
                    } else {
                        alert('Gagal menjalankan alat');
                    }
                });
        }

    </script>




    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
</body>

</html>
