<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Show add product page
     */
    public function showAddProductPage()
    {
        return Inertia::render('Master/AddProduct');
    }

    /**
     * Show product list page
     */
    public function showManageProductPage()
    {
        $products = Products::orderBy('id')->get();

        return Inertia::render('Master/ManageProduct', [
            'products' => $products,
        ]);
    }

    /**
     * Show product list page
     */
    public function getProductList(Request $request)
    {
        $products = Products::orderBy('id')->get();
        if (! empty($request->searchBy)) {
            $products = Products::orderBy('id')->where($request->type ?? 'sku', 'LIKE', '%'.$request->searchBy.'%')
                ->orderBy('id')->get();
        }

        return response()->json(['success' => [
            'products' => $products,
        ]]);
    }

    /**
     * Edit  Product
     *
     */
    public function editProduct(Products $product, Request $request)
    {
        return Inertia::render('Master/AddProduct', [
            'product' => $product
        ]);
    }

    /**
     * Delete product
     */
    public function deleteProduct(Products $product, Request $request)
    {
        $product->delete();

        return redirect('master/manage-product');
    }

    /**
     * Save new product
     */
    public function createOrUpdateProduct(Request $request)
    {
        if ($request->edit && $request->id) {
            Products::where('id', $request->id)->update([
                'sku' => $request->sku,
                'stone_name' => $request->stone_name,
                'shape' => $request->shape,
                'size' => $request->size,
                'piece' => $request->piece,
                'gross_weight' => $request->gross_weight,
                's_w' => $request->s_w,
                'line' => $request->line,
                'net_weight' => $request->net_weight,
                'price' => $request->price,
                'color' => $request->color,
                'description' => $request->description,
            ]);
        } else {
            Products::create([
                'sku' => $request->sku,
                'stone_name' => $request->stone_name,
                'shape' => $request->shape,
                'size' => $request->size,
                'piece' => $request->piece,
                'gross_weight' => $request->gross_weight,
                's_w' => $request->s_w,
                'line' => $request->line,
                'net_weight' => $request->net_weight,
                'price' => $request->price,
                'color' => $request->color,
                'description' => $request->description,
            ]);
        }

        return redirect('master/add-product')->with('success', 'Product added');
    }
    public function viewProductInvoice(int $id) {
        // dd($id);
        $order = Products::find($id);
        // echo "<pre>";
        // print_r($order);
        // echo "</pre>";
        // die;
        return view("invoice.generate-product-invoice",compact('order'));
    }
    public function generateProductInvoice($id) {
        $order = Products::find($id);
        $pdf = PDF::loadView('invoice.generate-dealer-invoice', compact('order'));

    // Return the PDF as a download
    return $pdf->download('invoice'.$order->id.'.pdf');
    }
}
