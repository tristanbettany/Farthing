@extends('layouts.dashboard')

@section('sidebar-info')
    <div class="flex flex-row justify-start items-end flex-wrap">

        <div class="w-full my-10px">
            <a href="/dashboard/toggle-redaction-mode" class="cursor-pointer block w-full text-center text-white border-2 border-ter-500 py-10px px-20px hover:border-white outline-none">
                Toggle Redaction Mode
            </a>
        </div>

    </div>
@endsection

@section('content')
    <h1 class="mb-40px">Greetings {{ auth()->user()->name }}</h1>

    <div class="w-full sm:w-1/2">
        <div class="flex flex-row justify-start items-baseline flex-wrap">

            @foreach($accountsCalculations as $account)
                <div class="w-full">
                    <div class="mb-20px sm:mb-20px">
                        <div class="bg-pri-400 text-white px-20px py-10px rounded-md">
                            Account <span class="underline text-white">{{ $account['name'] }}</span> Profit Loss
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <table class="w-full table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Profit/Loss</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($account['months'] as $month)
                                <tr>
                                    <td><strong>{{ $month['from']->format('M') }}</strong></td>
                                    <td>
                                        <span class="{{ session('redacted') === true ? 'rounded bg-black text-black px-10px py-5px' : '' }}">{{ $month['calculations']['start'] }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ session('redacted') === true ? 'rounded bg-black text-black px-10px py-5px' : '' }}">{{ $month['calculations']['end'] }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ session('redacted') === true ? 'rounded bg-black text-black px-10px py-5px' : '' }}">{{ $month['calculations']['diff'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach

        </div>
    </div>
@endsection
