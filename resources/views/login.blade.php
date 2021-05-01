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
    <div class="flex flex-row justify-center flex-wrap sm:h-screen items-center">

        <div class="w-full sm:w-1/2 h-450px sm:h-screen bg-no-repeat bg-cover bg-bottom shadow-2xl filter grayscale" style="background-image: url({{ asset('img/banners/'. rand(1, 1) .'.jpg') }});">
        </div>

        <div class="w-full sm:w-1/2 p-20px sm:h-screen flex flex-col justify-center flex-wrap items-center text-center: sm:text-left">

            <div class="w-full flex flex-col justify-center flex-wrap items-center text-center">

                <div class="pb-40px">
                    <h1 class="text-60px tracking-widest">F<i class="text-ter-800 text-40px sm:text-60px fas fa-coins"></i>RTHING</h1>
                </div>
                <a class="px-20px py-10px bg-pri-500 text-white cursor-pointer text-24px border-2 border-pri-500 hover:bg-white hover:text-ter-800" href="/dashboard">Login</a>

            </div>

        </div>

    </div>
</body>
</html>
