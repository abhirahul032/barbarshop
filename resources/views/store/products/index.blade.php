@extends('store.layouts.app')
@section('title','Products')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Products</h3>
  <a href="{{ route('store.products.create') }}" class="btn btn-primary">Add Product</a>
</div>
 @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<table class="table table-striped">
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>SKU</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Store</th>
      <th>Supplier</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $p)
    <tr>
      <td style="width:80px;">
        @if($p->images->first())
          <img src="{{ asset('storage/'.$p->images->first()->path) }}" class="img-fluid" alt="" />
        @endif
      </td>
      <td>{{ $p->name }}</td>
      <td>{{ $p->sku }}</td>
      <td>{{ number_format($p->retail_price,2) }}</td>
      <td>
        @if($p->track_stock)
          {{ $p->stock_quantity }}
        @else
          -
        @endif
      </td>
      <td>{{ $p->store_id }}</td>
      <td>{{ $p->supplier?->name }}</td>
      <td class="text-end">
        <a href="{{ route('store.products.show', $p) }}" class="btn btn-sm btn-outline-primary">View</a>
        <a href="{{ route('store.products.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Edit</a>

        <form action="{{ route('store.products.destroy', $p) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Delete product?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $products->links() }}
@endsection
