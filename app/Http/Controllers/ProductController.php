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

        $product_variants = DB::table('product_variants');
        $variants = DB::table('variants');
        $products = DB::table('products')->paginate(2);
        return view('products.index',[
            'products' => $products,
            'options'=> $options,
            'product_variants' => $product_variants,
            'variants' => $variants
        ]);
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

        $products = DB::table('products');
        $products_variant = $request->variant;
        $products_price_from = $request->price_from;
        $products_price_to = $request->price_to;
        $products_date = $request->date;

        if($request->title != null){
            $products = $products->orWhere('products.title','Like','%'.$request->title);
        }

        $products = $products
            ->join('product_variant_prices', 'product_variant_prices.product_id', '=', 'products.id')
            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->select('products.id', 'products.title', 'products.created_at', 'products.description', 'product_variants.variant', 'product_variant_prices.price', 'product_variant_prices.stock')
            ->paginate(2);

        return view('products.index', [
            'products' => $products,
            'options' => $options
        ]);
    }
}
