@extends('layouts.app')
@section('title', __('Login activities'))
@section('content')

<div class="nk-block-head col-md-8 mx-auto mt-8">
    <div class="nk-block-head-content">
        <div class="nk-block-head-sub"><a class="back-to" href="{{ route('user-dashboard') }}"><em class="icon ni ni-arrow-left"></em><span>{{ __('Dashboard') }}</span></a></div>
        <h2 class="nk-block-title fw-normal">{{ __('Login activities') }}</h2>
    </div>
</div><!-- .nk-block-head -->
<div class="nk-block col-md-8 mx-auto">
    <div class="nk-block-title-group mb-3">
        <h6 class="nk-block-title title">{{ __('Activity on your account') }}</h6>
        <form action="{{ route('user-activities') }}" method="post">
             @csrf
             <button type="submit" class="link link-danger">{{ __('Clear all') }}</button>
        </form>
    </div>
    <div class="card card-shadow bdrs-20 card card-inner">
        <table class="table table-ulogs">
            <thead>
                <tr>
                    <th class="tb-col-os"><span class="overline-title">{{ __('Activity') }}</span></th>
                    <th class="tb-col-ip"><span class="overline-title">{{ __('Ip') }}</span></th>
                    <th class="tb-col-time"><span class="overline-title">{{ __('Browser') }}</span></th>
                    <th class="tb-col-time"><span class="overline-title">{{ __('Os') }}</span></th>
                    <th class="tb-col-time"><span class="overline-title">{{ __('Date') }}</span></th>
                </tr>
            </thead>
            <tbody>
              @foreach ($activities as $activity)
                <tr>
                    <td class="tb-col-os">{{ $activity->what }}</td>
                    <td class="tb-col-ip"><span class="sub-text">{{ $activity->ip }}</span></td>
                    <td class="tb-col-time"><span class="sub-text">{{ $activity->browser }}</span></td>
                    <td class="tb-col-time"><span class="sub-text">{{ $activity->os }}</span></td>
                    <td class="tb-col-time"><span class="sub-text">{{ Carbon\Carbon::parse($activity->date)->toDateString() }}</span></td>
                </tr>
              @endforeach
            </tbody>
        </table>
        {{ $activities->withQueryString()->links() }}
    </div><!-- .card -->
</div><!-- .nk-block -->
@endsection
