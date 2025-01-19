@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Unit Measure</h4>
                        <form method="post" action="{{ route('unitMeasure.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="unitMeasure" class="form-label">UnitMeasure Name</label>
                                <input type="text" name="unitMeasure" class="form-control" id="unitMeasure" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
