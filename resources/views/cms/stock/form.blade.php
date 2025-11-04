@extends('cms.layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('stock.index') }}">Stock List</a></li>
                        <li class="breadcrumb-item active">Stock Form</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Stock Form</h3>
                <div class="card-tools"><span class="text-danger"><b>Note:-</b> </span><b>*</b> Fields are Required</div>
            </div>

            {{ Form::model($object, ['url' => $url, 'method' => $method, 'onSubmit' => "document.getElementById('submit').disabled=true;",'files' => true]) }}
            <input type="hidden" name="id" value="{{ $object->id }}">
            <div class="card-body">
                <div class="row ml-0"><b>Note :- </b>&nbsp;<p class="text-danger">Name field should only contain
                        alphabetical characters.</p>
                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('category_id', 'Select Category', []) }}<span style="color: red;"> *</span>
                        {{ Form::select('category_id', $categories, null, ['class' => 'form-control select2', 'placeholder' => 'Select Category', 'data-placeholder' => 'Select Category', 'required']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('name', 'Name', []) }}<span style="color: red;"> *</span>
                        {{ Form::text('name', null, ['class' => 'form-control name', 'placeholder' => 'Enter Name', 'required']) }}
                    </div>
                    <div class="form-group col-4">
                        {{ Form::label('description', 'Description', []) }}
                        {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-3">
                        {{ Form::label('vendor', 'Vendor', []) }}
                        {{ Form::text('vendor', null, ['class' => 'form-control', 'placeholder' => 'Enter Vendor', 'required']) }}
                    </div>

                    <div class="form-group col-3">
                        {{ Form::label('purchase_date', 'Purchase Date', []) }}
                        {{ Form::date('purchase_date', null, ['class' => 'form-control', 'placeholder' => 'Enter Purchase Date','max'=> date('Y-m-d'), 'required']) }}
                    </div>

                    <div class="form-group col-3">
                        {{ Form::label('total_quantity', 'Total Quantity', []) }}
                        {{ Form::number('total_quantity', null, ['class' => 'form-control', 'placeholder' => 'Enter Total Quantity', 'required', 'min' => '0']) }}
                    </div>

                    <div class="form-group col-3">
                        {{ Form::label('available_quantity', 'Available Quantity', []) }}
                        {{ Form::number('available_quantity', null, ['class' => 'form-control', 'placeholder' => 'Enter Available Quantity', 'required', 'min' => '0']) }}
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {{ Form::label('unit_price', 'Unit Price', []) }}
                        {{ Form::number('unit_price', null, ['class' => 'form-control', 'placeholder' => 'Enter Unit Price', 'required', 'min' => '0', 'step' => '0.01']) }}
                    </div>

                    <div class="form-group col-4">
                        {{ Form::label('condition', 'Select Condition', []) }}
                        {{ Form::select('condition', $conditions, null, ['class' => 'form-control select2', 'placeholder' => 'Select Condition', 'data-placeholder' => 'Select Condition', 'required']) }}
                    </div>

                    <div class="form-group col-4">
                        {{ Form::label('qr_required', 'QR Required', []) }}
                        {{ Form::select('qr_required', ['0'=>'NO','1'=>'Yes'], null, ['class' => 'form-control select2', 'placeholder' => 'QR Required', 'data-placeholder' => 'QR Required', 'required']) }}
                    </div>

                </div>

                <div class="row">
                    <div class="form-group" id="image">
                    {{ Form::label('image', 'Image') }}
                    {{ Form::file('image', ['class' => 'file-upload-default','id'=>'imageField', 'accept' => 'image/jpg, image/jpeg, image/png']) }}

                    <div class="row">
                        <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="image_preview"></div>
                        <div class="image-preview mt-2  ml-2">
                            @if (!empty($object->image) && file_exists("uploads/stocks/" . $object->image))
                            {{ Form::label('image', 'Image',['class'=>'mr-2']) }}
                                <img style="background:thistle;max-height: 150px;"
                                    src={{ asset('uploads/stocks/' . $object->image) }} />
                            @endif
                        </div>
                    </div>
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
@section('footerScript')
    <script>
        $(document).ready(function() {


            $('#imageField').on('change', function() {
                validateFile(this, ['image/jpeg', 'image/jpg','image/png'], 2 * 1024 * 1024, '#image_preview');
            });

            function updateFileLabel(input, previewElement) {
                var fileName = $(input).val().split('\\').pop();
                $(input).next('.file-upload-default').html(fileName);

                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var previewHtml = '';
                        if (file.type.startsWith('image')) {
                            previewHtml = '<label>Preview:</label><img style="background:thistle;max-height: 150px;" src="' + e.target.result + '" class="img-fluid">';
                        }
                        $(previewElement).html(previewHtml);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $(previewElement).html('');
                }
            }

            function validateFile(input, allowedTypes, maxSize, previewElement) {
                var file = input.files[0];
                if (file) {
                    var fileType = file.type;
                    var fileSize = file.size;
                    var isValidType = allowedTypes.includes(fileType);
                    var isValidSize = fileSize <= maxSize;

                    if (!isValidType) {
                        alert('Invalid file type. Please select a valid file.');
                        $(input).val('');
                        $(input).next('.file-upload-default').html('Choose file');
                        $(previewElement).html('');
                        return false;
                    }

                    if (!isValidSize) {
                        alert('File size exceeds 2 MB. Please select a smaller file.');
                        $(input).val('');
                        $(input).next('.file-upload-default').html('Choose file');
                        $(previewElement).html('');
                        return false;
                    }

                    updateFileLabel(input, previewElement);
                    return true;
                }
                return false;
            }



            var category = $(".name").val();
            if (category == "") {
                $('#submit').prop('disabled', true);
            }
            $('.name').on('input', function() {
                var inputValue = $(this).val();
                var numeric = /^\d/;
                var specialCharacter = "!@#\\$%\^&*()_\\-+=\\[\\]{};':\",./<>?\\|`~";
                var emojiRegex = /[\uD800-\uDBFF][\uDC00-\uDFFF]|[\u2600-\u27FF]/;
                var hasSpecialCharacter = false;
                var hasnumeric = false;

                for (var i = 0; i < specialCharacter.length; i++) {
                    if (inputValue.includes(specialCharacter[i])) {
                        hasSpecialCharacter = true;
                        break;
                    }
                }

                if (/\d/.test(inputValue)) {
                    hasnumeric = true;
                }

                if (hasSpecialCharacter || emojiRegex.test(inputValue) || hasnumeric) {
                    $('#submit').prop('disabled', true);
                } else {
                    $('#submit').prop('disabled', false);
                }
            });


        });
    </script>
@endsection
