<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Models\ProductCategory;
use WellySongket\Models\MotifCategory;

final class CategoryController extends BaseAdminController
{
    public function index(): never
    {
        $this->render('admin/categories/index', [
            'productCategories' => ProductCategory::all(),
            'motifCategories'   => MotifCategory::all(),
            'message'           => (string) $this->request->query('message', ''),
            'status'            => (string) $this->request->query('status', 'success'),
        ], 'admin/admin');
    }

    public function storeProduct(): never
    {
        $this->requireCsrf();
        $name = trim((string) $this->request->post('name'));
        if ($name === '') {
            $this->redirect(url('/admin/categories?message=Nama+kategori+wajib+diisi&status=error'));
        }
        ProductCategory::create($name);
        $this->redirect(url('/admin/categories?message=Kategori+produk+ditambahkan'));
    }

    public function storeMotif(): never
    {
        $this->requireCsrf();
        $name = trim((string) $this->request->post('name'));
        if ($name === '') {
            $this->redirect(url('/admin/categories?message=Nama+kategori+wajib+diisi&status=error'));
        }
        MotifCategory::create($name);
        $this->redirect(url('/admin/categories?message=Kategori+motif+ditambahkan'));
    }

    public function deleteProduct(): never
    {
        $this->requireCsrf();
        $id = (int) $this->request->post('id');
        ProductCategory::delete($id);
        $this->redirect(url('/admin/categories?message=Kategori+produk+dihapus'));
    }

    public function deleteMotif(): never
    {
        $this->requireCsrf();
        $id = (int) $this->request->post('id');
        MotifCategory::delete($id);
        $this->redirect(url('/admin/categories?message=Kategori+motif+dihapus'));
    }
}
