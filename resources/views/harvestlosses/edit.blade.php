@extends('layouts.app')
@section('content')
  <h1> Edit Blog</h1 >
    {!! Form::open(['action'=>['HarvestlossesController@update',$blog->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title','Blog Title')}}
        {{Form::textarea('title',$blog->title,['class'=>'form-control','placeholder'=>'Blog Title'])}}
      </div>
      <div class="form-group">
        {{Form::label('body','Blog Information')}}
         {{Form::textarea('body', $blog->body, [ 'id'=> 'article-ckeditor','class'=>'form-control', 'placeholder'=>'Blog Description'])}}
      </div>
      {{Form::hidden('_method','PUT')}}
      {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
      {!! Form::close() !!}
@endsection