<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Farthing</title>
    <script src="https://kit.fontawesome.com/a016df5e6e.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="flex flex-col justify-start flex-wrap sm:h-screen items-baseline">

        <nav class="w-full sm:w-300px sm:h-screen shadow-2xl sm:fixed bg-ter-800">

            <div class="text-center p-20px mb-20px">
                <a href="/dashboard" title="Farthing" class="text-40px text-white tracking-widest">F<i class="text-white text-40px fas fa-coins"></i>RTHING</a>
            </div>

            <ul>
                <li class="cursor-pointer bg-ter-700"><a href="/dashboard/accounts" class="py-10px px-20px text-ter-300 block">Accounts</a></li>
                @foreach(\App\Models\Account::where('user_id', \Illuminate\Support\Facades\Auth::id())->get() as $account)
                    <li class="cursor-pointer group relative">
                        <a href="/dashboard/accounts/{{ $account->id }}" class="py-10px px-30px text-white block hover:bg-ter-600"><i class="text-white fas fa-caret-down"></i> {{ $account->name }}</a>
                        <ul class="hidden sm:group-hover:block">
                            <li class="cursor-pointer">
                                <a href="/dashboard/accounts/{{ $account->id }}/transactions" class="py-10px px-40px text-white block hover:bg-ter-600"><i class="text-white fas fa-caret-right"></i> Transactions</a>
                                <a href="/dashboard/accounts/{{ $account->id }}/tags" class="py-10px px-40px text-white block hover:bg-ter-600"><i class="text-white fas fa-caret-right"></i> Tags</a>
                                <a href="/dashboard/accounts/{{ $account->id }}/templates" class="py-10px px-40px text-white block hover:bg-ter-600"><i class="text-white fas fa-caret-right"></i> Templates</a>
                            </li>
                        </ul>
                    </li>
                @endforeach
            </ul>

            <a href="/logout" class="sm:absolute sm:bottom-0px sm:left-0px sm:w-300px px-20px py-10px bg-pri-500 text-white cursor-pointer hover:bg-pri-700 block text-right">Logout <i class="text-white fas fa-sign-out-alt"></i></a>

            <div class="text-white sm:absolute block sm:w-300px sm:left-0px sm:bottom-100px px-20px py-10px">
                @yield('sidebar-info')
            </div>
        </nav>

        <div class="w-full px-20px py-20px sm:pl-340px sm:pr-40px sm:py-20px sm:h-screen text-justify">

            @if(empty(session('success')) === false)
                <div class="w-full bg-pri-100 text-pri-500 p-20px mb-20px">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(empty(session('error')) === false)
                <div class="w-full bg-error-100 text-error-600 p-20px mb-20px">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')

        </div>

    </div>
</body>
</html>
