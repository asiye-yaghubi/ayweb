<!DOCTYPE html>
<html>
<head>
@include('admin.partials.head')
@yield('extra-css-header')
</head>
<body class="theme-red">
@include('admin.partials.loader')
<div class="overlay"></div>

@include('admin.partials.searchbar')
@include('admin.partials.navbar')
<section>
@include('admin.partials.sidebar-left')
@include('admin.partials.sidebar-right')
</section>
<section class="content" id="app">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>
@include('admin.partials.footer-script')
@yield('modal')
@yield('extra-script-footer')
</body>
</html>