<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Item Keluar</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Tambah Item Keluar Baru' : 'Edit Item Keluar') : 'Daftar Item Keluar' ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if (!isset($mode) || ($mode !== 'create' && $mode !== 'edit')): ?>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="<?= base_url('outgoing-item/create') ?>" class="btn btn-primary">Tambah Item Keluar
                                Baru</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Form Tambah Item Keluar' : 'Form Edit Item Keluar') : 'Daftar Item Keluar' ?>
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
                            action="<?= $mode === 'create' ? base_url('outgoing-item/store') : base_url('outgoing-item/update/' . $outgoing_item['id']) ?>"
                            method="post">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Produk</label>
                                <select class="form-control" id="product_id" name="product_id">
                                    <option value="">Pilih Produk</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['id'] ?>" <?= isset($outgoing_item) && $outgoing_item['product_id'] == $product['id'] ? 'selected' : '' ?>>
                                            <?= esc($product['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="datetime-local" class="form-control" id="date" name="date"
                                    value="<?= isset($outgoing_item) ? date('Y-m-d\TH:i', strtotime($outgoing_item['date'])) : old('date') ?>"
                                    placeholder="Pilih tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" step="0.01"
                                    value="<?= isset($outgoing_item) ? esc($outgoing_item['quantity']) : old('quantity') ?>"
                                    placeholder="Masukkan jumlah">
                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light"><?= $mode === 'create' ? 'Simpan' : 'Perbarui' ?></button>
                            <a href="<?= base_url('outgoing-item') ?>" class="btn btn-secondary waves-effect">Batal</a>
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
                                        <th>#</th>
                                        <th>Produk</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($outgoing_items)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada item keluar ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($outgoing_items as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($item['product_name']) ?></td>
                                                <td><?= esc(date('d-m-Y H:i', strtotime($item['date']))) ?></td>
                                                <td><?= esc($item['quantity']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('outgoing-item/edit/' . $item['id']) ?>"
                                                        class="btn btn-sm btn-warning waves-effect waves-light">Edit</a>
                                                    <a href="<?= base_url('outgoing-item/delete/' . $item['id']) ?>"
                                                        class="btn btn-sm btn-danger waves-effect waves-light"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus item keluar ini?')">Hapus</a>
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