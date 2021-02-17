@extends('layouts.app')
  @section('title', __('All pages'))
    @section('content')
    <link href="{{ url('font/css/all.css') }}" rel="stylesheet">
    <!-- START COUNTER -->
    <section class="section bg-white pt-5" style="margin-top: 10em;">
        <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('all-pages') }}">{{ __('Pages') }}</a></li>
          </ol>
        </nav>
       <h4 class="bold mb-4 mt-5">{{ __('Popular pages') }}</h4>
       <div class="row">
        @foreach ($popular_pages as $item)
            <div class="col-12 col-md-6 mb-4">
                <div class="d-flex align-items-baseline card p-2 card-bordered">
                    <a href="{{$item->type == 'internal' ? url('page/' . $item->url) : $item->url}}" target="{{ $item->type == 'internal' ? '_self' : '_blank' }}" class="h5 mr-1">{{ucfirst($item->title)}}</a>
                     @if ($item->type == 'internal')
                       <small class="text-muted">({{$item->total_views}} <b>{{ __('views') }}</b>)</small>
                       @else
                         <a class="text-muted" href="{{$item->type == 'internal' ? url('page/' . $item->url) : $item->url}}" target="{{ $item->type == 'internal' ? '_self' : '_blank' }}">{{ __('View page') }}</a>
                     @endif
                </div>
            </div>
        @endforeach
       </div>
        <h2 class="bold text-dark mb-2">{{ __('Pages categories') }}</h2>
          <div class="row mt-1">
            @foreach ($pages as $item)
              <div class="col-12 col-md-4">
                  <div class="counter-box mt-4">
                      <div class="media shadow-big bg-white p-5 rounded">
                          <div class="media-body pl-2">
                              <div class="counter-icon mr-3">
                                  <i class="{{$item->icon}} text-primary h2"></i>
                              </div>
                              <h5 class="mt-2 mb-0 f-17">{{$item->title}}</h5>
                              <p class="text-muted mb-0 mt-2 f-15">{{$item->description}}</p>
                              <p class="text-muted mb-0 mt-2 f-15">{{$item->count_pages}} {{ __('Total pages') }}</p>
                              <a href="{{ url(route('all-pages') . '/' . $item->url) }}" class="btn btn-link pl-0">{{ __('View pages') }}</a>
                          </div>
                      </div>
                  </div>
              </div>
            @endforeach
          </div>
        </div>
    </section>

@stop