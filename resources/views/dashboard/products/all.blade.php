@extends('layouts.app')
@section('headJS')
<script src="{{ asset('js/Sortable.min.js') }}"></script>
@stop
@section('title', 'All Product')
@section('content')
<div class="nk-block-head mt-7">
  <div class="row">
    <div class="col-6 d-flex align-items-center">
      <div class="nk-block-head-content">
         <h3 class="nk-block-title fw-normal">{{ __('Products') }} <span class="badge badge-dim badge-primary badge-pill">{{ count($products) }}</span></h3>
      </div>
    </div>
    <div class="col-6">
      <div class="nk-block-head-content mb-3">
         <div class="nk-block-tools justify-content-right">
              <a href="{{ route('user-add-product') }}" class="btn ml-auto btn-primary btn-lg">{{ __('Add new product') }}</a>
         </div>
      </div>
    </div>
  </div>
</div>
<div class="mt-3">
  <div class="row sortable-div" data-handle=".item-handle" data-route="{{ route('user-products-sortable') }}">
    @foreach ($products as $item)
    <div class="col-md-4 sortable-item" data-id="{{$item->id}}">
       <div class="card card-shadow bdrs-20 product-card mb-5">
          <div class="card-body">
             <div class="d-flex align-items-center">
                <div class="product-img">
                   <img class="bdrs-20" src="{{ getfirstproductimg($item->id) }}" alt=" ">
                </div>
                <div class="d-flex flex-column mr-auto">
                   <div class="d-flex flex-column mr-auto">
                      <a href="#" class="text-dark text-hover-primary font-size-h4 font-weight-bolder mb-1">{{ $item->title }}</a>
                      <span class="text-muted font-weight-bold">{{ __('Price - ') }} {{ number_format(!empty($item->salePrice) ? $item->salePrice : $item->price) }} <small class="btn-warning p-1" {{ !empty($item->salePrice) ? '' : 'hidden' }}>{{ __('on sale') }}</small> {{ __('Stock') }} - {{ number_format($item->stock) }}</span>
                   </div>
                </div>
             </div>
             <div class="mb-10 mt-3 font-weight-bold">{{ Str::limit(clean($item->description, 'clean_all'), $limit = 100, $end = '...') }}</div>
          </div>
          <div class="p-3 bdrs-20 bg-white border-top d-flex align-items-center between-center">
           <div class="d-flex">
              <a href="{{ route('user-edit-product', $item->id) }}" class="text-muted d-flex ml-2"><em class="icon ni ni-edit lead mr-1"></em> {{ __('Edit') }}</a>
           </div>
           <div class="d-flex">
              <a href="#" class="text-muted item-handle ml-2 d-flex"><em class="icon ni ni-move lead mr-1"></em></a>
           </div>
           <div class="d-flex">
            <form action="{{ route('user-post-product', 'delete') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">
                <button data-confirm="{{ __('Are you sure you want to delete this?') }}" class="text-danger ml-2 d-flex bg-transparent align-items-center border-0"><em class="icon ni ni-edit lead mr-1"></em>{{ __('Delete') }}</button>
            </form>
           </div>
          </div>
       </div>
    </div>
    @endforeach
  </div>
</div>
@stop

