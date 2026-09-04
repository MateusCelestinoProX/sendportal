<div class="main-header" style="background-color: #000000 !important; background: #000000 !important; border-bottom: 1px solid #18181b !important;">

    <header class="navbar navbar-expand flex-row justify-content-between pl-4-half pr-4-half py-3 mb-4" style="background-color: #000000 !important; background: #000000 !important; border: none !important;">

        <button type="button" class="btn btn-light mr-3 btn-sm d-xl-none" data-toggle="modal" data-target="#sidebar-modal" style="background-color: #121214 !important; border: 1px solid #27272a !important; color: #ffffff !important;">
            <i class="fa fa-bars" style="color: #ffffff !important;"></i>
        </button>

        <h1 class="h3 mb-0" style="color: #ffffff !important; font-weight: 800 !important; letter-spacing: -0.02em; text-shadow: 0 0 15px rgba(255, 255, 255, 0.35);">@yield('heading')</h1>

        {!! \Sendportal\Base\Facades\Sendportal::headerHtmlContent() !!}

    </header>
</div>

