<?php

namespace App\Controllers;

use App\Models\IncomingItemModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\ProductModel;

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

    public function index()
    {
        $data = [
            'mode' => 'index',
            'incoming_items' => $this->incomingItemModel->getIncomingItemsWithDetails()
        ];
        return view('incoming_item', $data);
    }

    public function create()
    {
        $data = [
            'mode' => 'create',
            'purchases' => $this->purchaseModel->findAll()
        ];
        return view('incoming_item', $data);
    }

    public function store()
    {
        if (!$this->validate($this->incomingItemModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get purchase and validate
        /** @var array|null $purchase */
        $purchase = $this->purchaseModel->find($this->request->getPost('purchase_id'));
        if (!$purchase || !is_array($purchase)) {
            return redirect()->back()->withInput()->with('errors', ['purchase_id' => 'Pembelian tidak ditemukan']);
        }

        // Check if purchase already has an incoming item
        $existing = $this->incomingItemModel->where('purchase_id', $this->request->getPost('purchase_id'))->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('errors', ['purchase_id' => 'Pembelian ini sudah memiliki transaksi barang masuk']);
        }

        // Validate quantity matches purchase items
        $purchaseQuantity = $this->purchaseItemModel->getTotalQuantity($this->request->getPost('purchase_id'));
        $inputQuantity = $this->request->getPost('quantity');
        if ($purchaseQuantity != $inputQuantity) {
            return redirect()->back()->withInput()->with('errors', ['quantity' => 'Jumlah barang masuk harus sama dengan jumlah barang di pembelian (' . $purchaseQuantity . ')']);
        }

        // Start transaction
        $this->incomingItemModel->db->transBegin();

        // Save incoming item
        $this->incomingItemModel->save([
            'purchase_id' => $this->request->getPost('purchase_id'),
            'date' => $this->request->getPost('date'),
            'quantity' => $inputQuantity
        ]);

        // Update product stock
        $items = $this->purchaseItemModel->where('purchase_id', $this->request->getPost('purchase_id'))->findAll();
        foreach ($items as $item) {
            /** @var array|null $product */
            $product = $this->productModel->find($item['product_id']);
            if ($product && is_array($product)) {
                $newStock = $product['stock'] + $item['quantity'];
                $this->productModel->update($item['product_id'], ['stock' => $newStock]);
            }
        }

        if ($this->incomingItemModel->db->transStatus() === false) {
            $this->incomingItemModel->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal menyimpan data']);
        }

        $this->incomingItemModel->db->transCommit();
        return redirect()->to('/incoming-item')->with('message', 'Transaksi barang masuk berhasil ditambahkan');
    }

    public function edit($id)
    {
        /** @var array|null $incomingItem */
        $incomingItem = $this->incomingItemModel->find($id);
        if (!$incomingItem || !is_array($incomingItem)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi barang masuk tidak ditemukan');
        }

        $data = [
            'mode' => 'edit',
            'incoming_item' => $incomingItem,
            'purchases' => $this->purchaseModel->findAll()
        ];
        return view('incoming_item', $data);
    }

    public function update($id)
    {
        /** @var array|null $incomingItem */
        $incomingItem = $this->incomingItemModel->find($id);
        if (!$incomingItem || !is_array($incomingItem)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi barang masuk tidak ditemukan');
        }

        if (!$this->validate($this->incomingItemModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get purchase and validate
        /** @var array|null $purchase */
        $purchase = $this->purchaseModel->find($this->request->getPost('purchase_id'));
        if (!$purchase || !is_array($purchase)) {
            return redirect()->back()->withInput()->with('errors', ['purchase_id' => 'Pembelian tidak ditemukan']);
        }

        // Check if purchase already has another incoming item
        $existing = $this->incomingItemModel->where('purchase_id', $this->request->getPost('purchase_id'))
            ->where('id !=', $id)
            ->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('errors', ['purchase_id' => 'Pembelian ini sudah memiliki transaksi barang masuk lain']);
        }

        // Validate quantity matches purchase items
        $purchaseQuantity = $this->purchaseItemModel->getTotalQuantity($this->request->getPost('purchase_id'));
        $inputQuantity = $this->request->getPost('quantity');
        if ($purchaseQuantity != $inputQuantity) {
            return redirect()->back()->withInput()->with('errors', ['quantity' => 'Jumlah barang masuk harus sama dengan jumlah barang di pembelian (' . $purchaseQuantity . ')']);
        }

        // Start transaction
        $this->incomingItemModel->db->transBegin();

        // Revert old stock changes
        $oldItems = $this->purchaseItemModel->where('purchase_id', $incomingItem['purchase_id'])->findAll();
        foreach ($oldItems as $item) {
            /** @var array|null $product */
            $product = $this->productModel->find($item['product_id']);
            if ($product && is_array($product)) {
                $newStock = $product['stock'] - $item['quantity'];
                $this->productModel->update($item['product_id'], ['stock' => max(0, $newStock)]);
            }
        }

        // Update incoming item
        $this->incomingItemModel->update($id, [
            'purchase_id' => $this->request->getPost('purchase_id'),
            'date' => $this->request->getPost('date'),
            'quantity' => $inputQuantity
        ]);

        // Update new stock
        $newItems = $this->purchaseItemModel->where('purchase_id', $this->request->getPost('purchase_id'))->findAll();
        foreach ($newItems as $item) {
            /** @var array|null $product */
            $product = $this->productModel->find($item['product_id']);
            if ($product && is_array($product)) {
                $newStock = $product['stock'] + $item['quantity'];
                $this->productModel->update($item['product_id'], ['stock' => $newStock]);
            }
        }

        if ($this->incomingItemModel->db->transStatus() === false) {
            $this->incomingItemModel->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal memperbarui data']);
        }

        $this->incomingItemModel->db->transCommit();
        return redirect()->to('/incoming-item')->with('message', 'Transaksi barang masuk berhasil diperbarui');
    }

    public function delete($id)
    {
        /** @var array|null $incomingItem */
        $incomingItem = $this->incomingItemModel->find($id);
        if (!$incomingItem || !is_array($incomingItem)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi barang masuk tidak ditemukan');
        }

        // Start transaction
        $this->incomingItemModel->db->transBegin();

        // Revert stock changes
        $items = $this->purchaseItemModel->where('purchase_id', $incomingItem['purchase_id'])->findAll();
        foreach ($items as $item) {
            /** @var array|null $product */
            $product = $this->productModel->find($item['product_id']);
            if ($product && is_array($product)) {
                $newStock = $product['stock'] - $item['quantity'];
                $this->productModel->update($item['product_id'], ['stock' => max(0, $newStock)]);
            }
        }

        // Delete incoming item
        $this->incomingItemModel->delete($id);

        if ($this->incomingItemModel->db->transStatus() === false) {
            $this->incomingItemModel->db->transRollback();
            return redirect()->to('/incoming-item')->with('errors', ['database' => 'Gagal menghapus data']);
        }

        $this->incomingItemModel->db->transCommit();
        return redirect()->to('/incoming-item')->with('message', 'Transaksi barang masuk berhasil dihapus');
    }
}