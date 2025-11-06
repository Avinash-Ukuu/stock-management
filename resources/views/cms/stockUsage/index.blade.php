@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Usage List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Stock Usage List</h3>
            </div>
            <div class="table-responsive">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Department</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Condition On Return</th>
                                <th>Remarks</th>
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
                ajax: "{{ route('stock-usage.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'Index',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'issue_date',
                        name: 'issue_date'
                    },
                    {
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        data: 'condition_on_return',
                        name: 'condition_on_return'
                    },

                    {
                        data: 'remarks',
                        name: 'remarks',
                        orderable: false
                    },

                ]
            });
        });
    </script>
@endsection
