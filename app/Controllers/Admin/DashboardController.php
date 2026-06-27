<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Models\Order;
use WellySongket\Models\Product;
use WellySongket\Models\Motif;
use WellySongket\Models\ProductCategory;
use WellySongket\Models\MotifCategory;

final class DashboardController extends BaseAdminController
{
    public function index(): never
    {
        $orderStats = [];
        $recentOrders = [];

        try {
            $orderStats   = Order::countByStatus();
            $recentOrders = array_slice(Order::all(), 0, 5);
        } catch (\Throwable) {}

        $products = [];
        $motifs   = [];
        try {
            $products = Product::all();
            $motifs   = Motif::all();
        } catch (\Throwable) {}

        $this->render('admin/dashboard', [
            'orderStats'   => $orderStats,
            'recentOrders' => $recentOrders,
            'productCount' => count($products),
            'motifCount'   => count($motifs),
            'message'      => (string) $this->request->query('message', ''),
            'status'       => (string) $this->request->query('status', 'success'),
        ], 'admin/admin');
    }
}
