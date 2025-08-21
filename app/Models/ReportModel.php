<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $productModel;
    protected $incomingItemModel;
    protected $outgoingItemModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
        $this->incomingItemModel = new IncomingItemModel();
        $this->outgoingItemModel = new OutgoingItemModel();
    }

    public function getIncomingItemsByDateRange($startDate, $endDate)
    {
        return $this->incomingItemModel
            ->select('incoming_items.*, products.name as product_name, products.code as product_code')
            ->join('products', 'products.id = incoming_items.product_id')
            ->where('incoming_items.date >=', $startDate)
            ->where('incoming_items.date <=', $endDate)
            ->findAll();
    }

    public function getOutgoingItemsByDateRange($startDate, $endDate)
    {
        return $this->outgoingItemModel
            ->select('outgoing_items.*, products.name as product_name, products.code as product_code')
            ->join('products', 'products.id = outgoing_items.product_id')
            ->where('outgoing_items.date >=', $startDate)
            ->where('outgoing_items.date <=', $endDate)
            ->findAll();
    }

    public function getCurrentStock()
    {
        return $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();
    }
}