<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self';">
    <title>Health Apps</title>

    <!-- icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css"
        integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- fontello -->
    <link rel="stylesheet" href="{{ asset('front/assets/fontello/css/icons.css') }}" />

    <!-- uicons -->
    <link rel="stylesheet" href="{{ asset('front/assets/uicons/css/uicons-regular-rounded.css') }}" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('front/assets/bootstrap/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('front/assets/css/swiper-bundle.min.css') }}" />

    <!-- custom -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
	  <script src="https://cdn.plyr.io/3.6.8/plyr.polyfilled.js"></script>

    @stack('styles')
</head>

<body>
    <div class="content">
        @yield('content')

        <!-- navbar bottom -->
        @hasSection('bottom_nav')
            <!-- @include('layouts.partials.front.floating-fitplan') -->
            @include('layouts.partials.front.bottom_nav')
        @endif
    </div>

    <script src="{{ asset('front/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('front/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
