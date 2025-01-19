@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Unit Measure</h4>
                        <form method="post" action="{{ route('unitMeasure.update', $unitMeasure->id) }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $unitMeasure->id }}">
                            <div class="mb-3">
                                <label for="unitMeasure" class="form-label">UnitMeasure Name</label>
                                <input type="text" name="unitMeasure" class="form-control" id="unitMeasure" value="{{ $unitMeasure->unit }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
