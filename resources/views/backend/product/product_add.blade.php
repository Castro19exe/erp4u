@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Add Product</h4>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Product</h4>
                        <br>
                        <form method="post" action="{{ route('product.store') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <!-- Product Name -->
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">Product Name</label>
                                <div class="form-group col-sm-10">
                                    <input id="code" name="name" class="form-control" type="text">
                                </div>
                            </div>
                            <!-- Product Description -->
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="form-group col-sm-10">
                                    <input id="description" name="description" class="form-control" type="text">
                                </div>
                            </div>
                            <!-- Product Family -->
                            <div class="row mb-3">
                                <label for="groupFamily" class="col-sm-2 col-form-label">Group Family</label>
                                <div class="form-group col-sm-10">
                                    <select id="groupFamily" name="family" class="form-select select2" aria-label="Default select example">
                                        <option selected="" value="">Select Family</option>
                                        @foreach($families as $family)
                                            <option value="{{ $family->family }}">{{ $family->family }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Measure Unit -->
                            <div class="row mb-3">
                                <label for="measureUnit" class="col-sm-2 col-form-label">Measure Unit</label>
                                <div class="form-group col-sm-10">
                                    <select id="measureUnit" name="unit" class="form-select select2" aria-label="Default select example">
                                        <option selected="" value="">Select Unit</option>
                                        @foreach($unitMeasures as $unit)
                                            <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Tax Rate -->
                            <div class="row mb-3">
                        <label for="taxRate" class="col-sm-2 col-form-label">Tax Rate</label>
                        <div class="form-group col-sm-5">
                            <select id="taxRate" name="taxRateCode" class="form-select select2" aria-label="Default select example">
                                <option selected="" value="">Select Tax Rate</option>
                                @foreach($taxRates as $taxRate)
                                    <option
                                        data-descriptionTaxRate="{{ $taxRate->descriptionTaxRate }}"
                                        data-taxRate="{{ $taxRate->taxRate }}"
                                        value="{{ $taxRate->taxRateCode }}">
                                        {{  $taxRate->taxRate }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <input type="text" id="descriptionTaxRate" class="form-control" placeholder="Description" readonly>
                        </div>
                        </div>

                            <!-- Product Image -->
                            <div class="row mb-3">
                                <label for="product_Image" class="col-sm-2 col-form-label">Product Image</label>
                                <div class="form-group col-sm-10">
                                    <input id="product_Image" name="product_Image" class="form-control" type="file">
                                </div>
                            </div>
                            <!-- Display Product Image -->
                            <div class="row mb-3">
                                <label for="showImage" class="col-sm-2 col-form-label"></label>
                                <div class="form-group col-sm-10">
                                    <img id="showImage" class="rounded avatar-lg" src="{{ url('upload/no_image.jpg') }}" alt="Product Image">
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-sm-12 text-end">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Product">
                                </div>
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {

                            $('#taxRate').on('change', function() {
                                const selectedOption = $(this).find(':selected');
                                const descriptionTaxRate = selectedOption.data('descriptiontaxrate');
                                
                                $('#descriptionTaxRate').val(descriptionTaxRate || '');
                            });

                            $('#product_Image').on('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('#showImage').attr('src', e.target.result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });

                            $('#myForm').validate({
                                rules: {
                                    name: {
                                        required: true,
                                    },
                                    description: {
                                        required: true,
                                    },
                                    family: {
                                        required: true,
                                    },
                                    unit: {
                                        required: true,
                                    },
                                    taxRateCode: {
                                        required: true,
                                    },
                                    product_Image: {
                                        required: true,
                                    },
                                },
                                messages: {
                                    name: {
                                        required: 'Please Enter Name.',
                                    },
                                    description: {
                                        required: 'Please Enter Description.',
                                    },
                                    family: {
                                        required: 'Please Enter Family Group.',
                                    },
                                    unit: {
                                        required: 'Please Enter Unit Measure.',
                                    },
                                    taxRateCode: {
                                        required: 'Please Enter Tax Rate.',
                                    },
                                    product_Image: {
                                        required: 'Please Enter Image.',
                                    },
                                },
                                errorElement: 'span',
                                errorPlacement: function(error, element) {
                                    error.addClass('invalid-feedback');
                                    element.closest('.form-group').append(error);
                                },
                                highlight: function(element, errorClass, validClass) {
                                    $(element).addClass('is-invalid');
                                },
                                unhighlight: function(element, errorClass, validClass) {
                                    $(element).removeClass('is-invalid');
                                },
                            });
                        });
                    </script>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection
