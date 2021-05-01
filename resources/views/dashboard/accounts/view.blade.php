@extends('layouts.dashboard')

@section('content')
    <h1>{{ $account->name }}</h1>

    <div class="pt-20px sm:pt-40px flex flex-row justify-start items-start flex-wrap">

        <div class="w-full sm:w-1/4">
            <span class="text-18px font-bold">Account Number</span>
            <div class="pt-10px pb-10px sm:pb-0px">
                <span class="pr-10px">{{ $account->account_number }}</span>
            </div>
        </div>

        <div class="w-full sm:w-1/4">
            <span class="text-18px font-bold">Sort Code</span>
            <div class="pt-10px pb-10px sm:pb-0px">
                <span class="pr-10px">{{ $account->sort_code }}</span>
            </div>
        </div>

    </div>

    <div class="w-full border-b-2 border-ter-200 my-40px"></div>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <div class="w-1/2 sm:w-1/4 sm:px-10px">
            <a href="/dashboard/accounts/{{ $account->id }}/transactions" class="text-center block bg-pri-500 text-white px-20px py-10px hover:text-black hover:bg-white border-2 border-pri-500">View Transactions</a>
        </div>

        <div class="w-1/2 sm:w-1/4 sm:px-10px">
            <a href="/dashboard/accounts/{{ $account->id }}/templates" class="text-center block bg-pri-500 text-white px-20px py-10px hover:text-black hover:bg-white border-2 border-pri-500">View Templates</a>
        </div>

        <div class="w-1/2 sm:w-1/4 sm:px-10px">
            <a href="/dashboard/accounts/{{ $account->id }}/tags" class="text-center block bg-pri-500 text-white px-20px py-10px hover:text-black hover:bg-white border-2 border-pri-500">View Tags</a>
        </div>

    </div>
@endsection
