@extends('templates.enumerators')

@section('content')


    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        {{-- Display erros if any --}}
        @include('errors.list')
        <div class="well bs-component">
            {!! Form::open(['url' => 'data/fetch', 'class'=>"form-horizontal"]) !!}
            <fieldset>
                <h3>Filter market data</h3>
                <div class="form-group">
                    <label for="Year" class="col-lg-2 control-label">Year</label>
                    <div class="col-lg-10">
                        {!! Form::text('year_name', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-lg-2 control-label">Month</label>
                    <div class="col-lg-10">
                        <select name="month_id" class="form-control">
                            @foreach ($months as $month_id => $month)
                                <option value="{!! $month_id !!}">{{$month}}</option>
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
