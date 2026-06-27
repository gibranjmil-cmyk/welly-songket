# Welly Songket

Website preorder Welly Songket berbasis PHP Native. Admin bisa mengelola produk, motif, foto, serta video dari dashboard.

## Fitur

- Halaman customer satu tujuan: isi preorder lalu diarahkan ke WhatsApp admin.
- Wajib isi nama, alamat, dan nomor WhatsApp.
- Produk dan motif tidak dibatasi. Customer bisa menambah banyak produk dalam satu pesanan.
- Motif utama Pucuk Rabuang sebagai ciri khas Pandai Sikek, tetapi pilihan motif tetap bebas.
- Ukuran menyesuaikan produk: pakaian, alas kaki, tas/dompet dalam cm, kain/selendang, atau custom.
- Admin bisa tambah/hapus produk, motif, foto produk, foto motif, dan video.

## Instalasi

### 1. Clone / Extract ke XAMPP htdocs

Letakkan folder `welly-songket` di `htdocs/`.

### 2. Install dependensi Composer (opsional tapi dianjurkan)

```bash
composer install
```

> Jika tidak bisa jalankan Composer, aplikasi akan otomatis menggunakan fallback autoloader bawaan.

### 3. Konfigurasi .env

Salin `.env.example` menjadi `.env` (atau edit langsung jika sudah ada):

```bash
cp .env.example .env
```

Edit sesuai kebutuhan:

```env
APP_URL=http://localhost/welly-songket/public
WHATSAPP_NUMBER=628123456789
INSTAGRAM_URL=https://instagram.com/akun
TIKTOK_URL=https://tiktok.com/@akun
ADMIN_PASSWORD=password-baru-anda
```

### 4. Pastikan folder storage dan uploads writable

```bash
chmod -R 775 storage/
chmod -R 775 public/uploads/
```

Di Windows/XAMPP, klik kanan folder → Properties → Security → beri akses write ke user web server.

### 5. Buka di browser

```
http://localhost/welly-songket/public
http://localhost/welly-songket/public/admin/login
```

Password admin default: `admin123` — **ganti segera di `.env`**.

## Menjalankan dengan PHP Built-in Server

```bash
php -S 127.0.0.1:8080 -t public
```

Buka `http://127.0.0.1:8080`.

## Penyimpanan Data

Data tersimpan di `storage/data/site.json`. File upload masuk ke:

- `public/uploads/products`
- `public/uploads/motifs`
- `public/uploads/videos`

## Catatan Keamanan

- Ganti `ADMIN_PASSWORD` di `.env` sebelum deploy ke production.
- Set `APP_DEBUG=false` di production.
- Pastikan `storage/` tidak bisa diakses langsung dari browser (sudah diproteksi `.htaccess` default Apache).
