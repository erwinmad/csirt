
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta description -->
    {!! SEO::generate(true) !!}

    <!--favicon icon-->
    <link rel="icon" href="{{ asset('sugih-mukti.png') }}" type="image/png" sizes="16x16">

    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!--build:css-->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>

    <livewire:partials.header />

    {{ $slot }}

    <livewire:partials.footer />

    <button class="scroll-top scroll-to-target" data-target="html">
        <span class="ti-rocket"></span>
    </button>

    <script src="{{ asset('assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/validator.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.rcounterup.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/hs.megamenu.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>