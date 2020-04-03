@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/harvestlosses" class="btn btn-dark">Go Back</a>
      <h1>{{$blog->title}}</h1>
      <div class="card"> 
        <div class="row">
           <aside class="col-sm-7">
            <article class="card-body p-5">
              <dl class="item-property">
                <dt>Product Description</dt>
                <dd>
                  {!!$blog->body!!}
                </dd>
              </dl>
              <dl class="param param-feature">
                <dt>Posted On</dt>
                <dd>{{$blog->created_at}}</dd>
              </dl>
              
              <hr>
              </div>
    
              <!--if user has logged in -->
              @if(!Auth::guest()) 
    
                @if(Auth::user()->id == $blog->user_id)
                  <a href="/harvestlosses/{{$blog->id}}/edit" class="btn btn-warning">Edit</a> 
                  {!!Form::open(['action'=>['HarvestlossesController@destroy', $blog->id], 'method'=>'POST','class'=>'float-right'])!!} 
                  {{Form::hidden('_method', 'DELETE')}} 
                  {{Form::submit('Delete', ['class'=>'btn btn-danger'])}} 
                  {!!Form::close()!!} 
                  
                @endif 
    
             <!-- Adds the buy and call buttons user is guest/not logged in -->
              @else
                <a href="/login" class="btn text-uppercase btn-info">Login to Start Reading about post harvest losses mitigation</a>
              @endif 
            </article>
            <!-- card-body.// -->
          </aside>    
      </div>
@endsection