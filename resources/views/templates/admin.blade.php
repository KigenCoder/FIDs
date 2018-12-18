<!DOCTYPE html>
<html lang="en">
<head>
@include('templates.header')
</head>

<body>
<div class="container">
    <div class="masthead" style="text-align: right">
        <h3 class="text-muted" style="right: 5%;  ">Fids App Admin</h3>

    </div>
    <div id='cssmenu' >
        <ul>
                <li class='has-sub'><a href='#'><span>User Module</span></a>
                    <ul>
                        <li class='has-sub'><span>{!! Html::link('user','Users') !!}</span></li>
                        <li class='has-sub'><span>{!! Html::link('user/create','New Users') !!}</span></li>
                    </ul>
                </li>
              
            <li class='last'>{!! Html::link('logout','Logout') !!}</li>
        </ul>
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
