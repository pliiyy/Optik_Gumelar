<?php

namespace App\Services;

class ProductCatalog
{
    public static function items(): array
    {
        return [
            'lens' => [
                'single-vision-standard' => ['name' => 'Single Vision Standard', 'category' => 'Lensa Resep', 'description' => 'Lensa resep single vision untuk pemakaian sehari-hari.', 'price' => 150000],
                'anti-radiasi-blue-light' => ['name' => 'Anti Radiasi Blue Light', 'category' => 'Lensa Resep', 'description' => 'Lensa dengan perlindungan sinar biru untuk aktivitas digital.', 'price' => 275000],
                'photochromic-transisi' => ['name' => 'Photochromic (Transisi)', 'category' => 'Lensa Resep', 'description' => 'Lensa yang menyesuaikan tingkat gelap berdasarkan paparan cahaya.', 'price' => 550000],
                'progressive-multifocal' => ['name' => 'Progressive Multifocal', 'category' => 'Lensa Resep', 'description' => 'Lensa multifokal untuk penglihatan jarak dekat dan jauh.', 'price' => 850000],
                'soft-contact-lens-bening' => ['name' => 'Soft Contact Lens Bening', 'category' => 'Lensa Kontak', 'description' => 'Lensa kontak bening yang nyaman digunakan sehari-hari.', 'price' => 120000],
                'contact-lens-silicone-hydrogel' => ['name' => 'Contact Lens Silicone Hydrogel', 'category' => 'Lensa Kontak', 'description' => 'Lensa kontak silicone hydrogel dengan sirkulasi oksigen yang baik.', 'price' => 210000],
                'lapisan-anti-gores' => ['name' => 'Lapisan Anti Gores', 'category' => 'Lensa Tambahan', 'description' => 'Lapisan pelindung untuk membantu mengurangi goresan pada lensa.', 'price' => 50000],
                'lapisan-anti-air-minyak' => ['name' => 'Lapisan Anti Air & Minyak', 'category' => 'Lensa Tambahan', 'description' => 'Lapisan lensa yang membantu menolak air dan minyak.', 'price' => 75000],
            ],
            'frame' => [
                'classic-round-tr90' => ['name' => 'Classic Round TR90', 'category' => 'Pria', 'description' => 'Frame klasik berbahan TR90 yang ringan.', 'price' => 350000],
                'cat-eye-acetate' => ['name' => 'Cat Eye Acetate', 'category' => 'Wanita', 'description' => 'Frame cat eye dengan bahan acetate premium.', 'price' => 420000],
                'kids-flexible-frame' => ['name' => 'Kids Flexible Frame', 'category' => 'Anak', 'description' => 'Frame anak fleksibel dan nyaman untuk aktivitas harian.', 'price' => 275000],
                'titanium-rimless' => ['name' => 'Titanium Rimless', 'category' => 'Pria', 'description' => 'Frame rimless titanium yang ringan dan minimalis.', 'price' => 650000],
                'vintage-square-metal' => ['name' => 'Vintage Square Metal', 'category' => 'Wanita', 'description' => 'Frame kotak bergaya vintage berbahan metal.', 'price' => 390000],
                'reading-glasses-basic' => ['name' => 'Reading Glasses Basic', 'category' => 'Kacamata Baca', 'description' => 'Kacamata baca basic dengan frame ringan.', 'price' => 180000],
            ],
            'accessory' => [
                'hard-case-kacamata' => ['name' => 'Hard Case Kacamata', 'category' => 'Aksesoris', 'description' => 'Pelindung kokoh untuk menjaga frame tetap aman.', 'price' => 75000],
                'pouch-kacamata' => ['name' => 'Pouch Kacamata', 'category' => 'Aksesoris', 'description' => 'Pouch ringan untuk penyimpanan kacamata sehari-hari.', 'price' => 35000],
                'kain-lap-mikrofiber' => ['name' => 'Kain Lap Mikrofiber', 'category' => 'Aksesoris', 'description' => 'Kain mikrofiber untuk membersihkan lensa tanpa goresan.', 'price' => 15000],
                'tali-kacamata' => ['name' => 'Tali Kacamata', 'category' => 'Aksesoris', 'description' => 'Tali nyaman agar kacamata mudah dijangkau.', 'price' => 25000],
                'cairan-pembersih-lensa' => ['name' => 'Cairan Pembersih Lensa', 'category' => 'Aksesoris', 'description' => 'Cairan untuk membersihkan debu dan minyak pada lensa.', 'price' => 30000],
                'obeng-mini-kacamata' => ['name' => 'Obeng Mini Kacamata', 'category' => 'Aksesoris', 'description' => 'Obeng mini untuk mengencangkan sekrup frame.', 'price' => 20000],
            ],
        ];
    }
}
