@extends('templates.admin')

@section('content')
<div class="row col-md-offset-10">
  <a href="{{url("user/create")}}" class="btn btn-success">+</a>
</div>
<table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Names</th>
        <th scope="col">Email</th>
        <th scope="col">Markets</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)

      <tr>
      <th scope="row">{{$user->id}}</th>
      <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
      <td><a href="{{url("user/$user->id/markets")}}" class="btn btn-success">View</a></td>
        </tr>
          
      @endforeach
    </tbody>
  </table>
  
  

  @stop