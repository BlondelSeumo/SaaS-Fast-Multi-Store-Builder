@extends('admin.layouts.app')

@section('title', __('Packages'))
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Packages') }}</h2>
        </div>
    </div>
    <div class="col-md-6 d-flex align-center justify-content-md-end">
        <div class="nk-block-head-content">
        <a class="btn btn-primary mt-3 mt-md-0" href="{{ route('admin-add-package') }}">{{ __('Create package') }}</a></div>
        </div>
    </div>
</div>
<div class="nk-block-head-content mt-4">
    <div class="nk-block-head-sub"><span>{{ __('All packages') }}</span></div>
</div>

<div class="row">
    @php 
        $free = settings('package_free');
        $planArray = settings('package_free.settings');
        $planActives = count(array_filter($planArray));
    @endphp
        <div class="col-md-3">
             <div class="admin-pricing-box">
                 <p class="admin-pricing-box-title">{{ settings('package_free.name') }}</p>
                 <div class="admin-pricing-box-content">
                   <div class="status-info success">
                     <p class="status-title bold">{{ __('NULL') }}</p>
                     <ul class="plan-items-list">
                         <li>
                            <span class="label">{{ __('Price') }}</span> - <span class="data">{{ settings('package_free.price.annual') }}</span>
                        </li>
                         <li>
                            <span class="label">{{ __('Users on Plan') }}</span> - <span class="data">{{$free_count ?? '0'}}</span>
                        </li>
                         <li>
                            <span class="label">Status</span> - <span class="data {{ (settings('package_free.status')) ? "" : "badge-warning" }}">{{ (settings('package_free.status')) ? __('active') : __('Inactive') }}</span>
                        </li>
                         <li>
                            <span class="label">{{ __('Features on Plan') }}</span> - <span class="data">{{$planActives}}</span>
                        </li>
                     </ul>
                     <a href="{{ route('admin-packages') .'/edit/'. settings('package_free.id') }}" class="button primary full mt-3">{{ __('Edit plan') }} <em class="icon ni ni-edit mt-4"></em></a>
                   </div>
                 </div>
            </div>
        </div>
    @php 
        $trial = settings('package_trial');
        $planArray = settings('package_trial.settings');
        $planActives = count(array_filter($planArray));
    @endphp
        <div class="col-md-3">
             <div class="admin-pricing-box">
                 <p class="admin-pricing-box-title">{{ settings('package_trial.name') }}</p>
                 <div class="admin-pricing-box-content">
                   <div class="status-info success">
                     <p class="status-title bold">{{ __('NULL') }}</p>
                     <ul class="plan-items-list">
                         <li>
                            <span class="label">{{ __('Price') }}</span> - <span class="data">{{ settings('package_trial.price.annual') }}</span>
                        </li>
                         <li>
                            <span class="label">{{ __('Users on Plan') }}</span> - <span class="data">{{$trial_count ?? '0'}}</span>
                        </li>
                         <li>
                            <span class="label">Status</span> - <span class="data {{ (settings('package_trial.status')) ? "" : "badge-warning" }}">{{ (settings('package_trial.status')) ? __('active') : __('Inactive') }}</span>
                        </li>
                         <li>
                            <span class="label">{{ __('Features on Plan') }}</span> - <span class="data">{{$planActives}}</span>
                        </li>
                     </ul>
                     <a href="{{ route('admin-packages') .'/edit/'. settings('package_trial.id') }}" class="button primary full mt-3">{{ __('Edit plan') }} <em class="icon ni ni-edit mt-4"></em></a>
                   </div>
                 </div>
            </div>
        </div>
    @foreach ($packages as $package)
        @php
            $planArray = (array) $package->settings;
            $planActives = count(array_filter($planArray));
        @endphp
        <div class="col-md-3">
             <div class="admin-pricing-box">
                 <p class="admin-pricing-box-title">{{ $package->name }}</p>
                 <div class="admin-pricing-box-content">
                   <div class="status-info success">
                     <p class="status-title bold">{{ Carbon\Carbon::parse($package->created_at)->toFormattedDateString()}}</p>
                     <ul class="plan-items-list">
                         <li>
                            <span class="label">{{ __('Price') }}</span> - <span class="data">{{ $package->price->annual }}</span>
                        </li>
                         <li>
                            <span class="label">{{ __('Users on Plan') }}</span> - <span class="data">{{$package->total_package ?? '0'}}</span>
                        </li>
                         <li>
                            <span class="label">Status</span> - <span class="data">{{ ($package->status == 1) ? __('active') : __('Inactive') }}</span>
                        </li>
                         <li>
                            <span class="label">{{ __('Features on Plan') }}</span> - <span class="data">{{$planActives}}</span>
                        </li>
                     </ul>
                     <a href="{{ route('admin-packages') .'/edit/'. $package->id }}" class="button primary full mt-3">{{ __('Edit plan') }} <em class="icon ni ni-edit mt-4"></em></a>
                     <a href="#" data-toggle="modal" data-target="#delete-{{$package->id}}" class="button void full text-danger mt-3">{{ __('Delete') }} <em class="icon ni ni-cross"></em></a>
                   </div>
                 </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="delete-{{$package->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-lg">
                        <form action="{{ route('admin-delete-package') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{$package->id}}" name="package_id">
                             <h4 class="bold text-danger">{{ __('TYPE DELETE') }}</h4>
                             <p class="text-danger">{{ __('Note that all users under this plan will be moved to free plan') }}</p>
                             <div class="form-group mt-5">
                                 <input type="text" class="form-control form-control-lg" name="delete" placeholder="{{ __('DELETE') }}" autocomplete="off">
                             </div>
                            <div class="form-group mt-5">
                             <button type="submit" class="btn btn-dark btn-block">{{ __('Submit') }}</button>
                            </div>
                        </form>
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div>
    @endforeach
</div>
@endsection
