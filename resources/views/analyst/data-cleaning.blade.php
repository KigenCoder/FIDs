@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="row">
            <div class="col-12 d-flex justify-content-center text-center">
                <h1>DATA CLEANING</h1>
            </div>

        </div>
        <div class="row">
            <div class="tile is-ancestor is-vertical">
                <!--Dataset and Indicators -->
                <div class="tile is-parent container box top-padding">

                    <div class="columns is-fullwidth ">
                        <div class="column">
                            <market_types></market_types>
                        </div>
                        <div class="column">
                            <cleaning_markets></cleaning_markets>
                        </div>
                        <div class="column">
                            <month_years></month_years>
                        </div>
                        <div class="column">
                            <btn_update_data></btn_update_data>
                        </div>
                    </div>
                </div>


                <div class="tile is-parent">
                    <!-- Market data -->
                    <div class="tile is-child">
                        <data_cleaning_table></data_cleaning_table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
