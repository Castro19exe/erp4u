@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Supplier</h4><br><br>
            <form method="post" action="{{ route('supplier.store')}}" id="myForm">
              @csrf
              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Code</label>
                <div class="form-group col-sm-10">
                  <input name="code" class="form-control" type="number">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                <div class="form-group col-sm-10">
                  <input name="name" class="form-control" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Address 1</label>
                <div class="form-group col-sm-10">
                  <input name="address1" class="form-control" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Address 2</label>
                <div class="form-group col-sm-10">
                  <input name="address2" class="form-control" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Postal Code</label>
                <div class="form-group col-sm-2">
                  <select id="codePostal" name="postalCode" class="form-select select2" aria-label="Default select example">
                    <option selected=""></option>
                    @foreach($postalCodes as $supp)
                    <option iLocation="{{ $supp->location }}" value="{{ $supp->postalCode }}">{{ $supp->postalCode }}</option>
                    @endforeach
                  </select>
                </div>
                <label for="example-text-input" id="lbLocation" name="lbLocation" class="col-sm-8 col-form-label"></label>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Town</label>
                <div class="form-group col-sm-10">
                  <input name="town" class="form-control" type="text">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">NIF</label>
                <div class="form-group col-sm-10">
                  <input name="nif" class="form-control" type="text">
                </div>
              </div>
              <!-- end row -->

              <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Postal Code">
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
    // Atualizar o label de localização baseado no código postal selecionado
    $("#codePostal").change(function() {
      $("#lbLocation").text(""); // Limpar o texto do label
      $("#lbLocation").text($("#codePostal option:selected").attr("iLocation"));
    });

    // Validação do formulário
    $('#myForm').validate({
      rules: {
        code: {
          required: true,
        },
        name: {
          required: true,
        },
        address1: {
          required: true,
        },
        postalCode: {
          required: true,
        },
      },
      messages: {
        code: {
          required: 'Please Enter Supplier Code.',
        },
        name: {
          required: 'Please Enter Supplier Name.',
        },
        address1: {
          required: 'Please Enter Supplier address.',
        },
        postalCode: {
          required: 'Please Enter Supplier Postal Code.',
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
@endsection