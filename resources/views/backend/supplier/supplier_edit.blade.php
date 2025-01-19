@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Edit Supplier</h4><br><br>
            <form method="post" action="{{ route('supplier.update') }}" id="myForm">
              @csrf
              <input type="hidden" name="id" value="{{ $supplier->id }}">
              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Code</label>
                <div class="form-group col-sm-10">
                  <input name="code" class="form-control" value="{{ $supplier->code }}" type="number">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                <div class="form-group col-sm-10">
                  <input name="name" class="form-control" value="{{ $supplier->name }}" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Address 1</label>
                <div class="form-group col-sm-10">
                  <input name="address1" class="form-control" value="{{ $supplier->address1 }}" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Address 2</label>
                <div class="form-group col-sm-10">
                  <input name="address2" class="form-control" value="{{ $supplier->address2 }}" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Postal Code</label>
                <div class="form-group col-sm-2">
                  <select id="codePostal" name="postalCode" class="form-select select2" aria-label="Default select example">
                    <option id="iValor" attr_inputOption="{{ $supplier->postalCode }}" selected=""></option>
                    @foreach($postalCodes as $supp)
                    <option attrLocation="{{ $supp->location }}" value="{{ $supp->postalCode }}" {{ $supplier->postalCode == $supp->postalCode ? 'selected' : '' }}>
                      {{ $supp->postalCode }}
                    </option>
                    @endforeach
                  </select>
                </div>
                <label for="example-text-input" id="lbLocation" name="lbLocation" class="col-sm-8 col-form-label"></label>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Town</label>
                <div class="form-group col-sm-10">
                  <input name="town" class="form-control" value="{{ $supplier->town }}" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">NIF</label>
                <div class="form-group col-sm-10">
                  <input name="nif" class="form-control" value="{{ $supplier->nif }}" type="text">
                </div>
              </div>
              <!-- end row -->

              <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Supplier">
            </form>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#codePostal').val($('#iValor').attr("attr_inputOption")).trigger('change');
    $('#lbLocation').text($('#codePostal option:selected').attr("attrLocation"));

    $('#codePostal').change(function() {
      $('#lbLocation').text("");
      $('#lbLocation').text($("#codePostal option:selected").attr("attrLocation"));
    });

    $('#myForm').validate({
      rules: {
        code: {
          required: true
        },
        name: {
          required: true
        },
      },
      messages: {
        code: {
          required: 'Please Enter Supplier Code.'
        },
        name: {
          required: 'Please Enter Name Supplier.'
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid');
      },
    });
  });
</script>
@endsection