<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Transaksi Barang Masuk</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Tambah Transaksi Barang Masuk Baru' : 'Edit Transaksi Barang Masuk') : 'Daftar Transaksi Barang Masuk' ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if (!isset($mode) || ($mode !== 'create' && $mode !== 'edit')): ?>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="<?= base_url('incoming-item/create') ?>" class="btn btn-primary">Tambah Transaksi
                                Barang Masuk Baru</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Form Tambah Transaksi Barang Masuk' : 'Form Edit Transaksi Barang Masuk') : 'Daftar Transaksi Barang Masuk' ?>
                        </h4>
                    </div>
                    <hr />
                    <?php if (isset($mode) && ($mode === 'create' || $mode === 'edit')): ?>
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <p><?= esc($error) ?></p>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form
                            action="<?= $mode === 'create' ? base_url('incoming-item/store') : base_url('incoming-item/update/' . $incoming_item['id']) ?>"
                            method="post">
                            <div class="mb-3">
                                <label for="purchase_id" class="form-label">Pembelian</label>
                                <select class="form-control" id="purchase_id" name="purchase_id">
                                    <option value="">Pilih Pembelian</option>
                                    <?php foreach ($purchases as $purchase): ?>
                                        <option value="<?= $purchase['id'] ?>" <?= isset($incoming_item) && $incoming_item['purchase_id'] == $purchase['id'] ? 'selected' : '' ?>>
                                            <?= esc($purchase['vendor_name']) . ' - ' . esc(date('d-m-Y H:i', strtotime($purchase['purchase_date']))) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="datetime-local" class="form-control" id="date" name="date"
                                    value="<?= isset($incoming_item) ? date('Y-m-d\TH:i', strtotime($incoming_item['date'])) : old('date') ?>"
                                    placeholder="Pilih tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" step="0.01"
                                    value="<?= isset($incoming_item) ? esc($incoming_item['quantity']) : old('quantity') ?>"
                                    placeholder="Masukkan jumlah">
                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light"><?= $mode === 'create' ? 'Simpan' : 'Perbarui' ?></button>
                            <a href="<?= base_url('incoming-item') ?>" class="btn btn-secondary waves-effect">Batal</a>
                        </form>
                    <?php else: ?>
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= esc(session()->getFlashdata('message')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <p><?= esc($error) ?></p>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Vendor</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($incoming_items)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi barang masuk ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($incoming_items as $item): ?>
                                            <tr>
                                                <td><?= esc($item['id']) ?></td>
                                                <td><?= esc($item['vendor_name']) ?></td>
                                                <td><?= esc(date('d-m-Y H:i', strtotime($item['date']))) ?></td>
                                                <td><?= esc($item['quantity']) ?></td>
                                                <td><?= esc($item['purchase_quantity']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('incoming-item/edit/' . $item['id']) ?>"
                                                        class="btn btn-sm btn-warning waves-effect waves-light">Edit</a>
                                                    <a href="<?= base_url('incoming-item/delete/' . $item['id']) ?>"
                                                        class="btn btn-sm btn-danger waves-effect waves-light"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi barang masuk ini?')">Hapus</a>
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
    <!--end page-content-wrapper-->
</div>
<!--end page-wrapper-->
<?= $this->endSection(); ?>