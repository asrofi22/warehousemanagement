<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vendor_name', 'vendor_address', 'purchase_date', 'buyer_name'];
    protected $returnType = 'array';

    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

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

    // Get purchases with their items count
    public function getPurchasesWithItems()
    {
        return $this->select('purchases.*, COUNT(purchase_items.id) as item_count')
            ->join('purchase_items', 'purchase_items.purchase_id = purchases.id', 'left')
            ->groupBy('purchases.id')
            ->findAll();
    }

    public function getPurchaseItems($purchaseId)
    {
        return $this->db->table('purchase_items')
            ->select('purchase_items.*, products.name as product_name')
            ->join('products', 'products.id = purchase_items.product_id')
            ->where('purchase_id', $purchaseId)
            ->get()
            ->getResultArray();
    }

    // Get purchases that are eligible for incoming items
    public function getEligiblePurchases()
    {
        $subquery = $this->db->table('incoming_items')
            ->select('purchase_id')
            ->where('deleted_at IS NULL');

        return $this->select('purchases.*')
            ->whereNotIn('purchases.id', $subquery)
            ->join('purchase_items', 'purchase_items.purchase_id = purchases.id', 'inner')
            ->groupBy('purchases.id')
            ->having('SUM(purchase_items.quantity) >', 0)
            ->findAll();
    }
}