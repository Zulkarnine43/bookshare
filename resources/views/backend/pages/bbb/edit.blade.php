@extends('backend.layouts.App')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Book -- {{ $book->title }}</h1> 
    </div>

    @include('frontend.layouts.partials.message')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.books.update', $book->id ) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for=" title">Book Title</label>
                        <br />
                        <input type="text" class="form-control" name="title"  value="{{$book->title}}">
                    </div>
                    <div class="col-md-6">
                        <label for="slug ">Book URL Text </label>
                        <br />
                        <input type="text" class="form-control" name="slug" value="{{$book->slug}}">
                    </div>
                    <div class="col-md-6">
                        <label for=" ">Book Category</label>
                        <br />
                        <select name="category_id" id="category_id" class="form-control ">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{$book->category_id ==  $category->id ?'selected':'' }}>{{ $category->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="isbn ">Book ISBN </label>
                        <br />
                        <input type="text" class="form-control" name="isbn" value="{{$book->isbn}}">

                       
                    </div>
                    <div class="col-md-6">
                        <label for=" ">Book Author </label>
                        <br />
                        <select name="author_ids[]" id="author_id" class="form-control select2  " multiple>
                            <option value="">Select a author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" {{App\Book::isAuthorSelected($book->id, $author->id) ? 'selected' : ''}}>{{ $author->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="publisher_id ">Book Publisher</label>
                        <br />
                        <select name="publisher_id" id="publisher_id" class="form-control ">
                            <option value="">Select a publisher</option>
                            @foreach ($publishers as $publisher)
                                <option value="{{ $publisher->id }}" {{$book->publisher_id == $publisher->id?'selected':'' }}>{{ $publisher->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="publish_year">Book Publication Year</label>
                        <br />
                        <select name="publish_year" id="publish_year" class="form-control ">
                            <option value="">Select a publisher</option>
                            @for ($year = date('Y'); $year >= 1900; $year--)
                                <option value="{{ $year }}" {{$book->publish_year == $year?'selected':''}}>{{ $year }}</option>
                            @endfor

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="image ">Book Featured Image(optional) <a href="{{asset('images/books/'.$book->image)}}" target="_blank">Old image</a></label>
                        <br />
                        <input type="file" name="image" id="image" class="form-control" >
                    </div>
                    <div class="col-md-6">
                        <label for="translator_id ">Book Translator</label>
                        <br />
                        <select name="translator_id" id="translator_id" class="form-control select2 ">
                            <option value="">Select a translator book</option>
                            @foreach ($books as $tb)
                                <option value="{{ $tb->id }}"{{$book->translator_id == $tb->id?'selected':''}}>{{ $book->title }}</option>

                            @endforeach

                        </select>
                    </div>



                    <div class="col-md-6">
                        <label for="summernote ">Book Detailes</label>
                        <br />
                        <textarea name="description" id="summernote" cols="30" rows="5" class="form-control">{{  $book->description }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>

        </div>
    </div>



@endsection
