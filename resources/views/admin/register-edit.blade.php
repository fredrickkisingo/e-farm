@extends('layouts.adlayouts')

@section('title')

Edit Registered | MkulimaBora Admin
    
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Role for Registered user</h3>
            </div>
            <div class="card-body">
                   <div class="row">
                       <div class="col-md-6">
                       <form action="/role-register-update/{{ $users->id }}" method="POST"> 
                            {{csrf_field() }}
                            {{method_field('PUT') }}
                            <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{$users->name}}" name="username" aria-describedby="username">
                          </div>
                          <div class="form-group">
                            <label>Give Role</label>
                            <select name="role_id"class="form-control">
                            <option value="1">Admin</option>
                            <option value="4">Buyer</option>
                            <option value="3">Farmer</option>
                            </select>
                          </div>
                          <button type="submit" class="btn btn-success">Update</button>
                          <a href="/role-register"><button type="submit" class="btn btn-danger">Cancel</a></button>

                        </form>
                       </div>
                   </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    
@endsection