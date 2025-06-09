@include('layouts.header', ['title' => 'CRUD Pasien'])
<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/pages/admin" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/admin/dokter" class="nav-link">
                <i class="nav-icon fas fa-user-md"></i>
                <p>
                    CRUD Dokter
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/admin/pasien" class="nav-link active">
                <i class="nav-icon fas fa-user-injured"></i>
                <p>
                    CRUD Pasien
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/admin/poli" class="nav-link">
                <i class="nav-icon fas fa-hospital"></i>
                <p>
                    CRUD Poli
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/admin/obat" class="nav-link">
                <i class="nav-icon fas fa-pills"></i>
                <p>
                    CRUD Obat
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
                        <li class="breadcrumb-item active">CRUD Pasien</li>
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
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pasien</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="/pages/admin/pasien">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama Pasien</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Input nama Pasien" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Input alamat pasien" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="no_ktp">No KTP</label>
                                    <input type="number" class="form-control" id="no_ktp" name="no_ktp"
                                        placeholder="Input No KTP" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No Hp</label>
                                    <input type="number" class="form-control" id="no_hp" name="no_hp"
                                        placeholder="Input phone number" required>
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
                <!-- right column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">List Pasien</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No KTP</th>
                                        <th>No HP</th>
                                        <th>No RM</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listPasien as $Pasien)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $Pasien->nama }}</td>
                                            <td>{{ $Pasien->alamat }}</td>
                                            <td>{{ $Pasien->no_ktp }}</td>
                                            <td>{{ $Pasien->no_hp }}</td>
                                            <td>{{ $Pasien->no_rm }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('deletePasien.admin', $Pasien->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin hapus Pasien ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
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
