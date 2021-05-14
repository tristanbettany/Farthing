<?php

namespace App\Http\Controllers;

use App\Services\AccountsService;
use App\Services\TransactionsService;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    public function __construct(
        private TransactionsService $transactionsService,
        private AccountsService $accountsService
    ){}

    public function getIndex(): Renderable
    {
        $accounts = $this->accountsService
            ->getAccountsQuery()
            ->get();

        $accountsCalculations = [];

        foreach($accounts as $account) {
            $monthlyCalculations = $this->transactionsService->getMonthlyCalculations(
                $account->id,
                6
            );

            $accountsCalculations[$account->id] = [
                'id' => $account->id,
                'name' => $account->name,
                'months' => $monthlyCalculations,
            ];
        }

        return view('dashboard.index')
            ->with('accountsCalculations', $accountsCalculations);
    }
}
