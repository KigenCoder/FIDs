@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="tile is-ancestor top-padding">
            <div class="tile is-3 is-vertical is-parent filters-panel">
                <div class="tile box is-parent is-vertical">
                    <span class="title tag is-success is-medium">LOCATION</span>
                    <div class="scroll-y">
                        <!-- Zone -->
                        <div class="tile is-parent  field">
                            <div class="tile is-child">
                                <zones></zones>
                            </div>
                        </div>

                        <!-- Regions -->
                        <div class="tile is-parent field">
                            <div class="tile is-child">
                                <regions></regions>
                            </div>
                        </div>

                        <!-- Markets -->
                        <div class="tile is-parent field">
                            <div class="tile is-child">
                                <markets></markets>
                            </div>
                        </div>

                        <!-- Indicators -->
                        <div class="tile is-parent is-vertical field">
                            <div class="tile is-child">
                                <indicators></indicators>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time period -->
                <div class="tile is-parent box is-vertical side-margin">
                    <span class="title tag is-success is-medium">PERIOD</span>
                    <div>
                        <time_period></time_period>
                    </div>
                </div>

                <!-- SELECT SERIES -->
                <div class="tile is-parent box is-vertical">
                    <div class="tile is-child">
                        <series></series>
                    </div>
                </div>

                <!-- CALCULATE AVERAGE -->
                <div class="tile is-parent box is-vertical">
                    <span class="title tag is-success is-medium">AVERAGE</span>
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
    </div>





@stop
