@extends('backend.layouts.App')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Book</h1>
    </div>

    @include('frontend.layouts.partials.message')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.books.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for=" title">Book Title</label>
                        <br />
                        <input type="text" class="form-control" name="title" placeholder="Book Title">
                    </div>
                    <div class="col-md-6">
                        <label for="slug ">Book URL Text </label>
                        <br />
                        <input type="text" class="form-control" name="slug" placeholder="Book URL">
                    </div>
                    <div class="col-md-6">
                        <label for=" ">Book Category</label>
                        <br />
                        <select name="category_id" id="category_id" class="form-control ">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="isbn ">Book ISBN </label>
                        <br />
                        <input type="text" class="form-control" name="isbn" placeholder="Book ISBN">

                       
                    </div>
                    <div class="col-md-6">
                        <label for=" ">Book Author </label>
                        <br />
                        <select name="author_ids[]" id="author_id" class="form-control select2  " multiple>
                            <option value="">Select a author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="publisher_id ">Book Publisher</label>
                        <br />
                        <select name="publisher_id" id="publisher_id" class="form-control ">
                            <option value="">Select a publisher</option>
                            @foreach ($publishers as $publisher)
                                <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="publish_year">Book Publication Year</label>
                        <br />
                        <select name="publish_year" id="publish_year" class="form-control ">
                            <option value="">Select a publisher</option>
                            @for ($year = date('Y'); $year >= 1900; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="image ">Book Featured Image</label>
                        <br />
                        <input type="file" name="image" id="image" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="translator_id ">Book Translator</label>
                        <br />
                        <select name="translator_id" id="translator_id" class="form-control select2 ">
                            <option value="">Select a translator book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>

                            @endforeach

                        </select>
                    </div>



                    <div class="col-md-6">
                        <label for="summernote ">Book Detailes</label>
                        <br />
                        <textarea name="description" id="summernote" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </div>
            </form>

        </div>
    </div>



@endsection
