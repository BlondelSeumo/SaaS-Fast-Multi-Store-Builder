@extends('layouts.app')

@section('title', __('Faq'))
@section('content')
<div class="container">
<div class="nk-block-head mt-8">
  <div class="row">
    <div class="col-6 d-flex align-items-center">
      <div class="nk-block-head-content">
         <h2 class="nk-block-title fw-normal">{{ __('Faq') }}</h2>
      </div>
    </div>
  </div>
</div>
<div class="nk-block">
     <h5 class="title text-primary">{{ __('General Question') }}</h5>
     <p>{{ __('You can find general answer here.') }}</p>
     <div id="faq-gq" class="accordion">
        @foreach ($faqs as $faq)
         <div class="accordion-item">
             <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#faq-{{ $faq->id }}">
                 <h6 class="title">{{ $faq->name }}</h6>
                 <span class="accordion-icon"></span>
             </a>
             <div class="accordion-body collapse" id="faq-{{ $faq->id }}" data-parent="#faq-gq">
                 <div class="accordion-inner">
                     {!! clean($faq->note, 'titles') !!}
                 </div>
             </div>
         </div><!-- .accordion-item -->
        @endforeach
     </div><!-- .accordion -->
 </div><!-- .nk-block -->
</div>
@endsection
