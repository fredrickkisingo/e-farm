@extends ('layouts.app') 
@section ('content')
<div class="container">
    <h1>Items In Cart</h1>
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                
                <tbody>
                    @if(count($carts)>0) 
                    @foreach ($carts as $cart)

                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                            <th> </th>
                        </tr>
                    </thead>
                    {{-- Displays the cart items --}}
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                             <img class="media-object" src="/storage/cover_images/{{$cart->cover_image}}" style="width: 72px; height: 72px; margin:5px;">
                                <div class="media-body">
                                    <h4 class="media-heading">{{$cart->product_name}}</h4>
                                    <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>{{$cart->qty}}</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>KSH {{$cart->price}}</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>KSH {{$cart->price * $cart->qty}}</strong></td>
                        <td class="col-sm-1 col-md-1">
                            {!!Form::open(['action'=>['CartsController@destroy', $cart->id], 'method'=>'POST'])!!} 
                            {{Form::hidden('_method','DELETE')}} 
                            {{Form::submit('Remove', ['class'=>'btn btn-danger'])}} 
                            {!!Form::close()!!}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                            <h3>Total</h3>
                        </td>
                        <td class="text-right">
                            <h3><strong> KSH {{$carts->pluck('total_price')->sum()}}</strong></h3>
                        </td>
                    </tr>
                        <tr>
                            
                            
                            <td><a class="btn btn-primary" href="/posts"><i class='fas fa-shopping-cart'></i> Continue Shopping</a>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td> </td>
                        </tr>
                        <td>
                     {!! Form::open(['action'=> 'PurchasesController@store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    {{Form::label('phone_number','My Phone Number(254..)')}} {{Form::text('phone_number', '', ['class'=>'form-control ', 'placeholder'=>'Phone Number','maxlength'=>'13'])}}
                                </div>
                            </div>
                    
                                 {{Form::button('Confirm Order', ['type' => 'submit','class'=>'btn btn-primary btn-lg btn-block'])}} 
                                
                     {!! Form::close() !!}
                        </td> 
                    @else
                    <p>
                        No Items In Your Cart
                    </p>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    @endsection
</div>