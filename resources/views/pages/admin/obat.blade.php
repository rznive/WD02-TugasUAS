@include('layouts.header', ['title' => 'CRUD Obat'])
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
            <a href="/pages/admin/pasien" class="nav-link">
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
            <a href="/pages/admin/obat" class="nav-link active">
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
                        <li class="breadcrumb-item active">CRUD Obat</li>
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
                            <h3 class="card-title">Daftar Obat</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="/pages/admin/obat">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_obat">Nama Obat</label>
                                    <input type="text" class="form-control" id="nama_obat" name="nama_obat"
                                        placeholder="Input nama Obat" required>
                                </div>
                                <div class="form-group">
                                    <label for="kemasan">Kemasan</label>
                                    <textarea class="form-control" id="kemasan" name="kemasan" placeholder="Input Kemasan" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <textarea class="form-control" id="harga" name="harga" placeholder="Input Harga" required></textarea>
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
                            <h3 class="card-title">List Obat</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Kemasan</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listObat as $Obat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $Obat->nama_obat }}</td>
                                            <td>{{ $Obat->kemasan }}</td>
                                            <td>{{ $Obat->harga }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary btn-edit-obat"
                                                        data-id="{{ $Obat->id }}" data-nama="{{ $Obat->nama_obat }}"
                                                        data-kemasan="{{ $Obat->kemasan }}"
                                                        data-harga="{{ $Obat->harga }}" data-toggle="modal"
                                                        data-target="#editObatModal">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>

                                                    <form action="{{ route('deleteObat.admin', $Obat->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin hapus Obat ini?')">
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
<div class="modal fade" id="editObatModal" tabindex="-1" role="dialog" aria-labelledby="editObatModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="/pages/admin/obat">
            @csrf
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-nama_obat">Nama Obat</label>
                        <input type="text" class="form-control" id="edit-nama_obat" name="nama_obat" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-kemasan">Kemasan</label>
                        <textarea class="form-control" id="edit-kemasan" name="kemasan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-harga">Harga</label>
                        <textarea class="form-control" id="edit-harga" name="harga" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit-obat');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-nama_obat').value = this.dataset.nama;
                document.getElementById('edit-kemasan').value = this.dataset.kemasan;
                document.getElementById('edit-harga').value = this.dataset.harga;
            });
        });
    });
</script>

@include('layouts.footer')
