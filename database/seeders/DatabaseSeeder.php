<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Supplier;
use App\Models\KategoriBeratPenerimaan;
use App\Models\KategoriBeratCutting;
use App\Models\KategoriByprodukCt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => '1',
            'password' => Hash::make('admin123'),
        ]);
        User::create([
            'name' => 'Pimpinan',
            'email' => 'superadmin@gmail.com',
            'role_id' => '3',
            'password' => Hash::make('superadmin'),
        ]);

        //Grade::factory(3)->create();

        Grade::create([
            'grade' => 'B/C',
        ]);
        Grade::create([
            'grade' => 'D',
        ]);
        Grade::create([
            'grade' => 'Lokal',
        ]);

        //KategoriBeratPenerimaan::factory(3)->create();

        KategoriBeratPenerimaan::create([
            'kategori_berat' => '20 UP',
        ]);
        KategoriBeratPenerimaan::create([
            'kategori_berat' => '20 DOWN',
        ]);
        KategoriBeratPenerimaan::create([
            'kategori_berat' => '30 UP',
        ]);

        //Supplier::factory(1)->create();

        Supplier::create([
            'supplier_id' => 01,
            'nama_supplier' => 'BPM',
            'alamat' => 'Jakarta Barat',
        ]);
        
        //Kategori_byproduk_ct::factory(3)->create();

        KategoriByprodukCt::create([
            'nama_produk' => 'Kama',
        ]);
        KategoriByprodukCt::create([
            'nama_produk' => 'Belly',
        ]);
        KategoriByprodukCt::create([
            'nama_produk' => 'TM (Tetelan Merah)',
        ]);
        KategoriByprodukCt::create([
            'nama_produk' => 'D. Kepala',
        ]); 
        KategoriByprodukCt::create([
            'nama_produk' => 'D. Pipi',
        ]); 
        KategoriByprodukCt::create([
            'nama_produk' => 'D. Kerok',
        ]); 
        KategoriByprodukCt::create([
            'nama_produk' => 'Iga Kerok',
        ]); 
    }
}
