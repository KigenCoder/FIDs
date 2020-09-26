@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="tile is-ancestor is-vertical">
            <!--Dataset and Indicators -->
            <div class="tile is-parent container box top-padding">

                <div class="columns is-fullwidth ">
                    <div class="column">
                        <weekly_market_types></weekly_market_types>
                    </div>
                    <div class="column">
                        <weekly_markets></weekly_markets>
                    </div>
                    <div class="column">
                        <weekly_month_years></weekly_month_years>
                    </div>
                </div>
            </div>


            <div class="tile is-parent">
                <!-- Market data -->
                <div class="tile is-child">
                    <weekly_data_table></weekly_data_table>
                </div>

            </div>
        </div>
    </div>
@endsection
