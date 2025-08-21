<?php

namespace App\Controllers;

use App\Models\OutgoingItemModel;
use App\Models\ProductModel;

class OutgoingItem extends BaseController
{
    protected $outgoingItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->outgoingItemModel = new OutgoingItemModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'mode' => 'index',
            'outgoing_items' => $this->outgoingItemModel->getOutgoingItemsWithProduct()
        ];
        return view('outgoing_item', $data);
    }

    public function create()
    {
        $data = [
            'mode' => 'create',
            'products' => $this->productModel->findAll()
        ];
        return view('outgoing_item', $data);
    }

    public function store()
    {
        if (!$this->validate($this->outgoingItemModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get product to ensure it exists
        /** @var array|null $product */
        $product = $this->productModel->find($this->request->getPost('product_id'));
        if (!$product || !is_array($product)) {
            return redirect()->back()->withInput()->with('errors', ['product_id' => 'Produk tidak ditemukan']);
        }

        // Check if sufficient stock exists
        $quantity = $this->request->getPost('quantity');
        if ($product['stock'] < $quantity) {
            return redirect()->back()->withInput()->with('errors', ['quantity' => 'Stok tidak mencukupi']);
        }

        // Start transaction
        $this->outgoingItemModel->db->transBegin();

        // Save outgoing item
        $this->outgoingItemModel->save([
            'product_id' => $this->request->getPost('product_id'),
            'date' => $this->request->getPost('date'),
            'quantity' => $quantity
        ]);

        // Update product stock (decrease)
        $newStock = $product['stock'] - $quantity;
        $this->productModel->update($product['id'], ['stock' => $newStock]);

        // Commit or rollback transaction
        if ($this->outgoingItemModel->db->transStatus() === false) {
            $this->outgoingItemModel->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal menyimpan data']);
        }

        $this->outgoingItemModel->db->transCommit();
        return redirect()->to('/outgoing-item')->with('message', 'Item keluar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $outgoingItem = $this->outgoingItemModel->find($id);
        if (!$outgoingItem) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item keluar tidak ditemukan');
        }

        $data = [
            'mode' => 'edit',
            'outgoing_item' => $outgoingItem,
            'products' => $this->productModel->findAll()
        ];
        return view('outgoing_item', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->outgoingItemModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get existing outgoing item
        $outgoingItem = $this->outgoingItemModel->find($id);
        if (!$outgoingItem) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item keluar tidak ditemukan');
        }

        // Get product to ensure it exists
        /** @var array|null $product */
        $product = $this->productModel->find($this->request->getPost('product_id'));
        if (!$product || !is_array($product)) {
            return redirect()->back()->withInput()->with('errors', ['product_id' => 'Produk tidak ditemukan']);
        }

        // Calculate stock adjustment
        $oldQuantity = $outgoingItem['quantity'];
        $newQuantity = $this->request->getPost('quantity');
        $quantityDifference = $newQuantity - $oldQuantity;

        // Check if sufficient stock exists for the adjustment
        if ($quantityDifference > 0 && $product['stock'] < $quantityDifference) {
            return redirect()->back()->withInput()->with('errors', ['quantity' => 'Stok tidak mencukupi untuk penambahan jumlah']);
        }

        // Start transaction
        $this->outgoingItemModel->db->transBegin();

        // Update outgoing item
        $this->outgoingItemModel->update($id, [
            'product_id' => $this->request->getPost('product_id'),
            'date' => $this->request->getPost('date'),
            'quantity' => $newQuantity
        ]);

        // Update product stock (adjust based on quantity difference)
        $newStock = $product['stock'] - $quantityDifference;
        $this->productModel->update($product['id'], ['stock' => max(0, $newStock)]);

        // Commit or rollback transaction
        if ($this->outgoingItemModel->db->transStatus() === false) {
            $this->outgoingItemModel->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal memperbarui data']);
        }

        $this->outgoingItemModel->db->transCommit();
        return redirect()->to('/outgoing-item')->with('message', 'Item keluar berhasil diperbarui');
    }

    public function delete($id)
    {
        $outgoingItem = $this->outgoingItemModel->find($id);
        if (!$outgoingItem) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item keluar tidak ditemukan');
        }

        // Start transaction
        $this->outgoingItemModel->db->transBegin();

        // Get product to update stock
        /** @var array|null $product */
        $product = $this->productModel->find($outgoingItem['product_id']);
        if ($product && is_array($product)) {
            // Increase stock by the quantity of the deleted outgoing item
            $newStock = $product['stock'] + $outgoingItem['quantity'];
            $this->productModel->update($product['id'], ['stock' => $newStock]);
        }

        // Delete outgoing item
        $this->outgoingItemModel->delete($id);

        // Commit or rollback transaction
        if ($this->outgoingItemModel->db->transStatus() === false) {
            $this->outgoingItemModel->db->transRollback();
            return redirect()->to('/outgoing-item')->with('errors', ['database' => 'Gagal menghapus data']);
        }

        $this->outgoingItemModel->db->transCommit();
        return redirect()->to('/outgoing-item')->with('message', 'Item keluar berhasil dihapus');
    }
}