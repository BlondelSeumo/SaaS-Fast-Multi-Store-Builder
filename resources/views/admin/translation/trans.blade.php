@extends('admin.layouts.app')

@section('title', __('Tanslations'))
@section('content')

<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Translation') }}</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card card-inner">
           <button class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#new_trans">{{ __('Add new translation') }}</button>
        </div>
        @foreach ($alltrans as $item)
        @php
          $file = pathinfo($item);
        @endphp
        <div class="card card-inner bdrs-15 m-3 card-shadow">
              <h4 class="admin-pricing-box-title">{{ ucfirst($file['filename']) }} </h4>
              @if (config('app.locale') == strtolower($file['filename']))
                  <small>{{ __('Current') }}</small>
              @endif
              <div class="admin-pricing-box-content row">
                <div class="col-12">
                    <div class="status-info success">
                      <a href="{{request()->fullUrlWithQuery(['trans' => $file['filename']])}}" class="btn btn-primary btn-block mt-3">{{ __('Edit translation') }} <em class="icon ni ni-edit ml-1"></em></a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="status-info">
                        <form action="{{ route('admin-translation-post', 'copy') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $file['filename'] }}" name="trans">
                            <button class="btn btn-success btn-block mt-3">{{ __('Copy') }} <em class="icon ni ni-copy ml-1"></em></button>
                        </form>
                    </div>
                </div>
              </div>
         </div>
        @endforeach
    </div>
    <div class="col-md-8">
        <div class="row card-shadow card-inner bdrs-20 mb-4">
            <div class="col-md-6">
                <h3>{{ $locale }}</h3>
            </div>
            <div class="col-md-3">
                <form action="{{ route('admin-translation-post', 'delete-trans') }}" method="post">
                    @csrf
                    <input type="hidden" name="trans" value="{{$locale}}">
                    <button class="btn btn-block" data-confirm="{{ __('Are you sure you want to delete this?') }}"><p class="text-danger">{{ __('DELETE') }}</p></button>
                </form>
            </div>
           @if (config('app.locale') !== strtolower($locale))
            <div class="col-md-3">
                <form action="{{ route('admin-translation-post', 'set-active') }}" method="post">
                    @csrf
                    <input type="hidden" name="locale" value="{{$locale}}">
                    <button class="btn btn-block"><p class="text-success">{{ __('Set active') }}</p></button>
                </form>
            </div>
            @endif
        </div>
        <div class="card card-shadow card-inner bdrs-20">
            <form class="row mb-5" method="post" action="{{ route('admin-translation-post', 'edit-trans-name') }}">
                @csrf
                <input type="hidden" name="trans" value="{{$locale}}">
                <div class="col-md-8">
                    <div class="form-group">
                         <h6>{{ __('Translation name') }}</h6>
                         <input type="text" class="form-control c-textarea form-control-lg" placeholder="{{ __('Translation name') }}" name="trans_name" value="{{ $locale }}" />
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <button class="btn btn-block btn-primary mt-4">{{ __('Post') }}</button>
                </div>
            </form>
            <form action="{{ route('admin-translation-post', 'post') }}" method="post">
                @csrf
                <div class="form-group">
                     <h6>{{ __('Search in translation') }}</h6>
                     <input type="text" class="form-control c-textarea form-control-lg" placeholder="{{ __('search') }}" data-search />
                </div>
                <input type="hidden" name="trans" value="{{$locale}}">
                <h5>{{ __('Add new translation') }}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="key" class="form-control c-textarea form-control-lg" placeholder="Key"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-4 mt-lg-0">
                            <textarea name="value" class="form-control c-textarea form-control-lg" placeholder="Value"></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                     <button class="btn btn-primary btn-block mt-4">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
        @if (!empty($trans_files))
        <div class="nk-block mt-5 card-shadow bdrs-20 card card-inner">
           <div class="nk-tb-list is-separate is-medium mb-3">
              <div class="nk-tb-item nk-tb-head">
                 <div class="nk-tb-col"><span>{{ __('Key') }}</span></div>
                 <div class="nk-tb-col tb-col-md"><span>{{ __('Value') }}</span></div>
                 <div class="nk-tb-col"></div>
              </div>
             @foreach ($trans_files as $key => $value)
              <div class="nk-tb-item background-lighter" data-filter-item data-filter-name="{{$key}}">
                 <div class="nk-tb-col background-lighter">
                    <span class="tb-lead">{{$key}}</span>
                 </div>
                 <div class="nk-tb-col tb-col-md background-lighter">
                    <span class="tb-sub">{{$value}}</span>
                 </div>
                 <div class="nk-tb-col nk-tb-col-tools background-lighter">
                    <button class="button primary w-100" data-toggle="modal" data-key="{{$key}}" data-previous_key="{{$key}}" data-value="{{$value}}" data-target="#update_trans">Edit</button>
                 </div>
                 <div class="nk-tb-col nk-tb-col-tools background-lighter">
                    <form action="{{ route('admin-translation-post', 'delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="trans" value="{{$locale}}">
                        <input type="hidden" name="key" value="{{$key}}">
                        <h5><button class="ml-3 btn text-danger"><em class="icon ni ni-trash"></em></button></h5>
                    </form>
                 </div>
              </div>
              @endforeach
           </div>
        </div>
        @endif
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="update_trans" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <form action="{{ route('admin-translation-post', 'edit') }}" method="post">
                    @csrf
                    <input type="hidden" name="trans" value="{{$locale}}">
                    <input type="hidden" name="previous_key">
                     <h4 class="bold">{{ __('Edit translation') }}</h4>
                     <div class="form-group mt-5">
                         <input type="text" class="form-control form-control-lg" name="key" placeholder="{{ __('Key') }}">
                     </div>
                     <div class="form-group mt-5">
                         <input type="text" class="form-control form-control-lg" name="value" placeholder="{{ __('Value') }}">
                     </div>
                    <div class="form-group mt-5">
                     <button type="submit" class="btn btn-block btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="new_trans" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <form action="{{ route('admin-translation-post', 'new') }}" method="post">
                    @csrf
                     <h4 class="bold">{{ __('New translation') }}</h4>
                     <div class="form-group mt-5">
                         <input type="text" class="form-control form-control-lg" name="name" placeholder="{{ __('Name Ex: french') }}">
                     </div>
                    <div class="form-group mt-5">
                     <button type="submit" class="btn btn-block btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
@endsection
