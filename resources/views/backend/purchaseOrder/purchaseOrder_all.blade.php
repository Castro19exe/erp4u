@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Orders</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('purchaseOrder.add') }}" class="btn btn-secondary btn-rounded waves effect waves-light"
                        style="float: right;">Add Purchase Order</a>
                        <table id="datatable" class="table  table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>POL</th>
                                    <th>Supplier Name</th>
                                    <th>P.Order No</th>
                                    <th>Date</th>
                                    <th>Observation</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrderC as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->pONumber }}</td>
                                        <td>{{ $item->pODate }}</td>
                                        <td>{{ $item->pOObservation }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span>Active</span>
                                            @else
                                                <span>Inactive</span>
                                            @endif
                                        </td>
                                        <td class="btnActionBox">
                                            <a href="{{ route('purchaseOrder.edit', $item->pONumber) }}" 
                                            class="btn btn-info sm" title="Edit Data"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('purchaseOrderC.disable', $item->pONumber) }}" 
                                            class="btn btn-warning sm" title="Disable Order" id="delete"><i class="fas fa-exclamation-circle"></i></a>
                                            <a href="{{ route('purchaseOrderC.delete', $item->id) }}" class="btn btn-danger sm"
                                            title="Delete Data" id="delete"><i class="fas fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>
@endsection