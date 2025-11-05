@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Item List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Stock Item List</h3>
            </div>
            <div class="table-responsive">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock</th>
                                <th>Unique Code</th>
                                <th>QR Code</th>
                                <th>Condition</th>
                                <th>Assigned Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row"></div>
@endsection
@section('footerScript')
    <script>
        $(document).ready(function() {

            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                ajax: "{{ route('stock-item.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'Index',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'unique_code',
                        name: 'unique_code'
                    },
                    {
                        data: 'qr_code',
                        name: 'qr_code'
                    },
                    {
                        data: 'condition',
                        name: 'condition'
                    },
                    {
                        data: 'assigned_department',
                        name: 'assigned_department'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });
        });
    </script>
@endsection
