<?php
$username = Session::get('username');
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Aplikasi PT. Pengelola Pusat Perdagangan Caringin di Kota Bandung">
        <meta name="author" content="">
        
        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
        
        <!-- Custom fonts for this template -->
        <link
            href="{{asset('vendor/fontawesome-free/css/all.min.css')}}"
            rel="stylesheet"
            type="text/css">
        <link
            href="{{asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}"
            rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{asset('css/sb-admin-2-copy.min.css')}}" rel="stylesheet">

        <link href="{{asset('css/fixed-columns.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link
            href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}"
            rel="stylesheet">

        <link rel="icon" href="{{asset('img/logo.png')}}">

        <script src="{{asset('js/animate.min.js')}}"></script>
        
        <link rel="stylesheet" href="{{asset('vendor/select2/select2.min.css')}}"/>
        <script src="{{asset('vendor/select2/select2.min.js')}}"></script>
        
    </head>

    <body id="page-top">

        <div class="se-pre-con">  
        </div>

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a
                    class="sidebar-brand d-flex align-items-center justify-content-center"
                    href="#">
                    <div class="sidebar-brand-text mx-3">MASTER</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item"  >
                    <a class="nav-link" href="{{url('master/dashboard')}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Sumber Daya
                </div>

                <!-- Nav Item - Pedagang -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('pedagang/data')}}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Pedagang</span></a>
                </li>

                <!-- Nav Item - Tempat Usaha -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseTempat"
                        aria-expanded="true"
                        aria-controls="collapseTempat">
                        <i class="fas fa-fw fa-store"></i>
                        <span>Tempat Usaha</span>
                    </a>
                    <div
                        id="collapseTempat"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Data :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/data')}}">Data Tempat</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/rekap')}}">Rekap</a>
                            <h6 class="collapse-header">Fasilitas :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/air')}}">Air Bersih</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/listrik')}}">Listrik</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/keamanan&ipk')}}">Keamanan & IPK</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/kebersihan')}}">Kebersihan</a>
                            <h6 class="collapse-header">Additional :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/airkotor')}}">Air Kotor</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/diskon')}}">Diskon / Bebas Bayar</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tempatusaha/fasilitas/lainlain')}}">Lain - Lain</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Tagihan -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('tagihan/data')}}">
                        <i class="fas fa-fw fa-plus"></i>
                        <span>Tagihan</span></a>
                </li>

                <!-- Nav Item - Tarif -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseTarif"
                        aria-expanded="true"
                        aria-controls="collapseTarif">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Tarif</span>
                    </a>
                    <div
                        id="collapseTarif"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Fasilitas :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/air')}}">Air Bersih</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/listrik')}}">Listrik</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/kebersihan')}}">Kebersihan</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/keamananipk')}}">Keamanan & IPK</a>
                            <h6 class="collapse-header">Additional :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/airkotor')}}">Air Kotor</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/persentase')}}">Keamanan & IPK</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/diskon')}}">Diskon / Bebas Bayar</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('tarif/lainlain')}}">Lain - Lain</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - User -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseUser"
                        aria-expanded="true"
                        aria-controls="collapseUser">
                        <i class="fas fa-users"></i>
                        <span>Pegawai</span>
                    </a>
                    <div
                        id="collapseUser"
                        class="collapse"
                        aria-labelledby="headingUser"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Data :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('pegawai/data')}}">Data Pegawai</a>
                            <h6 class="collapse-header">Otoritas :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('pegawai/otoritas')}}">Otoritas Pegawai</a>
                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Report
                </div>

                <!-- Nav Item - Pemakaian -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapsePemakaian"
                        aria-expanded="true"
                        aria-controls="collapsePemakaian">
                        <i class="far fa-file-alt"></i>
                        <span>Pemakaian</span>
                    </a>
                    <div
                        id="collapsePemakaian"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div class="collapse-divider"></div>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('pemakaian/show')}}">Pemakaian Bulanan</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Laporan -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapsePages"
                        aria-expanded="true"
                        aria-controls="collapsePages">
                        <i class="fa fa-book"></i>
                        <span>Laporan</span>
                    </a>
                    <div
                        id="collapsePages"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Pendapatan :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/harian')}}">Harian</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/bulanan')}}">Bulanan</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/tahunan')}}">Tahunan</a>
                            <h6 class="collapse-header">Data :</h6>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/tagihan')}}">Tagihan</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/tunggakan')}}">Tunggakan</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/bongkaran')}}">Bongkaran</a>
                            <a class="collapse-item" style="font-size:0.8rem;" href="{{url('laporan/penghapusan')}}">Penghapusan</a>
                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Other
                </div>

                <!-- Nav Item - Meteran -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('alat/data')}}">
                        <i class="fas fa-tools"></i>
                        <span>Alat Meter</span></a>
                </li>
                
                <!-- Nav Item - Hari Libur -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('harilibur/data')}}">
                        <i class="far fa-calendar-alt"></i>
                        <span>Hari Libur</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav
                        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button
                            id="sidebarToggleTop"
                            class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="searchDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div
                                    class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                    aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto w-100 navbar-search">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control bg-light border-0 small"
                                                placeholder="Search for..."
                                                aria-label="Search"
                                                aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="userDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$username}}</span>
                                    <img class="img-profile rounded-circle" src="{{asset('img/icon_user.png')}}">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div
                                    class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        data-toggle="modal"
                                        data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Content -->
                    @include('message.flash-message') 
                    @include('message.password-message') 
                    @include('message.update-message') 
                    
                    @yield('content')
                    <!-- End Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy;PT Pengelola Pusat Perdagangan Caringin</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div>

        @yield('modal')

        <!-- Logout Modal-->
        <div
            class="modal fade"
            id="logoutModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin untuk logout?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah ini jika anda siap untuk mengakhiri sesi anda saat ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="{{url('logout')}}">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(window).load(function () {
                $(".se-pre-con")
                    .fadeIn("slow")
                    .fadeOut("slow");;
            });
        </script>

        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
        <script src="{{asset('js/autocomplete.js')}}"></script>

        <!-- Page level plugins -->
        <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{asset('js/demo/datatables-demo.js')}}"></script>

        <!-- Button -->
        <script src="{{asset('js/datatables.buttons.min.js')}}"></script>
        <script src="{{asset('js/jszip.min.js')}}"></script>
        <script src="{{asset('js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

        <script src="{{asset('js/fixed-columns.min.js')}}"></script>

        <!--for column table toggle-->
        <script>
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true))
                    .DataTable()
                    .columns
                    .adjust();
            });
        </script>
        <script>
            jQuery
                .fn
                .dataTable
                .Api
                .register('processing()', function (show) {
                    return this.iterator('table', function (ctx) {
                        ctx
                            .oApi
                            ._fnProcessingDisplay(ctx, show);
                    });
                });
        </script>
        
        @yield('js')
        
    </body>
</html>