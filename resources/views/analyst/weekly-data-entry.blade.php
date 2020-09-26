@extends('templates.enumerators')

@section('content')
    <div id="app">
            <div class="tile is-ancestor is-vertical">
                <!--Dataset and Indicators -->
                <div class="tile is-parent container box top-padding">

                    <div class="columns is-full ">
                        <div class="column">
                            <weekly_market_type></weekly_market_type>
                        </div>

                        <div class="column">
                            <weekly_entry_markets></weekly_entry_markets>
                        </div>
                        <div class="column">
                            <time_periods></time_periods>
                        </div>

                        <div class="column">
                           <save_weekly_data></save_weekly_data>
                        </div>

                    </div>
                </div>


                <div class="tile is-parent">
                    <!-- Market data -->
                    <div class="tile is-child">
                        <weekly_entry_table></weekly_entry_table>
                    </div>

                </div>
            </div>

    </div>
@stop
