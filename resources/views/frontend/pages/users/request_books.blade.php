@extends('frontend.layouts.app')

@section('content')

<div class="main-content">

  <div class="login-area page-area">
    <div class="container">
      <div class="row">
          <div class="col-md-8 p-1">
            <div class="profile-tab border p-2">
              <h3>
                My Requested Books
              </h3>
              <hr>
              
              <div class="table-respossice">
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>Sl</th>
                              <th>Book</th>
                              <th>Rrquester</th>
                              <th>Phone N0</th>

                              <th>Message</th>
                              <th>Action</th>


                          </tr>
                          @foreach ($book_requests as $br)
                          <tbody>
                              <tr>
                                  <td>{{$loop->index+1}}</td>
                                  <td><a href="{{route('books.show', $br->book->slug)}}">{{$br->book->title}}</a></td>
                                  <td>{{$br->user->name }}</td>
                                  <td>{{$br->user->phone_no }}</td>

                                  

                                  <td>{{$br->user_message}}</td>
                                  <td>
                                      @if ($br->status == 1)
                                       Request sent
                                       @elseif ($br->status == 2)
                                       Request Approve
                                       @elseif ($br->status == 3)
                                       Request Rejectted
                                       @elseif ($br->status == 4)
                                       User Confirm
                                       @elseif ($br->status == 5)
                                       User Rejected
                                       @elseif ($br->status == 6)
                                       Return Request 
                                       @elseif ($br->status == 7)
                                       Return Confirm

                                          
                                      @endif
                                      @if ($br->status == 1)
                                      <form action="{{route('books.request.approve', $br->id)}}" method="POST">
                                        @csrf
                                          <button type="submit" class="btn btn-success"> Approve</button>
                                      </form>
                                      <form action="{{route('books.request.reject', $br->id)}}" method="POST"  class="mt-1">
                                        @csrf
                                          <button type="submit" class="btn btn-danger"> Reject</button>
                                      </form>
                                      @elseif($br->status == 2)
                                      <form action="{{route('books.request.reject', $br->id)}}" method="POST"  class="mt-1">
                                        @csrf
                                          <button type="submit" class="btn btn-danger"> Reject</button>
                                      </form>
                                      @elseif($br->status == 3)
                                      <form action="{{route('books.request.approve', $br->id)}}" method="POST">
                                        @csrf
                                          <button type="submit" class="btn btn-success"> Approve</button>
                                      </form>
                                      @elseif($br->status == 6)
                                      <form action="{{route('books.return', $br->id)}}" method="POST">
                                        @csrf
                                          <button type="submit" class="btn btn-success">Confirm Return</button>
                                      </form>
                                          
                                      @endif
                                     
                                  </td>


                                  

                              </tr>
                          </tbody>
                          {{$book_requests->links()}}
                              
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