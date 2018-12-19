@extends('templates.enumerators')

@section('content')
<div class="row col-md-offset-0">
<h2>{{$marketInfo->market_name }}</h2>
</div>
<table class="table table-bordered">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Indicator</th>
        <th scope="col">Week 1</th>
        <th scope="col">Week 2</th>
        <th scope="col">Week 3</th>
        <th scope="col">Week 4</th>
        <th scope="col">Week 5</th>
      </tr>
    </thead>
    <tbody>
      @foreach($priceData as $indicator => $data)
      <tr>
      <td>{{$indicator}}</td>
      @foreach($data as $week => $price)
            <td>{{$price}}</td>
      @endforeach
      </tr>    
      @endforeach
    </tbody>
  </table>
  
  

  @stop