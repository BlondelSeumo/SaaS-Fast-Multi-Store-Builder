@foreach ($users as $user)

@extends('profile.master')
 @section('title', ucfirst($user->name))
 @section('content')
        @section('content')
    <div class="container">
      <div class="row mt-5">
          <div class="col-12 col-md-5 form__cover">
              <div class="row">
                  <div class="col-12 col-sm-6 col-md-12">
                    <div class="container-fluid m-auto">
                      <div class="box-1 align-center">
                        <h2 class="heading-title mt-7rem shimmer shimmer-text">Success</h2>
                        <p class="heading-text shimmer shimmer-text w-100">Don’t see a position that fits you? No problem! we wanna hear from you, send us an email to: </p> 
                        </p>
                      </div>
                    </div>
                  </div>
              </div>
          </div>

          <div class="col-12 col-md-7 form__content">
              <section id="sec1">

                  <div class="container-fluid m-auto">
                    <ul class="table-careers">
                     <li class="head">
                       <span>Name</span>
                       <span>Qty</span>
                       <span>Price</span>
                       <span>Date</span>
                     </li>
                  @foreach ($success as $order)
                         @php $single = DB::table('products')->where('id', $order->product_id)->first(); @endphp
                        <li class="@if ($order->status == 2) bg-gradient-success @elseif($order->status == 1) bg-gradient-warning @else left-hero @endif">
                        <span class="position bold @if ($order->status == 2 || $order->status == 1) text-white @endif"> {{$single->name}}</span>
                        <span class="position bold @if ($order->status == 2 || $order->status == 1) text-white @endif"> {{$order->qty}}</span>
                        <span class="position bold @if ($order->status == 2 || $order->status == 1) text-white @endif">{{$single->price}}</span>
                        <span class="position bold @if ($order->status == 2 || $order->status == 1) text-white @endif">{{Carbon\Carbon::parse($order->date, 'Africa/Lagos')->diffForHumans()}}</span>
                        </li>
                      @endforeach
                    </ul>

                  </div>
              </section>
          </div>
      </div>
    </div>
 @endforeach
@stop