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
                        @if(count($purchases)>0)
                        <div class="row">
                            <h3>Here are Your Past Purchases</h3>
                            <div class="col-sm-12 col-md-10 col-md-offset-1">
                                <table class="table table-hover">
                                    <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Total</th>
                                                    <th></th>
                                                </tr>
                                     </thead>        
                                        <tbody>
                                             
                                                @foreach ($purchases as $purchase) {{-- Displays titles on the post table --}}
                                                        <tr>
                                                            <td class="col-sm-8 col-md-6">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <h4 class="media-heading">{{$purchase->product_name}}</h4>
                                                                        <span>Purchase Date: </span><span class="text-success"><strong>{{$purchase->updated_at}}</strong></td>
                                                                    </div>
                                                                </div>
                                                                </td>
                                                                <td class="col-sm-1 col-md-1 text-center"><strong>{{$purchase->qty}}</strong></td>
                                                                <td class="col-sm-1 col-md-1 text-center"><strong>KSH {{$purchase->price}}</strong></td>
                                                                <td class="col-sm-1 col-md-1 text-center"><strong>KSH {{$purchase->price*$purchase->qty}}</strong></td>
                                                                <td class="col-sm-1 col-md-1">
                                                                  {!!Form::open(['action'=>['PurchasesController@destroy',$purchase->product_id],'method'=>'POST'])!!}{{Form::hidden('_method','DELETE')}}
                                                                    {{Form::submit('Remove', ['class'=>'btn btn-danger'])}} {!!Form::close()!!}
                                                                </td>
                                                        </tr>
                                                @endforeach
                                                @else
                                                    <p>No Purchase history</p>
                                             @endif

                                        </tbody>
                                </table>

                             </div>  
                            </div>
                          @endif
                   
            </div>
        </div>
    </div>
</div>
@endsection
