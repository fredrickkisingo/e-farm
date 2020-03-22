@extends('layouts.app')

@section('content')
  <h1> Edit Product</h1 >
    {!! Form::open(['action'=>['PostsController@update',$post->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
      <div class="form-group">
        {{Form::label('title','Product Name')}}
        {{Form::text('title',$post->title,['class'=>'form-control','placeholder'=>'Product Name'])}}
      </div>
      <div class="form-group col-md-6">
        {{Form::label('price','Price (KSH)')}} 
        {{Form::text('price', $post->products_price, ['class'=>'form-control ', 'placeholder'=>'Price (KSH)'])}}
      </div>
      <div class="form-group">
        {{Form::label('body','Product Description')}} {{Form::textarea('body', $post->body, ['id'=> 'article-ckeditor',
        'class'=>'form-control', 'placeholder'=>'Product Description'])}}
      </div>
        <div class="form-group col-md-6">
          {{Form::label('phone_number','My Phone Number')}} 
          {{Form::text('phone_number', $post->phone_number, ['class'=>'form-control ', 'placeholder'=>'Phone Number'])}}
        </div>
        <div class="form-group">
          {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}

@endsection
