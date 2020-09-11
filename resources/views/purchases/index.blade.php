@extends('layouts.app')
@section('content')
    <div class="app-title">
        <div>
        <h1><i class="fa fa-th-list"></i> Payments Status</h1>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover " id="usersTable">        
                        @if(count($stk_push_payments)>0)  @foreach ($stk_push_payments as $stk_push_payment)  
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <td>Paid Amount</td>
                                    <th>Result Description</th>
                                    <th>Mpesa Receipt Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                                 <tbody>
                                    <tr>
                                    <td>{{$stk_push_payment->id}}</td>
                                    <td>{{$stk_push_payment->amount}}   
                                    <td>{{$stk_push_payment->ResultDesc}}</td>
                                    <td>{{$stk_push_payment->MpesaReceiptNumber}}</td>
                                    <td>{{$stk_push_payment->status}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                </div>
            </div>
          </div>
        </div>  
        @else
        <p>
            You Haven't Purchased Anything
        </p>
        @endif
@endsection
