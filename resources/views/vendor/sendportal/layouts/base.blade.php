<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="mcp-os-multi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script>
        (function() {
            var theme = localStorage.getItem("sendportal_theme") || "mcp-os-multi";
            document.documentElement.setAttribute("data-theme", theme);
            var bgId = localStorage.getItem("sendportal_bg") || "strands";
            window.__mcpActiveBg = bgId;

            // Paletas ambientais instantâneas dos Shaders para Frame 0 (Zero-Flash)
            var shaderPalettes = {
                strands: "radial-gradient(ellipse at 50% 50%, #20113a 0%, #080611 50%, #040407 100%)",
                siderays: "radial-gradient(ellipse at 80% 20%, #1f1b2e 0%, #090614 60%, #040407 100%)",
                plasmawave: "radial-gradient(ellipse at 50% 50%, #220e38 0%, #08111e 60%, #040407 100%)",
                ferrofluid: "radial-gradient(ellipse at 50% 50%, #151520 0%, #08080d 60%, #040407 100%)",
                softaurora: "radial-gradient(ellipse at 50% 30%, #0e2428 0%, #0f1226 60%, #040407 100%)",
                dither: "radial-gradient(ellipse at 50% 50%, #1a102f 0%, #090514 60%, #040407 100%)",
                darkveil: "radial-gradient(ellipse at 50% 50%, #140b1e 0%, #06040a 60%, #040407 100%)",
                acidsquares: "radial-gradient(ellipse at 50% 50%, #1e1335 0%, #070712 60%, #040407 100%)",
                webthreads: "radial-gradient(ellipse at 50% 50%, #161a30 0%, #070a14 60%, #040407 100%)",
                balatro: "radial-gradient(ellipse at 50% 50%, #260d26 0%, #0c050f 60%, #040407 100%)",
                moltenmetal: "radial-gradient(ellipse at 50% 50%, #28120e 0%, #0c0505 60%, #040407 100%)",
                topography: "radial-gradient(ellipse at 50% 50%, #180e2b 0%, #080512 60%, #040407 100%)",
                lighttunnel: "radial-gradient(ellipse at 50% 50%, #1d0f36 0%, #060814 60%, #040407 100%)"
            };

            var initialBgStyle = shaderPalettes[bgId] || "radial-gradient(ellipse at 50% 50%, #1a102f 0%, #040407 100%)";
            document.write('<style>#bg-container { background: ' + initialBgStyle + ' !important; }</style>');
        })();
    </script>

    @include("sendportal::layouts.partials.favicons")

    <title>
        @hasSection("title")
            @yield("title") |
        @endif
        {{ config("app.name") }}
    </title>

    <link href="{{ asset("vendor/sendportal/css/fontawesome-all.min.css") }}" rel="stylesheet">
    <link href="{{ asset("vendor/sendportal/css/bootstrap.min.css") }}" rel="stylesheet">
    <link href="{{ asset(mix("app.css", "vendor/sendportal")) }}" rel="stylesheet">
    <link id="sendportal-amoled-css" href="{{ asset("css/amoled-theme.css") }}?v=mcpos-3.1" rel="stylesheet">
    <link id="sendportal-mcpos-css" href="{{ asset("css/mcp-os-multi.css") }}?v=mcpos-3.1" rel="stylesheet">
    <script>
        (function() {
            var theme = localStorage.getItem("sendportal_theme") || "mcp-os-multi";
            if (theme === "mcp-os-multi") {
                var amoled = document.getElementById("sendportal-amoled-css");
                if (amoled) amoled.disabled = true;
            } else {
                var mcpos = document.getElementById("sendportal-mcpos-css");
                if (mcpos) mcpos.disabled = true;
            }
        })();
    </script>

    @stack("css")

</head>
<body>

<!-- Background Engine Permanente (Nunca desmonta na navegação SPA) -->
<div id="bg-container">
    <div class="bg-slide active" id="bg-slide-1"></div>
    <div class="bg-slide" id="bg-slide-2"></div>
    <div id="bg-webgl-container"></div>
</div>
<div id="bg-overlay"></div>

@yield("htmlBody")

<script src="{{ asset("vendor/sendportal/js/jquery-3.6.0.min.js") }}"></script>
<script src="{{ asset("vendor/sendportal/js/popper.min.js") }}"></script>
<script src="{{ asset("vendor/sendportal/js/bootstrap.min.js") }}"></script>

<script>
    $(".sidebar-toggle").click(function (e) {
        e.preventDefault();
        toggleElements();
    });

    function toggleElements() {
        $(".sidebar").toggleClass("d-none");
    }
</script>

<script type="module" src="{{ asset("js/mcp-os-webgl.js") }}?v=mcpos-3.1"></script>
<script type="module" src="{{ asset("js/mcp-os-theme-manager.js") }}?v=mcpos-3.1"></script>

@stack("js")

</body>
</html>
