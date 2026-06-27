<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Models\Order;

final class OrderController extends BaseAdminController
{
    public function index(): never
    {
        $status  = (string) $this->request->query('status_filter', '');
        $orders  = Order::all();

        if ($status !== '') {
            $orders = array_filter($orders, fn($o) => $o['status'] === $status);
        }

        $this->render('admin/orders/index', [
            'orders'        => array_values($orders),
            'orderStats'    => Order::countByStatus(),
            'statusFilter'  => $status,
            'message'       => (string) $this->request->query('message', ''),
            'status'        => (string) $this->request->query('status', 'success'),
        ], 'admin/admin');
    }

    public function show(): never
    {
        $id    = (int) $this->request->query('id');
        $order = Order::find($id);
        if (!$order) {
            $this->redirect(url('/admin/orders?message=Pesanan+tidak+ditemukan&status=error'));
        }
        $this->render('admin/orders/show', [
            'order'   => $order,
            'message' => (string) $this->request->query('message', ''),
            'status'  => (string) $this->request->query('status', 'success'),
        ], 'admin/admin');
    }

    public function updateStatus(): never
    {
        $this->requireCsrf();
        $id     = (int) $this->request->post('id');
        $status = (string) $this->request->post('order_status');
        Order::updateStatus($id, $status);
        $this->redirect(url('/admin/orders?message=Status+pesanan+diperbarui'));
    }

    public function delete(): never
    {
        $this->requireCsrf();
        $id = (int) $this->request->post('id');
        Order::delete($id);
        $this->redirect(url('/admin/orders?message=Pesanan+berhasil+dihapus'));
    }
}
