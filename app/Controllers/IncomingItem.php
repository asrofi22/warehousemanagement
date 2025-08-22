<?php

namespace App\Controllers;

use App\Models\IncomingItemModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\RedirectResponse;

class IncomingItem extends BaseController
{
    protected $incomingItemModel;
    protected $purchaseModel;
    protected $purchaseItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->incomingItemModel = new IncomingItemModel();
        $this->purchaseModel = new PurchaseModel();
        $this->purchaseItemModel = new PurchaseItemModel();
        $this->productModel = new ProductModel();
    }

    /**
     * Display the list of incoming items.
     *
     * @return string
     */
    public function index(): string
    {
        return view('incoming_item', [
            'mode' => 'index',
            'incoming_items' => $this->incomingItemModel->getIncomingItemsWithDetails(),
        ]);
    }

    /**
     * Display the form to create a new incoming item.
     *
     * @return string
     */
    public function create(): string
    {
        $availablePurchases = $this->getAvailablePurchases();

        return view('incoming_item', [
            'mode' => 'create',
            'purchases' => $availablePurchases,
        ]);
    }

    /**
     * Store a new incoming item and update product stocks.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $purchaseId = $this->request->getPost('purchase_id');
        $date = $this->request->getPost('date');

        // Validate input
        if (!$this->validateInput($purchaseId, $date)) {
            return redirect()->back()->withInput();
        }

        // Validate purchase and items
        $purchase = $this->purchaseModel->find($purchaseId);
        if (!$purchase) {
            return redirect()->back()->withInput()->with('error', 'Pembelian tidak ditemukan');
        }

        if ($this->incomingItemModel->purchaseHasIncoming($purchaseId)) {
            return redirect()->back()->withInput()->with('error', 'Pembelian ini sudah memiliki transaksi barang masuk');
        }

        $items = $this->purchaseItemModel->where('purchase_id', $purchaseId)->findAll();
        if (empty($items)) {
            return redirect()->back()->withInput()->with('error', 'Pembelian tidak memiliki item');
        }

        if (!$this->validatePurchaseItems($items, $purchaseId)) {
            return redirect()->back()->withInput();
        }

        $totalQuantity = $this->purchaseItemModel->getTotalQuantity($purchaseId);
        if ($totalQuantity <= 0) {
            return redirect()->back()->withInput()->with('error', 'Pembelian tidak memiliki item dengan quantity yang valid');
        }

        // Perform database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Save incoming item
            $incomingData = [
                'purchase_id' => $purchaseId,
                'date' => $date,
                'quantity' => $totalQuantity,
            ];

            log_message('debug', 'Inserting incoming item: ' . json_encode($incomingData));
            if (!$this->incomingItemModel->insert($incomingData)) {
                $error = implode(', ', $this->incomingItemModel->errors());
                log_message('error', 'Failed to save incoming item: ' . $error);
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $error);
            }

            // Update product stocks
            foreach ($items as $item) {
                if (!$this->updateProductStock($item['product_id'], $item['quantity'], true)) {
                    $db->transRollback();
                    return redirect()->back()->withInput()->with('error', 'Gagal update stok produk');
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                log_message('error', 'Transaction failed for purchase_id: ' . $purchaseId);
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database');
            }

            return redirect()->to('/incoming-item')->with('success', 'Transaksi barang masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            log_message('error', 'Exception in store: ' . $e->getMessage());
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete an incoming item and adjust product stocks.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $incomingItem = $this->incomingItemModel->find($id);
        if (!$incomingItem) {
            return redirect()->to('/incoming-item')->with('error', 'Data tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $items = $this->purchaseItemModel->where('purchase_id', $incomingItem['purchase_id'])->findAll();
            foreach ($items as $item) {
                if (!$this->updateProductStock($item['product_id'], $item['quantity'], false)) {
                    $db->transRollback();
                    return redirect()->to('/incoming-item')->with('error', 'Gagal update stok produk');
                }
            }

            $this->incomingItemModel->delete($id);
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/incoming-item')->with('error', 'Gagal menghapus data');
            }

            return redirect()->to('/incoming-item')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/incoming-item')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Fetch purchase details for AJAX requests.
     *
     * @param int $purchaseId
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function purchaseDetails(int $purchaseId)
    {
        $purchase = $this->purchaseModel->find($purchaseId);
        if (!$purchase) {
            return $this->response->setJSON(['success' => false, 'message' => 'Purchase not found']);
        }

        $items = $this->purchaseItemModel
            ->select('purchase_items.*, products.name as product_name, products.stock')
            ->join('products', 'products.id = purchase_items.product_id')
            ->where('purchase_items.purchase_id', $purchaseId)
            ->findAll();

        $totalQuantity = $this->purchaseItemModel->getTotalQuantity($purchaseId);

        return $this->response->setJSON([
            'success' => true,
            'purchase' => $purchase,
            'items' => $items,
            'total_quantity' => $totalQuantity,
        ]);
    }

    /**
     * Get available purchases for creating incoming items.
     *
     * @return array
     */
    private function getAvailablePurchases(): array
    {
        $allPurchases = $this->purchaseModel->findAll();
        $availablePurchases = [];

        foreach ($allPurchases as $purchase) {
            if ($this->incomingItemModel->purchaseHasIncoming($purchase['id'])) {
                continue;
            }

            $items = $this->purchaseItemModel->where('purchase_id', $purchase['id'])->findAll();
            $totalQty = 0;
            $validItems = true;

            foreach ($items as $item) {
                if (empty($item['product_id']) || $item['product_id'] == 0) {
                    $validItems = false;
                    break;
                }
                $totalQty += $item['quantity'];
            }

            if ($validItems && $totalQty > 0) {
                $availablePurchases[] = [
                    'id' => $purchase['id'],
                    'vendor_name' => $purchase['vendor_name'],
                    'purchase_date' => $purchase['purchase_date'],
                    'buyer_name' => $purchase['buyer_name'],
                    'total_quantity' => $totalQty,
                ];
            }
        }

        return $availablePurchases;
    }

    /**
     * Validate input for the store method.
     *
     * @param mixed $purchaseId
     * @param mixed $date
     * @return bool
     */
    private function validateInput($purchaseId, $date): bool
    {
        if (empty($purchaseId)) {
            session()->setFlashdata('error', 'Pilih pembelian terlebih dahulu');
            return false;
        }

        if (empty($date)) {
            session()->setFlashdata('error', 'Tanggal harus diisi');
            return false;
        }

        return true;
    }

    /**
     * Validate purchase items.
     *
     * @param array $items
     * @param int $purchaseId
     * @return bool
     */
    private function validatePurchaseItems(array $items, int $purchaseId): bool
    {
        foreach ($items as $item) {
            if (empty($item['product_id']) || $item['product_id'] == 0) {
                log_message('error', 'Invalid product_id found in purchase_items for purchase_id: ' . $purchaseId);
                session()->setFlashdata('error', 'Pembelian memiliki item tanpa product yang valid. Silakan perbaiki data pembelian terlebih dahulu.');
                return false;
            }

            $product = $this->productModel->find($item['product_id']);
            if (!$product) {
                log_message('error', 'Product not found for product_id: ' . $item['product_id'] . ' in purchase_id: ' . $purchaseId);
                session()->setFlashdata('error', 'Produk dengan ID ' . $item['product_id'] . ' tidak ditemukan. Silakan perbaiki data pembelian.');
                return false;
            }
        }

        return true;
    }

    /**
     * Update product stock.
     *
     * @param int $productId
     * @param float $quantity
     * @param bool $increase
     * @return bool
     */
    private function updateProductStock(int $productId, float $quantity, bool $increase): bool
    {
        $product = $this->productModel->find($productId);
        if (!$product) {
            return false;
        }

        $newStock = $increase ? $product['stock'] + $quantity : max(0, $product['stock'] - $quantity);
        log_message('debug', 'Updating stock for product_id: ' . $productId . ' to new stock: ' . $newStock);
        return $this->productModel->update($productId, ['stock' => $newStock]);
    }
}