@extends('layouts.app')
  @section('title', ucfirst($category->title))
    @section('content')
    <link href="{{ url('font/css/all.css') }}" rel="stylesheet">
    <!-- START COUNTER -->
    <section class="section bg-white pt-5 mt-10em">
        <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all-pages') }}">{{ __('Pages') }}</a></li>
            <li class="breadcrumb-item" aria-current="page"><a>{{ucfirst($category->title)}}</a></li>
          </ol>
        </nav>
        <h2 class="bold text-dark">{{ucfirst($category->title)}}</h2>
          <div class="row mt-1">
            @foreach ($pages as $item)
            @php
              $item->settings = json_decode($item->settings);
            @endphp
              <div class="col-12 col-md-6">
                  <div class="counter-box mt-4">
                      <div class="media card-shadow bdrs-20 bg-white p-5">
                          <div class="media-body pl-2">
                            <div class="row">
                              @if (file_exists(public_path('img/pages/' . $item->image)))
                              <div class="col-md-6">
                                <div class="counter-icon mr-3 pages">
                                     <img src="{{ url('img/pages/' . $item->image) }}" alt=" ">
                                </div>
                              </div>
                              @endif
                              <div class="col-md-6">
                                  <h5 class="mt-2 mb-0 f-17">{{$item->title}}</h5>
                                  <p class="text-muted mb-0 mt-2 f-15">{!! clean((!empty($item->settings->sh_description) ? $item->settings->sh_description : ""), 'titles') !!}</p>
                                  @if ($item->type == 'internal')
                                    <p class="text-muted">({{$item->total_views}} <b>{{ __('views') }}</b>)</p>
                                  @endif

                                  <a href="{{$item->type == 'internal' ? url('page/' . $item->url) : $item->url}}" target="{{ $item->type == 'internal' ? '_self' : '_blank' }}" class="btn btn-link pl-0">{{ __('View pages') }}</a>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
            @endforeach
          </div>
        </div>
    </section>

@stop