<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\ProductModel;

class Purchase extends BaseController
{
    protected $purchaseModel;
    protected $purchaseItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
        $this->purchaseItemModel = new PurchaseItemModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'mode' => 'index',
            'purchases' => $this->purchaseModel->getPurchasesWithItems()
        ];
        return view('purchase', $data);
    }

    public function create()
    {
        $data = [
            'mode' => 'create',
            'products' => $this->productModel->findAll()
        ];
        return view('purchase', $data);
    }

    public function store()
    {
        // Validate purchase
        if (!$this->validate($this->purchaseModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate purchase items
        $items = $this->request->getPost('items');
        if (empty($items) || !is_array($items)) {
            return redirect()->back()->withInput()->with('errors', ['items' => 'At least one item is required']);
        }

        foreach ($items as $item) {
            if (
                !$this->validate([
                    'items.*.product_id' => 'required|integer',
                    'items.*.quantity' => 'required|decimal|greater_than[0]'
                ])
            ) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        // Start transaction
        $this->purchaseModel->db->transBegin();

        // Save purchase
        $purchaseData = [
            'vendor_name' => $this->request->getPost('vendor_name'),
            'vendor_address' => $this->request->getPost('vendor_address'),
            'purchase_date' => $this->request->getPost('purchase_date'),
            'buyer_name' => $this->request->getPost('buyer_name')
        ];
        $this->purchaseModel->save($purchaseData);
        $purchaseId = $this->purchaseModel->insertID();

        // Save purchase items
        foreach ($items as $item) {
            /** @var array|null $product */
            $product = $this->productModel->find($item['product_id']);
            if (!$product || !is_array($product)) {
                $this->purchaseModel->db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['items' => 'Produk tidak ditemukan']);
            }

            $this->purchaseItemModel->save([
                'purchase_id' => $purchaseId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ]);
        }

        if ($this->purchaseModel->db->transStatus() === false) {
            $this->purchaseModel->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal menyimpan data']);
        }

        $this->purchaseModel->db->transCommit();
        return redirect()->to('/purchase')->with('message', 'Pembelian berhasil ditambahkan');
    }

    public function edit($id)
    {
        /** @var array|null $purchase */
        $purchase = $this->purchaseModel->find($id);
        if (!$purchase || !is_array($purchase)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pembelian tidak ditemukan');
        }

        $data = [
            'mode' => 'edit',
            'purchase' => $purchase,
            'items' => $this->purchaseItemModel->getItemsByPurchase($id),
            'products' => $this->productModel->findAll()
        ];
        return view('purchase', $data);
    }

    public function update($id)
    {
        /** @var array|null $purchase */
        $purchase = $this->purchaseModel->find($id);
        if (!$purchase || !is_array($purchase)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pembelian tidak ditemukan');
        }

        // Validate purchase
        if (!$this->validate($this->purchaseModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate purchase items
        $items = $this->request->getPost('items');
        if (empty($items) || !is_array($items)) {
            return redirect()->back()->withInput()->with('errors', ['items' => 'At least one item is required']);
        }

        foreach ($items as $item) {
            if (
                !$this->validate([
                    'items.*.product_id' => 'required|integer',
                    'items.*.quantity' => 'required|decimal|greater_than[0]'
                ])
            ) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        // Start transaction
        $this->purchaseModel->db->transBegin();

        // Update purchase
        $this->purchaseModel->update($id, [
            'vendor_name' => $this->request->getPost('vendor_name'),
            'vendor_address' => $this->request->getPost('vendor_address'),
            'purchase_date' => $this->request->getPost('purchase_date'),
            'buyer_name' => $this->request->getPost('buyer_name')
        ]);

        // Delete existing items
        $this->purchaseItemModel->where('purchase_id', $id)->delete();

        // Save new items
        foreach ($items as $item) {
            /** @var array|null $product */
            $product = $this->productModel->find($item['product_id']);
            if (!$product || !is_array($product)) {
                $this->purchaseModel->db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['items' => 'Produk tidak ditemukan']);
            }

            $this->purchaseItemModel->save([
                'purchase_id' => $id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ]);
        }

        if ($this->purchaseModel->db->transStatus() === false) {
            $this->purchaseModel->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal memperbarui data']);
        }

        $this->purchaseModel->db->transCommit();
        return redirect()->to('/purchase')->with('message', 'Pembelian berhasil diperbarui');
    }

    public function delete($id)
    {
        /** @var array|null $purchase */
        $purchase = $this->purchaseModel->find($id);
        if (!$purchase || !is_array($purchase)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pembelian tidak ditemukan');
        }

        // Check if purchase is used in incoming_items
        $incomingItems = $this->db->table('incoming_items')->where('purchase_id', $id)->countAllResults();
        if ($incomingItems > 0) {
            return redirect()->to('/purchase')->with('errors', ['database' => 'Pembelian tidak dapat dihapus karena sudah digunakan di transaksi barang masuk']);
        }

        // Start transaction
        $this->purchaseModel->db->transBegin();

        // Delete purchase items
        $this->purchaseItemModel->where('purchase_id', $id)->delete();

        // Delete purchase
        $this->purchaseModel->delete($id);

        if ($this->purchaseModel->db->transStatus() === false) {
            $this->purchaseModel->db->transRollback();
            return redirect()->to('/purchase')->with('errors', ['database' => 'Gagal menghapus data']);
        }

        $this->purchaseModel->db->transCommit();
        return redirect()->to('/purchase')->with('message', 'Pembelian berhasil dihapus');
    }
}