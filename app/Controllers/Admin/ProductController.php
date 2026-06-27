<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Models\Product;
use WellySongket\Models\ProductCategory;
use WellySongket\Models\ProductMedia;

final class ProductController extends BaseAdminController
{
    public function index(): never
    {
        $this->render('admin/products/index', [
            'products'   => Product::all(),
            'categories' => ProductCategory::all(),
            'message'    => (string) $this->request->query('message', ''),
            'status'     => (string) $this->request->query('status', 'success'),
        ], 'admin/admin');
    }

    public function store(): never
    {
        $this->requireCsrf();
        $name = trim((string) $this->request->post('name'));
        if ($name === '') {
            $this->redirect(url('/admin/products?message=Nama+produk+wajib+diisi&status=error'));
        }
        Product::create([
            'name'        => $name,
            'category_id' => (int) $this->request->post('category_id', 0),
            'category'    => (string) $this->request->post('category', 'custom'),
            'description' => trim((string) $this->request->post('description')),
        ]);
        $this->redirect(url('/admin/products?message=Produk+berhasil+ditambahkan'));
    }

    public function update(): never
    {
        $this->requireCsrf();
        $id   = (int) $this->request->post('id');
        $name = trim((string) $this->request->post('name'));
        if ($id < 1 || $name === '') {
            $this->redirect(url('/admin/products?message=Data+tidak+valid&status=error'));
        }
        Product::update($id, [
            'name'        => $name,
            'category_id' => (int) $this->request->post('category_id', 0),
            'description' => trim((string) $this->request->post('description')),
        ]);
        $this->redirect(url('/admin/products?message=Produk+berhasil+diperbarui'));
    }

    public function delete(): never
    {
        $this->requireCsrf();
        $id = (int) $this->request->post('id');
        if ($id < 1) {
            $this->redirect(url('/admin/products?message=ID+tidak+valid&status=error'));
        }
        // Delete media files first
        $media = ProductMedia::forProduct($id);
        foreach ($media as $m) {
            $filePath = BASE_PATH . '/public' . $m['file_name'];
            if (is_file($filePath)) @unlink($filePath);
        }
        Product::delete($id);
        $this->redirect(url('/admin/products?message=Produk+berhasil+dihapus'));
    }

    public function uploadMedia(): never
    {
        $this->requireCsrf();
        $productId = (int) $this->request->post('product_id');
        if ($productId < 1) {
            $this->redirect(url('/admin/products?message=Pilih+produk+terlebih+dahulu&status=error'));
        }

        $file      = $this->request->file('media');
        $fileName  = $this->storeUpload($file, 'products');
        if ($fileName === '') {
            $this->redirect(url('/admin/products?message=Upload+gagal&status=error'));
        }

        $ext       = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $mediaType = in_array($ext, ['mp4', 'mov', 'webm'], true) ? 'video' : 'image';
        $isCover   = (bool) $this->request->post('is_cover', false);

        ProductMedia::create($productId, $fileName, $mediaType, $isCover);
        $this->redirect(url('/admin/products?message=Media+berhasil+diupload'));
    }

    public function deleteMedia(): never
    {
        $this->requireCsrf();
        $id  = (int) $this->request->post('id');
        $row = ProductMedia::delete($id);
        if ($row) {
            $path = BASE_PATH . '/public' . $row['file_name'];
            if (is_file($path)) @unlink($path);
        }
        $this->redirect(url('/admin/products?message=Media+berhasil+dihapus'));
    }

    private function storeUpload(?array $file, string $folder): string
    {
        if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return '';
        $ext     = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'mov', 'webm'];
        if (!in_array($ext, $allowed, true)) return '';
        $maxSize = (int) env('UPLOAD_MAX_SIZE', 20971520);
        if (($file['size'] ?? 0) > $maxSize) return '';
        $dir = BASE_PATH . '/public/uploads/' . $folder;
        if (!is_dir($dir)) mkdir($dir, 0775, true);
        $name   = date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
        $target = $dir . '/' . $name;
        if (!move_uploaded_file((string) $file['tmp_name'], $target)) return '';
        return '/uploads/' . $folder . '/' . $name;
    }
}
