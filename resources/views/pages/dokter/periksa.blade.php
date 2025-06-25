@include('layouts.header', ['title' => 'CRUD Jadwal Dokter'])
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
            <a href="/pages/dokter/periksaPasien" class="nav-link active">
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
                            <h3 class="card-title">List Pasien</h3>
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
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalPeriksa{{ $periksa->id }}">
                                                    PERIKSA
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @foreach ($listPeriksa as $periksa)
                                <div class="modal fade" id="modalPeriksa{{ $periksa->id }}" tabindex="-1"
                                    aria-labelledby="modalPeriksaLabel{{ $periksa->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('periksaPasien.dokter') }}" method="POST"
                                                onsubmit="return confirm('Simpan data pemeriksaan?')">
                                                @csrf
                                                <input type="hidden" name="id_daftar_poli" value="{{ $periksa->id }}">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title" id="modalPeriksaLabel{{ $periksa->id }}">
                                                        Periksa Pasien – {{ $periksa->pasien->nama }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Nama Pasien</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $periksa->pasien->nama }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Tanggal Periksa</label>
                                                        <input type="text" class="form-control" name="tgl_periksa"
                                                            value="{{ now()->format('Y-m-d') }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Catatan Dokter</label>
                                                        <textarea name="catatan" class="form-control" rows="3" required></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Obat</label>
                                                        <div class="row">
                                                            @foreach ($listObat as $obat)
                                                                <div class="col-md-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input obat-checkbox"
                                                                            type="checkbox" name="obat[]"
                                                                            value="{{ $obat->id }}"
                                                                            data-harga="{{ $obat->harga }}"
                                                                            id="obat{{ $periksa->id }}-{{ $obat->id }}">
                                                                        <label class="form-check-label"
                                                                            for="obat{{ $periksa->id }}-{{ $obat->id }}">
                                                                            {{ $obat->nama_obat }} –
                                                                            {{ $obat->kemasan }} <span
                                                                                class="text-muted">(Rp
                                                                                {{ number_format($obat->harga, 0, ',', '.') }})</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Total Biaya</label>
                                                        <input type="text" class="form-control biaya-total"
                                                            name="biaya_periksa" readonly value="150000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".modal").forEach(function(modal) {
            const checkboxes = modal.querySelectorAll(".obat-checkbox");
            const biayaInput = modal.querySelector(".biaya-total");
            const biayaDasar = 150000;

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    let total = biayaDasar;
                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            total += parseInt(cb.dataset.harga);
                        }
                    });
                    biayaInput.value = total;
                });
            });
        });
    });
</script>

@include('layouts.footer')
