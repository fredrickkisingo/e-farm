@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- if the user is a farmer,display farmers products --}}
                    @if(Auth::user()->role_id==3)
                        <a href="/posts/create" class="btn btn-primary">Add Product</a>
                        <h3>Your Products you Uploaded</h3>
                        @if(count($posts)> 0)
                                <table class="table table-stripped">
                                <tr>
                                    <th>Title</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{$post->title}}</td>
                                            <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                                        <td>
                                            {!!Form::open(['action'=> ['PostsController@destroy',$post->id],'method'=>'POST','class'=> 'float-right'])!!}
                                                {{Form::hidden('_method','DELETE')}}
                                                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                                            {!!Form::close()!!}
                                        </td>
                                        </tr>
                                    @endforeach
                                </table>
                                @else
                                    <p>You have no products</p>
                                @endif
                    @else
                        <p>View the products catalogue by clicking the button below!</p>
                        <a href="/posts" class="btn btn-primary">Products</a>
                    @endif
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
