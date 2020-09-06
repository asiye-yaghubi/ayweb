<!DOCTYPE html>
<html>
<head>
@include('admin.partials.head')
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
<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>
@include('admin.partials.footer-script')

</body>
</html>