<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Kategori</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Tambah Kategori Baru' : 'Edit Kategori') : 'Daftar Kategori' ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if (!isset($mode) || ($mode !== 'create' && $mode !== 'edit')): ?>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="<?= base_url('category/create') ?>" class="btn btn-primary">Tambah Kategori Baru</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= isset($mode) && ($mode === 'create' || $mode === 'edit') ? ($mode === 'create' ? 'Form Tambah Kategori' : 'Form Edit Kategori') : 'Daftar Kategori' ?>
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
                            action="<?= $mode === 'create' ? base_url('category/store') : base_url('category/update/' . $category['id']) ?>"
                            method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= isset($category) ? esc($category['name']) : old('name') ?>"
                                    placeholder="Masukkan nama kategori">
                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light"><?= $mode === 'create' ? 'Simpan' : 'Perbarui' ?></button>
                            <a href="<?= base_url('category') ?>" class="btn btn-secondary waves-effect">Batal</a>
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
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($categories)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada kategori ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td><?= esc($category['id']) ?></td>
                                                <td><?= esc($category['name']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('category/edit/' . $category['id']) ?>"
                                                        class="btn btn-sm btn-warning waves-effect waves-light">Edit</a>
                                                    <a href="<?= base_url('category/delete/' . $category['id']) ?>"
                                                        class="btn btn-sm btn-danger waves-effect waves-light"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</a>
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