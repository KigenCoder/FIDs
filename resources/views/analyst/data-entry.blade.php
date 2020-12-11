@extends('templates.analyst')

@section('content')
    <div id="app">
        <div class="row">
            <div class="col-12 d-flex justify-content-center text-center">
                <h1>MONTHLY DATA ENTRY</h1>
            </div>

        </div>
        <div class="row">
            <div class="tile is-ancestor is-vertical">
                <!--Dataset and Indicators -->
                <div class="tile is-parent container box top-padding">

                    <div class="columns is-full ">
                        <div class="column">
                            <entry_market_type></entry_market_type>
                        </div>
                        <div class="column">
                            <data_entry_markets></data_entry_markets>
                        </div>
                        <div class="column">
                            <entry_month_years></entry_month_years>
                        </div>
                        <div class="column">
                            <save_monthly_data></save_monthly_data>
                        </div>
                    </div>
                </div>

                <!-- Market data Entry -->
                <div class="tile is-parent">

                    <div class="tile is-child">
                        <data_entry_table></data_entry_table>
                    </div>
                </div>
                <! -- SLIMS Data Entry -- >
                <div class="tile is-parent">
                    <div class="tile is-child">
                        <slims_entry_table></slims_entry_table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
