@extends('layouts.dashboard')

@section('content')
    <h1>Accounts</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

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
