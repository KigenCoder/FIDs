@extends('templates.enumerators')

@section('content')
<div class="row col-md-offset-0">
<h2>{{$marketInfo->market_name }}</h2>
</div>
<table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Indicator</th>
        <th scope="col">Year</th>
        <th scope="col">Month</th>
        <th scope="col">Week</th>
        <th scope="col">Price</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($marketData as $data)

      <tr>
      <th scope="row">{{$data->id}}</th>
      <td>{{$data->indicator_business_name}}</td>
      <td>{{$data->year_name}}</td>
      <td>{{$data->month_id}}</td>
      <td>{{$data->week}}</td>
      <td>{{$data->price}}</td>
      </tr>
          
      @endforeach
    </tbody>
  </table>
  
  

  @stop