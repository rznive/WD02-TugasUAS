@include('layouts.header', ['title' => 'Riwayat Periksa'])
<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/pages/dokter" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/dokter/jadwalPeriksa" class="nav-link">
                <i class="nav-icon fas fa-hospital"></i>
                <p>
                    Jadwal Periksa
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/dokter/periksaPasien" class="nav-link">
                <i class="nav-icon fas fa-user-injured"></i>
                <p>
                    Periksa Pasien
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/dokter/riwayatPeriksa" class="nav-link active">
                <i class="nav-icon fas fa-history"></i>
                <p>
                    Riwayat Periksa
                </p>
            </a>
        <li class="nav-item">
            <a href="/pages/dokter/profile" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Edit Profile
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Periksa Pasien</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Periksa Pasien</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pasien</th>
                                        <th>Keluhan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listPeriksa as $periksa)
                                        <tr>
                                            <td>{{ $periksa->no_antrian }}</td>
                                            <td>{{ $periksa->pasien->nama }}</td>
                                            <td>{{ $periksa->keluhan }}</td>
                                            <td>
                                                DETAIL
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

@include('layouts.footer')
