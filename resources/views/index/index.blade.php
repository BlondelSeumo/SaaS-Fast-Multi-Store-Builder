@extends('layouts.app')
@section('headJS')
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&family=Paytone+One&display=swap" rel="stylesheet"> 
  @if (config('app.captcha_status') && config('app.captcha_type') == 'recaptcha')
  {!! htmlScriptTagJsApi() !!}
  @endif
    <style>
      .container-lg{
        max-width: initial !important;
        padding: 0 !important;
      }
    </style>
@stop
  @section('title', __('Complete Storefront Solution'))
    @section('content')

  <div id="wrapper">
    <div id="content">
      <!-- Stat main -->
      <main>
        <section class="demo_2 demo_3 banner_section">
          <div class="container">
            <div class="row">
              <div class="col-md-8 col-lg-6 z-index-3">
                <div class="banner_title mb-0">
                  <div class="fs-20px mb-0">
                    <span class="c-dark">{{ __('Welcome to') }}</span> 
                    <span class="c-green">{{ env('APP_NAME') }}</span>
                  </div>
                  <h1 class="text-dark mt-0">{{ __('Create Your Own e-Commerce Store!') }}</h1>
                  <p class="text-dark">
                    {{ __('Start your e-commerce store with a few easy steps. Create products, set categories, connect a payment gateway and publish your sparkling new e-commerce site in a few minutes!') }}
                  </p>
                  <div class="form-row">
                    <div class="col-md-12 col-12 form-group input_subscribe dark mb-0 d-lg-flex">
                      <form class="item_input" method="get" action="{{ route('register') }}">
                        <input type="email" class="form-control rounded-8" placeholder="{{ __('Enter email address') }}" aria-describedby="emailHelp" name="email">
                        <button class="btn scale c-white btn_md_primary rounded-8 btn_subscribe">
                          {{ __('Sign Up') }}
                        </button>
                      </form>
                        @if (!empty($demo_user))
                          <a href="{{ profile($demo_user->id) }}" target="_blank" class="btn demo-store ml-lg-3 btn-outline-primary rounded-pill">{{ __('Demo Store') }}</a>
                        @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-lg-6 z-index-2">
                <!-- Do nothing -->
              </div>
                <div class="img--elements">
                  <img src="{{ url('media/Ecom-UI-Assets-1.png') }}">
                </div>
                <img src="{{ url('media/Ecom-UI-Assets-2.png') }}" class="overlay_yellow d-none z-index-1 d-md-block">
            </div>
          </div>
        </section>
        <section class="products_section product_demo3 padding-t-12 mt-md-5" id="Services">
          <div class="container">
            <div class="row">
              <div class="col-md-8 col-lg-5 margin-b-3">
                <div class="title_sections margin-b-2">
                  <div class="before_title">
                    <span>{{ __('What You') }}</span>
                    <span class="c-green">{{ __('Get') }}</span>
                  </div>
                  <h2 class="c-dark">
                    {{ __('All you will ever need to create your own online store!') }}
                  </h2>
                </div>
                <a href="{{ route('login') }}" class="btn btn_md_primary z-index-2 c-white scale bg-orange-red effect-letter rounded-8">{{ __('Get started') }}</a>
                <img class="mt-4 d-sm-none d-lg-block" src="{{ url('media/Ecom-UI-Assets-4.png') }}" width="460">
              </div>
              <div class="col-lg-6 ml-sm-auto">
                <div class="row">
                  <div class="col-md-6 margin-b-5">
                    <div class="item_pro">
                      <i class="icon ni ni-setting"></i>
                      <h4 class="c-black mt-2">{{ __('Easy Setup & Management') }}</h4>
                      <p class="c-black">
                        {{ __('Simply create an account, setup your store and publish in minutes. Manage sales conveniently!') }}
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 margin-b-5">
                    <div class="item_pro">
                      <i class="icon ni ni-template"></i>
                      <h4 class="c-black mt-2">{{ __('Rich Analytics System') }}</h4>
                      <p class="c-black">
                        {{ __('Measure your growth, track sales, manage views and other detailed analytics right from your dashboard.') }}
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 margin-b-5">
                    <div class="item_pro">
                      <i class="icon ni ni-grid-fill"></i>
                      <h4 class="c-black mt-2">{{ __('Multiple Payment Gateway Options') }}</h4>
                      <p class="c-black">
                        {{ __('Choose from a variety of available payment option that suites you and receive payments easily.') }}
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 margin-b-5">
                    <div class="item_pro">
                      <i class="icon ni ni-link"></i>
                      <h4 class="c-black mt-2">{{ __('Add Your Social Media Links') }}</h4>
                      <p class="c-black">
                        {{ __('Let your visitors link directly to your social media pages by simply adding your preferred links to your store!') }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- .container -->
        </section>

        <section class="services_section py-9 support_item mt-8" id="how-it-work">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-md-10 col-lg-6 text-center">
                <div class="title_sections">
                  <div class="before_title">
                    <span>{{ __("How It") }}</span>
                    <span class="c-green">{{ __('Works') }}</span>
                  </div>
                  <h2>{{ __('Let’s Get You Started') }}</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-lg-4 mb-3 mb-lg-0 padding-r-5">
                <div class="items_serv sevice_block">
                  <div class="icon--top">
                    <i class="icon ni ni-setting-alt"></i>
                  </div>
                  <div class="txt">
                    <h4 class="c-black">{{ __('Create An Account') }}</h4>
                    <p>
                     {{ __('Simply create an account, setup your store and publish in minutes. Manage sales conveniently!') }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4 mb-3 mb-lg-0">
                <div class="items_serv sevice_block">
                  <div class="icon--top">
                    <i class="icon ni ni-plus"></i>
                  </div>
                  <div class="txt">
                    <h4 class="c-black">{{ __('Post Your Products') }}</h4>
                    <p>
                      {{ __('Create items you want to showcase on your products and set your all-important products as much as you need.') }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="items_serv sevice_block">
                  <div class="icon--top">
                    <i class="icon ni ni-share"></i>
                  </div>
                  <div class="txt">
                    <h4 class="c-black">{{ __('Start Sharing') }}</h4>
                    <p>
                      {{ __('Share your store link on Instagram, Facebook, Tik Tok, LinkedIn, anywhere and boom, that’s it!') }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      @if(settings('package_trial.status') == 1)
        <!-- Try it -->
        <section class="simplecontact_section tryit_now add-background-img padding-py-6">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-7">
                <div class="title_sections mb-1 mb-lg-auto">
                  <h2 class="c-white">{{ __('Start Now for FREE!') }}</h2>
                  <p>
                    {{ __('We offer a FREE trial to get you started with the PRO features of our platform.') }}
                  </p>
                </div>
              </div>
              <div class="col-md-3 col-lg-5 my-auto ml-auto text-sm-right">
                <a href="{{ route('register') }}" 
                  class="btn mt-3 rounded-8 btn_md_primary c-white effect-letter scale bg-orange-red">
                  {{ __('Try it Now') }}
                </a>
              </div>
            </div>
          </div>
        </section>
        @endif

        <!-- Start Pricing -->
        <section class="pricing_section padding-t-12" id="Pricing">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-md-8 col-lg-6 text-center">
                <div class="title_sections">
                  <div class="before_title">
                      <h3 class="title-heading mt-4">{!! __('Pricing Plan') !!}</h3>
                  </div>
                  <h2>{{ __('Check out our simple subscription') }}</h2>
                </div>
              </div>
            </div>
            <div class="mb-5 d-none justify-content-center pricing-selector" hidden>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                 <label class="btn btn-outline-primary" data-payment-pricing="monthly">
                  <input type="radio" name="payment_frequency" data-payment-pricing="month" checked="">{{ __('Monthly') }}</label>
                 <label class="btn btn-outline-primary">
                  <input type="radio" name="payment_frequency" data-payment-pricing="quarter">{{ __('Quarterly') }}</label>
                 <label class="btn btn-outline-primary">
                  <input type="radio" name="payment_frequency" data-payment-pricing="annual">{{ __('Annually') }}</label>
                </div>
            </div>
            <div class="blocks_pricing" id="monthly">
              <div class="row justify-content-center">
                  @if(settings('package_free.status') == 1)
                    <div class="col-md-6 col-lg-4">
                      @include('includes.pricing', ['key' => settings('package_free')])
                    </div>
                  @endif
                  @if(settings('package_trial.status') == 1)
                    <div class="col-md-6 col-lg-4">
                      @include('includes.pricing', ['key' => settings('package_trial')])
                    </div>
                  @endif
                  @foreach ($packages as $key)
                    <div class="col-md-6 col-lg-4">
                      @include('includes.pricing', ['key' => $key])
                    </div>
                  @endforeach
              </div>
            </div>
          </div>
        </section>
        <!-- End Start Pricing -->

        <!-- Start Simple Contact -->
        <section class="simplecontact_section padding-py-12 mt-5">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-md-6 text-center">
                <div class="title_sections mb-0">
                  <h2>{{ __('Need help?') }}</h2>
                  <p>
                    {{ __('Fill the form at the bottom right corner
                    of this page to speak with us or you can use the email below') }}
                    <a class="c-blue" href="mailto:{{settings('email')}}">{{settings('email')}}</a>.
                  </p>
                  <a href="#contact" type="button" class="btn rounded-pill btn_md_primary c-white scale ripple bg-blue">
                    {{ __('Contact Us') }}
                  </a>
                </div>
              </div>
            </div>
            <!-- <div class="circle-ripple"></div> -->
            <div class="circle-ripple">
              <div class="ripple ripple-1"></div>
              <div class="ripple ripple-2"></div>
              <div class="ripple ripple-3"></div>
            </div>
          </div>
        </section>
        <!-- End Simple Contact -->
      </main>
      <!-- end main -->
    </div>
    <!-- [id] content -->
  @if (settings('contact'))
    <div class="default_footer dark padding-t-12 padding-b-10" id="contact">
      <div class="container">
        <img class="shape_overlay" src="{{ url('media/shape-lines.svg') }}">
        <div class="row">
          <div class="col-lg-5 margin-b-3">
            <div class="title_sections margin-b-2">
              <h2>{{ __('Contact us') }}</h2>
              <p class="c-white">
                {{ __('If you have any issue regarding our platform or you have questions regarding our packages or anything, kindly contact us, our team would be glad to help.') }}
              </p>
            </div>
            <div class="dashed-line margin-b-2"></div>
            <!-- Start Testimonial -->
            <div class="block_testimonial">
              <h3 class="c-white">{{ __('Faq') }}</h3>
              <p class="c-white">{{ __('Here are some of our faq to get started') }}</p>
               <div id="faq-gq" class="accordion border-0">
                  @foreach (\App\Model\Faq::limit(4)->get() as $faq)
                   <div class="accordion-item card card-shadow mt-3">
                        <div class="card-header bg-white card-shadow active" id="headingOne">
                          <h3 class="mb-0">
                            <a href="#" class="btn btn-link accordion-head border-0 collapsed px-0" data-toggle="collapse" data-target="#faq-{{ $faq->id }}">
                              <span>{{ $faq->name }}</span>
                              <span class="accordion-icon"></span>
                             </a>
                          </h3>
                        </div>
                       <div class="accordion-body collapse" id="faq-{{ $faq->id }}" data-parent="#faq-gq">
                           <div class="accordion-inner card-body card-shadow border-0">
                               {!! clean($faq->note) !!}
                           </div>
                       </div>
                   </div><!-- .accordion-item -->
                  @endforeach
               </div><!-- .accordion -->
            </div>
          </div>
          <div class="col-lg-5 mx-auto">
            <form method="post" action="{{ route('contact-us') }}" class="form_register">
                <h3 class="title--forms">{{ __('Fill out the Form') }}</h3>
                 @csrf
                 <div class="row">
                     <div class="col-lg-6">
                         <div class="form-group custom mt-3">
                             <label class="mb-3 ml-3">{{__('First Name')}}</label>
                             <input name="firstname" id="name" class="form-control" type="text">
                         </div>
                     </div>

                     <div class="col-lg-6">
                         <div class="form-group custom mt-3">
                             <label class="ml-3 mb-3">{{__('Last Name')}}</label>
                             <input name="name" id="lastname" class="form-control" type="text">
                         </div>
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-lg-12">
                         <div class="form-group custom mt-3">
                             <label class="ml-3 mb-3">{{__('Email Address')}}</label>
                             <input name="email" id="email" class="form-control" required="" type="email">
                         </div>
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-lg-12">
                         <div class="form-group custom mt-3">
                             <label class="ml-3 mb-3">{{__('Subject')}}</label>
                             <input name="subject" id="subject" class="form-control" type="text">
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="form-group custom mt-3">
                             <label class="ml-3 mb-3"> {{__('Your Message')}} </label>
                             <textarea name="message" id="message" rows="5" class="form-control"></textarea>
                         </div>
                     </div>
                 </div>
                    <div class="col-12">
                     @if (config('app.captcha_status') && config('app.captcha_type') == 'recaptcha')
                     {!! htmlFormSnippet() !!}
                     @endif
                     @if (config('app.captcha_status') && config('app.captcha_type') == 'default')
                     <div class="row mt-3 mb-4">
                       <div class="col-md-6 mb-4 mb-md-0">
                         <div class="bdrs-20 p-2 text-center card-shadow">
                            {!! captcha_img() !!}
                         </div>
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">
                            <input type="text" class="form-control form-control-lg @error('captcha') is-invalid @enderror" placeholder="{{ __('Captcha') }}" name="captcha">
                         </div>
                       </div>
                     </div>
                     @endif
                    </div>
                    <div class="col-12">
                      <button class="btn mt-3 btn-primary btn-round btn-block">{{ __('Send Message') }}</button>
                    </div>
                </form>
              </div>
            </div>
            <!-- Forms -->
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
  <!-- End. wrapper -->
@stop