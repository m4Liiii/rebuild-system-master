<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\GetDebt;
use App\Models\Customer;
use Carbon\Carbon;

class DeleteOldRecords extends Command
{
    protected $signature = 'records:delete-old';
    protected $description = 'Delete records older than 40 days';

    public function handle()
    {
        $threshold = Carbon::now()->subMinutes(1);

        // Delete old products
        Product::where('updated_at', '<', $threshold)
               ->where('type_delete', 0)
               ->delete();

        // Delete old categories
        Category::where('updated_at', '<', $threshold)
                ->where('type_delete', 0)
                ->delete();

        // Delete old debts
        GetDebt::where('updated_at', '<', $threshold)
               ->where('type_delete', 0)
               ->delete();

        // Delete old customers
        Customer::where('updated_at', '<', $threshold)
                ->where('type_delete', 0)
                ->delete();

        $this->info('Old records deleted successfully.');
    }
}
