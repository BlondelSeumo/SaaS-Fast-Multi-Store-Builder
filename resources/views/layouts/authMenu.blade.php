
                <div class="container-xl wide-lg">
                    <div class="nk-header-wrap">
                        <div class="nk-menu-trigger mr-sm-2 d-lg-none">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
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
                        </div><!-- .nk-header-menu -->
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                @if ($user->role == 1)
                                    <li><a href="{{ route('admin-home') }}" class="nk-quick-nav-icon"><em class="icon ni ni-security"></em></a></li>
                                @endif
                                <li class="dropdown user-dropdown order-sm-first">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
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
                    </div><!-- .nk-header-wrap -->
                </div><!-- .container-fliud -->