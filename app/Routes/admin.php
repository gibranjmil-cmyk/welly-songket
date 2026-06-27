<?php

declare(strict_types=1);

use WellySongket\Controllers\Admin\AuthController;
use WellySongket\Controllers\Admin\DashboardController;
use WellySongket\Controllers\Admin\ProductController;
use WellySongket\Controllers\Admin\MotifController;
use WellySongket\Controllers\Admin\OrderController;
use WellySongket\Controllers\Admin\CategoryController;

// Auth
$router->get('/admin/login',  AuthController::class, 'login',        'admin.login');
$router->post('/admin/login', AuthController::class, 'authenticate', 'admin.authenticate');
$router->post('/admin/logout',AuthController::class, 'logout',       'admin.logout');

// Dashboard
$router->get('/admin',           DashboardController::class, 'index', 'admin');
$router->get('/admin/dashboard', DashboardController::class, 'index', 'admin.dashboard');

// Produk
$router->get('/admin/products',              ProductController::class, 'index',       'admin.products');
$router->post('/admin/products/store',       ProductController::class, 'store',       'admin.products.store');
$router->post('/admin/products/update',      ProductController::class, 'update',      'admin.products.update');
$router->post('/admin/products/delete',      ProductController::class, 'delete',      'admin.products.delete');
$router->post('/admin/products/media',       ProductController::class, 'uploadMedia', 'admin.products.media');
$router->post('/admin/products/media/delete',ProductController::class, 'deleteMedia', 'admin.products.media.delete');

// Motif
$router->get('/admin/motifs',         MotifController::class, 'index',  'admin.motifs');
$router->post('/admin/motifs/store',  MotifController::class, 'store',  'admin.motifs.store');
$router->post('/admin/motifs/update', MotifController::class, 'update', 'admin.motifs.update');
$router->post('/admin/motifs/delete', MotifController::class, 'delete', 'admin.motifs.delete');

// Pesanan
$router->get('/admin/orders',               OrderController::class, 'index',        'admin.orders');
$router->get('/admin/orders/show',          OrderController::class, 'show',         'admin.orders.show');
$router->post('/admin/orders/status',       OrderController::class, 'updateStatus', 'admin.orders.status');
$router->post('/admin/orders/delete',       OrderController::class, 'delete',       'admin.orders.delete');

// Kategori
$router->get('/admin/categories',                  CategoryController::class, 'index',         'admin.categories');
$router->post('/admin/categories/product/store',   CategoryController::class, 'storeProduct',  'admin.categories.product.store');
$router->post('/admin/categories/motif/store',     CategoryController::class, 'storeMotif',    'admin.categories.motif.store');
$router->post('/admin/categories/product/delete',  CategoryController::class, 'deleteProduct', 'admin.categories.product.delete');
$router->post('/admin/categories/motif/delete',    CategoryController::class, 'deleteMotif',   'admin.categories.motif.delete');
