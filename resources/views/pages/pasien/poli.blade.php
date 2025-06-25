@include('layouts.header', ['title' => 'Daftar Poli'])
<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/pages/pasien" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/pages/pasien/poli" class="nav-link active">
                <i class="nav-icon fas fa-hospital"></i>
                <p>
                    Poli
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
                        <li class="breadcrumb-item active">Poli</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- /.content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-4">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Poli</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="/pages/pasien/poli">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_rm">No Rekam Medis</label>
                                    <input type="text" class="form-control" id="no_rm" name="no_rm"
                                        value="{{ auth()->user()->no_rm }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="poliSelect">Pilih Poli</label>
                                    <select class="form-control" id="poliSelect" name="id_poli">
                                        @foreach ($poliList as $poli)
                                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jadwalSelect">Pilih Jadwal [under maintenancee bosq]</label>
                                    <select class="form-control" id="jadwalSelect" name="id_jadwal">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keluhan">Keluhan</label>
                                    <textarea class="form-control" id="keluhan" name="keluhan" placeholder="Masukkan keluhan Anda"></textarea>
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
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Daftar Poli</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Jam</th>
                                        <th>Antrian</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showDaftarPoli as $daftarPoli)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $daftarPoli->jadwalPeriksa?->dokter?->poli?->nama_poli ?? '-' }}</td>
                                            <td>{{ $daftarPoli->jadwalPeriksa?->dokter?->nama ?? '-' }}</td>
                                            <td>{{ $daftarPoli->jadwalPeriksa?->hari ?? '-' }},
                                                {{ $daftarPoli->jadwalPeriksa?->jam_mulai ?? '-' }} -
                                                {{ $daftarPoli->jadwalPeriksa?->jam_selesai ?? '-' }}</td>
                                            <td>{{ $daftarPoli->no_antrian }}</td>
                                            <td class="text-center">
                                                @if (is_null($daftarPoli->Periksa?->tgl_periksa))
                                                    Belum Diperiksa
                                                @else
                                                    <span
                                                        class="badge bg-info">Diperiksa {{ $daftarPoli->Periksa?->tgl_periksa }}</span>
                                                @endif
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#poliSelect').on('change', function() {
            var poliId = $(this).val();

            if (poliId) {
                $.ajax({
                    url: '/get-jadwal-by-poli/' + poliId,
                    type: 'GET',
                    success: function(data) {
                        $('#jadwalSelect').empty().append(
                            '');
                        $.each(data, function(index, jadwal) {
                            $('#jadwalSelect').append(
                                '<option value="' + jadwal.id + '">' +
                                jadwal.hari + ' - ' + jadwal.jam_mulai +
                                '</option>'
                            );
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data jadwal.');
                    }
                });
            } else {
                $('#jadwalSelect').html('');
            }
        });
    });
</script>
@include('layouts.footer')
