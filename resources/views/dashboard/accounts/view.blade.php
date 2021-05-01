@extends('layouts.dashboard')

@section('content')
    <form method="POST" action="/dashboard/accounts/{{ $account->id }}">

        @csrf

        <div class="flex flex-row justify-start items-start flex-wrap">
            <div class="w-full sm:w-1/2">
                <input type="text" name="name" class="form-input text-40px" value="{{ $account->name }}" />
            </div>
        </div>

        <div class="pt-20px sm:pt-40px flex flex-row justify-start items-end flex-wrap">

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px sm:pb-20px block">Sort Code</span>
                <input type="text" name="sort_code" class="form-input" value="{{ $account->sort_code }}" />
            </div>

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px sm:pb-20px block">Account Number</span>
                <input type="text" name="account_number" class="form-input" value="{{ $account->account_number }}" />
            </div>

        </div>

        <div class="flex flex-row justify-start items-start flex-wrap pt-40px">

            <div class="w-full sm:w-1/4 sm:px-10px">
                <button class="form-submit block w-full" name="submit">
                    Update Account Details
                </button>
            </div>

        </div>

        <div class="w-full border-b-2 border-ter-200 mb-40px mt-40px"></div>

        <div class="flex flex-row justify-start items-start flex-wrap">

            <div class="w-full pb-10px sm:w-1/4 sm:px-10px">
                <a href="/dashboard/accounts/{{ $account->id }}/transactions" class="text-center block bg-ter-100 px-20px py-10px hover:text-black hover:bg-white hover:border-ter-200 border-2 border-ter-100">View Transactions</a>
            </div>

            <div class="w-full pb-10px sm:w-1/4 sm:px-10px">
                <a href="/dashboard/accounts/{{ $account->id }}/templates" class="text-center block bg-ter-100 px-20px py-10px hover:text-black hover:bg-white hover:border-ter-200 border-2 border-ter-100">View Templates</a>
            </div>

            <div class="w-full pb-10px sm:w-1/4 sm:px-10px">
                <a href="/dashboard/accounts/{{ $account->id }}/tags" class="text-center block bg-ter-100 px-20px py-10px hover:text-black hover:bg-white hover:border-ter-200 border-2 border-ter-100">View Tags</a>
            </div>

        </div>
    </form>
@endsection
