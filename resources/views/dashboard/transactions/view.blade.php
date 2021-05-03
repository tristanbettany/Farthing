@extends('layouts.dashboard')

@section('content')
    <form method="POST" action="/dashboard/accounts/{{ $account->id }}/transactions/{{ $transaction->id }}">

        @csrf

        <div class="flex flex-row justify-start items-start flex-wrap">
            <div class="w-full sm:w-1/2">
                <input type="text" name="name" class="form-input text-40px" value="{{ $transaction->name }}" />
            </div>
        </div>

        <div class="pt-20px sm:pt-40px flex flex-row justify-start items-end flex-wrap">

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px sm:pb-20px block">Amount</span>
                <input type="text" name="amount" class="form-input" value="{{ $transaction->amount }}" />
            </div>

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px sm:pb-20px block">Date</span>
                <input type="date" name="date" class="form-input" value="{{ $transaction->date->format('Y-m-d') }}" />
            </div>

        </div>

        <div class="flex flex-row justify-start items-start flex-wrap pt-40px">

            <div class="w-full sm:w-1/4 sm:px-10px">
                <button class="form-submit block w-full" name="submit">
                    Update Transaction
                </button>
            </div>

            <div class="w-full sm:w-1/4 sm:px-10px">
                <a href="/dashboard/accounts/{{ $account->id }}/transactions" class="text-center block bg-ter-100 px-20px py-10px hover:text-black hover:bg-white hover:border-ter-200 border-2 border-ter-100">
                    Cancel
                </a>
            </div>

        </div>

    </form>
@endsection
