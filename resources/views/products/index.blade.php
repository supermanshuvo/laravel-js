@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="{{ route('products.filter') }}" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        <option value="">Select a variant</option>
                        @foreach ($options as $title => $options_variants)
                            <optgroup label="{{ $title }}">
                                @foreach ($options_variants as $variant)
                                    <option value="{{ $variant }}">{{ $variant }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 15%">Title</th>
                        <th style="width: 25%">Description</th>
                        <th style="width: 40%">Variant</th>
                        <th style="width: 5%">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($products as $product)
                    <tr class="font-weight-lighter">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }} <br> Created at : <br> {{$product->created_at}}</td>
                        <td>{{$product->description}}</td>
                        <td>
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                <dt class="col-sm-3 pb-0">
{{--                                    @foreach($variants as $variant)--}}
{{--                                        @foreach($product_variants where product_variants.variant_id = )--}}
{{--                                        @endforeach--}}
{{--                                    @endforeach--}}
                                    SM/ Red/ V-Nick
                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
{{--                                        @foreach($product->product_variant_prices as $price)--}}
                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($product->price ?? 0,2) }}</dt>
                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($product->stock ?? 0,2) }}</dd>
{{--                                        @endforeach--}}
                                    </dl>
                                </dd>
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} out of {{ $products->total() }}</p>
                    {{ $products->links() }}
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

@endsection
