@extends('layouts.adlayouts')

@section('title')

Dashboard |E-Farm Admin
    
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Welcome to E-FARM Admin Panel</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>
                  Name
                </th>
                <th>
                  Country
                </th>
                <th>
                  City
                </th>
                <th class="text-right">
                 Role
                </th>
            </thead>
              <tbody>
                <tr>
                  <td>
                    Fredrick Kisingo
                  </td>
                  <td>
                   Kenya
                  </td>
                  <td>
                    Mombasa
                  </td>
                  <td class="text-right">
                   Administrator
                  </td>
                </tr>       
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   
</div>
    
@endsection

@section('scripts')
    
@endsection