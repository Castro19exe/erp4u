@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Family</h4>
                        <form method="post" action="{{ route('family.update') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $family->id }}">
                            <div class="mb-3">
                                <label for="family" class="form-label">Family Name</label>
                                <input type="text" name="family" class="form-control" id="family" value="{{ $family->family }}" required>
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