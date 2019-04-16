<!DOCTYPE html>
<html lang="en">
<head>
    @include('templates.header')
</head>

<body>
<div class="container">
    <div class="masthead" style="text-align: right">
        <h3 class="text-muted" style="right: 5%;  ">FIDS ANALYSIS</h3>
    </div>
    <div id='cssmenu'>
        <ul>
            <li class='has-sub'><a href='#'><span>DATA ENTRY</span></a>
                <ul>
                    <li class='has-sub'><span>{!! Html::link('data-entry','Enter data') !!}</span></li>
                </ul>
            </li>
            <li class='has-sub'><a href='#'><span>DATA CLEANING</span></a>
                <ul>
                    <li class='has-sub'><span>{!! Html::link('data-cleaning','Clean Data') !!}</span></li>
                </ul>
            </li>
            <li class='has-sub'><a href='#'><span>MARKET ANALYSIS</span></a>
                <ul>
                    <li class='has-sub'><span>{!! Html::link('monthly-analysis','Monthly Analysis') !!}</span></li>
                </ul>
            </li>
            <li class='has-sub'><a href='#'><span>IMPORT DATA</span></a>
            </li>
            <li class='has-sub'><a href='#'><span>EXPORT DATA</span></a>
            </li>

            <li class='last'>{!! Html::link('logout','LOGOUT') !!}</li>
        </ul>
    </div>
</div>


<div class="tile is-parent is-vertical">
    <div class="container">
        @yield('content')
    </div>
    <div class="container">
        @include('templates.footer')
    </div>

</div>
</body>

</html>
