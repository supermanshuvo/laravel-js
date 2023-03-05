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
                    <p style="display: none">{{ $count = $products->firstItem() }}</p>
                    @foreach($products as $product)
                        <tr class="font-weight-lighter">
                            <td>{{ $count }}</td>
                            <td>{{ $product->title }} <br> Created at : <br> {{$product->created_at}}</td>
                            <td>{{$product->description}}</td>
                            <td>
                                <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant-{{ $count }}">
                                    @foreach($product_variants as $variant)
                                        @if($variant->product_id == $product->id)
                                            <dt class="col-sm-3 pb-0">{{ $variant->variant }}</dt>
                                            <dd class="col-sm-9">
                                                <dl class="row mb-0">
                                                    @foreach($product_variant_prices as $product_variant_price)
                                                        @if($product_variant_price->product_id == $product->id)
                                                            <dt class="col-sm-4 pb-0">Price : {{ number_format($product_variant_price->price ?? 0,2) }}</dt>
                                                            <dd class="col-sm-8 pb-0">InStock : {{ number_format($product_variant_price->stock ?? 0,2) }}</dd>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </dl>
                                            </dd>
                                        @endif
                                    @endforeach
                                </dl>
                                <button onclick="$('#variant-{{ $product->id }}').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <p style="display: none">{{ $count++ }}</p>
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
