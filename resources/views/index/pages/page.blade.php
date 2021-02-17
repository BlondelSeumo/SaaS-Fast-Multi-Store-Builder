@extends('layouts.app')
  @section('title', ucfirst($page->title))
    @section('content')
     <link href="{{ url('font/css/all.css') }}" rel="stylesheet">
    <!-- START COUNTER -->
    <section class="section bg-white pt-5 mt-10em">
        <div class="container wild-lg">
             <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all-pages') }}">{{ __('Pages') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url((!empty($category->url) ? route('all-pages') . '/' . $category->url : route('all-pages'))) }}">{{!empty($category->title) ? ucfirst($category->title) : 'Pages categories'}}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a>{{ucfirst($page->title)}}</a></li>
              </ol>
            </nav>
            <div class="d-flex justify-center mt-4 w-100">
                    <div class="card card-shadow card-inner bdrs-20 w-100">
                     @if (file_exists(public_path('img/pages/' . $page->image)))
                      <div class="card card-shadow card-inner bdrs-20 mb-5">
                         <img class="h-45 object-fit-cover bdrs-20" src="{{ url('img/pages/' . $page->image) }}" alt=" ">
                      </div>
                      @endif
                     <h5 class="bold text-dark border-bottom">{{ucfirst($page->title)}}</h5>
                     <p>{!! clean((!empty($page->settings->sh_description) ? $page->settings->sh_description : ""), 'titles') !!}</p>
                     <p class="mt-3">{!! clean((!empty($page->settings->content) ? $page->settings->content : ""), 'titles') !!}</p>
                     <small class="mt-5">{{ __('Updated on') }} {{ Carbon\Carbon::parse($page->edited_on)->toFormattedDateString() }}</small>
                    </div>
            </div>
        </div>
    </section>
@stop