@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">EDIT PRODUCT</h4>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('product.update') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <!-- Product Code -->
                            <div class="form-group row mb-3">
                                <label for="code" class="col-sm-1 col-form-label">Code</label>
                                <div class="col-sm-2">
                                    <input id="code" name="code" class="form-control" type="text" value="{{ $product->code }}">
                                </div>

                                <!-- Product Name -->
                                <label for="name" class="col-sm-1 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <input id="name" name="name" class="form-control" type="text" value="{{ $product->name }}">
                                </div>
                            </div>

                            <!-- Product Description -->
                            <div class="row mb-3">
                                <label for="description" class="col-sm-1 col-form-label">Description</label>
                                <div class="form-group col-sm-11">
                                    <input id="description" name="description" class="form-control" type="text" value="{{ $product->description }}">
                                </div>
                            </div>

                            <!-- Product Family -->
                            <div class="form-group row mb-3">
                                <label for="product_family" class="col-sm-1 col-form-label">Family</label>
                                <div class="col-sm-2">
                                    <select id="product_family" name="product_family" class="form-select select2" aria-label="Default select example">
                                        <option selected value="">Select Family</option>
                                        @foreach($families as $prod)
                                            <option value="{{ $prod->family }}" {{ $prod->family == $product->family ? 'selected' : '' }}>
                                                {{ $prod->family }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Product Unit -->
                                <label for="product_unit" class="col-sm-1 col-form-label">Unit</label>
                                <div class="col-sm-2">
                                    <select id="product_unit" name="product_unit" class="form-select select2" aria-label="Default select example">
                                        <option selected value="">Select Unit</option>
                                        @foreach($unitMeasures as $prod)
                                            <option value="{{ $prod->unit }}" {{ $prod->unit == $product->unit ? 'selected' : '' }}>
                                                {{ $prod->unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <!-- Tax Rate -->
                                <label for="product_taxRateCode" class="col-sm-1 col-form-label">Tax Rate</label>
                                <div class="col-sm-2">
                                    <select id="product_taxRateCode" name="taxRateCode_Product" class="form-select select2" aria-label="Default select example">
                                        <option selected value="">Select Tax Rate</option>
                                        @foreach($taxRates as $prod)
                                            <option
                                                data-descriptionTaxRate="{{ $prod->descriptionTaxRate }}" value="{{ $prod->taxRateCode }}"
                                                {{ $prod->taxRateCode == $product->taxRateCode ? 'selected' : '' }}>
                                                {{ $prod->taxRate }}%
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-5">
                                    <input type="text" id="descriptionTaxRate" class="form-control" placeholder="Description" readonly>
                                </div>
                            </div>

                            <!-- Product Image File -->
                            <div class="form-group row mb-3">
                                <label for="image" class="col-sm-1 col-form-label">Img Product</label>
                                <div class="col-sm-11">
                                    <input id="image" name="profile_image" class="form-control" type="file">
                                </div>
                            </div>

                            <!-- Product Image Display -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-1 col-form-label"></label>
                                <div class="col-sm-11">
                                    <img id="showImage" class="rounded avatar-lg" src="{{ asset($product->image) }}" alt="Card image cap">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mb-3">
                                <div class="col-sm-12 text-end">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Product">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#showImage').click(function () {
        $('#image').click();
    });

    $('#image').change(function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    $('#product_taxRateCode').change(function () {
        var description = $('#product_taxRateCode option:selected').data('descriptiontaxrate');
        $("#descriptionTaxRate").val(description || '');
    });

    const selectedOption = $('#product_taxRateCode option:selected');
    const descriptionTaxRate = selectedOption.data('descriptiontaxrate');
    $('#descriptionTaxRate').val(descriptionTaxRate || '');

    $('#myForm').validate({
        rules: {
            code: {
                required: true,
            },
            description: {
                required: true,
            },
            product_family: {
                required: true,
            },
            product_unit: {
                required: true,
            },
            taxRateCode_Product: {
                required: true,
            },
        },
        messages: {
            code: "Please Enter Product Code.",
            description: "Please Enter Product Description.",
            product_family: "Please Select Product Family.",
            product_unit: "Please Select Product Unit.",
            taxRateCode_Product: "Please Select Tax Rate.",
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
    });
});
</script>

@endsection
