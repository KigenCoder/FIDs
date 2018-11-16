@extends('templates.app')

@section('content')
<div class="row col-md-offset-10">
  <a href="#" class="btn btn-success">+</a>
</div>
<table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Names</th>
        <th scope="col">Remove</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($user_markets as $market)

      <tr>
      <th scope="row">{{$market->id}}</th>
      <td>{{$market->market_name}}</td>
      <td><a href="#" class="btn btn-success">X</a></td>
        </tr>
          
      @endforeach
    </tbody>
  </table>
  
  

  @stop