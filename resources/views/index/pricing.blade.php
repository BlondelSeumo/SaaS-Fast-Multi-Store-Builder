@extends('layouts.app')
  @section('title', __('Pricing'))
    @section('content')

    <!-- START PRICING -->
    <section class="section" id="pricing">
        <div class="container">
        <!-- Start Pricing -->
        <section class="pricing_section" id="Pricing">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-md-8 col-lg-6 text-center">
                <div class="title_sections mb-0">
                  <div class="before_title">
                      <h3 class="title-heading mt-4">{!! __('Pricing Plan') !!}</h3>
                  </div>
                  <h2>{{ __("Here's our simple subscription") }}</h2>
                </div>
              </div>
            </div>
            <div class="mb-5 d-flex justify-content-center pricing-selector">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                 <label class="btn btn-outline-primary" data-payment-pricing="monthly">
                  <input type="radio" name="payment_frequency" data-payment-pricing="month" checked="">{{ __('Monthly') }}</label>
                 <label class="btn btn-outline-primary">
                  <input type="radio" name="payment_frequency" data-payment-pricing="quarter">{{ __('Quarterly') }}</label>
                 <label class="btn btn-outline-primary">
                  <input type="radio" name="payment_frequency" data-payment-pricing="annual">{{ __('Annually') }}</label>
                </div>
            </div>

            <div class="blocks_pricing">
              <div class="row justify-content-center">
                @if(settings('package_free.status') == 1)
                <div class="col-lg-4">
                    @include('includes.pricing', ['key' => settings('package_free')])
                </div>
                @endif
                @if(settings('package_trial.status') == 1)
                @auth
                 @if (!$user->package_trial_done)
                  <div class="col-lg-4">
                      @include('includes.pricing', ['key' => settings('package_trial')])
                  </div>
                 @endif
                 @else
                  <div class="col-lg-4">
                      @include('includes.pricing', ['key' => settings('package_trial')])
                  </div>
                @endauth
                @endif
                @foreach ($packages as $key)
                    <div class="col-lg-4">
                        @include('includes.pricing', ['key' => $key])
                    </div>
                @endforeach
              </div>
            </div>

          </div>
        </section>
        <!-- End Start Pricing -->

        </div>
    </section>
    <!-- END PRICING -->
@stop