<?php

namespace App\Http\Controllers\Actl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PostalCode;
use App\Models\Supplier;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SupplierController extends Controller
{
    public function SupplierAll()
    {
        // $suppliers = Supplier::all();
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));
    }

    public function SupplierAdd()
    {
        $postalCodes = PostalCode::all();
        return view('backend.supplier.supplier_add', compact('postalCodes'));
    }

    public function SupplierStore(Request $request)
    {
        Supplier::insert([
            'code'       => $request->code,
            'name'       => $request->name,
            'address1'   => $request->address1,
            'address2'   => $request->address2,
            'postalCode' => $request->postalCode,
            'nif'        => $request->nif,
            'town'       => $request->town,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message'    => 'Supplier Inserted Successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function SupplierEdit($id)
    {
        $postalCodes = PostalCode::all();
        $supplier = Supplier::findOrFail($id);

        return view('backend.supplier.supplier_edit', compact('postalCodes', 'supplier'));
    }

    public function SupplierUpdate(Request $request)
    {
        $supplier_id = $request->id;

        Supplier::findOrFail($supplier_id)->update([
            'code'       => $request->code,
            'name'       => $request->name,
            'address1'   => $request->address1,
            'address2'   => $request->address2,
            'postalCode' => $request->postalCode,
            'town'       => $request->town,
            'nif'        => $request->nif,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message'    => 'Supplier Updated Successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function SupplierDelete($id)
    {
        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message'    => 'Supplier Deleted Successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // AJAX 
    public function getSupplierName(Request $request) {
        $supplier = $request->input('supplier');

        $supplierName = Supplier::where('code', $supplier)->pluck('name')->first();

        return response()->json($supplierName);
    }
}
