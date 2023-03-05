<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $options = array();
        $results = DB::table('variants')
            ->join('product_variants', 'product_variants.variant_id', '=', 'variants.id')
            ->select('variants.title', 'product_variants.variant')
            ->distinct()
            ->get();

        foreach ($results as $row) {
            $title = $row->title;
            $variant = $row->variant;

            if (!array_key_exists($title, $options)) {
                $options[$title] = array();
            }

            $options[$title][] = $variant;
        }

        $products = DB::table('products')->paginate(2);
        return view('products.index',['products' => $products],compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Search the specific resource from database.
     */
    public function filter(Request $request){
//        $colors = DB::table('product_variants')
//            ->select('variant')
//            ->distinct()
//            ->where('variant_id', '=', 1)
//            ->get();
//        $sizes = DB::table('product_variants')
//            ->select('variant')
//            ->distinct()
//            ->where('variant_id', '=', 2)
//            ->get();
//        $styles = DB::table('product_variants')
//            ->select('variant')
//            ->distinct()
//            ->where('variant_id', '=', 6)
//            ->get();
//         $option = DB::table('variants')
//            ->join('product_variants', 'product_variants.variant_id', '=', 'variants.id')
//            ->select('variants.title', 'product_variants.variant')
//            ->distinct()
//            ->get();
        $products = DB::table('products');
//        if($request->title != null){
//            $products = $products->where('title','Like','%'.$request->title.'%');
//        }
//
//        $products = $products->join('product_variant_prices', 'products.id', '=', 'product_variant_prices.product_id')
//                            ->join('product_variants', 'product_variant_prices.product_variant_one', '=', 'product_variants.variant_id')
//                            ->select('products.id', 'products.title', 'products.description', 'product_variant_prices.price', 'product_variant_prices.stock', 'product_variants.variant')
//                            ->distinct()
//                            ->get();
        $options = array();

        $results = DB::table('variants')
            ->join('product_variants', 'product_variants.variant_id', '=', 'variants.id')
            ->select('variants.title', 'product_variants.variant')
            ->distinct()
            ->get();

        foreach ($results as $row) {
            $title = $row->title;
            $variant = $row->variant;

            if (!array_key_exists($title, $options)) {
                $options[$title] = array();
            }

            $options[$title][] = $variant;
        }
        dd($options);
//        return view('products.index',['products' => $products]);
    }
}
