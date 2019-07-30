@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="tile is-ancestor is-vertical">
            <!--Dataset and Indicators -->
            <div class="tile is-parent is-fullwidth">
                <!-- Market Type -->
                <div class="tile is-child">
                    <div class="field is-horizontal">
                        <div class="field-label is-small">
                            <label class="label">DATASET</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <market_type></market_type>
                            </div>
                        </div>

                        <!-- First commodity -->
                        <div class="field-label is-small">
                            <label class="label">First</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <first_indicator></first_indicator>
                            </div>
                        </div>

                        <!-- Second commodity -->
                        <div class="field-label is-small">
                            <label class="label">Second</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <second_indicator></second_indicator>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tile is-parent is-fullwidth">

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


            <div class="tile is-parent">
                <!-- ToT Data -->
                <div class="tile is-child box">
                    <tot_data></tot_data>
                </div>
                <!-- ToT Chart -->
                <div class="tile is-parent box">
                    <tot_series_chart></tot_series_chart>
                </div>
            </div>
        </div>
    </div>
@stop
