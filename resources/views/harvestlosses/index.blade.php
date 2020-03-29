@extends('layouts.app')
@section('content')
<h1>Information about post harvest losses mitigation</h1>
 @if(count($blogs)>0) 
 @foreach($posts as $post)
 <div class="well">
     <h3>{{$blog->title}}</h3>
     <small>Posted On {{$blog->created_at}}</small>
 </div>
 @endforeach

 @else

 <p>No information found</p>
 @endif

  @endsection