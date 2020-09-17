@extends ('layouts.mapview') 
    @section ('content')
<div class="container">
        {{-- same as php echo $title --}} {{-- this is the main index page --}}
        <h1>Maps for Farms</h1>
        <p>
            Welcome to Maps for Available Farmers
        </p>
        {!! Form::open(['action'=> 'MapsController@store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('place_search','Search for Place')}} 
                {{Form::text('place_search', '', ['class'=>'form-control', 'placeholder'=>'e.g. Mombasa, Kenya'])}}
            </div>
        </div>
        {{Form::submit('Search', ['class'=>'btn btn-primary'])}} {!! Form::close() !!}
        {!!$map['html']!!}
    @endsection
 {{-- this basically means that the whole layout (html,etc) will be extended from the layouts.app file and the
    only changes to be made will be the content which will be dictated in the respective files such as the index, about and
    services. --}}
</div>