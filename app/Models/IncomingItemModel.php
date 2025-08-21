<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomingItemModel extends Model
{
    protected $table = 'incoming_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['purchase_id', 'date', 'quantity'];

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'purchase_id' => 'required|integer',
        'date' => 'required|valid_date',
        'quantity' => 'required|decimal|greater_than[0]'
    ];

    protected $validationMessages = [
        'purchase_id' => [
            'required' => 'Purchase ID is required',
            'integer' => 'Purchase ID must be a valid number'
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

    // Get incoming items with purchase and product details
    public function getIncomingItemsWithDetails()
    {
        return $this->select('incoming_items.*, purchases.vendor_name, SUM(purchase_items.quantity) as purchase_quantity')
            ->join('purchases', 'purchases.id = incoming_items.purchase_id')
            ->join('purchase_items', 'purchase_items.purchase_id = incoming_items.purchase_id')
            ->groupBy('incoming_items.id')
            ->findAll();
    }
}