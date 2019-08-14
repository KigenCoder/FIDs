@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="tile is-parent is-fullwidth">
            <!--Dataset and Indicators -->
            <div class="tile is-child is-vertical box">
                <div class="tile is-child is-vertical">
                    <div class="tile is-child">
                        <market_type></market_type>
                    </div>
                    <!-- Indicators -->
                    <div class="tile is-child">
                        <indicators></indicators>
                    </div>
                </div>
            </div>

            <!-- Zones, Regions -->
            <div class="tile is-child is-vertical box">
                <div class="tile is-child is-vertical">
                    <div class="tile is-child">
                        <zones></zones>
                    </div>
                    <!-- Region -->
                    <div class="tile is-child">
                        <regions></regions>
                    </div>

                    <!-- Markets -->
                    <div class="tile is-child">
                        <div class="box-scroll">
                            <markets></markets>
                        </div>
                    </div>
                </div>
            </div>


            <div class="tile is-child box">
                <div class="tile is-child">
                    <time_period></time_period>
                </div>
            </div>
            <div class="tile is-child box">
                <div>
                    <series></series>
                </div>
            </div>
            <div class="tile is-child">
                <div class="scroll-y">
                    <average></average>
                </div>
            </div>
        </div>


        <div class="tile is-parent">
            <market_data></market_data>
            <modal></modal>
        </div>


    </div>






@stop
