<!DOCTYPE html>
<html lang="en">
<head>
    @include('templates.header')
</head>

<body>
<div class="container top-padding">
    <nav class="level box">
        <!-- Left side -->
        <div class="level-left">
            <div class="level-item">
                <img src="../../images/fsnau_logo.png" alt="FSNAU">
            </div>
        </div>

        <div class="level-item">
            <p class="title is-6">FIDS ANALYSIS</p>
        </div>
        <!-- Right side -->
        <div class="level-right">
            <img src="../../images/fao_logo.png" alt="FAO">
        </div>
    </nav>


</div>


<div class="column container is-full">
    <div class="box container">
        @yield('content')
    </div>
    <div class="container">
        @include('templates.footer')
    </div>
</div>
</body>

</html>
