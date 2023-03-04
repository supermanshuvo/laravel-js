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
        $products = DB::table('products')->paginate(2);
        return view('products.index',['products' => $products]);
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
        // Get the filter values from the request
        $title = $request->input('title');
        $variant = $request->input('variant');
        $minPrice = $request->input('price_from');
        $maxPrice = $request->input('price_to');
        $date = $request->input('date');

        echo $title,$variant,$minPrice,$maxPrice,$date;
        /*$products = DB::table('products')
            ->select('products.*', 'product_variants.name as variant_name', 'product_price.price')
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_price', 'product_variants.id', '=', 'product_price.product_variant_id')
            ->where(function ($query) use ($title, $variant) {
                if ($title) {
                    $query->where('products.title', 'like', '%'.$title.'%');
                }

                if ($variant) {
                    $query->where('product_variants.name', 'like', '%'.$variant.'%');
                }
            })
            ->whereDate('created_at', $date)
            ->when($minPrice, function ($query, $minPrice) {
                return $query->where('product_price.price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                return $query->where('product_price.price', '<=', $maxPrice);
            })
            ->groupBy('products.id')
            ->get();*/
//        return view('products.index');
    }
}
