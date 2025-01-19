<?php

namespace App\Http\Controllers\Actl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseOrderC;
use App\Models\PurchaseOrderD;
use App\Models\Product;
use App\Models\Family;
use App\Models\TaxRate;
use App\Models\UnitMeasure;
use App\Models\Supplier;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Exception;

class PurchaseOrderController extends Controller
{
    public function PurchaseOrderAll() {
        $purchaseOrderC = PurchaseOrderC::join('supplier', 'purchaseorderc.supplierCode', '=', 'supplier.code')
                                        ->select('purchaseorderc.*', 'supplier.name as supplier_name')
                                        ->latest('purchaseorderc.created_at')
                                        ->get();

        $purchaseOrderD = PurchaseOrderD::latest()->get();

        return view('backend.purchaseOrder.purchaseOrder_all', 
        compact('purchaseOrderC', 'purchaseOrderD'));
    }

    public function PurchaseOrderAdd() {
        $nextPurchaseOrderC = PurchaseOrderC::latest()->value('pONumber') + 1;
        $products = Product::latest()->get();
        $families = Family::latest()->get();
        $unitMeasures = UnitMeasure::latest()->get();
        $taxRates = TaxRate::latest()->get();
        $suppliers = Supplier::latest()->get();

        return view ('backend.purchaseOrder.purchaseOrder_add', 
        compact('nextPurchaseOrderC', 'families', 'unitMeasures', 'taxRates', 'products', 'suppliers'));
    }

    public function PurchaseOrderStore(Request $request) {
        PurchaseOrderC::insert([
            'discount' => $request->discount ?? 0,
            'pODate' => $request->date,
            'pONumber' => $request->pONumber,
            'pOObservation' => $request->observation,
            'status' => 1,
            'supplierCode' => $request->supplier,
            'total' => 0,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $products = $request->input('products', []);

        if (!is_array($products) || empty($products)) {
            return redirect()->back()->withErrors(['products' => 'No products added.']);
        }
        foreach ($products as $product) {
            PurchaseOrderD::insert([
                'deliveredQuantity' => 2, // valores para teste
                'discountPercent' => 2,   // valores para teste
                'pODateDelivery' => Carbon::now(),
                'pONumber' => $request->pONumber,
                'productCode' => $product['code'],
                'productFamily' => $request->family,
                'productUnit' => $product['unit'],
                'quantity' => $product['stock'],
                'sellingPrice' => $product['price'],
                'status' => 1,
                'taxRateCode' => $product['taxRateCode'],
                'unitPrice' => $product['price'],
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
        }

        $result = PurchaseOrderD::where('purchaseorderd.pONumber', $request->pONumber)
                                ->selectRaw('SUM(quantity * unitPrice) as subtotal')
                                ->value('subtotal');

        $discount = PurchaseOrderC::where('pONumber', $request->pONumber)
            ->value('discount');

        $totalPrice = $result - $discount;

        PurchaseOrderC::where('pONumber', $request->pONumber)->where('status', 1)->update([
            'total' => $totalPrice,
        ]);

        $notification = array(
            'message'    => 'Purchase made with success.',
            'alert-type' => 'success'
        );  

        return redirect()->route('purchaseOrder.all')->with($notification);
    }

    public function PurchaseOrderEdit($pONumber) {
        $purchaseOrderDetails = PurchaseOrderD::where('pONumber', $pONumber)->get();

        $products = Product::latest()->get();
        $families = Family::all();
        $unitMeasures = UnitMeasure::latest()->get();
        $taxRates = TaxRate::latest()->get();
        $suppliers = Supplier::latest()->get();

        $pOC = PurchaseOrderC::findOrFail($pONumber);
        $pOD = PurchaseOrderD::where('pONumber', $pONumber)
                             ->where('purchaseOrderD.status', 1)
                             ->join('product', 'purchaseorderd.productCode', '=', 'product.code')
                             ->join('taxrate', 'product.taxRateCode', '=', 'taxrate.taxRateCode')
                             ->select('purchaseorderd.*', 'product.description', 'taxrate.taxRate')
                             ->orderBy('purchaseorderd.id', 'asc')
                             ->get();

        return view('backend.purchaseOrder.purchaseOrder_edit', 
        compact('families', 'unitMeasures', 'taxRates', 'products', 'suppliers', 'pOC', 'pOD'));
    }

    public function PurchaseOrderUpdate(Request $request) {
        $pOC = $request->pONumber;
        $products = $request->input('products', []);

        try {
            PurchaseOrderC::findOrFail($pOC)->update([
                'discount' => $request->discount ?? 0,
                'pODate' => $request->date,
                'pOObservation' => $request->observation,
                'supplierCode' => $request->supplier,
                'total' => $request->totalPrice ?? 0,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            
            if (!empty($products)) {
                foreach ($products as $product) {
                    PurchaseOrderD::insert([
                        'deliveredQuantity' => 2, // valores para teste
                        'discountPercent' => 2,   // valores para teste
                        'pODateDelivery' => Carbon::now(),
                        'pONumber' => $pOC,
                        'productCode' => $product['code'],
                        'productFamily' => $request->family,
                        'productUnit' => $product['unit'],
                        'quantity' => $product['stock'],
                        'sellingPrice' => 100,
                        'status' => 1,
                        'taxRateCode' => $product['taxRateCode'],
                        'unitPrice' => $product['price'],
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
            $quantities = $request->input('quantity', []); // Array de quantidades
            $unitPrices = $request->input('unitPrice', []); // Array de preços unitários

            foreach ($quantities as $id => $quantity) {
                $unitPrice = $unitPrices[$id] ?? 0; // Obtém o preço correspondente ao mesmo ID

                PurchaseOrderD::where('id', $id)->where('status', 1)->update([
                    'quantity' => $quantity,
                    'unitPrice' => $unitPrice,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now(),
                ]);
            }

            $result = PurchaseOrderD::where('purchaseorderd.pONumber', $request->pONumber)
                                ->selectRaw('SUM(quantity * unitPrice) as subtotal')
                                ->value('subtotal');

            $discount = PurchaseOrderC::where('pONumber', $request->pONumber)
                                        ->value('discount');

            $totalPrice = $result - $discount;

            if($totalPrice < 0)
                $totalPrice = 0;

            PurchaseOrderC::where('pONumber', $request->pONumber)->where('status', 1)->update([
                'total' => $totalPrice,
            ]);
        }
        catch (Exception $e) {
            $notification = [
                'message' => 'Product Updated Unsuccessfully. ', //.  $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $notification = array(
            'message'    => 'Purchase Edited Successfully.',
            'alert-type' => 'success'
        );  

        return redirect()->route('purchaseOrder.all')->with($notification);
    }

    public function PurchaseOrderCDisable($pONumber) {
        $activeOrInactive = PurchaseOrderC::where('pONumber', $pONumber)->value('status');

        try {
            if($activeOrInactive == 1) {
                PurchaseOrderC::findOrFail($pONumber)->update([
                    'status' => 0,
                ]);
    
                $notification = [
                'message' => 'Order Disabled Successfully.',
                'alert-type' => 'success',];
    
                return redirect()->back()->with($notification);
            }
            else {
                PurchaseOrderC::findOrFail($pONumber)->update([
                    'status' => 1,
                ]);
    
                $notification = [
                'message' => 'Order Enabled Successfully.',
                'alert-type' => 'success',];
    
                return redirect()->back()->with($notification);
            }
        }
        catch (Exception $e) {
            $notification = [
            'message' => 'Order Disabled Unsuccessfully. ' . $e->getMessage(),
            'alert-type' => 'error',];

            return redirect()->back()->with($notification);
        }
    }

    public function PurchaseOrderCDelete($id) {
        $pOC = PurchaseOrderC::findOrFail($id);

        try {
            $pOC->delete();
        }
        catch (Exception $e) {
            $notification = [
            'message' => 'Order Deleted Unsuccessfully. ' . $e->getMessage(),
            'alert-type' => 'error',];

            return redirect()->back()->with($notification);
        }
    }

    public function PurchaseOrderDDelete($id) {
        $pOD = PurchaseOrderD::findOrFail($id);
        $pODNumber = PurchaseOrderD::where('purchaseorderd.id', $id)
                                    ->select('pONumber')
                                    ->value('pONumber');

        try {
            $pOD->delete();

            $result = PurchaseOrderD::where('purchaseorderd.pONumber', $pODNumber)
                                    ->selectRaw('SUM(quantity * unitPrice) as subtotal')
                                    ->value('subtotal');

            $discount = PurchaseOrderC::where('pONumber', $pODNumber)
                                       ->value('discount');

            $totalPrice = $result - $discount;

            if($totalPrice < 0)
                $totalPrice = 0;

            PurchaseOrderC::where('pONumber', $pODNumber)->where('status', 1)->update([
                'total' => $totalPrice,
            ]);

            $notification = [
                'message' => 'Product Removed Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        }
        catch (Exception $e) {
            $notification = [
            'message' => 'Product Deleted Unsuccessfully. ' . $e->getMessage(),
            'alert-type' => 'error',];

            return redirect()->back()->with($notification);
        }
    }
}
