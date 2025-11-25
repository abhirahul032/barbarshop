@extends('store.layouts.app')
@section('title','View Product')
@section('content')

<div class="d-flex justify-content-between mb-3">
  <h3>{{ $product->name }}</h3>
  <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit</a>
</div>

<div class="row">

  {{-- LEFT SIDE --}}
  <div class="col-md-8">

    {{-- BASIC INFO --}}
    <div class="card mb-3">
      <div class="card-header">Basic info</div>
      <div class="card-body">

        <p><strong>Product name:</strong> {{ $product->name }}</p>
        <p><strong>Barcode:</strong> {{ $product->barcode ?? '—' }}</p>
        <p><strong>Brand:</strong> {{ $product->brand->name ?? '—' }}</p>
        <p><strong>Measure:</strong> 
          {{ $product->measure_amount ?? '' }} {{ $product->measure_unit ?? '' }}
        </p>

        <p><strong>Short description:</strong><br>
          {{ $product->short_description ?? '—' }}</p>

        <p><strong>Description:</strong><br>
          {!! nl2br(e($product->description)) ?? '—' !!}
        </p>

        <p><strong>Category:</strong>
          {{ $product->category->name ?? '—' }}</p>

      </div>
    </div>

    {{-- PRICING --}}
    <div class="card mb-3">
      <div class="card-header">Pricing</div>
      <div class="card-body">

        <p><strong>Supply price:</strong> ?{{ number_format($product->supply_price,2) }}</p>
        <p><strong>Retail price:</strong> ?{{ number_format($product->retail_price,2) }}</p>
        <p><strong>Markup:</strong> {{ $product->markup_percent }}%</p>

        <p><strong>Commission enabled:</strong>
          {{ $product->team_commission_enabled ? 'Yes' : 'No' }}
        </p>

      </div>
    </div>

    {{-- INVENTORY --}}
    <div class="card mb-3">
      <div class="card-header">Inventory</div>
      <div class="card-body">

        <p><strong>SKU:</strong> {{ $product->sku }}</p>

        <p><strong>Supplier:</strong>
          {{ $product->supplier->name ?? '—' }}</p>

        <p><strong>Track stock:</strong>
          {{ $product->track_stock ? 'Yes' : 'No' }}</p>

        @if($product->track_stock)
          <p><strong>Stock quantity:</strong> {{ $product->stock_quantity }}</p>
          <p><strong>Low stock level:</strong> {{ $product->low_stock_level ?? '0' }}</p>
          <p><strong>Reorder quantity:</strong> {{ $product->reorder_quantity ?? '0' }}</p>
          <p><strong>Low stock notifications:</strong>
            {{ $product->low_stock_notifications ? 'Enabled' : 'Disabled' }}
          </p>
        @endif

      </div>
    </div>

  </div>

  {{-- RIGHT SIDE --}}
  <div class="col-md-4">

    <div class="card mb-3">
      <div class="card-header">Product photos</div>
      <div class="card-body">
        @if($product->images->count())
          @foreach($product->images as $img)
            <img src="{{ asset('storage/'.$img->path) }}" class="img-fluid mb-3 rounded" />
          @endforeach
        @else
          <p>No photos uploaded.</p>
        @endif
      </div>
    </div>

  </div>

</div>

@endsection
