@extends('frontend.layouts.app')
@section('content')
<div class="main-content">
   @include('frontend.layouts.partials.message')
    <!-- Carousel -->
  <div id="carouselExampleIndicators" class="carousel slide main-slider" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('images/sliders/slider1.png') }}" class="d-block w-100">
        <div class="carousel-caption d-none d-md-block">
          <h3>Welcome to your Book Sharing Platform</h3>
          <p>
            <a href="register.html" class="btn btn-primary slider-link">
              Get Start Now
            </a>
          </p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/sliders/slider2.png') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h3>Welcome to your Book Sharing Platform</h3>
          <p>
            <a href="" class="btn btn-primary slider-link">
              New Account
            </a>
          </p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/sliders/slider3.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h3>Welcome to your Book Sharing Platform</h3>
          <p>
            <a href="" class="btn btn-primary slider-link">
              Borrow Now
            </a>
          </p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
    <!-- Carousel -->
   <div class="top-body pt-4 pb-4">
      <div class="container">
            @if (Session::has('status'))
                <div class="container">
                      <div class="row justify-content-center">
                          <div class="col-md-12">
                                <div class="alert alert-success mt-1">
                                    <p>{{ Session::get('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                      </p>
                                </div>
                          </div>
                      </div>
                </div>
            @endif
      </div>
  </div>
  
  <div class="advance-search bg-dark">
    <div class="container">
      <h3 >Advance Search</h3>
      <form action="{{route('books.searched.advance')}}" method="GET">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Book Title/Description</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="t" placeholder="Book Title/Description">
              </div>
          </div>
          {{-- <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Author</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Book Author">
              </div>
          </div> --}}
          <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Publication</label>
                <select class="form-control" name="p"> 
                  <option value="">Select a publisher</option>
                  @foreach($publishers as $publish)
                  <option value="{{$publish->id }}">{{$publish->name }}</option>
                  @endforeach                
                </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Book Category</label>
                <select class="form-control" name="c"> 
                  <option value="">Select a category</option>
                  @foreach($categories as $cat)
                  <option value="{{$cat->id }}">{{$cat->name }}</option>
                  @endforeach
                
                </select>
            </div>
          </div>
          <div class="col-md-2 mt-4">
            <p class="mt-2">
              <button type="submit" class="btn btn-success btn-lg" name="">
                <i class="fa fa-search"></i> Search
             </button>

            </p>
         </div>
        </div>
      </form>
    </div>
  </div>
  <div class="book-list-sidebar">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <h3>Recent Uploaded Books</h3>
          <div class="row">
            @foreach ($books as $book)
            <div class="col-md-4">
              <div class="single-book">
                <img src="{{asset('images/books/'.$book->image)}}" alt="" style="width:245px;">
                <div class="book-short-info">
                  <h5>{{ $book->title }} </h5>       
                  <p>
                    <a href="{{route('users.profile', $book->user->username)}}" class=""> <i class="fa fa-upload"></i>{{ $book->user->username}}</a>
                  </p>
        
                   @if(Route::is('users.dashboard'))
                      <a href="{{route('books.show', $book->slug)}}" class="btn btn-outline-primary"><i class="fa fa-eye"></i></a>
            
                      <a href="{{route('users.dashboard.books.edit', $book->slug)}}" class="btn btn-outline-primary"><i class="fa fa-edit"></i></a>
                      <a href="#deleteModal{{ $book->id }}" onclick=" return 'are you sure to delete? " class="btn btn-danger"
                        ><i class="fa fa-trash"></i></a>
                        
                      
                   @else               
                      <form action="{{route('wishlist_add', $book->id)}}">
                        <a href="{{route('books.show', $book->slug)}}" class="btn btn-outline-primary"><i class="fa fa-eye">View</i></a>
                          @php
                            $user_id = Auth::id();
                            // dd($user);                           
                          @endphp
                        @if ($book->user->id == $user_id)
                        <button href="" class=" d-none btn btn-outline-danger"> <i class="fa fa-heart">Remove</i></button>
                        @elseif ( App\Wishlist::where('book_id',$book->id)->count() > 0 && App\Wishlist::where('user_id',$user_id)->count() > 0 )
                        {{-- <button href="" class="btn btn-outline-danger"> <i class="fa fa-heart">Remove</i></button> --}}
                        @else
                        <button href="" class="btn btn-outline-danger"> <i class="fa fa-heart">Add</i></button>

                        @endif  
                           
                      </form>
                       
                   @endif
                </div>
              </div>
            </div>                
            @endforeach
          </div>

         <div class="books-pagination mt-5">
           {{$books->links() }}
         </div>
        </div> <!-- Book List -->

        @include('frontend.pages.books.partials.category_sidebar')

      </div>
    </div>
  </div>
</div>
@endsection