<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckTableSeeder extends Seeder
{
    public function run()
    {
        try {
            // Check if table exists
            $tableExists = DB::select("SHOW TABLES LIKE 'penerimaan_ikans'");
            
            if (empty($tableExists)) {
                echo "Table 'penerimaan_ikans' does not exist.\n";
                return;
            }
            
            echo "Table 'penerimaan_ikans' exists.\n\n";
            
            // Get table structure
            $columns = DB::select('DESCRIBE penerimaan_ikans');
            
            echo "Table structure:\n";
            echo str_pad("Field", 30) . str_pad("Type", 20) . str_pad("Null", 8) . "Default\n";
            echo str_repeat("-", 70) . "\n";
            
            foreach ($columns as $column) {
                echo str_pad($column->Field, 30) . 
                     str_pad($column->Type, 20) . 
                     str_pad($column->Null, 8) . 
                     ($column->Default ?? 'NULL') . "\n";
            }
            
            // Check if suhu_ikan column exists
            $suhuIkanExists = collect($columns)->contains('Field', 'suhu_ikan');
            
            echo "\n";
            if ($suhuIkanExists) {
                echo "✅ Column 'suhu_ikan' exists in the table.\n";
            } else {
                echo "❌ Column 'suhu_ikan' does NOT exist in the table.\n";
            }
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            Log::error('Database check failed: ' . $e->getMessage());
        }
    }
}
