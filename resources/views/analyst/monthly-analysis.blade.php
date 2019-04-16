@extends('templates.analyst')

@section('content')
    <div id="app">
            <div class="tile is-parent box is-vertical">
                <div class="tile is-child box">
                    <div class="container">
                        <zones></zones>
                    </div>

                </div>
                <div class="tile is-parent box">
                    <div class="container">
                        <article></article>
                        <h1>{{"Data content area"}}</h1>
                    </div>
                </div>
            </div>
    </div>

@stop

