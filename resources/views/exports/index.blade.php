@extends('templates.analyst')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-2"></div>
            <div class="column is-8">
                {{-- Display erros if any --}}
                @include('errors.list')
                {!! Form::open(['url' => 'export', 'class'=>"box"]) !!}
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">From</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                            <div class="select is-fullwidth">
                                <select name="startMonth">
                                    <option value="" disabled selected>select month</option>
                                    @for($i=0; $i<count($months); $i++)
                                        <option value="{{$i+1}}">{{$months[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                            </p>
                            <p><span class="is-size-7 is-italic">*Required</span></p>
                        </div>
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                            <div class="select is-fullwidth">
                                <select name="startYear">
                                    <option value="" disabled selected>select year</option>
                                    @foreach($years as $year)
                                        <option value="{{$year->year_name}}">{{$year->year_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </p>
                            <p><span class="is-size-7 is-italic">*Required</span></p>
                        </div>
                    </div>
                </div>


                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">To</label>
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <p class="control is-expanded has-icons-left">
                            <div class="select is-fullwidth">
                                <select name="endMonth">
                                    <option value="" disabled selected>month</option>
                                    @for($i=0; $i<count($months); $i++)
                                        <option value="{{$i+1}}">{{$months[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                            </p>
                            <p><span class="is-size-7 is-italic">*Optional</span></p>
                        </div>

                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">

                            <div class="select is-fullwidth">
                                <select name="endYear">
                                    <option value="" disabled selected>year</option>
                                    @foreach($years as $year)
                                        <option value="{{$year->year_name}}">{{$year->year_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            </p>
                            <p><span class="is-size-7 is-italic">*Optional</span></p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Market Type</label>
                    </div>

                    <div class="field-body">
                        <div class="field is-widescreen">
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="marketType">
                                        <option value="" disabled selected>Select Type</option>
                                        @foreach($market_types as $market_type)
                                            <option value="{{$market_type->id}}">{{$market_type->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <p><span class="is-size-7 is-italic">*Optional</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label">
                        <!-- Left empty for spacing -->
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary">
                                    EXPORT DATA
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
            <div class="column is-2"></div>


        </div>


    </div>
@stop
