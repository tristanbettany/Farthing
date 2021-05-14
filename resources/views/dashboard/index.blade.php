@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-40px">Greetings {{ auth()->user()->name }}</h1>

    <div class="w-full sm:w-1/2">
        <div class="flex flex-row justify-start items-baseline flex-wrap">

            <div class="w-full">
                <div class="mb-10px sm:mb-20px">
                    <div class="bg-ter-100 text-black px-20px py-10px rounded-md">
                        Profit Loss Last 6 Months
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
