@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Department List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Department List</h3>
                {{-- @can('admin', new App\Models\User()) --}}
                    <div class="card-tools"><a href="{{ route('department.create') }}"><span class="btn btn-sm btn-info">Add
                    &nbsp;<span class="fa fa-plus"></span></span></a></div>
                {{-- @endcan --}}
            </div>
            <div class="table-responsive">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Head</th>
                                <th>Name</th>
                                @can('admin', new App\Models\User())
                                    <th>Action</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $department->head->name ?? '' }}</td>
                                    <td>{{ $department->name }}</td>
                                    @can('admin', new App\Models\User())
                                        <td>
                                            <div class="row">
                                                <a href="{{ route('department.edit', ['department' => $department->id]) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                {{-- <form
                                                    action="{{ route('department.destroy', ['department' => $department->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('Delete')
                                                    <button type="button" onclick="confirmBox(this)"
                                                        style="border: 0px;background-color:transparent;"><i
                                                            class="fa fa-trash text-red"></i></button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();
        });
    </script>
@endsection
