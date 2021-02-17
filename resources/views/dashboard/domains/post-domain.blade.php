@extends('layouts.app')

@section('title', __('Create domain'))
@section('content')
<div class="nk-block-head mt-8">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Custom Domain') }}</h2>
        </div>
    </div>
</div>
<div class="card card-shadow card-inner bdrs-20">
    <div class="card-body">
        <form action="{{ route('user-domains-post') }}" method="post" role="form">
           @csrf
           @if (!empty(request()->get('id')))
             <input type="hidden" name="domain_id" value="{{request()->get('id')}}">
           @endif
           <input type="hidden" value="{{ $user->id }}" name="user">

            <p class="text-muted">{{ __('Make sure your domain or subdomain has an A record pointing to') }} <b>{{$_SERVER['SERVER_ADDR']}}</b> {{ __('or CNAME record pointing to') }} <b>{{ parse_url(url(env('APP_URL')))['host'] ?? '' }}</b>.</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <h6 class="mb-3">{{ __('Domain / Subdomain') }}</h6>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="scheme" class="form-select input-group-text" data-search="off" data-ui="lg">
                                <option value="https://" {{ !empty($domain) && $domain->scheme == 'https://' ? 'selected' : '' }}>{{ __('https://') }}</option>
                                <option value="http://" {{ !empty($domain) && $domain->scheme == 'http://' ? 'selected' : '' }}>{{ __('http://') }}</option>
                            </select>
                        </div>
                        <input type="text" class="form-control form-control-lg" name="host" placeholder="domain.com" value="{{ $domain->host ?? '' }}" required="required">
                    </div>
                    <p class="text-muted mt-2">{!! __('Only <code>subdomain.domain.com</code> and <code>domain.com</code> formats are allowed (subdomains or root domains).') !!}</p>
                </div>
              </div>
              <div class="col-md-6 mt-4 mt-lg-0">
               <h6 class="mb-3">{{ __('Status') }}</h6>
               <select name="status" class="form-select input-group-text" data-search="off" data-ui="lg">
                   <option value="1" {{ !empty($domain) && $domain->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                   <option value="0" {{ !empty($domain) && $domain->status == 0 ? 'selected' : '' }}>{{ __('In active') }}</option>
               </select>
              </div>
            </div>

            <div class="mt-4">
                <button type="submit" name="submit" class="button primary w-100">{{ !empty($domain) ? __('Edit domain') : __('Add Domain') }}</button>
            </div>
        </form>

    </div>
</div>

@endsection
