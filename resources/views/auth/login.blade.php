@extends('templates.auth')

@section('content')
    <div class="columns is-centered">
        <div class="column is-9-tablet is-8-desktop is-7-widescreen">
            <h1 class="title">FIDS LOGIN</h1>
            {!! Form::open(['url' => 'login', 'class'=>"box"]) !!}
            <div class="field">
                <label for="" class="label">Email</label>
                <div class="control has-icons-left">
                    {!! Form::text('email', null, ['class'=>'input', 'placeholder'=>'you@email.com']) !!}
                    <span class="icon is-small is-left">
                    <i class="fa fa-envelope"></i>
                </span>
                </div>
            </div>

            <div class="field">
                <label for="" class="label">Password</label>
                <div class="control has-icons-left">
                    {!! Form::password('password', ['class'=>'input', 'placeholder'=>'********']) !!}
                    <span class="icon is-small is-left">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
            </div>
            <div class="field">
                <label for="" class="checkbox">
                    <input type="checkbox">
                    Remember me
                </label>
            </div>
            <div class="field">
                <button class="button is-info">
                    Login
                </button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

@stop
