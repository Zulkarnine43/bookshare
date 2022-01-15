@extends('backend.layouts.App')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Publishers</h1>
        <a href="#addModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"><i
                class="fas fa-plus-circle fa-sm text-white-50"></i>Add
            Publisher</a>

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
                    <form action="{{ route('admin.publishers.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="author_name">Publisher Name</label>
                                <br />
                                <input type="text" class="form-control" name="name" placeholder="Publisher Name">
                            </div>
                            <div class="col-md-6">
                                <label for="author_name">Publisher Link</label>
                                <br />
                                <input type="text" class="form-control" name="link" placeholder="Publisher Link">
                            </div>
                            <div class="col-md-6">
                                <label for="author_name">Publisher Address</label>
                                <br />
                                <input type="text" class="form-control" name="address" placeholder="Publisher Address">
                            </div>
                            <div class="col-md-6">
                                <label for="author_name">Publisher Outlet</label>
                                <br />
                                <input type="text" class="form-control" name="outlet" placeholder="Publisher Outlet">
                            </div>
                            <div class="col-md-6">
                                <label for="author_name">Publisher Detailes</label>
                                <br />
                                <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Publisher</button>
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
                                <th>Link</th>
                                <th>Address</th>
                                <th>Outlet</th>
                                <th>Manage</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($publishers as $publisher)
                                <tr>
                                    <td>{{ $publisher->id }}</td>
                                    <td>{{ $publisher->name }}</td>
                                    <td>{{ $publisher->link }}</td>
                                    <td>{{ $publisher->address }}</td>
                                    <td>{{ $publisher->outlet }}</td>
                                    <td>
                                        <a href="#editModal{{ $publisher->id }}" class="btn btn-success"
                                            data-toggle="modal"><i class="fa fa-edit">Edit</i></a>
                                        <a href="#deleteModal{{ $publisher->id }}" class="btn btn-danger"
                                            data-toggle="modal"><i class="fa fa-trash">Delete</i></a>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $publisher->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Publisher</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.publishers.update', $publisher->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="author_name">Publisher Name</label>
                                                            <br />
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $publisher->name }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="author_name">Publisher Link</label>
                                                            <br />
                                                            <input type="text" class="form-control" name="link"
                                                                value="{{ $publisher->link }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="author_name">Publisher Address</label>
                                                            <br />
                                                            <input type="text" class="form-control" name="address"
                                                                value="{{ $publisher->address }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="author_name">Publisher Outlet</label>
                                                            <br />
                                                            <input type="text" class="form-control" name="outlet"
                                                                value="{{ $publisher->outlet }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="author_name">Publisher Detailes</label>
                                                            <br />
                                                            <textarea name="description" id="" cols="30" rows="5"
                                                                class="form-control"> {{ $publisher->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update
                                                            Publisher</button>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Dekete Modal -->
                                <div class="modal fade" id="deleteModal{{ $publisher->id }}" tabindex="-1" role="dialog"
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
                                                <form action="{{ route('admin.publishers.delete', $publisher->id) }}"
                                                    method="post">
                                                    @csrf
                                                    {{ $publisher->name }} will be deleted !!
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
