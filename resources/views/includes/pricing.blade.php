                        @php
                            $key = (object) $key;
                            $key->settings = (object) $key->settings;
                            $json = !empty($key->domains) && is_array(json_decode($key->domains, true)) ? json_decode($key->domains) : [];
                            $domains = [];
                            foreach($json as $value){
                                if ($domain = \App\Model\Domains::where('id', $value)->where('status', 1)->first()) {
                                    $domains[$domain->id] = (object) ['domain' => $domain->host];
                                }
                            }
                        @endphp
                        <div class="h-lg-950px">
                                    
                          <div class="item__price">
                            <h4 class="name_p">{{$key->name}}</h4>
                            <div class="number data-package month">
                                @if (!empty($key->settings->trial) && $key->settings->trial)
                                  <span class="d-block per">{{ $key->price['expiry'] }} {{ __('Days') }}</span>
                                  @else
                              <span class="n_price">{{ number_format($key->price->month ?? null) }}</span>
                              <span class="coins">{!! Currency::symbol(settings('currency')) !!}</span>
                              <span class="d-block per">{{ __('Monthly Plan') }}</span>
                              @endif
                            </div>

                            <div class="number data-package quarter">
                                @if (!empty($key->settings->trial) && $key->settings->trial)
                                  <span class="d-block per">{{ $key->price['expiry'] }} {{ __('Days') }}</span>
                                  @else
                              <span class="n_price">{{ number_format($key->price->quarter ?? null) }}</span>
                              <span class="coins">{!! Currency::symbol(settings('currency')) !!}</span>
                              <span class="d-block per">{{ __('Quarter Plan') }}</span>
                              @endif
                            </div>

                            <div class="number data-package annual">
                                @if (!empty($key->settings->trial) && $key->settings->trial)
                                  <span class="d-block per">{{ $key->price['expiry'] }} {{ __('Days') }}</span>
                                  @else
                                  <span class="n_price">{{ number_format($key->price->annual ?? null) }}</span>
                                  <span class="coins">{!! Currency::symbol(settings('currency')) !!}</span>
                                  <span class="d-block per">{{ __('Annual Plan') }}</span>
                              @endif
                            </div>
                            <div class="feature_price mb-9">
                              <ul class="list-group">
                                <li class="list-group-item">
                                  @if ($key->settings->ads)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Ads') }}
                                </li>
                                <li class="list-group-item">
                                  @if ($key->settings->custom_branding)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Custom Branding') }}
                                </li>
                                <li class="list-group-item">
                                  @if ($key->settings->statistics)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Advance stats') }}
                                </li>
                                <li class="list-group-item">
                                  @if ($key->settings->verified)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Verified badge') }}
                                </li>                        <li class="list-group-item">
                                  @if ($key->settings->social)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Social links to your profile') }}
                                </li>
                                <li class="list-group-item">
                                  @if ($key->settings->google_analytics)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Google analytics') }}
                                </li>
                                <li class="list-group-item">
                                  @if ($key->settings->facebook_pixel)
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   @else
                                   <i class="icon ni ni-cross-circle text-danger"></i>
                                  @endif
                                  {{ __('Facebook pixel') }}
                                </li>
                                <li class="list-group-item">
                                   <em class="icon ni ni-check-circle text-success"></em>
                                   {{__('Multi Domain')}} | @foreach ($domains as $value) {{$value->domain}} | @endforeach {{ parse_url(config('app.url'))['host'] }}
                                </li>
                                <li class="list-group-item">
                                   <em class="icon ni ni-check-circle text-success"></em>
                                  {{(!empty($key->settings->blogs_limits) && $key->settings->blogs_limits == '-1' ? "Unlimited" : !empty($key->settings->blogs_limits) && $key->settings->blogs_limits )}} {{ __('Blogs') }}
                                </li>

                                <li class="list-group-item">
                                   <em class="icon ni ni-check-circle text-success"></em>
                                  {{($key->settings->products_limit == '-1' ? "Unlimited" : $key->settings->products_limit )}} {{ __('Products') }}
                                </li>

                                <li class="list-group-item">
                                   <em class="icon ni ni-check-circle text-success"></em>
                                  {{(!empty($key->settings->custom_domain_limit) && $key->settings->custom_domain_limit == '-1' ? "Unlimited" : !empty($key->settings->custom_domain_limit) && $key->settings->custom_domain_limit )}} {{ __('Custom domain') }}
                                </li>
                              </ul>
                              @auth
                                <a href="{{ route('user-package-select', [$key->id == 'free' ? 'free' : $key->slug]) }}" class="btn effect-letter scale rounded-pill btn_md_primary c-white bg-blue" {!! !empty($key->slug) && $key->slug == 'trial' ? 'data-confirm="Are you sure you want to take this trial?"'  : ''!!}>{{__('Choose')}}</a>
                                @else
                                <a href="{{ route('login') }}" class="btn effect-letter scale rounded-pill btn_md_primary c-white bg-blue">{{__('Login')}}</a>
                              @endauth
                            </div>
                          </div>
                                <div class="pricing-box mt-4 rounded bg-white d-none">
                                    <div class="pricing-content">
                                        <h3>{{$key->name}}</h3>
                                        <div class="data-package month">
                                            <span class="h2">
                                                @if (!empty($key->settings->trial) && $key->settings->trial)
                                                     <b><span>{{ $key->price['expiry'] }} {{ __('Days') }}</span></b>
                                                    @else
                                                    <b><span> {!! Currency::symbol(settings('currency')) !!}{{ number_format($key->price->month ?? null) }}</span></b> | <span>{{ __('Monthly Plan') }}</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="data-package annual">
                                            <span class="h2">
                                                @if (!empty($key->settings->trial) && $key->settings->trial)
                                                     <b><span>{{ $key->price['expiry'] ?? '' }} {{ __('Days') }}</span></b>
                                                    @else
                                                    <b><span> {!! Currency::symbol(settings('currency')) !!}{{ number_format($key->price->annual ?? null) }}</span></b> | <span>{{ __('Annual Plan') }}</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="data-package quarter">
                                            <span class="h2">
                                                @if (!empty($key->settings->trial) && $key->settings->trial)
                                                     <b><span>{{ $key->price['expiry'] ?? '' }} {{ __('Days') }}</span></b>
                                                    @else
                                                    <b><span>{!! Currency::symbol(settings('currency')) !!}{{ number_format($key->price->quarter ?? null) }}</span> </b> | <span>{{ __('Quarter Plan') }}</span>
                                                @endif
                                            </span>
                                        </div>
                                        <hr>
                                        <div class="pricing-features pt-3">
                                        <p class="text-muted {{$key->settings->ads ? "" : "disabled"}}"><em class="icon ni ni-eye-off"></em> {{__('Ads')}} </p>

                                        <p class="text-muted {{$key->settings->custom_branding ? "" : "disabled"}}"><em class="icon ni ni-pen"></em> {{__('Branding')}}</p>

                                        <p class="text-muted {{$key->settings->statistics ? "" : "disabled"}}"><em class="icon ni ni-bar-chart"></em> {{__('Advance stats')}}</p>

                                        <p class="text-muted {{$key->settings->verified ? "" : "disabled"}}"><em class="icon ni ni-check-circle"></em> {{__('Verified badge')}}</p>

                                        <p class="text-muted {{($key->settings->social) ? "" : "disabled"}}"><em class="icon ni ni-user-circle"></em>{{__('Social links to your profile')}}</p>

                                        <p class="text-muted {{(!empty($key->settings->google_analytics) && $key->settings->google_analytics) ? "" : "disabled"}}"><em class="icon ni ni-google"></em> {{__('Google analytics')}}</p>

                                        <p class="text-muted {{(!empty($key->settings->facebook_pixel) && $key->settings->facebook_pixel) ? "" : "disabled"}}"><em class="icon ni ni-facebook-f"></em> {{__('Facebook pixel')}}</p>

                                        <p class="text-muted {{!empty($key->settings->domains) && $key->settings->domains ? "" : "disabled"}}"><em class="icon ni ni-row-view1"></em> {{__('Multi Domain')}} | @foreach ($domains as $value) {{$value->domain}} | @endforeach {{ parse_url(config('app.url'))['host'] }}</p>

                                        <p class="text-muted"><strong class="text-dark">{{($key->settings->products_limit == '-1' ? "Unlimited" : $key->settings->products_limit )}}</strong> {{__('Product')}}</p>
                                        </div>
                                        <div class="pricing-border mt-3"></div>
                                        <div class="mt-4 pt-2 text-center">
                                            @auth
                                              <a href="{{ route('user-package-select', [$key->id == 'free' ? 'free' : $key->slug]) }}" class="btn btn-block btn-primary btn-round justify-left" {!! !empty($key->slug) && $key->slug == 'trial' ? 'data-confirm="Are you sure you want to take this trial?"'  : ''!!}>{{__('Choose')}}</a>
                                              @else
                                              <a href="{{ route('login') }}" class="btn btn-block btn-primary btn-round justify-left">{{__('Login')}}</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                        </div>