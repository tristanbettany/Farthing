@extends('layouts.dashboard')

@section('content')
    <form method="POST" action="/dashboard/accounts/{{ $account->id }}/tags/{{ $tag->id }}">

        @csrf

        <div class="flex flex-row justify-start items-start flex-wrap">
            <div class="w-full sm:w-1/2">
                <input type="text" name="name" class="form-input text-40px" value="{{ $tag->name }}" />
            </div>
        </div>

        <div class="pt-20px sm:pt-40px flex flex-row justify-start items-end flex-wrap">

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px sm:pb-20px block">Regex</span>
                <input type="text" name="regex" class="form-input" value="{{ $tag->regex }}" />
            </div>

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px sm:pb-20px block">Hex Code</span>
                <input type="text" name="hex_code" class="form-input" value="{{ $tag->hex_code }}" />
            </div>

            <div class="w-full sm:w-1/4 sm:px-10px">
                <span class="text-18px font-bold pb-10px block">Light Text?</span>
                <div class="form-select-container">
                    <select class="form-select" name="is_light_text">
                        <option {{ $tag->is_light_text === false ? 'selected' : '' }}>No</option>
                        <option {{ $tag->is_light_text === true ? 'selected' : '' }}>Yes</option>
                    </select>
                    <div class="form-select-icon">
                        <i class="fas fa-caret-down"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex flex-row justify-start items-start flex-wrap pt-40px">

            <div class="w-full sm:w-1/4 sm:px-10px">
                <button class="form-submit block w-full" name="submit">
                    Update Tag
                </button>
            </div>

            <div class="w-full sm:w-1/4 sm:px-10px">
                <a href="/dashboard/accounts/{{ $account->id }}/tags" class="text-center block bg-ter-100 px-20px py-10px hover:text-black hover:bg-white hover:border-ter-200 border-2 border-ter-100">
                    Cancel
                </a>
            </div>

        </div>

    </form>
@endsection
