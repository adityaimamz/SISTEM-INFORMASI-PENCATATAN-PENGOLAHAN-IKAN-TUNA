<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Supplier;
use App\Models\KategoriBeratPenerimaan;
use App\Models\KategoriBeratCutting;
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

        Grade::create([
            'grade' => 'AB',
        ]);
        Grade::create([
            'grade' => 'ABC',
        ]);
        Grade::create([
            'grade' => 'C',
        ]);
        Grade::create([
            'grade' => 'Lokal',
        ]);

        KategoriBeratPenerimaan::create([
            'kategori_berat' => '10 UP',
        ]);
        KategoriBeratPenerimaan::create([
            'kategori_berat' => '20 UP',
        ]);
        KategoriBeratPenerimaan::create([
            'kategori_berat' => '30 UP',
        ]);

        KategoriBeratCutting::create([
            'kategori_berat' => '1/3',
        ]);
        KategoriBeratCutting::create([
            'kategori_berat' => '3/5',
        ]);
        KategoriBeratCutting::create([
            'kategori_berat' => '5 UP',
        ]);

        Supplier::create([
            'supplier_id' => 001,
            'nama_supplier' => 'Mansur',
            'nama_kapal' => 'Kapal A',
            'alamat' => 'Jl. A',
        ]);

        
    }
}
