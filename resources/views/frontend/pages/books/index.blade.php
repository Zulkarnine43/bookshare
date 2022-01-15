@extends('frontend.layouts.app')


@section('content')

<div class="main-content">
 


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
  </div> <!-- End Top Body Links -->

 

  <div class="book-list-sidebar">
    <div class="container">
      <div class="row">

        <div class="col-md-9">

          @if (isset($searched))
          Searched Book By -- <mark>{{ $searched }}</mark>
              @else
              @if (Route::is('categories.show'))
            <h1> <mark>  {{ $category->name }}</mark> Category Books</h1>

              @else
              <h3>Recent Uploaded Books</h3>
                  
              @endif
             


          @endif

         @include('frontend.pages.books.partials.list')
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