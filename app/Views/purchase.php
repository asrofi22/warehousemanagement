<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Manajemen Pembelian</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Tambah Pembelian Baru' : 'Edit Pembelian') : 'Daftar Pembelian' ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if (!isset($mode) || ($mode !== 'create' && $mode !== 'edit')): ?>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="<?= base_url('purchase/create') ?>" class="btn btn-primary">Tambah Pembelian Baru</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Form Tambah Pembelian' : 'Form Edit Pembelian') : 'Daftar Pembelian' ?>
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
                            action="<?= $mode === 'create' ? base_url('purchase/store') : base_url('purchase/update/' . $purchase['id']) ?>"
                            method="post">
                            <div class="mb-3">
                                <label for="vendor_name" class="form-label">Nama Vendor</label>
                                <input type="text" class="form-control" id="vendor_name" name="vendor_name"
                                    value="<?= isset($purchase) ? esc($purchase['vendor_name']) : old('vendor_name') ?>"
                                    placeholder="Masukkan nama vendor">
                            </div>
                            <div class="mb-3">
                                <label for="vendor_address" class="form-label">Alamat Vendor</label>
                                <textarea class="form-control" id="vendor_address" name="vendor_address"
                                    placeholder="Masukkan alamat vendor"><?= isset($purchase) ? esc($purchase['vendor_address']) : old('vendor_address') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="purchase_date" class="form-label">Tanggal Pembelian</label>
                                <input type="datetime-local" class="form-control" id="purchase_date" name="purchase_date"
                                    value="<?= isset($purchase) ? date('Y-m-d\TH:i', strtotime($purchase['purchase_date'])) : old('purchase_date') ?>"
                                    placeholder="Pilih tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_name" class="form-label">Nama Pembeli</label>
                                <input type="text" class="form-control" id="buyer_name" name="buyer_name"
                                    value="<?= isset($purchase) ? esc($purchase['buyer_name']) : old('buyer_name') ?>"
                                    placeholder="Masukkan nama pembeli">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail Barang</label>
                                <div id="items-container">
                                    <?php if (isset($items) && !empty($items)): ?>
                                        <?php foreach ($items as $index => $item): ?>
                                            <div class="item-row mb-2">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <select class="form-control" name="items[<?= $index ?>][product_id]">
                                                            <option value="">Pilih Produk</option>
                                                            <?php foreach ($products as $product): ?>
                                                                <option value="<?= $product['id'] ?>"
                                                                    <?= $item['product_id'] == $product['id'] ? 'selected' : '' ?>>
                                                                    <?= esc($product['name']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="number" class="form-control"
                                                            name="items[<?= $index ?>][quantity]"
                                                            value="<?= esc($item['quantity']) ?>" placeholder="Jumlah" step="0.01">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="item-row mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <select class="form-control" name="items[0][product_id]">
                                                        <option value="">Pilih Produk</option>
                                                        <?php foreach ($products as $product): ?>
                                                            <option value="<?= $product['id'] ?>"><?= esc($product['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" class="form-control" name="items[0][quantity]"
                                                        placeholder="Jumlah" step="0.01">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="btn btn-secondary mt-2" id="add-item">Tambah Item</button>
                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light"><?= $mode === 'create' ? 'Simpan' : 'Perbarui' ?></button>
                            <a href="<?= base_url('purchase') ?>" class="btn btn-secondary waves-effect">Batal</a>
                        </form>
                        <script>
                            document.getElementById('add-item').addEventListener('click', function () {
                                const container = document.getElementById('items-container');
                                const index = container.children.length;
                                const row = document.createElement('div');
                                row.className = 'item-row mb-2';
                                row.innerHTML = `
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select class="form-control" name="items[${index}][product_id]">
                                                <option value="">Pilih Produk</option>
                                                <?php foreach ($products as $product): ?>
                                                    <option value="<?= $product['id'] ?>"><?= esc($product['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" name="items[${index}][quantity]" placeholder="Jumlah" step="0.01">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                        </div>
                                    </div>
                                `;
                                container.appendChild(row);
                            });

                            document.addEventListener('click', function (e) {
                                if (e.target.classList.contains('remove-item')) {
                                    e.target.closest('.item-row').remove();
                                }
                            });
                        </script>
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
                                        <th>Nama Vendor</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Nama Pembeli</th>
                                        <th>Jumlah Item</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($purchases)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada pembelian ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($purchases as $index => $purchase): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($purchase['vendor_name']) ?></td>
                                                <td><?= esc(date('d-m-Y H:i', strtotime($purchase['purchase_date']))) ?></td>
                                                <td><?= esc($purchase['buyer_name']) ?></td>
                                                <td><?= esc($purchase['item_count']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('purchase/edit/' . $purchase['id']) ?>"
                                                        class="btn btn-sm btn-warning waves-effect waves-light">Edit</a>
                                                    <a href="<?= base_url('purchase/delete/' . $purchase['id']) ?>"
                                                        class="btn btn-sm btn-danger waves-effect waves-light"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pembelian ini?')">Hapus</a>
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