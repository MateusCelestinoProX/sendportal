@extends('sendportal::layouts.base')

@section('htmlBody')
    <div id="app-shell" class="container-fluid p-0">
        <div class="row no-gutters">

            <div class="sidebar min-vh-100 d-none d-xl-block">

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
