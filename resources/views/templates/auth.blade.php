<!DOCTYPE html>
<html lang="en">
<head>
    @include('templates.header')
</head>

<body>
<section class="hero has-background-grey-lighter is-fullheight">
    <div class="hero-body ">
        <div class="tile  is-parent is-vertical container">
            <div class="tile is-child">
                @yield('content')
            </div>
        </div>
    </div>
</section>
<div class="container">

    @include('templates.footer')

</div>

</body>

</html>

