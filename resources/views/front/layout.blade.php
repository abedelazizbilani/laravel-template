<!DOCTYPE html>
<!--[if IE 8 ]>
<html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="{{ config('app.locale') }}"> <!--<![endif]-->
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>{{ isset($post) && $post->seo_title ? $post->seo_title :  __(lcfirst('Title')) }}</title>
    <meta name="description"
          content="{{ isset($post) && $post->meta_description ? $post->meta_description : __('description') }}">
    <meta name="author" content="@lang(lcfirst ('Author'))">
    @if(isset($post) && $post->meta_keywords)
        <meta name="keywords" content="{{ $post->meta_keywords }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    {{--<link rel="stylesheet" href="public/css/base.css">--}}
    {{--<link rel="stylesheet" href="public/css/vendor.css">--}}
    {{--<link rel="stylesheet" href="public/css/main.css">--}}
    {{--<link rel="stylesheet" href="public/css/templateStyle.css">--}}
    <link rel="stylesheet" href="public/css/app.css">
    @yield('css')

    <style>
        .search-wrap .search-form::after {
            content: "@lang('Press Enter to begin your search.')";
        }
    </style>

    <!-- script
    ================================================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body id="top" class="bg-dark">

<!-- header
================================================== -->
{{--</header> <!-- end header -->--}}

@yield('main')

<!-- footer
================================================== -->
{{--<footer>--}}

{{--</footer>--}}

<div id="preloader">
    <div id="loader"></div>
</div>

<!-- Java Script
================================================== -->
<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
<script src="public/js/plugins.js"></script>
<script src="public/js/main.js"></script>
<script src="public/js/app.js"></script>
<script>
    $(function () {
        $('#logout').click(function (e) {
            e.preventDefault();
            $('#logout-form').submit()
        })
    })
</script>

@yield('scripts')

</body>

</html>
