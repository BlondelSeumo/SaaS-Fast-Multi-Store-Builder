@extends('layouts.app')
@section('content')
      <div class="section pt-8 px-3">
        <div class="container">
           <div class="mx-auto text-center">
              <h2>{{ __('Latest Posts') }}</h2>
              <p>{{ __('See more from our blog') }}</p>
           </div>
          <div class="portfolio-title-outside row spacing-40 mt-5">
                 @foreach (store_blogs($uid, 3) as $item)
                    @include('include.blog-item', ['item' => $item])
            @endforeach
          </div>
        </div><!-- end container -->
      </div>
@endsection
