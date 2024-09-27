@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Products</h2>
        </div>
        <div class="pull-right d-flex align-items-center">
            @can('products-create')
            <a class="btn btn-success btn-sm mb-2 me-2" href="{{ route('products.create') }}"><i class="fa fa-plus"></i> Create New Product</a>
            @endcan
        </div>
    </div>
</div>

<div class="card-body p-0"> <!-- Removed padding -->
    <form method="GET" action="{{ route('products.index') }}" class="d-flex flex-wrap align-items-center">
        <div class="me-2 mb-1 flex-fill d-flex">
            <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Search products..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm ms-1"><i class="fa fa-search"></i></button>
        </div>
        
        <div class="me-2 mb-1 flex-fill">
            <select name="category" id="category" class="form-select form-select-sm" aria-label="Category Filter" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="me-2 mb-1 flex-fill">
            <select name="brand" id="brand" class="form-select form-select-sm" aria-label="Brand Filter" onchange="this.form.submit()">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="me-2 mb-1 d-flex flex-fill">
            <h6 class="me-2 mt-1">Start</h6>
            <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" onchange="this.form.submit()">
        </div>

        <div class="mb-1 d-flex flex-fill">
            <h6 class="me-2 mt-1">End</h6>
            <input type="date" name="end_date" id="end_date" class="form-control form-control-sm me-2" value="{{ request('end_date') }}" onchange="this.form.submit()">
        </div>

        <div class="mb-1 d-flex">
            <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='{{ route('products.index') }}'">Reset</button>
        </div>
    </form>
</div>

@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 6%;">ID</th> <!-- Changed header from "No" to "ID" -->
            <th style="width: 20%;">Name</th>
            <th style="width: 10%;">Price</th>
            <th style="width: 12%;">Discount Price</th>
            <th style="width: 12%;">Quantity in Stock</th>
            <th style="width: 10%;">Category</th>
            <th style="width: 10%;">Brand</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td> <!-- Display product ID -->
            <td>{{ $product->name }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>${{ number_format($product->discount_price, 2) }}</td>
            <td>{{ $product->quantity_in_stock }}</td>
            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
            <td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td>
            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    <a class="btn btn-info btn-sm" href="{{ route('products.show',$product->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                    @can('products-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit',$product->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')

                    @can('products-delete')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa-solid fa-trash"></i> Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $products->links('vendor.pagination.custom-pagination') !!}

@endsection
