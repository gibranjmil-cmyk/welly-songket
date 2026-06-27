<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Front;

use WellySongket\Core\Controller;
use WellySongket\Models\Product;
use WellySongket\Models\Motif;
use WellySongket\Models\ProductMedia;

final class HomeController extends Controller
{
    public function index(): never
    {
        $products     = [];
        $motifs       = [];
        $productMedia = [];

        try {
            $products     = Product::allWithMedia();
            $motifs       = Motif::all();
        } catch (\Throwable) {
            // DB not ready — silently use empty arrays; page still renders
        }

        // Separate media by type
        $allMedia     = [];
        foreach ($products as $p) {
            foreach ($p['media'] ?? [] as $m) {
                $allMedia[] = $m;
            }
        }
        $productMedia = array_filter($allMedia, fn($m) => $m['media_type'] === 'image');
        $videos       = array_filter($allMedia, fn($m) => $m['media_type'] === 'video');

        $this->render('front/home', [
            'products'        => $products,
            'motifs'          => $motifs,
            'productMedia'    => array_values($productMedia),
            'motifMedia'      => [],   // no separate motif media table currently
            'videos'          => array_values($videos),
            'whatsappNumber'  => preg_replace('/\D+/', '', (string) env('WHATSAPP_NUMBER', '628123456789')),
            'instagramUrl'    => (string) env('INSTAGRAM_URL', '#'),
            'tiktokUrl'       => (string) env('TIKTOK_URL', '#'),
        ]);
    }
}
