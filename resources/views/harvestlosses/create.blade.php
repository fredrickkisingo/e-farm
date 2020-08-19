@extends ('layouts.app') 
@section ('content')
<div class="container">
    @if(Auth::user()->role_id==1)  <h1>New Blog Post</h1>

  {!! Form::open(['action'=> 'HarvestlossesController@store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
  <div class="form-row">
        <div class="form-group col-md-6">
        {{-- Starts with the label (first is the label name associated with the second parameter(displayed on the screen)) Then the
        text has the text name associated with what will be entered in the second parameter (empty because user must provide),
        then the third is the attribute of that text or textarea etc using bootstrap --}} 
        {{Form::label('title','Post Title')}} 
        {{Form::text('title', '', ['class'=>'form-control', 'placeholder'=>'Post Title'])}}
        </div>
       
  </div>
 <div class="form-group">
            {{Form::label('body','Post Description')}} 
            {{Form::textarea('body', '', [ 'id'=> 'article-ckeditor','class'=>'form-control','placeholder'=>'Post Description'])}}
        </div>
  {{Form::submit('Post', ['class'=>'btn btn-primary'])}} {!! Form::close() !!}
  @else
  <p>You cannot create a blog</p>
  @endif
</div>
@endsection

