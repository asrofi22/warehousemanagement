<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($mode) && $mode === 'create' ? 'Tambah User Baru' : (isset($user->id) ? 'Edit User' : 'Daftar User') ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php if (!isset($mode) && !isset($user->id)): ?>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="<?= base_url('user/create') ?>" class="btn btn-primary">Tambah User Baru</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <?= isset($mode) && $mode === 'create' ? 'Form Tambah User' : (isset($user->id) ? 'Form Edit User' : 'Daftar User') ?>
                        </h4>
                    </div>
                    <hr />
                    <?php if (isset($mode) && $mode === 'create' || isset($user->id)): ?>
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <p><?= esc($error) ?></p>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form
                            action="<?= isset($user->id) ? base_url('user/update/' . $user->id) : base_url('user/store') ?>"
                            method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= old('email', $user->email ?? '') ?>" placeholder="Masukkan email" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="<?= old('username', $user->username ?? '') ?>" placeholder="Masukkan username"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password"
                                    class="form-label"><?= isset($user->id) ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password' ?></label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password" <?= isset($user->id) ? '' : 'required' ?>>
                            </div>
                            <div class="mb-3">
                                <label for="active" class="form-label">Active</label>
                                <input type="checkbox" id="active" name="active" value="1" <?= old('active', ($user->active ?? 0)) ? 'checked' : '' ?>>
                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light"><?= isset($user->id) ? 'Perbarui' : 'Simpan' ?></button>
                            <a href="<?= base_url('user') ?>" class="btn btn-secondary waves-effect">Batal</a>
                        </form>
                    <?php else: ?>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= esc(session()->getFlashdata('success')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada user ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($users as $index => $u): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($u->email) ?></td>
                                                <td><?= esc($u->username) ?></td>
                                                <td><?= $u->active ? 'Yes' : 'No' ?></td>
                                                <td><?= esc($u->created_at) ?></td>
                                                <td>
                                                    <a href="<?= base_url('user/edit/' . $u->id) ?>"
                                                        class="btn btn-sm btn-warning waves-effect waves-light">Edit</a>
                                                    <a href="<?= base_url('user/delete/' . $u->id) ?>"
                                                        class="btn btn-sm btn-danger waves-effect waves-light"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
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
<?= $this->endSection() ?>