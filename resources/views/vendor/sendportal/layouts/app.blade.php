@extends('sendportal::layouts.base')

@section('htmlBody')
    <div class="container-fluid">
        <div class="row">

            <div class="sidebar bg-black min-vh-100 d-none d-xl-block" style="background-color: #000000 !important; border-right: 1px solid #18181b;">

                <div class="mt-4">
                    <div class="logo text-center">
                        <a href="{{ route('sendportal.dashboard') }}">
                            <img src="{{ asset('/vendor/sendportal/img/logo-main.png') }}" alt="" width="175px">
                        </a>
                    </div>
                </div>

                <div class="mt-5">
                    @include('sendportal::layouts.partials.sidebar')
                </div>
            </div>

            @include('sendportal::layouts.main')
        </div>
    </div>
@endsection