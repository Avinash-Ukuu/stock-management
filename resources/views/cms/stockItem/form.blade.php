@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('stock-item.index') }}">Stock Item List</a></li>
                        <li class="breadcrumb-item active">Stock Item Form</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Stock Item Form</h3>
                <div class="card-tools"><span class="text-danger"><b>Note:-</b> </span><b>*</b> Fields are Required</div>
            </div>

            {{ Form::model($object, ['url' => $url, 'method' => $method, 'onSubmit' => "document.getElementById('submit').disabled=true;", 'files' => true]) }}
            <input type="hidden" name="id" value="{{ $object->id }}">
            <div class="card-body">
                <div class="row ml-0"><b>Note :- </b>&nbsp;<p class="text-danger">Name field should only contain
                        alphabetical characters.</p>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('stock_id', 'Stock', []) }}
                        {{ Form::text('stock_id', $object->stock->name, ['class' => 'form-control', 'placeholder' => 'Stock', 'disabled']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('unique_code', 'Unique Code', []) }}<span style="color: red;"> *</span>
                        {{ Form::text('unique_code', null, ['class' => 'form-control', 'placeholder' => 'Enter Unique Code', 'required']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('qr_code', 'QR Code', []) }}<span style="color: red;"> *</span>
                        {{ Form::text('qr_code', null, ['class' => 'form-control', 'placeholder' => 'Enter QR Code']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('condition', 'Select Condition', []) }}<span style="color: red;"> *</span>
                        {{ Form::select('condition', $conditions, null, ['class' => 'form-control select2', 'placeholder' => 'Select Condition', 'data-placeholder' => 'Select Condition', 'required']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('assigned_department', 'Select Department', []) }}<span style="color: red;"> *</span>
                        {{ Form::select('assigned_department', $departments, null, ['class' => 'form-control select2', 'placeholder' => 'Select Department', 'data-placeholder' => 'Select Department']) }}
                    </div>

                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
