@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add taxRate</h4>
                        <form method="post" action="{{ route('taxRate.store') }}" id="myForm">
                            @csrf
                            <div class="mb-3">
                                <label for="taxRateCode" class="form-label"> Tax Rate Code</label>
                                <input type="number" name="taxRateCode" class="form-control">
                                
                                <label for="descriptionTaxRate">Description</label>
                                <input type="text" name="descriptionTaxRate" class="form-control" >

                                <label for="taxRate">Tax Rate %</label>

                                <input type="number" name="taxRate" class="form-control" >
                                
                            </div>
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#myForm').validate({
                                rules: {
                                    taxRateCode: {
                                        required: true,
                                    },
                                    descriptionTaxRate: {
                                        required: true,
                                    },
                                },
                                messages: {
                                    taxRateCode: {
                                        required: 'Please Enter A Tax Rate Code.',
                                    },
                                    descriptionTaxRate: {
                                        required: 'Please Enter A Description.',
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
            </div>
        </div>
    </div>
</div>

@endsection
