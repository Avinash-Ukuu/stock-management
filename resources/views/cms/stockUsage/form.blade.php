@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('stock-usage.index') }}">Stock Usage List</a></li>
                        <li class="breadcrumb-item active">Stock Usage Form</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Stock Usage Form</h3>
                <div class="card-tools"><span class="text-danger"><b>Note:-</b> </span><b>*</b> Fields are Required</div>
            </div>

            {{ Form::model($object, ['url' => $url, 'method' => $method, 'onSubmit' => "document.getElementById('submit').disabled=true;"]) }}
            <input type="hidden" name="id" value="{{ $object->id }}">
            <div class="card-body">
                <div class="row ml-0"><b>Note :- </b>&nbsp;<p class="text-danger">Name field should only contain
                        alphabetical characters.</p>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('department_id', 'Select Department', []) }}<span style="color: red;"> *</span>
                        {{ Form::select('department_id', $departments, null, ['class' => 'form-control select2', 'placeholder' => 'Select Department', 'data-placeholder' => 'Select Department', 'required']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('stock_id', 'Select Stock', []) }}<span style="color: red;"> *</span>
                        {{ Form::select('stock_id', $stocks, null, ['class' => 'form-control select2', 'placeholder' => 'Select Stock', 'data-placeholder' => 'Select Stock', 'required']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('quantity', 'Quantity', []) }}<span style="color: red;"> *</span>
                        {{ Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Enter Quantity', 'required','min'=>'1']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('issue_date', 'Issue Date', []) }}<span style="color: red;"> *</span>
                        {{ Form::date('issue_date', null, ['class' => 'form-control', 'placeholder' => 'Enter Issue Date','max'=> date('Y-m-d')]) }}
                    </div>
                    <div class="form-group col-8">
                        {{ Form::label('remarks', 'Remarks', []) }}<span style="color: red;"> *</span>
                        {{ Form::text('remarks', null, ['class' => 'form-control', 'placeholder' => 'Enter Remarks']) }}
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
