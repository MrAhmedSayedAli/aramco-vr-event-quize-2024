<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! SEO::generate() !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
{{--    <title>Cyber Bounty AR Challenge</title>--}}
    <style>

        @font-face{
            font-family: "ManifaPro2 Regular";
            src: url("{{asset('fonts/ManifaPro2/ManifaPro2.eot')}}");
            src: url("{{asset('fonts/ManifaPro2/ManifaPro2.eot')}}?#iefix")format("embedded-opentype"),
            url("{{asset('fonts/ManifaPro2/ManifaPro2.woff')}}")format("woff"),
            url("{{asset('fonts/ManifaPro2/ManifaPro2.woff2')}}")format("woff2"),
            url("{{asset('fonts/ManifaPro2/ManifaPro2.ttf')}}")format("truetype"),
            url("{{asset('fonts/ManifaPro2/ManifaPro2.svg')}}#ManifaPro2 Regular")format("svg");
            font-weight:normal;
            font-style:normal;
            font-display:swap;
        }
        .aramco-btn {
            background-color: #26a8ab;
        }
        body{
            font-family: "ManifaPro2 Regular", "Segoe UI", serif;
        }
        .header {
            background-color: #00A88E;
            padding: 20px;
            text-align: center;
        }
        .header h1 {

            color: white;
            font-size: 1.8em;
            margin: 0;
        }
        .main-content {
            padding: 40px 20px;
        }

        .main-content h2 {
            color: #00A88E;
            font-size: 1.5em;
            margin-top: 20px;
        }
        .main-content p {
            color: #333;
            font-size: 1.1em;
            margin: 20px 0;
        }
        .tabs {
            display: flex;
            justify-content: space-around;
            background: linear-gradient(90deg, #00A88E 0%, #8142FF 100%);
            padding: 20px;
        }
        .tab {
            width: 30%;
            text-align: center;
        }
        .tab img {
            width: 75px;
            height: 75px;
            margin: 0 auto;
        }
        .tab p {
            color: white;
            font-size: 1em;
            margin: 10px 0 0;
        }
        .footer {
            background-color: #00A88E;
            color: white;
            text-align: center;

        }
    </style>
</head>
<body class="bg-gray-500">

{{--<div class="relative rounded-lg bg-cover bg-no-repeat p-12 text-center" style="background-image: url('{{asset('images/bg.png')}}');height: 100vh; background-repeat: no-repeat; background-size: cover">--}}
<div class="relative rounded-lg bg-cover bg-no-repeat p-12 text-center">
{{--
        <div class="header">
            <h1>Cybersecurity Challenge in Augmented Reality Experience</h1>
        </div>



    <div class="tabs row">
        <div class="tab col">
            <a href="{{route('player.register')}}">
                <img src="{{asset('images/register.png')}}" alt="Register Icon">
            </a>
        </div>
        <div class="tab col">
            <a href="{{route('player.login')}}">
                <img src="{{asset('images/check_in.png')}}" alt="Check-In Icon">
            </a>
        </div>
        <div class="tab col">
            <a href="{{route('player.forget')}}">
                <img src="{{asset('images/forget_id.png')}}" alt="Forgot ID Icon">
            </a>
        </div>
    </div>
    --}}
    <main>
        <div class="bg-center main-content">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                {{ $slot }}
            </div>
        </div>
    </main>

{{--

    <footer>
    <div class="w-full mx-auto max-w-screen-xl md:flex md:items-center md:justify-between footer fixed bottom-0">Cybersecurity Bounty Program | See Something Wrong? Do Something Right!</div>
    </footer>
    --}}
</div>

</body>
</html>
