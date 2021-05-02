@extends('layouts.dashboard')

@section('content')
    <h1>{{ $account->name }}, Transactions</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <form class="pt-40px w-full" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="flex flex-row justify-start items-end flex-wrap">

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Select File</span>
                    <input type="file" id="csv" name="csv" accept=".csv" required>
                </div>

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <span class="text-18px font-bold pb-10px block">Bank</span>
                    <div class="form-select-container">
                        <select class="form-select" name="bank">
                            <option>Natwest</option>
                        </select>
                        <div class="form-select-icon">
                            <i class="fas fa-caret-down"></i>
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <button class="form-submit block w-full" name="upload">
                        Upload Transactions
                    </button>
                </div>

            </div>
        </form>

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
