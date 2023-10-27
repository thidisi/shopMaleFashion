@extends('frontend.layout_frontend')
@php
    $title = '404';
@endphp
@push('css')
    <style>
        .page_error {
            width: 100%;
            margin: 0;
            color: #fff;
        }

        .page_error h1 {
            text-align: center;
            margin-top: 1%;
            margin-bottom: 25px;
            font-size: 30px;
            font-weight: 400;
        }

        .page_error p {
            display: block;
            margin: 25px auto;
            max-width: 776px;
            text-align: center;
            color: #f95801;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
        }

        .bl_page404__wrapper {
            position: relative;
            width: 100%;
            margin: 10px auto 10px;
            max-width: 330px;
            min-height: 430px;

        }

        .bl_page404__img {
            width: 100%;
        }

        .bl_page404__link {
            display: block;
            margin: 0 auto;
            width: 260px;
            height: 64px;
            box-shadow: 0 5px 0 #9c1007, inset 0 0 18px rgba(253, 60, 0, 0.75);
            background-color: #f95801;
            color: #fff;
            font-family: "Open Sans", sans-serif;
            font-size: 24px;
            font-weight: 700;
            line-height: 64px;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 30px;
            text-align: center;
        }

        .bl_page404__link:hover,
        .bl_page404__link:focus {
            background-color: #ff7400;
        }

        .bl_page404__el1 {
            position: absolute;
            top: 108px;
            left: 102px;
            opacity: 1;
            animation: el1Move 800ms linear infinite;
            width: 84px;
            height: 106px;
            background: url("https://lucasfashion.com/frontend/img/404/404-1.png") 50% 50% no-repeat;
            z-index: 2;
        }

        .bl_page404__el2 {
            position: absolute;
            top: 92px;
            left: 136px;
            opacity: 1;
            animation: el2Move 800ms linear infinite;
            width: 184px;
            height: 106px;
            background: url("https://lucasfashion.com/frontend/img/404/404-2.png") 50% 50% no-repeat;
            z-index: 2;
        }

        .bl_page404__el3 {
            position: absolute;
            top: 108px;
            left: 180px;
            opacity: 1;
            animation: el3Move 800ms linear infinite;
            width: 284px;
            height: 106px;
            background: url("https://lucasfashion.com/frontend/img/404/404-3.png") 50% 50% no-repeat;
            z-index: 2;
        }

        @keyframes el1Move {
            0% {
                top: 108px;
                left: 102px;
                opacity: 1;
            }

            100% {
                top: -10px;
                left: 22px;
                opacity: 0;
            }
        }

        @keyframes el2Move {
            0% {
                top: 92px;
                left: 136px;
                opacity: 1;
            }

            100% {
                top: -10px;
                left: 108px;
                opacity: 0;
            }
        }

        @keyframes el3Move {
            0% {
                top: 108px;
                left: 180px;
                opacity: 1;
            }

            100% {
                top: 28px;
                left: 276px;
                opacity: 0;
            }
        }
    </style>
@endpush
@section('container')
    <div class="container">
        <div class="page_error">
            <main class="bl_page404">
                <h1>Error 404. The page does not exist</h1>
                <p>Sorry! The page you are looking for can not be found. Perhaps the page you requested was moved or
                    deleted. It
                    is also possible that you made a small typo when entering the address. Go to the main page.
                </p>
                <div class="bl_page404__wrapper">
                    <img src="{{ asset('frontend/img/404/cloud_warmcasino.png') }}"
                        alt="cloud_warmcasino.png">
                    <div class="bl_page404__el1"></div>
                    <div class="bl_page404__el2"></div>
                    <div class="bl_page404__el3"></div>
                    <a class="bl_page404__link" href="/">go home</a>
                </div>
            </main>
        </div>
    </div>
@endsection
