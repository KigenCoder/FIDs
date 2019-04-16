<!DOCTYPE html>
<html lang="en">
<head>
@include('templates.header')
</head>

<body>
<div class="tile is-parent is-vertical">
    <div class="bs-docs-section container">
        @yield('content')
    </div>
    <div class="container">
        @include('templates.footer')
    </div>

</div>

</body>

</html>
