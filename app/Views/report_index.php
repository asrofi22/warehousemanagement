<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard Laporan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">Dashboard Laporan</h4>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?= base_url('report/incoming') ?>" class="btn btn-primary w-100 mb-3">Laporan
                                Barang Masuk</a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('report/outgoing') ?>" class="btn btn-primary w-100 mb-3">Laporan
                                Barang Keluar</a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('report/stock') ?>" class="btn btn-primary w-100 mb-3">Laporan Stok
                                Terkini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page-wrapper-->
<?= $this->endSection() ?>