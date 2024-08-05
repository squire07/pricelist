@extends('adminlte::page')

@section('title', 'Customers')

@section('content')
<div class="container">
        <h1>Product Catalog</h1>
        {{-- <form action="{{ route('product.filter') }}" method="GET">
            <select name="category" onchange="this.form.submit()">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form> --}}

        @if($products->isEmpty())
            <p>No products available in this category.</p>
        @else
            @foreach($products as $product)
                <div>
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    <a href="{{ route('product.details', ['id' => $product->id]) }}" class="btn-details">View Details</a>
                </div>
            @endforeach
        @endif
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product-image {
            width: 100%;
            max-width: 300px;
            border-radius: 8px;
        }
        .btn-details {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-details:hover {
            background-color: #0056b3;
        }
        select {
            margin: 20px 0;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
@stop