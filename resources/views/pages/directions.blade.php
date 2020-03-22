@extends ('layouts.mapview') 
@section ('content')
<div class="container">
    {{-- same as php echo $title --}} {{-- this is the main index page --}}
    <h1>Directions</h1>
    <p>
        Let's Take You There
    </p>
    {!! Form::open(['action'=> 'DirectionsController@store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('start_location','Start Location')}} {{Form::text('start_location', '', ['class'=>'form-control', 'placeholder'=>'e.g. Mombasa, Kenya'])}}
        </div>
        
        <div class="form-group col-md-6">
            {{Form::label('end_location','End Location')}} {{Form::text('end_location', '', ['class'=>'form-control', 'placeholder'=>'e.g. Nairobi, Kenya'])}}
        </div>
    </div>
    {{Form::submit('Direct Me', ['class'=>'btn btn-primary'])}} {!! Form::close() !!}
    {!!$map['html']!!}
    
    {{-- this is going to populate when you have the results --}}
    <div id="directionsDiv"></div>
@endsection
 {{-- this basically means that the whole layout (html,etc) will be extended from the layouts.app
    file and the only changes to be made will be the content which will be dictated in the respective files such as the index,
    about and services. --}}
</div>