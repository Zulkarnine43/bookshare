@extends('backend.layouts.App')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Category</h1>
        <a href="#addModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"><i
                class="fas fa-plus-circle fa-sm text-white-50"></i>Add
            Category</a>

    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.categories.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="category_name">Category Name</label>
                                <br />
                                <input type="text" class="form-control" name="name"
                                    placeholder="Category Slug, e.g, c-programming">
                            </div>
                            <div class="col-md-6">
                                <label for="category url">Category URL Text</label>
                                <br />
                                <input type="text" class="form-control" name="slug" placeholder="Publisher Link">
                            </div>
                            <div class="col-md-6">
                                <label for="parent_id">Parent Category</label>
                                <br />
                                <select name="parent_id" id="parent_id" class="form-control ">
                                    <option value="">Select a category</option>
                                    @foreach ($parent_categories as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6">
                                <label for="author_name">Publisher Detailes</label>
                                <br />
                                <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    @include('frontend.layouts.partials.message')


    <div class="row">

        <div class="col-sm-12">
            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Publishers Lists</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Parent_Category</th>
                                <th>Manage</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ route('categories.show', $category->slug) }}" target="_blank">
                                            {{ route('categories.show', $category->slug) }}
                                    </td>
                                    </a>
                                    <td>
                                        @if (!is_null($category->parent_category($category->parent_id)))
                                            {{ $category->parent_category($category->parent_id)->name }}
                                        @else
                                            --
                                        @endif

                                    </td>
                                    <td>
                                        <a href="#editModal{{ $category->id }}" class="btn btn-success"
                                            data-toggle="modal"><i class="fa fa-edit">Edit</i></a>
                                        <a href="#deleteModal{{ $category->id }}" class="btn btn-danger"
                                            data-toggle="modal"><i class="fa fa-trash">Delete</i></a>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.categories.update', $category->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="category_name">Category Name</label>
                                                            <br />
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $category->name }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="category url">Category URL Text</label>
                                                            <br />
                                                            <input type="text" class="form-control" name="slug"
                                                                value="{{ $category->slug }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="parent_id">Parent Category</label>
                                                            <br />
                                                            <select name="parent_id" id="parent_id" class="form-control ">
                                                                <option value="">Select a category</option>
                                                                @foreach ($parent_categories as $parent)
                                                                    <option value="{{ $parent->id }}"
                                                                        {{ $category->parent_id == $parent->id ? 'selected' : '' }}>

                                                                        {{ $parent->name }}</option>

                                                                @endforeach

                                                            </select>

                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="author_name">Category Detailes</label>
                                                            <br />
                                                            <textarea name="description" id="" cols="30" rows="5"
                                                                class="form-control">{{ $category->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update
                                                            Category</button>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Dekete Modal -->
                                <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to delete ?
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.categories.delete', $category->id) }}"
                                                    method="post">
                                                    @csrf
                                                    {{ $category->name }} will be deleted !!
                                                    <div class="mt-4">

                                                        <button type="submit" class="btn btn-primary">Ok, Confirm</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Dekete Modal -->




                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

@endsection
