<?php

namespace App\Models;

use CodeIgniter\Model;

class OutgoingItemModel extends Model
{
    protected $table = 'outgoing_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'date', 'quantity'];

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'product_id' => 'required|integer',
        'date' => 'required|valid_date',
        'quantity' => 'required|decimal|greater_than[0]'
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be a valid number'
        ],
        'date' => [
            'required' => 'Date is required',
            'valid_date' => 'Please enter a valid date'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'decimal' => 'Quantity must be a valid number',
            'greater_than' => 'Quantity must be greater than 0'
        ]
    ];

    // Join with products table
    public function getOutgoingItemsWithProduct()
    {
        return $this->select('outgoing_items.*, products.name as product_name')
            ->join('products', 'products.id = outgoing_items.product_id')
            ->findAll();
    }
}