<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'name', 'code', 'unit', 'stock'];

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'category_id' => 'required|integer',
        'name' => 'required|min_length[3]|max_length[100]',
        'code' => 'required|min_length[3]|max_length[50]|is_unique[products.code,id,{id}]',
        'unit' => 'required|min_length[2]|max_length[50]',
        'stock' => 'required|decimal'
    ];

    protected $validationMessages = [
        'category_id' => [
            'required' => 'Category ID is required',
            'integer' => 'Category ID must be a valid number'
        ],
        'name' => [
            'required' => 'Product name is required',
            'min_length' => 'Product name must be at least 3 characters',
            'max_length' => 'Product name cannot exceed 100 characters'
        ],
        'code' => [
            'required' => 'Product code is required',
            'min_length' => 'Product code must be at least 3 characters',
            'max_length' => 'Product code cannot exceed 50 characters',
            'is_unique' => 'Product code must be unique'
        ],
        'unit' => [
            'required' => 'Unit is required',
            'min_length' => 'Unit must be at least 2 characters',
            'max_length' => 'Unit cannot exceed 50 characters'
        ],
        'stock' => [
            'required' => 'Stock is required',
            'decimal' => 'Stock must be a valid number'
        ]
    ];

    // Join with categories table
    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->findAll();
    }
}