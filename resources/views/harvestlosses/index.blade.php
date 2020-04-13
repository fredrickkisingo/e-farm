@extends('layouts.app')
@section('content')
<h1>Information about post harvest losses mitigation</h1>
@if(count($blogs)>0) 
 @foreach($blogs as $blog)
 <div class="container">
     
<div class="card text-center">
    <div class="card-header">
    </div>
      <div class="card-body">
        <h5 class="card-title">{{$blog->title}}</h5>
       <p class="card-text"></p> 
        <a href="/harvestlosses/{{$blog->id}}" class="btn btn-primary">Read more</a>
      </div>
      <div class="card-footer text-muted">
        Posted On {{$blog->created_at}}
      </div>

    </div>
  </div>
 @endforeach

 @else

 <p>No information found</p>
 @endif
 </div>
@endsection