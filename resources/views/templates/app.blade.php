<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FIDS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link href="{{asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('bootstrap/assets/css/custom.min.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
    <script src="../bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
    <!-- Menu -->
    <link href="{{asset('menu/styles.css') }}" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src=".."></script>
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

    <!-- Site footer -->
    <footer class="footer">
        <p>&copy; fao.org</p>
    </footer>
</div>
<!-- /container -->

<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
{!! Html::script('bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('javascript/script.js') !!}


</body>

</html>
