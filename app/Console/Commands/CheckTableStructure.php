<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckTableStructure extends Command
{
    protected $signature = 'table:check-structure {table} {column?}';
    protected $description = 'Check if a table and optional column exists in the database';

    public function handle()
    {
        $table = $this->argument('table');
        $column = $this->argument('column');

        if (!Schema::hasTable($table)) {
            $this->error("Table '{$table}' does not exist!");
            return 1;
        }

        $this->info("✅ Table '{$table}' exists.");

        if ($column) {
            if (Schema::hasColumn($table, $column)) {
                $this->info("✅ Column '{$column}' exists in table '{$table}'.");
            } else {
                $this->warn("❌ Column '{$column}' does not exist in table '{$table}'.");
            }
        }

        // Show table columns
        $columns = Schema::getColumnListing($table);
        $this->line("\nTable '{$table}' columns:");
        $this->table(
            ['Column Name', 'Type', 'Nullable', 'Default'],
            array_map(function($column) use ($table) {
                $columnType = DB::connection()->getDoctrineColumn($table, $column)->getType()->getName();
                $isNullable = DB::connection()->getDoctrineColumn($table, $column)->getNotnull() ? 'NO' : 'YES';
                $default = DB::connection()->getDoctrineColumn($table, $column)->getDefault();
                return [
                    $column,
                    $columnType,
                    $isNullable,
                    $default ?? 'NULL'
                ];
            }, $columns)
        );

        return 0;
    }
}
