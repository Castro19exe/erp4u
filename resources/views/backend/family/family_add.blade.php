@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h1 text-center">Add Family</h1>
                        <form method="post" action="{{ route('family.store') }}" id="myForm">
                            @csrf
                            <div class="row mb-3">
                                <label for="title-input" class="col-form-label">Family Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="family" class="form-control" type="text">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#myForm').validate({
                                rules: {
                                    family: {
                                        required: true,
                                    },
                                },
                                messages: {
                                    family: {
                                        required: 'Please Enter A Name.',
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