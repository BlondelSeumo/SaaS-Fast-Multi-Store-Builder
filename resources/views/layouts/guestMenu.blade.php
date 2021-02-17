
                <div class="container h-100">
                    <div class="nk-header-wrap h-100">
                        <div class="nk-menu-trigger mr-sm-2 d-xl-none">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="{{ Auth::check() && request()->path() !== '/' && request()->path() !== 'pricing' ? 'sidebarMenu' : 'headerNav' }}"><em class="icon ni ni-menu"></em></a>
                        </div>
                        <div class="nk-header-brand">
                            <a href="{{url('/')}}" class="logo-link">
                                <img class="logo-img" src="{{ url('media/logo/' . settings('logo')) }}" alt="logo">
                            </a>
                        </div><!-- .nk-header-brand -->
                        <div class="nk-header-menu" data-content="headerNav">
                            <div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a href="{{url('/')}}" class="logo-link">
                                        <img class="logo-img" src="{{ url('media/logo/' . settings('logo')) }}" alt="logo">
                                    </a>
                                </div>
                                <div class="nk-menu-trigger mr-n2">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                                </div>
                            </div>
                            <!-- Menu -->
                            <ul class="nk-menu nk-menu-main">
                                    @auth
                                    <li class="nk-menu-item">
                                        <a href="{{ route('user-dashboard') }}" class="nk-menu-link fs-10px">
                                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                            <span class="nk-menu-text">{{ __('Dashboard') }}</span>
                                        </a>
                                    </li>
                                    @endauth
                                    <li class="nk-menu-item">
                                        <a href="{{ url('/#how-it-work') }}" class="nk-menu-link fs-10px">
                                            <span class="nk-menu-icon"><em class="icon ni ni-edit"></em></span>
                                            <span class="nk-menu-text">{{ __('How it works') }}</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('pricing') }}" class="nk-menu-link fs-10px">
                                            <span class="nk-menu-icon"><em class="icon ni ni-wallet"></em></span>
                                            <span class="nk-menu-text">{{ __('Pricing') }}</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle fs-10px" data-original-title="" title="">
                                    <span class="nk-menu-text">{{ __('Pages') }}</span>
                                    </a>
                                      <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('all-pages') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">{{ __('All pages') }}</span>
                                            </a>
                                        </li>
                                        @foreach ($allPages as $item)
                                            <li class="nk-menu-item"><a class="nk-menu-link" data-original-title="" title="" href="{{$item->type == 'internal' ? url('page/' . $item->url) : $item->url}}" target="{{ $item->type == 'internal' ? '_self' : '_blank' }}"><span class="nk-menu-text">{{ ucfirst($item->title) }}</span></a></li>
                                        @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!-- .nk-header-menu -->
                        @guest
                            <div class="nk-header-tools">
                                <a href="{{ route('login') }}" class="btn rounded-pill mr-2 btn-outline-primary text-dark">{{ __('Login') }}</a>
                                @if (settings('registration'))
                                    <a href="{{ route('register') }}" class="btn scale btn_sm_primary bg-blue c-white rounded-pill">{{ __('Register') }}</a>
                                @endif
                            </div>
                        @endguest
                        @auth
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown user-dropdown order-sm-first">
                                    <a href="#" class="dropdown-toggle bg-transparent" data-toggle="dropdown">
                                        <div class="user-toggle">
                                            <div class="user-avatar sm">
                                                <img src="{{ avatar() }}" alt=" ">
                                            </div>
                                            <div class="user-info d-none d-xl-block">
                                                <div class="user-status user-status-unverified">{{($user->role == 1 ? 'Admin' : 'User')}}</div>
                                                <div class="user-name dropdown-indicator">{{user('name.first_name')}} {{user('name.last_name')}}</div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1 is-light">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                 <img src="{{ avatar() }}" alt=" ">
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text">{{user('name.first_name')}}</span>
                                                    <span class="sub-text">{{$user->email ?? ''}}</span>
                                                </div>
                                                <div class="user-action">
                                                    <a class="btn btn-icon mr-n2" href="{{ route('user-settings') }}"><em class="icon ni ni-setting"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner user-account-info">
                                            <h6 class="overline-title-alt">{{ __('Plan') }}</h6>
                                            <div class="user-balance">{{$package->name}}</div>
                                            <div class="user-balance-sub">Expires <span>{{ (strtolower($package->name) == 'free' ? __('Forever') : Carbon\Carbon::parse($user->package_due)->toFormattedDateString()) }}</span></div>
                                            <a href="{{ route('pricing') }}" class="link"><span>{{ __('Change Plan') }}</span> <em class="icon ni ni-wallet-out"></em></a>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="{{ url($profile_url) }}" target="_blank"><em class="icon ni ni-template"></em><span>{{ __('View Store') }}</span></a></li>
                                                <li><a href="{{ route('user-settings') }}"><em class="icon ni ni-setting"></em><span>{{ __('Settings') }}</span></a></li>
                                                <li><a href="{{ route('user-transactions') }}"><em class="icon ni ni-wallet"></em><span>{{ __('Transactions') }}</span></a></li>
                                                <li><a href="{{ route('user-faq') }}"><em class="icon ni ni-msg-circle"></em><span>{{ __('Faq') }}</span></a></li>
                                                <li><a href="{{ route('user-activities') }}"><em class="icon ni ni-activity-alt"></em><span>{{ __('Login activity') }}</span></a></li>
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                    <form method="post" id="form-submit" action="{{ url('logout') }}">
                                      @csrf
                                      <ul class="link-list">
                                          <li><a class="submit-closest"><em class="icon ni ni-signout"></em><span>{{ __('Sign out') }}</span></a></li>
                                      </ul>
                                   </form>
                                        </div>
                                    </div>
                                </li><!-- .dropdown -->
                            </ul><!-- .nk-quick-nav -->
                        </div><!-- .nk-header-tools -->
                        @endauth
                    </div><!-- .nk-header-wrap -->
                </div><!-- .container-fliud -->