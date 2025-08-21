<?php

namespace App\Controllers;

use App\Models\ReportModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Report extends BaseController
{
    protected $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Laporan'
        ];
        return view('report_index', $data);
    }

    public function incoming()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data = [
            'mode' => 'incoming',
            'title' => 'Laporan Barang Masuk',
            'incoming_items' => $this->reportModel->getIncomingItemsByDateRange($startDate, $endDate),
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        return view('report', $data);
    }

    public function outgoing()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data = [
            'mode' => 'outgoing',
            'title' => 'Laporan Barang Keluar',
            'outgoing_items' => $this->reportModel->getOutgoingItemsByDateRange($startDate, $endDate),
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        return view('report', $data);
    }

    public function stock()
    {
        $data = [
            'mode' => 'stock',
            'title' => 'Laporan Stok Barang Terkini',
            'products' => $this->reportModel->getCurrentStock()
        ];

        return view('report', $data);
    }
}