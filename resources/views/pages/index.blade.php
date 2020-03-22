@extends('layouts.app')

@section('content')
@include('inc.slider');
<div class="jumbotron text-center">
  
  {{--this is the main index page--}}
<p>
  EFarm: Your trusted farm products solution
</p>

 </div>
  @endsection   

{{--this means that the  whole layout(html)will be extended from the layouts.app file and the only changes to be made will be dictated in the respective files of such as index,about and services--}}

