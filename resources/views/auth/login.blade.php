@extends('templates.app')

@section('content')


    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        {{-- Display erros if any --}}
        @include('errors.list')
        <div class="well bs-component">
            {!! Form::open(['url' => 'login', 'class'=>"form-horizontal"]) !!}
            <fieldset>
                <h3>Login</h3>
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
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </fieldset>
            </form>
        </div>
    </div>
    <div class="col-lg-2"></div>
    {!! Form::close() !!}
@stop
