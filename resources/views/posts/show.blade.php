@extends('layouts.app')

@section('content')
<div class="container">
<a href="/posts" class="btn btn-dark">Go Back</a>
  <h1>{{$post->title}}</h1>

  <div class="card"> 
    <div class="row">
      <aside class="col-sm-5">
       <img class="img-fluid" style="max-width:100%; max-height:100%;" src="/storage/cover_images/{{$post->cover_image}}" >
          <!-- gallery-wrap .end// -->
       </aside>
       <aside class="col-sm-7">
        <article class="card-body p-5">
          <h3 class="title mb-3"><strong>{{$post->product_name}}</strong></h3>
          <p class="price-detail-wrap">
            <span class="price h3 text-info"> 
		        <span class="currency">KSH </span><span class="num">{!!$post->products_price!!}</span>
            </span>
            <span>/per kg</span>
          </p>
                                            
          <!-- price-detail-wrap .// -->
          <dl class="item-property">
            <dt>Product Description</dt>
            <dd>
              {!!$post->body!!}
            </dd>
          </dl>
          <!--farmer phone number-->
          <dl class="param param-feature">
            <dt>Phone Number</dt>
            <dd>+254{!!$post->phone_number!!}</dd>
          </dl>
          <!-- item-property-hor .// -->
          <dl class="param param-feature">
          <!-- item-property-hor .// -->
          <dl class="param param-feature">
            <dt>Posted On</dt>
            <dd>{{$post->created_at}}</dd>
          </dl>
          
          <hr>
          <div class="row">
            <div class="col-sm-5">
              <dl class="param param-inline">
                <dt>Quantity</dt>
              </dl>
              <!-- item-property .// -->
            </div>
          </div>

          <!--if user has logged in -->
          @if(!Auth::guest()) 

            @if(Auth::user()->id == $post->user_id)
              <a href="/posts/{{$post->id}}/edit" class="btn btn-warning">Edit</a> 
              

           <!-- Adds the buy  button if the product doesn't belong to current user -->
            @else
              {!!Form::open(['action'=>['CartsController@update', $post->id], 'method'=>'POST','class'=>'float-left'])!!} 
              {{Form::hidden('_method','PUT')}}
              {{Form::button('Purchase product <i class="fas fa-shopping-cart"></i>', ['type' => 'submit','class'=>'btn btn-lg btn-outline-primary text-uppercase', 'style'=>'margin:5px'])}} 
              {!!Form::close()!!}
              
            @endif 

         <!-- Adds the buy and call buttons user is guest/not logged in -->
          @else
            <a href="/login" class="btn text-uppercase btn-info">Login to Start Purchasing</a>
          @endif 
        </article>
        <!-- card-body.// -->
      </aside>    
   </div>
  </div>
@endsection
