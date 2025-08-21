<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vendor_name', 'vendor_address', 'purchase_date', 'buyer_name'];

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation rules
    protected $validationRules = [
        'vendor_name' => 'required|max_length[255]',
        'vendor_address' => 'permit_empty',
        'purchase_date' => 'required|valid_date',
        'buyer_name' => 'required|max_length[100]'
    ];

    protected $validationMessages = [
        'vendor_name' => [
            'required' => 'Nama vendor is required',
            'max_length' => 'Nama vendor cannot exceed 255 characters'
        ],
        'purchase_date' => [
            'required' => 'Tanggal pembelian is required',
            'valid_date' => 'Please enter a valid date'
        ],
        'buyer_name' => [
            'required' => 'Nama pembeli is required',
            'max_length' => 'Nama pembeli cannot exceed 100 characters'
        ]
    ];

    // Get purchases with their items
    public function getPurchasesWithItems()
    {
        return $this->select('purchases.*, COUNT(purchase_items.id) as item_count')
            ->join('purchase_items', 'purchase_items.purchase_id = purchases.id', 'left')
            ->groupBy('purchases.id')
            ->findAll();
    }
}