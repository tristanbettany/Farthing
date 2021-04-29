@extends('layouts.dashboard')

@section('content')
    <h1>{{ $account->name }}, Transactions</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <div class="w-full overflow-x-auto pt-40px overflow-y-hidden">
            @includeIf('dashboard.partials.transactions-table', [
                'transactions' => $transactions,
            ])
        </div>

        <div class="pt-20px">
            {{ $transactions->links('dashboard.partials.pagination') }}
        </div>

    </div>
@endsection
