<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title> {{ gs()->siteName(__($pageTitle)) }}</title>

    @include('partials.seo')

    <link type="image/png" href="{{ siteFavicon() }}" rel="icon" sizes="16x16" />

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset($activeTemplateTrue . 'css/lib/odometer-theme-default.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/lib/magnific-popup.css') }}" rel="stylesheet" />

    @stack('style-lib')

    <link href="{{ asset($activeTemplateTrue . 'css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet" />

    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}" rel="stylesheet" />

    @stack('style')
</head>

@php echo loadExtension('google-analytics') @endphp

<body>
    @stack('fbComment')

    <div class="preloader">
        <div class="preloader__img">
            <img src="{{ siteFavicon() }}" alt="image">
        </div>
    </div>

    <div class="back-to-top">
        <span class="back-top">
            <i class="las la-angle-double-up"></i>
        </span>
    </div>

    @yield('panel')

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/global/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/lib/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/lib/viewport.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/lib/odometer.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>

    <script>
        function showAmount(amount, decimal = 8, separate = false, exceptZeros = true) {
            amount *= 1;
            var separator = '';
            if (separate) {
                separator = ',';
            }
            var printAmount = amount.toFixed(decimal).replace(/\B(?=(\d{3})+(?!\d))/g, separator);
            if (exceptZeros) {
                var exp = printAmount.split('.');
                if (exp[1] * 1 == 0) {
                    printAmount = exp[0];
                } else {
                    printAmount = printAmount.replace(/0+$/, '');
                }
            }
            return printAmount;
        }
    </script>

    @php echo loadExtension('tawk-chat') @endphp

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @include('partials.notify')

    @stack('script')

    <script>
        (function($) {
            "use strict";

            $('.select2-basic').select2();

            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });

            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });
        })(jQuery);
    </script>
</body>

</html>
