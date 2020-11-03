@extends('templates.analyst_user')

@section('content')

    <div class="container">
        <div class="row ">
            <div class="col-9 d-flex justify-content-center text-center">
                <h1>ANALYST REGISTRATION</h1>
            </div>

        </div>
        <div class="row">
            <div class="col-10">
                {{-- Display erros if any --}}
                @include('errors.list')
            </div>
        </div>
        <div class="row">
            {!! Form::open(['url' => 'analyst', 'class'=>"container"]) !!}


            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Names</label>
                <div class="col-lg-10">
                    {!! Form::text('name', null, ['class'=>'form-control input-sm']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    {!! Form::text('email', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-10">
                    {!! Form::password('password', ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="col-lg-2 control-label">Confirm Password</label>
                <div class="col-lg-10">
                    {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>

            {!! Form::close() !!}

        </div>


    </div>

    </div>
@stop
