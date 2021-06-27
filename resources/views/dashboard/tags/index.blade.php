@extends('layouts.dashboard')

@section('sidebar-info')
    <div class="flex flex-row justify-start items-end flex-wrap">

        <div class="w-full my-10px">
            <a href="/dashboard/accounts/{{ $account->id }}/tags/process" class="cursor-pointer block w-full text-center text-white border-2 border-ter-500 py-10px px-20px hover:border-white outline-none">
                Re-process Tags
            </a>
        </div>

    </div>
@endsection

@section('content')
    <h1>{{ $account->name }}, Tags</h1>

    <div class="flex flex-row justify-start items-start flex-wrap">

        <form class="pt-40px w-full" method="POST" action="/dashboard/accounts/{{ $account->id }}/tags">

            @csrf

            <div class="flex flex-row justify-start items-end flex-wrap">

                <div class="w-full sm:w-1/5 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Tag Name</span>
                    <input type="text" name="name" class="form-input" />
                </div>

                <div class="w-full sm:w-1/5 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Regex</span>
                    <input type="text" name="regex" class="form-input" />
                </div>

                <div class="w-full sm:w-1/5 sm:px-10px">
                    <span class="text-18px font-bold pb-10px sm:pb-20px block">Hex Code</span>
                    <input type="text" name="hex_code" class="form-input" />
                </div>

                <div class="w-full sm:w-1/5 sm:px-10px">
                    <span class="text-18px font-bold pb-10px block">Light Text?</span>
                    <div class="form-select-container">
                        <select class="form-select" name="is_light_text">
                            <option selected>No</option>
                            <option>Yes</option>
                        </select>
                        <div class="form-select-icon">
                            <i class="fas fa-caret-down"></i>
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-1/5 sm:px-10px">
                    <button class="form-submit block w-full" name="submit">
                        Add Tag
                    </button>
                </div>

            </div>

        </form>

        <div class="w-full overflow-x-auto pt-40px overflow-y-hidden">
            @includeIf('dashboard.partials.tags-table', [
                'tags' => $tags,
                'account' => $account,
            ])
        </div>

        <div class="pt-20px">
            {{ $tags->links('dashboard.partials.pagination') }}
        </div>

    </div>
@endsection
