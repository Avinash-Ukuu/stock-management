@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('stock-usage.index') }}">Stock Usage List</a></li>
                        <li class="breadcrumb-item active">Return Stock Form</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Return Stock Form</h3>
                <div class="card-tools"><span class="text-danger"><b>Note:-</b> </span><b>*</b> Fields are Required</div>
            </div>

            {{ Form::open(['url' => route('stock-usage.returnStore', $usage->id), 'method' => 'POST', 'onSubmit' => "document.getElementById('submit').disabled=true;"]) }}

            <div class="card-body">
                <div class="row ml-0"><b>Note :- </b>&nbsp;<p class="text-danger">Name field should only contain
                        alphabetical characters.</p>
                </div>

                <div class="row">
                    <div class="form-group col-3">
                        {{ Form::label('stock', 'Stock', []) }}
                        {{ Form::text('stock', $usage->stock->name, ['class' => 'form-control', 'placeholder' => 'Enter Stock', 'disabled']) }}
                    </div>
                    <div class="form-group col-3">
                        {{ Form::label('department', 'Department', []) }}
                        {{ Form::text('department', $usage->department->name, ['class' => 'form-control', 'placeholder' => 'Enter Department', 'disabled']) }}
                    </div>
                    <div class="form-group col-2">
                        {{ Form::label('issue_date', 'Issue Date', []) }}
                        {{ Form::text('issue_date',  \Carbon\Carbon::parse($usage->issue_date)->format('d-m-Y')  , ['class' => 'form-control', 'placeholder' => 'Enter Issue Date', 'disabled']) }}
                    </div>
                    <div class="form-group col-2">
                        {{ Form::label('issued_quantity', 'Issued Quantity', []) }}
                        {{ Form::text('issued_quantity', $usage->quantity, ['class' => 'form-control', 'placeholder' => 'Enter Issued Quantity', 'disabled']) }}
                    </div>
                    <div class="form-group col-2">
                        {{ Form::label('already_returned', 'Already Returned', []) }}
                        {{ Form::text('already_returned', $usage->returned_quantity ?? 0, ['class' => 'form-control', 'placeholder' => 'Enter Already Returned', 'disabled']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('return_date', 'Return Date', []) }}<span style="color: red;"> *</span>
                        {{ Form::date('return_date', null, ['class' => 'form-control', 'placeholder' => 'Enter Return Date', 'max' => date('Y-m-d')]) }}
                    </div>
                    <div class="form-group col-8">
                        {{ Form::label('remarks', 'Remarks', []) }}<span style="color: red;"> *</span>
                        {{ Form::text('remarks', null, ['class' => 'form-control', 'placeholder' => 'Enter Remarks']) }}
                    </div>
                </div>


                {{-- <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('return_quantity', 'Return Quantity', []) }}<span style="color: red;"> *</span>
                        {{ Form::number('return_quantity', null, ['class' => 'form-control', 'placeholder' => 'Enter Return Quantity', 'required', 'min' => '1', 'max' => $usage->quantity]) }}
                    </div>

                    <div class="form-group col-4">
                        {{ Form::label('condition_on_return', 'Condition On Return', []) }}<span style="color: red;">
                            *</span>
                        {{ Form::select('condition_on_return', $conditions, null, ['class' => 'form-control select2', 'placeholder' => 'Condition On Return', 'data-placeholder' => 'Condition On Return', 'required']) }}
                    </div>

                </div> --}}
                @if(!$usage->stock->qr_required )
                    <h5>Return Quantity by Condition</h5>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label>New</label>
                            <input type="number" name="condition_on_return[new]" class="form-control" min="0" value="0">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Good</label>
                            <input type="number" name="condition_on_return[good]" class="form-control" min="0" value="0">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Need Repair</label>
                            <input type="number" name="condition_on_return[need_repair]" class="form-control" min="0" value="0">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Damage</label>
                            <input type="number" name="condition_on_return[damage]" class="form-control" min="0" value="0">
                        </div>
                    </div>
                @else

                    <h5 class="mt-3">Return Individual Items</h5>
                    <p>Select the condition of each item being returned.</p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Unique Code</th>
                                <th>Current Condition</th>
                                <th>Return Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usage->stock->stockItems as $item)
                                <tr>
                                    <td>{{ $item->unique_code }}</td>
                                    <td>{{ ucfirst($item->condition) }}</td>
                                    <td>
                                        <select name="returned_items[{{ $item->id }}]" class="form-select">
                                            <option value="">-- Select Condition --</option>
                                            <option value="new">New</option>
                                            <option value="good">Good</option>
                                            <option value="need_repair">Need Repair</option>
                                            <option value="damage">Damage</option>
                                        </select>
                                        {{-- {{ Form::label('condition_on_return', 'Condition On Return', []) }}<span style="color: red;">*</span>
                                        {{ Form::select('condition_on_return', $conditions, null, ['class' => 'form-control select2', 'placeholder' => 'Condition On Return', 'data-placeholder' => 'Condition On Return', 'required']) }} --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
