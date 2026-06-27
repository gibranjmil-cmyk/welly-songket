<?php

declare(strict_types=1);

namespace WellySongket\Services;

final class SiteContentService
{
    private string $file;

    public function __construct()
    {
        $this->file = BASE_PATH . '/storage/data/site.json';
    }

    public function all(): array
    {
        $this->ensureFile();

        $content = json_decode((string) file_get_contents($this->file), true);

        return is_array($content) ? $content : $this->defaults();
    }

    public function save(array $data): void
    {
        $this->ensureFile();

        file_put_contents(
            $this->file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    public function add(string $section, array $item): void
    {
        $data = $this->all();
        $data[$section][] = array_merge(['id' => bin2hex(random_bytes(6))], $item);
        $this->save($data);
    }

    public function delete(string $section, string $id): void
    {
        $data = $this->all();
        $data[$section] = array_values(array_filter(
            $data[$section] ?? [],
            static fn (array $item): bool => ($item['id'] ?? '') !== $id
        ));
        $this->save($data);
    }

    private function ensureFile(): void
    {
        $dir = dirname($this->file);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        if (!is_file($this->file)) {
            file_put_contents(
                $this->file,
                json_encode($this->defaults(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            );
        }
    }

    private function defaults(): array
    {
        return [
            'products' => [
                ['id' => 'selendang', 'name' => 'Selendang', 'category' => 'kain', 'description' => 'Preorder selendang songket dengan motif dan ukuran sesuai pesanan.'],
                ['id' => 'tas', 'name' => 'Tas', 'category' => 'aksesoris_cm', 'description' => 'Tas songket custom dengan ukuran dalam cm.'],
                ['id' => 'dompet', 'name' => 'Dompet', 'category' => 'aksesoris_cm', 'description' => 'Dompet songket custom dengan ukuran dalam cm.'],
                ['id' => 'sepatu', 'name' => 'Sepatu', 'category' => 'alas_kaki', 'description' => 'Sepatu songket preorder sesuai ukuran kaki.'],
                ['id' => 'sandal', 'name' => 'Sandal', 'category' => 'alas_kaki', 'description' => 'Sandal songket preorder sesuai ukuran kaki.'],
                ['id' => 'baju-kurung', 'name' => 'Baju Kurung', 'category' => 'pakaian', 'description' => 'Baju kurung songket custom agar fit di badan customer.'],
                ['id' => 'baju-basiba', 'name' => 'Baju Basiba', 'category' => 'pakaian', 'description' => 'Baju basiba songket custom sesuai ukuran badan.'],
                ['id' => 'kemeja', 'name' => 'Kemeja', 'category' => 'pakaian', 'description' => 'Kemeja songket custom sesuai ukuran badan.'],
            ],
            'motifs' => [
                ['id' => 'pucuk-rabuang', 'name' => 'Pucuk Rabuang', 'description' => 'Motif khas Pandai Sikek yang menjadi pilihan utama, namun customer tetap bebas memilih motif lain.'],
            ],
            'product_media' => [],
            'motif_media' => [],
            'videos' => [],
        ];
    }
}
