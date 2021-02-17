@extends('admin.layouts.app')
@section('title', __('Add new user'))
@section('content')
<div class="container wide-sm mt-5">
   <div class="nk-content-inner">
      <div class="nk-content-body">
         <div class="nk-content-wrap">
            <div class="nk-block-head nk-block-head-lg wide-sm m-auto text-left">
               <div class="nk-block-head-content card-shadow card card-inner bdrs-20">
                  <h5 class="nk-block-title fw-bold">{{ __('Add new store') }}</h5>
               </div>
            </div>
            <!-- .nk-block-head -->
            <div class="nk-block mb-3">
               <div class="card card-shadow bdrs-20">
                  <div class="card-inner">
                     <form action="{{ route('admin-create-post-user') }}" method="post" class="form-contact">
                      @csrf
                        <div class="row g-4">
                           <!-- .col -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('First Name') }}" name="first_name">
                                 </div>
                              </div>
                           </div>
                           <!-- .col -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('Last Name') }}" name="last_name">
                                 </div>
                              </div>
                           </div>
                           <!-- .col -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('Store url. Ex: fashion-store') }}" name="username">
                                 </div>
                              </div>
                           </div>
                           <!-- .col -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('Email') }}" name="email">
                                 </div>
                              </div>
                           </div>
                           <!-- .col -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('Password') }}" name="password">
                                 </div>
                              </div>
                           </div>
                           <!-- .col -->
                           <div class="col-12">
                              <button type="submit" class="button w-100 primary">{{ __('Create') }}</button>
                           </div>
                           <!-- .col -->
                        </div>
                        <!-- .row -->
                     </form>
                     <!-- .form-contact -->
                  </div>
                  <!-- .card-inner -->
               </div>
               <!-- .card -->
            </div>
            <!-- .nk-block -->
         </div>
      </div>
   </div>
</div>
@endsection
