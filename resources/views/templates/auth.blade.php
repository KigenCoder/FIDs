<!DOCTYPE html>
<html lang="en">
<head>
@include('templates.header')
</head>

<body>
<div class="container">
    <div class="masthead" style="text-align: right">
        <h3 class="text-muted" style="right: 5%;  ">Fids</h3>
    </div>
    <div class="row">
        <div class="bs-docs-section">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>

<div>
@include('templates.footer')
</body>

</html>
