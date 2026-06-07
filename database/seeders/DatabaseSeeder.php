<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* ── Admin ───────────────────────── */
        $admin = User::create([
            'name'     => 'Admin Tradivo',
            'email'    => 'admin@tradivo.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'location' => 'Jakarta',
            'bio'      => 'Administrator platform Tradivo.',
            'email_verified_at' => now(),
        ]);

        /* ── Demo User ───────────────────── */
        $demoUser = User::create([
            'name'     => 'Bahlil',
            'email'    => 'user@tradivo.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
            'phone'    => '081298765432',
            'location' => 'Bandung',
            'bio'      => 'Penjual terpercaya di Tradivo.',
            'email_verified_at' => now(),
        ]);

        /* ── More Users ──────────────────── */
        $users = User::factory(8)->create();
        $allUsers = $users->push($demoUser);

        /* ── Categories ──────────────────── */
        $categories = [
            ['name' => 'Elektronik',         'icon' => '📱', 'sort_order' => 1, 'children' => ['Handphone', 'Laptop & PC', 'Tablet', 'Kamera', 'Audio']],
            ['name' => 'Kendaraan',          'icon' => '🏍️', 'sort_order' => 2, 'children' => ['Motor', 'Mobil', 'Sepeda']],
            ['name' => 'Properti',           'icon' => '🏠', 'sort_order' => 3, 'children' => ['Rumah', 'Apartemen', 'Tanah', 'Kos-kosan']],
            ['name' => 'Fashion',            'icon' => '👕', 'sort_order' => 4, 'children' => ['Pakaian Pria', 'Pakaian Wanita', 'Sepatu', 'Tas', 'Aksesoris']],
            ['name' => 'Hobi & Olahraga',    'icon' => '⚽', 'sort_order' => 5, 'children' => ['Alat Musik', 'Olahraga', 'Koleksi', 'Gaming']],
            ['name' => 'Rumah Tangga',       'icon' => '🛋️', 'sort_order' => 6, 'children' => ['Furnitur', 'Peralatan Dapur', 'Dekorasi']],
            ['name' => 'Perlengkapan Bayi',  'icon' => '👶', 'sort_order' => 7, 'children' => ['Stroller', 'Pakaian Bayi', 'Mainan']],
            ['name' => 'Jasa',               'icon' => '🔧', 'sort_order' => 8, 'children' => ['Les Privat', 'Servis', 'Desain']],
            ['name' => 'Makanan & Minuman',  'icon' => '🍔', 'sort_order' => 9, 'children' => []],
            ['name' => 'Lainnya',            'icon' => '📦', 'sort_order' => 10, 'children' => []],
        ];

        $allCategoryIds = [];

        foreach ($categories as $catData) {
            $parent = Category::create([
                'name'       => $catData['name'],
                'icon'       => $catData['icon'],
                'sort_order' => $catData['sort_order'],
            ]);
            $allCategoryIds[] = $parent->id;

            foreach ($catData['children'] as $childName) {
                $child = Category::create([
                    'name'      => $childName,
                    'parent_id' => $parent->id,
                ]);
                $allCategoryIds[] = $child->id;
            }
        }

        /* ── Listings ────────────────────── */
        $productImages = [
            'iPhone 15 Pro Max 256GB' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80',
            'MacBook Air M2 2023' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=600&auto=format&fit=crop&q=80',
            'Samsung Galaxy S24 Ultra' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=600&auto=format&fit=crop&q=80',
            'Honda Beat 2022 Putih' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=600&auto=format&fit=crop&q=80',
            'Yamaha NMAX 2023 ABS' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=600&auto=format&fit=crop&q=80',
            'PS5 Slim Digital Edition' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=600&auto=format&fit=crop&q=80',
            'iPad Pro 12.9 M2 Chip' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80',
            'Nike Air Jordan 1 High OG' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=600&auto=format&fit=crop&q=80',
            'Kamera Sony A7 III Body Only' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&auto=format&fit=crop&q=80',
            'Sepeda Polygon Cascade 3' => 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?w=600&auto=format&fit=crop&q=80',
            'TV Samsung 55 inch 4K UHD' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=600&auto=format&fit=crop&q=80',
            'Robot Vacuum Xiaomi Gen 2' => 'https://images.unsplash.com/photo-1589739900243-4b52cd9b104e?w=600&auto=format&fit=crop&q=80',
            'Sofa L Minimalis Premium' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=600&auto=format&fit=crop&q=80',
            'Meja Kerja Standing Desk' => 'https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?w=600&auto=format&fit=crop&q=80',
            'Kulkas 2 Pintu LG Inverter' => 'https://images.unsplash.com/photo-1571175432230-01a2887f013f?w=600&auto=format&fit=crop&q=80',
            'Mesin Cuci Samsung 10kg' => 'https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?w=600&auto=format&fit=crop&q=80',
            'Drone DJI Mini 3 Pro' => 'https://images.unsplash.com/photo-1508614589041-895b88991e3e?w=600&auto=format&fit=crop&q=80',
            'Keyboard Mechanical Keychron K2' => 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?w=600&auto=format&fit=crop&q=80',
            'Monitor LG 27 inch IPS 144Hz' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop&q=80',
            'AC Daikin 1 PK Inverter' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&auto=format&fit=crop&q=80',
            'Tas Ransel Eiger Original' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&auto=format&fit=crop&q=80',
            'Jam Tangan Casio G-Shock' => 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=600&auto=format&fit=crop&q=80',
            'Helm KYT TT Course Full Face' => 'https://images.unsplash.com/photo-1599819811279-d5ad9cccf838?w=600&auto=format&fit=crop&q=80',
            'Gitar Yamaha F310 Akustik' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?w=600&auto=format&fit=crop&q=80',
            'Printer Canon Pixma G2020' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59edd6?w=600&auto=format&fit=crop&q=80',
        ];

        foreach ($allUsers as $user) {
            $numListings = rand(2, 6);
            for ($i = 0; $i < $numListings; $i++) {
                $listing = Listing::factory()->create([
                    'user_id'     => $user->id,
                    'category_id' => $allCategoryIds[array_rand($allCategoryIds)],
                ]);

                $imageUrl = $productImages[$listing->title] ?? 'listings/placeholder.jpg';

                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $imageUrl,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        /* ── Conversations & Messages ────── */
        $listings = Listing::where('user_id', $demoUser->id)->take(2)->get();
        foreach ($listings as $listing) {
            $buyer = $allUsers->where('id', '!=', $demoUser->id)->random();
            $conversation = Conversation::create([
                'listing_id' => $listing->id,
                'buyer_id'   => $buyer->id,
                'seller_id'  => $demoUser->id,
            ]);

            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id'       => $buyer->id,
                'body'            => 'Halo, saya tertarik dengan ' . $listing->title . '. Apakah masih tersedia?',
            ]);
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id'       => $demoUser->id,
                'body'            => 'Halo kak, masih tersedia. Mau tanya-tanya dulu atau langsung deal?',
            ]);
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id'       => $buyer->id,
                'body'            => 'Boleh nego sedikit kak? Lokasi di mana ya?',
            ]);
        }

        /* ── Wishlists ───────────────────── */
        $randomListings = Listing::inRandomOrder()->take(5)->get();
        foreach ($randomListings as $listing) {
            if ($listing->user_id !== $demoUser->id) {
                Wishlist::firstOrCreate([
                    'user_id'    => $demoUser->id,
                    'listing_id' => $listing->id,
                ]);
            }
        }

        /* ── Create placeholder image ────── */
        $storagePath = storage_path('app/public/listings');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Create a simple placeholder image
        if (function_exists('imagecreatetruecolor')) {
            $img = imagecreatetruecolor(800, 600);
            $bgColor = imagecolorallocate($img, 241, 245, 249);
            $textColor = imagecolorallocate($img, 148, 163, 184);
            imagefill($img, 0, 0, $bgColor);
            imagestring($img, 5, 320, 290, 'No Image', $textColor);
            imagejpeg($img, $storagePath . '/placeholder.jpg', 90);
            imagedestroy($img);
        }
    }
}
