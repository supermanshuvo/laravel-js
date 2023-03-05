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
                    ->select('products.id', 'products.title', 'products.description', 'product_variants.variant', 'product_variant_prices.price', 'product_variant_prices.stock')
                    ->get();
//        $products = DB::table('products')
//            ->join('product_variant_prices', 'product_variant_prices.product_id', '=', 'products.id')
//            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
//            ->select('products.id', 'products.title', 'products.description', 'product_variants.variant', 'product_variant_prices.price', 'product_variant_prices.stock')
////            ->when($title, function($query, $title) {
////                return $query->where('products.title', 'like', '%'.$title.'%');
////            })
////            ->orWhere('product_variants.variant', 'like', '%'.$variant.'%')
////            ->orWhereBetween('product_variant_prices.price', [$price_to, $price_from])
////            ->whereDate('products.created_at', '=', $date)
//            ->get()
//            ->groupBy('id')
//            ->map(function ($item) use ($title) {
//                if($title && $item[0]->title !== $title){
//                    return null;
//                }
//                return [
//                    'title' => $item[0]->title,
//                    'description' => $item[0]->description,
//                    'variants' => $item->pluck('variant')->toArray(),
//                    'prices' => $item->pluck('price')->toArray(),
//                    'stock' => $item->pluck('stock')->toArray(),
//                ];
//            })
//            ->filter()
//            ->values()
//            ->toArray();
        dd($products);
//        return view('products.index',['products' => $products]);
    }
}
