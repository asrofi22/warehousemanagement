<?php $this->extend('layouts/template'); ?>

<?php $this->section('content'); ?>
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-4">
                <div class="breadcrumb-title pe-3">Transaksi Barang Masuk</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= $mode === 'create' ? 'Tambah Baru' : 'Daftar' ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if ($mode === 'index'): ?>
                    <div class="ms-auto">
                        <a href="<?= base_url('incoming-item/create') ?>" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Baru
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= $mode === 'create' ? 'Tambah Transaksi Barang Masuk' : 'Daftar Transaksi Barang Masuk' ?>
                        </h4>
                    </div>
                    <hr />

                    <!-- Notifications -->
                    <?php if (session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle"></i> <?= esc(session('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error"></i> <?= esc(session('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Create Form -->
                    <?php if ($mode === 'create'): ?>
                        <form action="<?= base_url('incoming-item/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="purchase_id" class="form-label fw-bold">Pembelian <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="purchase_id" name="purchase_id" required>
                                            <option value="" disabled selected>Pilih Pembelian</option>
                                            <?php foreach ($purchases as $purchase): ?>
                                                <option value="<?= esc($purchase['id']) ?>"
                                                    data-quantity="<?= esc($purchase['total_quantity']) ?>"
                                                    <?= old('purchase_id') == $purchase['id'] ? 'selected' : '' ?>>
                                                    <?= esc($purchase['vendor_name']) ?> -
                                                    <?= date('d/m/Y', strtotime($purchase['purchase_date'])) ?> -
                                                    Total: <?= number_format($purchase['total_quantity'], 0) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (empty($purchases)): ?>
                                            <small class="text-danger mt-1 d-block">
                                                Tidak ada pembelian yang tersedia. Pastikan ada pembelian yang belum memiliki
                                                transaksi barang masuk dan memiliki jumlah > 0.
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label fw-bold">Tanggal Barang Masuk <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="date" name="date" required
                                            value="<?= esc(old('date', date('Y-m-d\TH:i'))) ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jumlah Barang Masuk</label>
                                        <div class="form-control bg-light" id="quantity-display">0</div>
                                        <small class="form-text text-muted">Jumlah otomatis sesuai total pembelian</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" <?= empty($purchases) ? 'disabled' : '' ?>>
                                    <i class="bx bx-save"></i> Simpan
                                </button>
                                <a href="<?= base_url('incoming-item') ?>" class="btn btn-secondary">
                                    <i class="bx bx-arrow-back"></i> Kembali
                                </a>
                            </div>
                        </form>

                        <!-- JavaScript for Quantity Display -->
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const purchaseSelect = document.getElementById('purchase_id');
                                const quantityDisplay = document.getElementById('quantity-display');

                                if (purchaseSelect) {
                                    purchaseSelect.addEventListener('change', () => {
                                        const selectedOption = purchaseSelect.options[purchaseSelect.selectedIndex];
                                        const quantity = selectedOption?.getAttribute('data-quantity') || '0';
                                        quantityDisplay.textContent = parseInt(quantity).toLocaleString('id-ID');
                                    });

                                    // Trigger change event if a value is pre-selected
                                    if (purchaseSelect.value) {
                                        purchaseSelect.dispatchEvent(new Event('change'));
                                    }
                                }
                            });
                        </script>

                        <!-- Index/List View -->
                    <?php else: ?>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vendor</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Tanggal Barang Masuk</th>
                                        <th>Jumlah</th>
                                        <th>Pembeli</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($incoming_items)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="bx bx-package text-muted" style="font-size: 3rem;"></i>
                                                <p class="mt-2 text-muted">Belum ada transaksi barang masuk</p>
                                                <a href="<?= base_url('incoming-item/create') ?>" class="btn btn-primary mt-2">
                                                    <i class="bx bx-plus"></i> Buat Transaksi Pertama
                                                </a>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($incoming_items as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= isset($item['vendor_name']) ? esc($item['vendor_name']) : '-' ?></td>
                                                <td><?= isset($item['purchase_date']) ? date('d/m/Y', strtotime($item['purchase_date'])) : '-' ?>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($item['date'])) ?></td>
                                                <td><?= number_format($item['quantity'], 0) ?></td>
                                                <td><?= isset($item['buyer_name']) ? esc($item['buyer_name']) : '-' ?></td>
                                                <td>
                                                    <a href="<?= base_url('incoming-item/delete/' . $item['id']) ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus transaksi ini? Stok produk akan dikurangi. Yakin?')">
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>