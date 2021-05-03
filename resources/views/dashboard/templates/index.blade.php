@extends('layouts.dashboard')

@section('content')
    <h1>{{ $account->name }}, Templates</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <form class="pt-40px w-full" method="POST">

            @csrf

            <div class="flex flex-row justify-start items-end flex-wrap">

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Amount</span>
                    <input type="text" name="amount" class="form-input" />
                </div>

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Occurances</span>
                    <input type="number" name="occurances" class="form-input" value="12" />
                </div>

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Occurance Syntax</span>
                    <input type="text" name="occurance_syntax" class="form-input" value="@monthly" />
                </div>

                <div class="w-full sm:w-1/3 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Name</span>
                    <input type="text" name="name" class="form-input" />
                </div>

                <div class="w-full sm:w-1/6 sm:px-10px">
                    <button class="form-submit block w-full" name="add">
                        Add Template
                    </button>
                </div>

            </div>

        </form>

        <div class="w-full overflow-x-auto pt-40px overflow-y-hidden">
            @includeIf('dashboard.partials.templates-table', [
                'templates' => $templates,
            ])
        </div>

        <div class="pt-20px">
            {{ $templates->links('dashboard.partials.pagination') }}
        </div>

    </div>
@endsection
