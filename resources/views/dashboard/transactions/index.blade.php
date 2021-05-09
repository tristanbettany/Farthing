@extends('layouts.dashboard')

@section('sidebar-info')
    <form class="w-full mb-60px" method="GET">

        @csrf

        <div class="flex flex-row justify-start items-end flex-wrap">

            <div class="w-full my-10px">
                <a href="/dashboard/accounts/{{ $account->id }}/transactions" class="cursor-pointer block w-full text-center text-white border-2 border-ter-500 py-10px px-20px hover:border-white outline-none">
                    Clear Filters
                </a>
            </div>

            <div class="w-full my-10px">
                <span class="text-18px font-bold pb-10px block text-white">From</span>
                <input type="date" name="date-from" class="form-input inverted"
                   @if(request()->get('date-from') !== null)
                        value="{{ (new DateTimeImmutable(request()->get('date-from')))->format('Y-m-d') }}"
                   @endif
                />
            </div>

            <div class="w-full my-10px">
                <span class="text-18px font-bold pb-10px block text-white">To</span>
                <input type="date" name="date-to" class="form-input inverted"
                   @if(request()->get('date-to') !== null)
                        value="{{ (new DateTimeImmutable(request()->get('date-to')))->format('Y-m-d') }}"
                   @endif
                />
            </div>

            <div class="w-full my-10px">
                <button class="block w-full bg-pri-500 text-white py-10px px-20px text-center hover:bg-ter-800 border-2 border-pri-500 outline-none" name="filter">
                    Filter Transactions
                </button>
            </div>

        </div>
    </form>

    <form class="w-full" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="flex flex-row justify-start items-end flex-wrap">

            <div class="w-full my-10px">
                <div class="relative">
                    <label class="cursor-pointer block w-full text-center text-white border-2 border-ter-500 py-10px px-20px hover:border-white outline-none" for="csv">Select File</label>
                    <input type="file" id="csv" name="csv" accept=".csv" required class="absolute top-0px bottom-0px right-0px left-0px m-0px p-0px cursor-pointer opacity-0" style="z-index: -1;">
                </div>
            </div>

            <div class="w-full">
                <div class="form-select-container">
                    <select class="form-select rounded-b-none" name="bank">
                        <option>{{ \App\Parsers\AbstractTransactionParser::PARSER_NATWEST }}</option>
                    </select>
                    <div class="form-select-icon">
                        <i class="fas fa-caret-down"></i>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <button class="block w-full bg-pri-500 text-white py-10px px-20px text-center hover:bg-ter-800 border-2 border-t-0 border-pri-500 rounded-t-none outline-none" name="upload">
                    Upload Transactions
                </button>
            </div>

            <div class="w-full mt-80px">
                <a href="/dashboard/accounts/{{ $account->id }}/transactions/toggle-redaction-mode" class="cursor-pointer block w-full text-center text-white border-2 border-ter-500 py-10px px-20px hover:border-white outline-none">
                    Toggle Redaction Mode
                </a>
            </div>

        </div>
    </form>
@endsection

@section('content')
    <h1>{{ $account->name }}, Transactions</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <form class="pt-40px w-full" method="POST">

            @csrf

            <div class="flex flex-row justify-start items-end flex-wrap">

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Date</span>
                    <input type="date" name="date" class="form-input" />
                </div>

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Amount</span>
                    <input type="text" name="amount" class="form-input" />
                </div>

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <span class="text-18px font-bold pb-10px block">Type</span>
                    <div class="form-select-container">
                        <select class="form-select" name="type">
                            <option>{{ \App\Models\Transaction::TYPE_FUTURE }}</option>
                            <option>{{ \App\Models\Transaction::TYPE_PENDING }}</option>
                        </select>
                        <div class="form-select-icon">
                            <i class="fas fa-caret-down"></i>
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-1/3 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Name</span>
                    <input type="text" name="name" class="form-input" />
                </div>

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <button class="form-submit block w-full" name="add">
                        Add Transaction
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
