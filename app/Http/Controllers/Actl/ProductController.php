<?php

namespace App\Http\Controllers\Actl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Family;
use App\Models\TaxRate;
use App\Models\UnitMeasure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProductController extends Controller {
    //
    public function ProductAll() {
        $products = Product::latest ()->get();
        return view('backend.product.product_all', compact('products'));
    }

    public function ProductAdd() {
        $families = Family::all();
        $unitMeasures = UnitMeasure::latest()->get() ;
        $taxRates = TaxRate::latest()->get();
        return view ('backend.product.product_add', compact('families','unitMeasures','taxRates' ) ) ;
    }

    public function ProductStore(Request $request) {
        if ($request->file('product_Image') ){
            // remover o ; do 'extension=gd' no php.ini
            // e depois fazer o "composer install"
            $manager = new ImageManager(new Driver());
            $transformName = hexdec(uniqid()).".".$request->file('product_Image')->getClientOriginalExtension();
            $img = $manager->read($request->file('product_Image'));
            $img = $img->resize(200,200);
            $img->toJpeg(80)->save(base_path('public/backend/assets/images/product/'.$transformName) );
            $save_url = '/backend/assets/images/product/'.$transformName;
        }

        try {
            $lastCode = Product::select(DB::raw('CAST(code AS UNSIGNED) as numeric_code'))
            ->orderBy('numeric_code', 'desc')
            ->pluck('numeric_code')
            ->first();

            $newCode = $lastCode + 1;

            Product::insert([
                'code' => $newCode,
                'name' => $request->name,
                'description' => $request->description,
                'family' => $request->family,
                'unit' => $request->unit ,
                'taxRateCode' => $request->taxRateCode,
                'image' => $save_url,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now( ),
            ]);

            $notification = array('message'=>'Product Inserted Successfuly.', 'alert-type'=> 'success');

            return redirect()->route('product.all')->with($notification);
        }
        catch (Exception $e) {
            dd($e);

            $notification = array('message'=>'Product Inserted Insuccessfuly. ','alert-type'=>'error');

            if (file_exists($save_url)) {
                unlink($save_url);
            }

            return redirect()->route('product.all')->with($notification);
        }
    }

    public function ProductEdit($id) {
        $families = Family::all();
        $unitMeasures = UnitMeasure::all();
        $taxRates = TaxRate::all();

        $product = Product::findOrFail($id);

        return view('backend.product.product_edit', compact('families','unitMeasures', 'taxRates' , 'product' ) ) ;
    }

    public function ProductUpdate(Request $request) {
        try {
            $product_id = $request->id;

            $product = Product::findOrFail($product_id);

            $oldImagePath = base_path('public' . $product->image); // Caminho completo da imagem antiga

            $manager = new ImageManager(new Driver());

            $save_url = $product->image; // Caso nenhuma nova imagem seja carregada, mantém a atual

            if ($request->file('profile_image')) {
                $transformName = hexdec(uniqid()) . "." . $request->file('profile_image')->getClientOriginalExtension();

                $img = $manager->read($request->file('profile_image'));
                $img = $img->resize(200,200);

                $newImagePath = base_path('public/backend/assets/images/product/' . $transformName);
                $img->save($newImagePath, 80);

                $save_url = '/backend/assets/images/product/' . $transformName;

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            Product::findOrFail($product_id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $save_url,
                'family' => $request->product_family,
                'unit' => $request->product_unit,
                'taxRateCode' => $request->taxRateCode_Product,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $notification = [
                'message' => 'Product Updated Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->route('product.all')->with($notification);
        } 
        catch (Exception $e) {
            dd($e->getMessage());
            $notification = [
                'message' => 'Product Updated Unsuccessfully. ' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->route('product.all')->with($notification);
        }
    }

    public function ProductDelete($id) {
        $product = Product::findOrFail($id);
        $imgPath = base_path('public' . $product->image); // Cria o caminho absoluto da imagem

        try {
            $product->delete();

            if (file_exists($imgPath)) {
                unlink($imgPath);

            }

            $notification = [
            'message' => 'Product Deleted Successfully.',
            'alert-type' => 'success',];

            return redirect()->back()->with($notification);
        }
        catch (Exception $e) {
            $notification = [
            'message' => 'Product Deleted Unsuccessfully. ' . $e->getMessage(),
            'alert-type' => 'error',];

            return redirect()->back()->with($notification);
        }
    }

    // AJAX 
    public function getProductsByFamily(Request $request) {
        $family = $request->input('family');

        $products = Product::where('family', $family)->get();

        return response()->json($products);
    }

    public function getProductsSelected(Request $request) {
        $productCode = $request->input('product');

        $product = Product::where('code', $productCode)
                            ->join('taxrate', 'product.taxRateCode', '=', 'taxrate.taxRateCode')
                            ->select('product.*', 'taxRate.taxRate')
                            ->first();

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}




