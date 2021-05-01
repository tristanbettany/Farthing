@extends('layouts.dashboard')

@section('content')
    <h1>Accounts</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <form class="pt-40px w-full" method="POST" action="/dashboard/accounts">

            @csrf

            <div class="flex flex-row justify-start items-end flex-wrap">

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Account Name</span>
                    <input type="text" name="name" class="form-input" />
                </div>

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Sort Code</span>
                    <input type="text" name="sort_code" class="form-input" />
                </div>

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Account Number</span>
                    <input type="text" name="account_number" class="form-input" />
                </div>

                <div class="w-full sm:w-1/4 sm:px-10px">
                    <button class="form-submit block w-full" name="submit">
                        Add Account
                    </button>
                </div>

            </div>

        </form>

        <div class="w-full overflow-x-auto pt-40px">
            @includeIf('dashboard.partials.accounts-table', [
                'accounts' => $accounts,
            ])
        </div>

        <div class="pt-20px">
            {{ $accounts->links('dashboard.partials.pagination') }}
        </div>

    </div>
@endsection
