@extends('admin.layouts.app')

@section('footerJS')
  <script>
    
  (function($){
  "use strict";
    $('#delete-user').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id            = button.data('id');
      var modal = $(this);
      modal.find('.modal-body input[name="user_id"]').val(id);
    });
    $('#send-email').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id            = button.data('id');
      var name          = button.data('name');
      var modal = $(this);
      modal.find('.modal-body .title b').html(name);
      modal.find('.modal-body input[name="user_id"]').val(id);
    });
  })(jQuery);
  </script>
 <script src="{{ url('js/support-messages.js') }}"></script>
 <script src="{{ url('tinymce/tinymce.min.js') }}"></script>
 <script src="{{ url('tinymce/sr.js') }}"></script>
@stop
@section('title', __('Users'))
@section('content')
<div class="nk-block-head nk-block-head-sm">
   <div class="nk-block-between">
      <div class="nk-block-head-content">
         <h3 class="nk-block-title fw-normal"><em class="icon ni ni-user"></em> <span>{{ __('Stores') }}</span></h3>
      </div>
      <div class="nk-block-head-content d-flex">
         <a href="{{ route('admin-create-user') }}" class="btn btn-primary mr-3">{{ __('New store') }}</a>
      <form method="get">
         <div class="toggle-wrap nk-block-tools-toggle">
            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
            <div class="toggle-expand-content" data-content="pageMenu">
               <ul class="nk-block-tools g-3">
                  <li class="w-100">
                     <div class="form-control-wrap">
                        <input type="text" class="form-control" name="query" placeholder="{{ __('Quick search') }}" value="{{ request()->get('query') }}">
                     </div>
                  </li>
                  <li class="w-100">
                    <div class="w-100">
                     <select name="type" class="form-select" data-search="off" data-ui="lg">
                       <option value="email" {{ request()->get('type') == 'email' ? 'selected' : '' }}>{{ __('Email') }}</option>
                       <option value="username" {{ request()->get('type') == 'username' ? 'selected' : '' }}>{{ __('Username') }}</option>
                     </select>
                    </div>
                  </li>
                  <li class="d-flex justify-content-end mr-2">
                    <button class="btn btn-icon btn-primary">
                      <em class="icon ni ni-search"></em>
                    </button>
                  </li>
               </ul>
            </div>
         </div>
       </form>
      </div>
   </div>
</div>
<table class="nk-tb-list nk-tb-ulist mt-4" data-auto-responsive="false">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col">
                <span class="sub-text">{{ __('Store') }}</span>
            </th>
            <th class="nk-tb-col tb-col-lg">
                <span class="sub-text">{{ __('Last Login') }}</span>
            </th>
            <th class="nk-tb-col tb-col-lg">
                <span class="sub-text">{{ __('Status') }}</span>
            </th>
            <th class="nk-tb-col tb-col-md">
                <span class="sub-text"> </span>
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $key)
        <tr class="nk-tb-item">
            <td class="nk-tb-col">
                <div class="user-card">
                    <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                     <img src="{{ avatar($key->id) }}" alt="">
                    </div>
                    <div class="user-info">
                        <span class="tb-lead">{{ full_name($key->id) }} <span class="dot dot-success d-md-none ml-1">
                        </span>
                    </span>
                    <span>{{ strtolower($key->email) }}</span>
                </div>
            </div>
        </td>
            <td class="nk-tb-col tb-col-lg">
                <span>{{ Carbon\Carbon::parse($key->activity)->toFormattedDateString() }}</span>
            </td>
            <td class="nk-tb-col tb-col-md">
                <span class="tb-status text-success">{{ ($key->active == 1) ? __('Active') : __('Inactive')}}</span>
            </td>
            <td class="nk-tb-col nk-tb-col-tools">
                <ul class="nk-tb-actions gx-1">
                    <li class="nk-tb-action-hidden">
                      @if ($user->id !== $key->id)
                      <form action="{{ route('admin-login-user') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $key->id }}" name="id">
                        <button class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('Login as ' . full_name($key->id)) }}">
                            <em class="icon ni ni-signin">
                            </em>
                        </button>
                      </form>
                      @endif
                    </li>
                    <li class="nk-tb-action-hidden">
                        <a href="#" data-toggle="modal" data-target="#send-email" data-id="{{ $key->id }}" data-name="{{full_name($key->id)}}" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('Send Email') }}">
                            <em class="icon ni ni-mail-fill">
                            </em>
                        </a>
                    </li>
                    <li class="nk-tb-action-hidden">
                        <a href="#" data-toggle="modal" data-target="#delete-user" data-id="{{ $key->id }}" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}">
                            <em class="icon ni ni-user-cross-fill">
                            </em>
                        </a>
                    </li>
                    <li>
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                <em class="icon ni ni-more-h">
                                </em>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a href="{{ url('/' . $key->username) }}" target="_blank">
                                            <em class="icon ni ni-template"></em>
                                            <span>{{ __('View Store') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                      <form action="{{ route('admin-login-user') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $key->id }}" name="id">
                                        <input type="hidden" value="true" name="settings">
                                        <button>
                                            <em class="icon ni ni-edit"></em>
                                            <span>{{ __('Edit user') }}</span>
                                        </button>
                                      </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
      @endforeach
    </tbody>
</table>

    <div class="modal fade" tabindex="-1" role="dialog" id="send-email" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">{{ __('New Mail to') }} <b></b></h5>
                    <form action="{{ route('send.user.mail') }}" method="post">
                        @csrf
                        <input type="hidden" value="" name="user_id">
                         <div class="form-group mt-5">
                             <label class="form-label" for="name">{{ __('Subject') }}</label>
                             <input type="text" class="form-control form-control-lg" id="subject" name="subject" placeholder="Enter subject">
                         </div>
                        <h4>{{ __('Subject shortcode') }}</h4>   
                        <code>@php
                          echo '@{{username}}, @{{name}}, @{{email}}';
                        @endphp</code>
                        <div class="gy-4 mb-3">
                           <div class="form-group mt-5">
                               <label class="form-label">{{ __('Message') }}</label>
                                <textarea class="form-control form-control-lg editor" name="message" placeholder="{{ __('Enter message') }}"></textarea>
                           </div>
                        </div>
                        <h4 class="mt-3">{{ __('Message short code') }}</h4>   
                        <code>@php
                          echo '@{{username}}, @{{name}}, @{{email}}, @{{tagline}}, @{{last_login}}, @{{package_name}}, @{{count_product}} @{{package_due}}';
                        @endphp</code>
                        <p>{{ __('Note: use short codes with braces') }} @php
                          echo "@{{ }}";
                        @endphp</p>
                        <div class="form-group mt-5">
                         <button type="submit" class="btn btn-block btn-primary">{{ __('Send') }}</button>
                        </div>
                    </form>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="delete-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <form action="{{ route('delete.user') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id">
                         <h4 class="bold text-danger">{{ __('TYPE DELETE') }}</h4>
                         <p class="text-danger">{{ __('This will delete all records of this user from your server') }}</p>
                         <div class="form-group mt-5">
                             <input type="text" class="form-control form-control-lg"  name="delete" placeholder="{{ __('DELETE') }}" autocomplete="off">
                         </div>
                        <div class="form-group mt-5">
                         <button type="submit" class="btn btn-primary btn-block">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
    <div class="d-flex justify-between users-pag"> {{ $users->withQueryString()->links() }} <h6><small>{{ __('Page') }} {{ $users->currentPage() }} {{ __('of') }} {{ $users->lastPage() .' '. __('Pages') }}</small></h6></div>
@stop
