@extends('frontend.layouts.app')

@section('content')

<div class="main-content">

  <div class="login-area page-area">
    <div class="container">
      <div class="row">
          <div class="col-md-8 p-1">
            <div class="profile-tab border p-2">
              <h3>
                My Orders Books
              </h3>
              <hr>
              
              <div class="table-respossice">
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>Sl</th>
                              <th>Book</th>
                              <th>Owner</th>
                              <th>Phone N0</th>

                              <th>Message</th>
                              <th>Action</th>


                          </tr>
                          @foreach ($book_orders as $br)
                          <tbody>
                              <tr>
                                  <td>{{$loop->index+1}}</td>
                                  <td><a href="{{route('books.show', $br->book->slug)}}">{{$br->book->title}}</a></td>
                                  <td>{{$br->owner->name }}</td>
                                  <td>{{$br->owner->phone_no }}</td>

                                  

                                  <td>{{$br->owner_message}}</td>
                                  <td>
                                      @if ($br->status == 1)
                                       Request sent
                                       @elseif ($br->status == 2)
                                       Owner Approve
                                       @elseif ($br->status == 3)
                                       Owner Rejectted
                                       @elseif ($br->status == 4)
                                        Confirmed By Owner
                                       @elseif ($br->status == 2)
                                        Rejected

                                          
                                      @endif
                                      @if ($br->status == 2)
                                      <form action="{{route('books.order.approve', $br->id)}}" method="POST">
                                        @csrf
                                          <button type="submit" class="btn btn-success"> Approve</button>
                                      </form>
                                      <form action="{{route('books.order.reject', $br->id)}}" method="POST"  class="mt-1">
                                        @csrf
                                          <button type="submit" class="btn btn-danger"> Reject</button>
                                      </form>
                                     
                                          
                                      @endif
                                     
                                  </td>


                                  

                              </tr>
                          </tbody>
                          {{$book_orders->links()}}
                              
                          @endforeach
                      </thead>
                  </table>


                
              </div>
            

            
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