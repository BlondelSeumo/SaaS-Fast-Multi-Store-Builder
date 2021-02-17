@extends('installer.layout')
@section('title', __('Install'))
@section('content')
    <link rel="stylesheet" href="{{ asset('css/smallPages.css') }}">
    <div class="container mt-7 mb-5">
    <img class="logo-img logo-img-lg mb-3 p-0 ml-0" src="{{ url('media/logo/logo.png') }}" alt="{{ config('app.name') }}">
    <h4>Details</h4>
    <p>Fill in all the form correctly to setup your product</p>
    <form method="POST" action="{{ route('InstallApp') }}">
       @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="data-head mb-4 mt-5">
              <h6 class="overline-title"><span>Site</span></h6>
            </div>
             <div class="form-group">
                <div class="form-label-group"><label class="form-label">{{ __('Website Name') }}</label></div>
                <input type="text" class="form-control form-control-lg @error('app_name') is-invalid @enderror" placeholder="{{ __('Enter your Website Name') }}" name="app_name" value="{{ old('APP_NAME') }}">
                 @error('app_name')
                     <span class="invalid-feedback d-block m-0" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
             </div>
             <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-lg">
                    <input type="hidden" class="custom-control-input" name="force_https" value="0">
                    <input type="checkbox" class="custom-control-input" id="force_https" name="force_https" value="1">
                    <label class="custom-control-label" for="force_https">{{ __('Force https') }}</label>
                </div>
             </div>
                <div class="data-head mb-4 mt-5">
                  <h6 class="overline-title"><span>Admin details</span></h6>
                </div>
               <div class="row mb-4">
                 <div class="col">
                   <div class="form-group">
                        <input id="first_name" class="form-control form-control-lg @error('first_name') is-invalid @enderror" type="text" placeholder="{{ __('First Name') }}" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus/>
                      @error('first_name')
                          <span class="invalid-feedback d-block m-0" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                   </div>
                 </div>
                 <div class="col">
                   <div class="form-group">
                        <input id="last_name" class="form-control form-control-lg @error('last_name') is-invalid @enderror" type="text" placeholder="{{ __('Last Name') }}" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name"/>
                      @error('last_name')
                          <span class="invalid-feedback d-block m-0" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                   </div>
                 </div>
                 <div class="col">
                   <div class="form-group">
                        <input id="username_email" class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}" autocomplete="email"/>
                      @error('email')
                          <span class="invalid-feedback d-block m-0" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                   </div>
                 </div>
               </div>
               <div class="form-group">
                    <input id="username" class="form-control form-control-lg @error('username') is-invalid @enderror" type="text" placeholder="{{ __('Username') }}" name="username" value="{{ old('username') }}" autocomplete="username"/>
                  @error('username')
                      <span class="invalid-feedback d-block m-0" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
               </div>
               <div class="row">
                 <div class="col">
                   <div class="form-group">
                       <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" />
                     @error('password')
                         <span class="invalid-feedback d-block m-0" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                   </div>
                 </div>
                 <div class="col">
                   <div class="form-group">
                       <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" autocomplete="new-password" class="form-control form-control-lg" />
                   @error('password')
                       <span class="invalid-feedback d-block m-0" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
                   </div>

                 </div>
               </div>
            </div>
            <div class="col-md-6">
                <div class="data-head mb-4 mt-5">
                  <h6 class="overline-title"><span>Database</span></h6>
                </div>
              <div class="row">
                  <div class="col">
                    <div class="form-group mb-5">
                       <div class="form-label-group"><label class="form-label">{{ __('Database Host') }}</label></div>
                       <input type="text" class="form-control form-control-lg @error('db_host') is-invalid @enderror" placeholder="{{ __('Enter Database Hostname') }}" name="db_host" value="{{ env('DB_HOST', 'localhost') }}" autocomplete="off">
                      @error('db_host')
                          <span class="invalid-feedback d-block m-0" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group mb-5">
                       <div class="form-label-group">
                        <label class="form-label">{{ __('Database Port') }}</label>
                      </div>
                       <input type="text" class="form-control form-control-lg @error('db_port') is-invalid @enderror" name="db_port" placeholder="{{ __('Enter Database Port') }}" value="{{ env('DB_PORT', '3306') }}" autocomplete="off">
                      @error('db_port')
                          <span class="invalid-feedback d-block m-0" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
              </div>
                <div class="form-group">
                   <div class="form-label-group"><label class="form-label">{{ __('Database Name') }}</label></div>
                   <input type="text" class="form-control form-control-lg @error('db_database') is-invalid @enderror" name="db_database" placeholder="{{ __('Enter Database Name') }}" value="{{ env('DB_DATABASE', '') }}" autocomplete="off">
                  @error('db_database')
                      <span class="invalid-feedback d-block m-0" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group mt-1">
                           <div class="form-label-group"><label class="form-label">{{ __('Database Username') }}</label></div>
                           <input type="text" class="form-control form-control-lg @error('db_username') is-invalid @enderror" name="db_username" placeholder="{{ __('Enter Database Name') }}" value="{{ env('DB_USERNAME', '') }}" autocomplete="off">
                          @error('db_username')
                              <span class="invalid-feedback d-block m-0" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mt-1">
                           <div class="form-label-group"><label class="form-label">{{ __('Database Password') }}</label></div>
                           <input type="text" class="form-control form-control-lg" name="db_password" placeholder="{{ __('Enter Database Password') }}" value="{{ env('DB_PASSWORD', '') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty(Session::get('errors')))
          <div class="alert alert-icon alert-danger mt-5" role="alert">
              <em class="icon ni ni-alert-circle"></em> 
              {{session()->get('errors')->first()}}
          </div>
        @endif
        <div class="form-group mt-5">
          <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Next') }}</button>
        </div>
     </form>
    </div>
@endsection
