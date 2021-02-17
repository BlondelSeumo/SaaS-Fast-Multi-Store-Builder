@extends('layouts.app')

@section('content')
<div class="container pt-8 mb-5">
	<div class="row">
		<div class="col-9 mx-auto d-flex align-items-center flex-column">
			<div class="d-flex">
				<h3 class="ml-2">{{$product->title}}</h3>
			</div>
			<hr>
			<div class="mx-auto">
                  @php
                    $rating = number_format($reviews->avg('rating'), 1);
                  @endphp
                  @foreach (range(1,5) as $i)
                  <span class="fa-stack m-0" style="width: 1em;">
                    <i class="far fa-star fa-stack-1x"></i>
                    @if ($rating > 0)
                      @if ($rating > 0.5)
                      <i class="fas fa-star fa-stack-1x"></i>
                      @else
                      <i class="fas fa-star-half fa-stack-1x"></i>
                      @endif
                    @endif
                    @php
                      $rating--;
                    @endphp
                  </span>
                  @endforeach
			</div>
		</div>
          <div class="col-12 col-md-9 mx-auto form__content mt-5">
             <div class="container-fluid m-auto">
               <ul class="table-reviews row">
                @if (empty($reviews))
                <div class="h-100">
                  <h3>{{ __('Nothing here') }}</h3>
                </div>
                @endif
                @foreach($reviews as $review)
                <div class="col-md-12">
                 <div class="p-4 bdrs-20 card-shadow">
                   <li class="mb-3">
                      <img src="{{ productReviewImage($review->id) }}" class="product_page-img">
                   </li>
                     <span class="position bold text-left title">{{$review->review->name ?? ''}}</span>
                     <br><hr>
                     <span class="position bold text-left card-rating" data-rating="{{$review->rating}}"> </span>
                     <br>
                     <span class="position bold text-left date">{{Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                     <hr>
                   <p>{{$review->review->review ?? ''}}</p>
                  </div>
                </div>
                  @endforeach
               </ul>
             </div>
          </div>
	</div>
</div>
@endsection
