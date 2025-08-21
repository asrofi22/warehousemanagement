<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Produk</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Tambah Produk Baru' : 'Edit Produk') : 'Daftar Produk' ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if (!isset($mode) || ($mode !== 'create' && $mode !== 'edit')): ?>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="<?= base_url('product/create') ?>" class="btn btn-primary">Tambah Produk Baru</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Form Tambah Produk' : 'Form Edit Produk') : 'Daftar Produk' ?>
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
                            action="<?= $mode === 'create' ? base_url('product/store') : base_url('product/update/' . $product['id']) ?>"
                            method="post">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= isset($product) && $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                            <?= esc($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= isset($product) ? esc($product['name']) : old('name') ?>"
                                    placeholder="Masukkan nama produk">
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="<?= isset($product) ? esc($product['code']) : old('code') ?>"
                                    placeholder="Masukkan kode produk">
                            </div>
                            <div class="mb-3">
                                <label for="unit" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit"
                                    value="<?= isset($product) ? esc($product['unit']) : old('unit') ?>"
                                    placeholder="Masukkan satuan">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" step="0.01"
                                    value="<?= isset($product) ? esc($product['stock']) : old('stock', 0) ?>"
                                    placeholder="Masukkan jumlah stok">
                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light"><?= $mode === 'create' ? 'Simpan' : 'Perbarui' ?></button>
                            <a href="<?= base_url('product') ?>" class="btn btn-secondary waves-effect">Batal</a>
                        </form>
                    <?php else: ?>
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= esc(session()->getFlashdata('message')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kategori</th>
                                        <th>Nama Produk</th>
                                        <th>Kode</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada produk ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?= esc($product['id']) ?></td>
                                                <td><?= esc($product['category_name']) ?></td>
                                                <td><?= esc($product['name']) ?></td>
                                                <td><?= esc($product['code']) ?></td>
                                                <td><?= esc($product['unit']) ?></td>
                                                <td><?= esc($product['stock']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('product/edit/' . $product['id']) ?>"
                                                        class="btn btn-sm btn-warning waves-effect waves-light">Edit</a>
                                                    <a href="<?= base_url('product/delete/' . $product['id']) ?>"
                                                        class="btn btn-sm btn-danger waves-effect waves-light"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
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