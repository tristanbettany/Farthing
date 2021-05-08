<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Pivots\TransactionTag;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = Account::factory()
            ->count(1)
            ->create();

        $transactions = Transaction::factory()
            ->count(50)
            ->create([
                'account_id' => $accounts->first()->id,
            ]);

        $tags = Tag::factory()
            ->count(5)
            ->create([
                'account_id' => $accounts->first()->id,
            ]);

        foreach ($transactions as $transaction) {
            foreach ($tags as $tag) {
                $transactionTag = TransactionTag::factory()
                    ->count(1)
                    ->create([
                        'transaction_id' => $transaction->id,
                        'tag_id' => $tag->id,
                    ]);
            }
        }

        $templates = Template::factory()
            ->count(5)
            ->create([
                'account_id' => $accounts->first()->id,
            ]);
    }
}
