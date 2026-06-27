<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Models\Motif;
use WellySongket\Models\MotifCategory;

final class MotifController extends BaseAdminController
{
    public function index(): never
    {
        $this->render('admin/motifs/index', [
            'motifs'     => Motif::all(),
            'categories' => MotifCategory::all(),
            'message'    => (string) $this->request->query('message', ''),
            'status'     => (string) $this->request->query('status', 'success'),
        ], 'admin/admin');
    }

    public function store(): never
    {
        $this->requireCsrf();
        $name = trim((string) $this->request->post('name'));
        if ($name === '') {
            $this->redirect(url('/admin/motifs?message=Nama+motif+wajib+diisi&status=error'));
        }

        // Handle reference image upload
        $refImage = $this->storeUpload($this->request->file('reference_image'), 'references');

        Motif::create([
            'name'            => $name,
            'keywords'        => trim((string) $this->request->post('keywords')),
            'category_id'     => (int) $this->request->post('category_id', 0),
            'philosophy'      => trim((string) $this->request->post('philosophy')),
            'description'     => trim((string) $this->request->post('description')),
            'reference_image' => $refImage ?: null,
        ]);
        $this->redirect(url('/admin/motifs?message=Motif+berhasil+ditambahkan'));
    }

    public function update(): never
    {
        $this->requireCsrf();
        $id   = (int) $this->request->post('id');
        $name = trim((string) $this->request->post('name'));
        if ($id < 1 || $name === '') {
            $this->redirect(url('/admin/motifs?message=Data+tidak+valid&status=error'));
        }
        Motif::update($id, [
            'name'        => $name,
            'keywords'    => trim((string) $this->request->post('keywords')),
            'category_id' => (int) $this->request->post('category_id', 0),
            'philosophy'  => trim((string) $this->request->post('philosophy')),
            'description' => trim((string) $this->request->post('description')),
        ]);
        $this->redirect(url('/admin/motifs?message=Motif+berhasil+diperbarui'));
    }

    public function delete(): never
    {
        $this->requireCsrf();
        $id = (int) $this->request->post('id');
        if ($id < 1) {
            $this->redirect(url('/admin/motifs?message=ID+tidak+valid&status=error'));
        }
        $motif = Motif::find($id);
        if ($motif && $motif['reference_image']) {
            $path = BASE_PATH . '/public' . $motif['reference_image'];
            if (is_file($path)) @unlink($path);
        }
        Motif::delete($id);
        $this->redirect(url('/admin/motifs?message=Motif+berhasil+dihapus'));
    }

    private function storeUpload(?array $file, string $folder): string
    {
        if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return '';
        $ext     = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
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
