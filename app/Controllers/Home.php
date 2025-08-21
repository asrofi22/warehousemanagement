<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\IncomingItemModel;
use App\Models\OutgoingItemModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    protected $purchaseModel;
    protected $incomingItemModel;
    protected $outgoingItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
        $this->incomingItemModel = new IncomingItemModel();
        $this->outgoingItemModel = new OutgoingItemModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // Fetch metrics
        $totalPurchases = $this->purchaseModel->countAllResults();
        $totalIncomingItems = $this->incomingItemModel->countAllResults();
        $totalOutgoingItems = $this->outgoingItemModel->countAllResults();
        $totalStock = $this->productModel->selectSum('stock')->get()->getRow()->stock;

        // Fetch chart data (last 6 months)
        $months = [];
        $incomingData = [];
        $outgoingData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthLabel = date('M Y', strtotime("-$i months"));
            $months[] = $monthLabel;

            // Incoming items for the month
            $incoming = $this->incomingItemModel
                ->selectSum('quantity')
                ->where("DATE_FORMAT(date, '%Y-%m')", $month)
                ->get()
                ->getRow()
                ->quantity ?? 0;
            $incomingData[] = $incoming;

            // Outgoing items for the month
            $outgoing = $this->outgoingItemModel
                ->selectSum('quantity')
                ->where("DATE_FORMAT(date, '%Y-%m')", $month)
                ->get()
                ->getRow()
                ->quantity ?? 0;
            $outgoingData[] = $outgoing;
        }

        // Fetch recent purchases (limit to 5)
        $purchases = $this->purchaseModel
            ->select('purchases.*, (SELECT COUNT(*) FROM incoming_items WHERE incoming_items.purchase_id = purchases.id) as has_incoming')
            ->orderBy('purchase_date', 'DESC')
            ->findAll(5);
        $recentPurchases = [];
        foreach ($purchases as $purchase) {
            $items = $this->purchaseModel->getPurchaseItems($purchase['id']);
            foreach ($items as &$item) {
                $product = $this->productModel->find($item['product_id']);
                $item['product_name'] = $product['name'] ?? 'Unknown';
            }
            $purchase['items'] = $items;
            $recentPurchases[] = $purchase;
        }

        /** @var array|null $data */
        $data = [
            'total_purchases' => $totalPurchases,
            'total_incoming_items' => $totalIncomingItems,
            'total_outgoing_items' => $totalOutgoingItems,
            'total_stock' => $totalStock ?? 0,
            'chart_labels' => $months,
            'incoming_data' => $incomingData,
            'outgoing_data' => $outgoingData,
            'recent_purchases' => $recentPurchases,
        ];

        return view('home', $data);
    }
}