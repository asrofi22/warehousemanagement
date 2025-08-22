<?php
// Ensure CSRF field is included for form submissions
helper('form');
?>
<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= $title ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="<?= base_url('report/incoming') ?>"
                            class="btn btn-primary <?= $mode === 'incoming' ? 'active' : '' ?>">Barang Masuk</a>
                        <a href="<?= base_url('report/outgoing') ?>"
                            class="btn btn-primary <?= $mode === 'outgoing' ? 'active' : '' ?>">Barang Keluar</a>
                        <a href="<?= base_url('report/stock') ?>"
                            class="btn btn-primary <?= $mode === 'stock' ? 'active' : '' ?>">Stok Terkini</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0"><?= $title ?></h4>
                    </div>
                    <hr />
                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= esc(session()->getFlashdata('message')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($mode === 'incoming' || $mode === 'outgoing'): ?>
                        <!-- Date Range Filter Form with Print Button -->
                        <form
                            action="<?= $mode === 'incoming' ? base_url('report/incoming') : base_url('report/outgoing') ?>"
                            method="get" class="mb-4">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?= esc($start_date ?? date('Y-m-d', strtotime('-30 days'))) ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?= esc($end_date ?? date('Y-m-d')) ?>" required>
                                </div>
                                <div class="col-md-4 align-self-end">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Filter</button>
                                    <button type="button" onclick="printReport()"
                                        class="btn btn-success waves-effect waves-light">Cetak Laporan</button>
                                </div>
                            </div>
                        </form>
                    <?php else: // mode === 'stock' ?>
                        <!-- Print Button for Stock Mode -->
                        <div class="mb-3">
                            <button type="button" onclick="printReport()"
                                class="btn btn-success waves-effect waves-light">Cetak Laporan</button>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive" id="report-table">
                        <?php if ($mode === 'incoming'): ?>
                            <h5 class="print-only"><?= $title ?> (<?= esc($start_date) ?> - <?= esc($end_date) ?>)</h5>
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($incoming_items)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada barang masuk ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($incoming_items as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($item['product_code']) ?></td>
                                                <td><?= esc($item['product_name']) ?></td>
                                                <td><?= esc($item['date']) ?></td>
                                                <td><?= esc($item['quantity']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php elseif ($mode === 'outgoing'): ?>
                            <h5 class="print-only"><?= $title ?> (<?= esc($start_date) ?> - <?= esc($end_date) ?>)</h5>
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($outgoing_items)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada barang keluar ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($outgoing_items as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($item['product_code']) ?></td>
                                                <td><?= esc($item['product_name']) ?></td>
                                                <td><?= esc($item['date']) ?></td>
                                                <td><?= esc($item['quantity']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php else: // mode === 'stock' ?>
                            <h5 class="print-only"><?= $title ?> (Per <?= date('Y-m-d') ?>)</h5>
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada produk ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($products as $index => $product): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($product['code']) ?></td>
                                                <td><?= esc($product['name']) ?></td>
                                                <td><?= esc($product['category_name'] ?? '-') ?></td>
                                                <td><?= esc($product['unit']) ?></td>
                                                <td><?= esc($product['stock']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page-content-wrapper-->
</div>
<!--end page-wrapper-->

<!-- Print-specific CSS -->
<!-- Print-specific CSS -->
<style>
    /* Default (normal screen) : sembunyikan area cetak */
    #print-area {
        display: none;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #print-area,
        #print-area * {
            visibility: visible;
        }

        #print-area {
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
        }

        .header-report {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-report h2,
        .header-report h4 {
            margin: 0;
            padding: 0;
        }

        .header-line {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            margin: 10px 0 20px 0;
        }

        .print-title {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        .footer-report {
            margin-top: 40px;
        }

        .footer-sign {
            float: right;
            text-align: center;
            margin-top: 60px;
        }

        /* elemen-elemen yang tidak perlu ikut cetak */
        .btn,
        .page-breadcrumb,
        .alert,
        form,
        .card-title,
        .btn-group,
        #report-table {
            display: none !important;
        }
    }
</style>

<!-- Cetak Area -->
<div id="print-area">
    <div class="header-report">
        <h2>PT Asrofi</h2>
        <h4><?= $title ?></h4>
        <div class="header-line"></div>
    </div>

    <div class="print-title">
        <?php if ($mode === 'incoming' || $mode === 'outgoing'): ?>
            Periode: <?= esc($start_date) ?> s/d <?= esc($end_date) ?>
        <?php else: ?>
            Per <?= date('Y-m-d') ?>
        <?php endif; ?>
    </div>

    <div>
        <?php if ($mode === 'incoming'): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($incoming_items)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada barang masuk ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($incoming_items as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($item['product_code']) ?></td>
                                <td><?= esc($item['product_name']) ?></td>
                                <td><?= esc($item['date']) ?></td>
                                <td><?= esc($item['quantity']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php elseif ($mode === 'outgoing'): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($outgoing_items)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada barang keluar ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($outgoing_items as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($item['product_code']) ?></td>
                                <td><?= esc($item['product_name']) ?></td>
                                <td><?= esc($item['date']) ?></td>
                                <td><?= esc($item['quantity']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada produk ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $index => $product): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($product['code']) ?></td>
                                <td><?= esc($product['name']) ?></td>
                                <td><?= esc($product['category_name'] ?? '-') ?></td>
                                <td><?= esc($product['unit']) ?></td>
                                <td><?= esc($product['stock']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="footer-report">
        <div class="footer-sign">
            <?= date('d F Y') ?><br>
            Mengetahui,<br><br><br><br>
            <u>(___________________)</u><br>
            Manager
        </div>
    </div>
</div>

<script>
    function printReport() {
        const printArea = document.querySelector('#print-area');
        const tableBody = printArea.querySelector('tbody');
        if (tableBody && tableBody.textContent.includes('Tidak ada')) {
            alert('Tidak ada data untuk dicetak!');
            return;
        }
        window.print();
    }
</script>


<?= $this->endSection() ?>