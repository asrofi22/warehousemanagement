<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'mode' => 'index',
            'products' => $this->productModel->getProductsWithCategory()
        ];
        return view('product', $data);
    }

    public function create()
    {
        $data = [
            'mode' => 'create',
            'categories' => $this->categoryModel->findAll()
        ];
        return view('product', $data);
    }

    public function store()
    {
        if (!$this->validate($this->productModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->save([
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'unit' => $this->request->getPost('unit'),
            'stock' => $this->request->getPost('stock')
        ]);

        return redirect()->to('/product')->with('message', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data = [
            'mode' => 'edit',
            'product' => $product,
            'categories' => $this->categoryModel->findAll()
        ];
        return view('product', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->productModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'unit' => $this->request->getPost('unit'),
            'stock' => $this->request->getPost('stock')
        ]);

        return redirect()->to('/product')->with('message', 'Produk berhasil diperbarui');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $this->productModel->delete($id);
        return redirect()->to('/product')->with('message', 'Produk berhasil dihapus');
    }
}