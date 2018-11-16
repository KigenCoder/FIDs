@extends('templates.app')

@section('content')


    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        {{-- Display erros if any --}}
        @include('errors.list')
        <div class="well bs-component">
            {!! Form::open(['url' => 'user', 'class'=>"form-horizontal"]) !!}
            <fieldset>
                <h3>New User</h3>
                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">Name</label>
                    <div class="col-lg-10">
                        {!! Form::text('name', null, ['class'=>'form-control']) !!}
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
                    <label for="email" class="col-lg-2 control-label">User Role</label>
                    <div class="col-lg-10">
                        <select name="user_role_id" class="form-control">
                            @foreach ($user_roles as $user_role)
                                 <option value="{!! $user_role->id !!}">{{$user_role->user_role}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-lg-2 control-label">Markets</label>
                    <div class="col-lg-10">
                        <select name="market_id" class="form-control">
                            <option value="0">ASSIGN MARKET<option
                            @foreach ($markets as $market)
                                <option value="{!! $market->id !!}">{{$market->market_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </div>
            </fieldset>
            </form>
        </div>
    </div>
    <div class="col-lg-2"></div>
    {!! Form::close() !!}
@stop
