<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'mode' => 'index',
            'categories' => $this->categoryModel->findAll()
        ];
        return view('category', $data);
    }

    public function create()
    {
        $data = [
            'mode' => 'create'
        ];
        return view('category', $data);
    }

    public function store()
    {
        if (!$this->validate($this->categoryModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->save([
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/category')->with('message', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $data = [
            'mode' => 'edit',
            'category' => $category
        ];
        return view('category', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->categoryModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/category')->with('message', 'Kategori berhasil diperbarui');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $this->categoryModel->delete($id);
        return redirect()->to('/category')->with('message', 'Kategori berhasil dihapus');
    }
}