<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<!--page-wrapper-->
<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="card radius-15 bg-voilet">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="mb-0 text-white">
                                        <?= $total_purchases ?> <i class='bx bxs-up-arrow-alt font-14 text-white'></i>
                                    </h2>
                                </div>
                                <div class="ms-auto font-35 text-white"><i class="bx bx-cart"></i></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Pembelian</p>
                                </div>
                                <!-- <div class="ms-auto font-14 text-white">+0%</div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card radius-15 bg-primary-blue">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="mb-0 text-white"><?= $total_incoming_items ?> <i
                                            class='bx bxs-up-arrow-alt font-14 text-white'></i></h2>
                                </div>
                                <div class="ms-auto font-35 text-white"><i class="bx bx-import"></i></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Barang Masuk</p>
                                </div>
                                <!-- <div class="ms-auto font-14 text-white">+0%</div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card radius-15 bg-rose">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="mb-0 text-white"><?= $total_outgoing_items ?> <i
                                            class='bx bxs-down-arrow-alt font-14 text-white'></i></h2>
                                </div>
                                <div class="ms-auto font-35 text-white"><i class="bx bx-export"></i></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Barang Keluar</p>
                                </div>
                                <!-- <div class="ms-auto font-14 text-white">+0%</div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card radius-15 bg-sunset">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="mb-0 text-white"><?= $total_stock ?> <i
                                            class='bx bxs-up-arrow-alt font-14 text-white'></i></h2>
                                </div>
                                <div class="ms-auto font-35 text-white"><i class="bx bx-package"></i></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Stok</p>
                                </div>
                                <!-- <div class="ms-auto font-14 text-white">+0%</div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            <div class="card radius-15 overflow-hidden">
                <div class="card-header border-bottom-0">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Pembelian/Purchase Terbaru</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="<?= base_url('purchase') ?>" class="btn btn-white btn-sm px-4 radius-15">View
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_purchases as $purchase): ?>
                                    <?php $items = $purchase['items'] ?? []; ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <?= esc($purchase['vendor_name']) ?>
                                            </td>
                                            <td>
                                                <?= esc($purchase['purchase_date']) ?>
                                            </td>
                                            <td>
                                                <?= esc($item['product_name']) ?>
                                            </td>
                                            <td>
                                                <?= esc($item['quantity']) ?>
                                            </td>
                                            <td>
                                                <?php if ($purchase['has_incoming']): ?>
                                                    <span class="btn btn-sm btn-light-success btn-block radius-30">Received</span>
                                                <?php else: ?>
                                                    <span class="btn btn-sm btn-light-warning btn-block radius-30">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page-content-wrapper-->
</div>
<!--end page-wrapper-->
<!--start overlay-->
<div class="overlay toggle-btn-mobile"></div>
<!--end overlay-->
<!--Start Back To Top Button-->
<a href="javascript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<!--footer -->
<div class="footer">
    <p class="mb-0">SIMGudang @2025 | Developed By : <a href="https://asrofi.netlify.app" target="_blank">Asrofi</a></p>
</div>
<!-- end footer -->
<!--start switcher-->
<div class="switcher-body">
    <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i
            class="bx bx-cog bx-spin"></i></button>
    <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="offcanvasScrolling">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <h6 class="mb-0">Theme Variation</h6>
            <hr>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name=" inlineRadioOptions" id="lightmode" value="option1"
                    checked>
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <hr>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="darkmode" value="option2">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <hr>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="darksidebar" value="option3">
                <label class="form-check-label" for="darksidebar">Semi Dark</label>
            </div>
            <hr>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ColorLessIcons"
                    value="option3">
                <label class="form-check-label" for="ColorLessIcons">Color Less Icons</label>
            </div>
        </div>
    </div>
</div>
<!--end switcher-->
<?= $this->endSection(); ?>