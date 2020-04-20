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
      @php
            $weekOnePrice = "";
            $weekTwoPrice = "";
            $weekThreePrice = "";
            $weekFourPrice = "";
            $weekFivePrice = "";
        @endphp
      @foreach($data as $week => $price)
              @php
                  switch($week){
                      case 1:
                          $weekOnePrice = $price;
                      break;
                      case 2:
                          $weekTwoPrice = $price;
                      break;
                      case 3:
                          $weekThreePrice = $price;
                      break;
                      case 4:
                          $weekFourPrice = $price;
                      break;
                      case 5:
                          $weekFivePrice = $price;
                      break;     
                  }      
              @endphp
      @endforeach

      <td>{{$weekOnePrice}}</td>
      <td>{{$weekTwoPrice}}</td>
      <td>{{$weekThreePrice}}</td>
      <td>{{$weekFourPrice}}</td>
      <td>{{$weekFivePrice}}</td>
      </tr>    
      @endforeach
    </tbody>
  </table>
  
  

  @stop