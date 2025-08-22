<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomingItemModel extends Model
{
    protected $table = 'incoming_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['purchase_id', 'date', 'quantity'];
    protected $returnType = 'array';
    protected $useSoftDeletes = false; // Assuming soft deletes are disabled

    public function getIncomingItemsWithDetails()
    {
        $builder = $this->db->table('incoming_items i');
        return $builder->select('i.id, i.purchase_id, i.date, i.quantity, p.vendor_name, p.purchase_date, p.buyer_name, 
                (SELECT SUM(pi.quantity) FROM purchase_items pi WHERE pi.purchase_id = i.purchase_id) as purchase_quantity')
            ->join('purchases p', 'p.id = i.purchase_id', 'left') // Use LEFT JOIN to handle missing purchases
            ->get()
            ->getResultArray();
    }

    public function purchaseHasIncoming($purchaseId)
    {
        return $this->where('purchase_id', $purchaseId)->countAllResults() > 0;
    }
}