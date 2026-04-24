<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Kategori Event
        $category1 = Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $category2 = Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        $category3 = Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        // 3. Buat Data Event (Minimal 6 event sesuai tugas)
        Event::create([
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date' => '2025-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        Event::create([
            'category_id' => $category1->id,
            'title' => 'Hackathon - Unleash Your Inner Developer',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif!',
            'date' => '2025-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        Event::create([
            'category_id' => $category1->id,
            'title' => 'AI & FUTURE TECH SUMMIT 2025',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan.',
            'date' => '2025-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);

        // TAMBAHKAN 3 EVENT LAGI (sesuai tugas minimal 6 event)
        Event::create([
            'category_id' => $category3->id,
            'title' => 'UI/UX Masterclass',
            'description' => 'Pelajari dasar-dasar desain UI/UX dari praktisi profesional.',
            'date' => '2025-06-15 09:00:00',
            'location' => 'Lab Komputer Amikom',
            'price' => 75000,
            'stock' => 50,
            'poster_path' => 'posters/event-4.png',
        ]);

        Event::create([
            'category_id' => $category2->id,
            'title' => 'E-Sport Championship',
            'description' => 'Turnamen gaming terbesar se-Universitas AMIKOM.',
            'date' => '2025-07-20 14:00:00',
            'location' => 'Gedung Olahraga Amikom',
            'price' => 0,
            'stock' => 200,
            'poster_path' => 'posters/event-5.png',
        ]);

        Event::create([
            'category_id' => $category1->id,
            'title' => 'Digital Marketing Workshop',
            'description' => 'Strategi pemasaran digital untuk pemula.',
            'date' => '2025-08-10 10:00:00',
            'location' => 'Ruang Seminar 1',
            'price' => 100000,
            'stock' => 75,
            'poster_path' => 'posters/event-6.png',
        ]);
    }
}