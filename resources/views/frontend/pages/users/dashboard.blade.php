@extends('frontend.layouts.app')

@section('content')

<div class="main-content">

  <div class="login-area page-area">
    <div class="container">
      <div class="row">
          <div class="col-md-8 p-1">
            <div class="profile-tab border p-2">
              <h3 class="float-left btn btn-success">
                {{$users->name}}s Dashboard
                
              </h3>
              <div class="float-right">
                <a href="#profileEditModal" data-toggle="modal" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
              </div>
              <div class="clearfix"></div>
              
              <div>
                <p>   
                   Hello {{$users->name}}
                </p>
                <p>This is your Dashboard</p>
              </div>
              @include('frontend.pages.books.partials.list')


           

            </div>
          </div>
          <div class="col-md-4 p-1">
           @include('frontend.pages.users.partials.sidebar')
          </div>
      </div>
    </div>
  </div>

</div>
@endsection