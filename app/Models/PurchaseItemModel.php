<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseItemModel extends Model
{
    protected $table = 'purchase_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['purchase_id', 'product_id', 'quantity'];

    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    // Validation rules
    protected $validationRules = [
        'purchase_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|decimal|greater_than[0]'
    ];

    protected $validationMessages = [
        'purchase_id' => [
            'required' => 'Purchase ID is required',
            'integer' => 'Purchase ID must be a valid number'
        ],
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be a valid number'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'decimal' => 'Quantity must be a valid number',
            'greater_than' => 'Quantity must be greater than 0'
        ]
    ];

    // Get items for a purchase with product details
    public function getItemsByPurchase($purchaseId)
    {
        return $this->select('purchase_items.*, products.name as product_name')
            ->join('products', 'products.id = purchase_items.product_id')
            ->where('purchase_items.purchase_id', $purchaseId)
            ->findAll();
    }

    // Get total quantity for a purchase
    public function getTotalQuantity($purchaseId)
    {
        return $this->where('purchase_id', $purchaseId)
            ->selectSum('quantity')
            ->first()['quantity'] ?? 0;
    }
}