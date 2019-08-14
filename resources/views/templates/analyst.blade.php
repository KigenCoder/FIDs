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
                    <li class='has-sub'><span>{!! Html::link('tot','ToT') !!}</span></li>
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
