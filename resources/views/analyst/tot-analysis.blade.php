@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="tile is-ancestor is-vertical is-fullwidth">
            <div class="tile is-parent">
                <!--Dataset and Indicators -->
                <div class="tile is-child is-vertical box">
                    <div class="tile is-child is-vertical">
                        <div class="tile is-child">
                            <market_type></market_type>
                        </div>
                        <!-- First Indicator -->
                        <div class="tile is-child">
                            <first_indicator></first_indicator>
                        </div>

                        <!-- Second Indicator -->
                        <div class="tile is-child">
                            <div class="box-scroll">
                                <second_indicator></second_indicator>
                            </div>
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
                                <tot_markets></tot_markets>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tile is-child box">
                    <div class="tile is-child">
                        <tot_time_period></tot_time_period>
                    </div>
                </div>
                <div class="tile is-child box">
                    <div>
                        <tot_time_series></tot_time_series>
                    </div>
                </div>
                <div class="tile is-child">
                    <div class="scroll-y">
                        <average></average>
                    </div>
                </div>

            </div>


            <div class="column is-full">
                <!-- ToT Data -->
                <div class="tile is-parent">
                    <tot_data></tot_data>
                </div>
                <!-- ToT Chart -->
                <div class="tile is-parent">
                    <tot_series_chart></tot_series_chart>
                </div>
            </div>
        </div>
    </div>
@stop
