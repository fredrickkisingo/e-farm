@extends('layouts.app')
@section('content')
<h1>Information about post harvest losses mitigation</h1>
@if(count($blogs)>0) 
 @foreach($blogs as $blog)
 <div class="container">
     
<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{$blog->title}}</h5>
         <small>Posted On {{$blog->created_at}}</small>
        <p class="card-text"></p>
        <a href="/harvestlosses/{{$blog->id}}" class="btn btn-primary">Read more</a>
      </div>
    </div>
  </div>
 </div>
 @endforeach

 @else

 <p>No information found</p>
 @endif
 </div>
@endsection