<?php

namespace Database\Seeders;

use App\Models\AccountModel;
use App\Models\Pivots\TransactionTagPivot;
use App\Models\TagModel;
use App\Models\TemplateModel;
use App\Models\TransactionModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = AccountModel::factory()
            ->count(1)
            ->create();

        $transactions = TransactionModel::factory()
            ->count(50)
            ->create([
                'account_id' => $accounts->first()->id,
            ]);

        $tags = TagModel::factory()
            ->count(5)
            ->create([
                'account_id' => $accounts->first()->id,
            ]);

        foreach ($transactions as $transaction) {
            foreach ($tags as $tag) {
                $transactionTag = TransactionTagPivot::factory()
                    ->count(1)
                    ->create([
                        'transaction_id' => $transaction->id,
                        'tag_id' => $tag->id,
                    ]);
            }
        }

        $templates = TemplateModel::factory()
            ->count(5)
            ->create([
                'account_id' => $accounts->first()->id,
            ]);
    }
}
