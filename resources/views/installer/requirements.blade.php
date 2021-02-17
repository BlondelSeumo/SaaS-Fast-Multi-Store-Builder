@extends('installer.layout')
@section('title', __('Install'))
@section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="container mt-7 mb-5">
     <img class="logo-img logo-img-lg mb-3 p-0 ml-0" src="{{ url('img/logo/logo.png') }}" alt="{{ config('app.name') }}">
     <h2>Requirements</h2>
     <p>Make sure everything is checked so that you do not run into problems.</p>
     <div class="row">
         <div class="col-md-6">
             <div class="d-flex w-100 p-2 bdrs-20 align-center p-0 bg-gray-200 mb-3 justify-around">
                 <p href=""></p>
                 <p class="m-0">Required</p>
                 <p href="">Current</p>
             </div>
            @foreach ($requirements as $key => $item)
             <div class="row card flex-row card-shadow bdrs-20 p-3 mt-3">
                 <div class="col-3">
                     <div>
                        <p class="m-0">{{ $key }}</p>
                     </div>
                 </div>
                 <div class="col-5">
                     <div>
                        <p class="m-0">{{ $item['message'] }}</p>
                     </div>
                 </div>
                 <div class="col-4">
                     <div>
                        <p class="m-0">{{ $item['current'] }}</p>
                     </div>
                 </div>
             </div>
            @endforeach
         </div>
         <div class="col-md-6">
             <div class="d-flex w-100 p-2 bdrs-20 align-center p-0 ml-3 bg-gray-200 mb-3 justify-around">
                 <p class="m-0">Path / File</p>
                 <p class="m-0">Status</p>
                 <p class="m-0"></p>
             </div>
            @foreach ($filesystem as $key => $item)
             <div class="row card flex-row card-shadow bdrs-20 p-3 ml-3 mt-3">
                 <div class="col-5">
                     <div>
                        <p class="m-0">{{ $item['dir'] }}</p>
                     </div>
                 </div>
                 <div class="col-3">
                     <div>
                        <p class="m-0">{{ $item['writable'] }}</p>
                     </div>
                 </div>
                 <div class="col-4">
                     <div>
                        <p class="m-0">{!! $item['message'] !!}</p>
                     </div>
                 </div>
             </div>
            @endforeach
         </div>
     </div>
     <div class="mt-5">
        @if ($pass)
         <a href="{{ request()->fullUrlWithQuery(['steps' => 'app']) }}" class="button w-100 primary">Next</a>
         @else
         <div class="alert alert-danger" role="alert">
            Please make sure all the requirements listed on the documentation and on this page are met before continuing!
        </div>
        @endif
     </div>
    </div>
@endsection
