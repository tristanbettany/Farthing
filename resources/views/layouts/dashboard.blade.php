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

        <nav class="w-full sm:w-300px h-200px sm:h-screen shadow-2xl bg-black sm:fixed bg-ter-800">

            <div class="text-center p-20px mb-20px">
                <a href="/dashboard" title="Farthing" class="text-40px text-white tracking-widest">F<i class="text-white text-40px fas fa-coins"></i>RTHING</a>
            </div>

            <ul>
                <li class="cursor-pointer hover:bg-ter-600"><a href="/dashboard/accounts" class="py-10px px-20px text-white block">Accounts</a></li>
                <li class="cursor-pointer hover:bg-ter-600"><a href="/dashboard/transactions" class="py-10px px-20px text-white block">Transactions</a></li>
                <li class="cursor-pointer hover:bg-ter-600"><a href="/dashboard/templates" class="py-10px px-20px text-white block">Templates</a></li>
            </ul>
        </nav>

        <div class="w-full px-20px py-20px sm:pl-340px sm:pr-40px sm:py-20px sm:h-screen text-justify">

            @yield('content')

        </div>

    </div>
</body>
</html>
