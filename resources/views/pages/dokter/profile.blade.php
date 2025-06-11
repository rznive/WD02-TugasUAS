@include('layouts.header', ['title' => 'Edit Profile Dokter'])
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
            <a href="/pages/dokter/pasien" class="nav-link">
                <i class="nav-icon fas fa-user-injured"></i>
                <p>
                    Periksa Pasien
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/dokter/riwayatPeriksa" class="nav-link">
                <i class="nav-icon fas fa-history"></i>
                <p>
                    Riwayat Periksa
                </p>
            </a>
        <li class="nav-item">
            <a href="/pages/dokter/profile" class="nav-link active">
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
                        <li class="breadcrumb-item active">Edit Profile</li>
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
                <!-- left column -->
                <div class="col-md">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="/pages/admin/dokter">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="dokter">Nama Dokter</label>
                                    <input type="text" class="form-control" id="nama" value="{{ old('nama', auth()->user()->nama) }}" name="nama"
                                        placeholder="Input nama dokter" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Input alamat dokter" required>{{ old('alamat', auth()->user()->alamat) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No Hp</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" required
                                        placeholder="Input phone number">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
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
