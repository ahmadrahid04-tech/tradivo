<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        $items = [
            'iPhone 15 Pro Max 256GB',
            'MacBook Air M2 2023',
            'Samsung Galaxy S24 Ultra',
            'Honda Beat 2022 Putih',
            'Yamaha NMAX 2023 ABS',
            'PS5 Slim Digital Edition',
            'iPad Pro 12.9 M2 Chip',
            'Nike Air Jordan 1 High OG',
            'Kamera Sony A7 III Body Only',
            'Sepeda Polygon Cascade 3',
            'TV Samsung 55 inch 4K UHD',
            'Robot Vacuum Xiaomi Gen 2',
            'Sofa L Minimalis Premium',
            'Meja Kerja Standing Desk',
            'Kulkas 2 Pintu LG Inverter',
            'Mesin Cuci Samsung 10kg',
            'Drone DJI Mini 3 Pro',
            'Keyboard Mechanical Keychron K2',
            'Monitor LG 27 inch IPS 144Hz',
            'AC Daikin 1 PK Inverter',
            'Tas Ransel Eiger Original',
            'Jam Tangan Casio G-Shock',
            'Helm KYT TT Course Full Face',
            'Gitar Yamaha F310 Akustik',
            'Printer Canon Pixma G2020',
        ];

        $descriptions = [
            "Barang masih dalam kondisi sangat baik, dipakai hanya beberapa bulan. Kelengkapan termasuk box, charger, dan semua aksesoris original. Dijual karena upgrade ke model terbaru. Harga sudah nett, tidak termasuk ongkir. Bisa COD di area sekitar atau kirim via ekspedisi. Serius buyer only, no PHP.",
            "Kondisi 99% seperti baru, garansi resmi masih panjang. Pemakaian sangat terawat, selalu menggunakan pelindung. Tidak pernah jatuh atau kena air. Dijual cepat karena butuh dana. Bisa nego tipis untuk pembeli serius. Chat untuk detail lebih lanjut.",
            "Barang second berkualitas, fungsi 100% normal tanpa kendala apapun. Sudah di-service dan dibersihkan total. Cocok untuk yang cari barang bagus dengan budget terbatas. Pembelian include bonus aksesoris tambahan. Lokasi pengambilan fleksibel.",
        ];

        return [
            'user_id'     => User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'title'       => fake()->randomElement($items),
            'description' => fake()->randomElement($descriptions),
            'price'       => fake()->randomElement([
                50000, 150000, 350000, 500000, 750000,
                1200000, 2500000, 3500000, 5000000, 7500000,
                10000000, 15000000, 25000000,
            ]),
            'location'    => fake()->randomElement([
                'Jakarta Selatan', 'Jakarta Barat', 'Surabaya', 'Bandung',
                'Medan', 'Semarang', 'Yogyakarta', 'Malang', 'Denpasar',
            ]),
            'condition'   => fake()->randomElement(['new', 'used']),
            'status'      => 'active',
            'views_count' => fake()->numberBetween(0, 500),
        ];
    }
}
