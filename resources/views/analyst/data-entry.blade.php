@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="tile is-ancestor is-vertical">
            <!--Dataset and Indicators -->
            <div class="tile is-parent container box top-padding">

                <div class="columns is-fullwidth ">
                    <div class="column">
                        <entry_market_type></entry_market_type>
                    </div>
                    <div class="column">
                        <data_entry_markets></data_entry_markets>
                    </div>
                    <div class="column">
                        <entry_month_years></entry_month_years>
                    </div>
                </div>
            </div>


            <div class="tile is-parent">
                <!-- Market data -->
                <div class="tile is-child">
                    <data_entry_table></data_entry_table>
                </div>

            </div>
        </div>
    </div>
@stop
