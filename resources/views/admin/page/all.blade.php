@extends('admin.layouts.app')

@section('title', __('Pages'))
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Pages') }}</h2>
        </div>
        <div class="nk-block-head-content">
            <ul class="nk-block-tools gx-3">
                <li class="btn-wrap"><a href="{{ route('add.category') }}" class="btn btn-icon btn-xl btn-warning"><em class="icon ni ni-plus"></em></a><span class="btn-extext">{{ __('add new category') }}</span></li>
                <li class="btn-wrap"><a href="{{ route('add.pages') }}" class="btn btn-icon btn-xl btn-warning"><em class="icon ni ni-plus"></em></a><span class="btn-extext">{{ __('Add new page') }}</span></li>
            </ul>
        </div>
    </div>
</div>

@if (!count($pages) > 0)
<div class="nk-block-head-content mt-4">
    <div class="nk-block-head-sub"><span>{{ __('All pages') }}</span></div>
</div>
@endif
<div class="nk-block mt-4">
    @if (count($pages) > 0)
    <div class="card card-bordered">
        <table class="table table-tickets">
            <thead class="tb-ticket-head">
                <tr class="tb-ticket-title">
                    <th class="tb-ticket-id">
                    	<span>{{ __('Title') }}</span>
                    </th>
                    <th class="tb-ticket-desc">
                        <span>{{ __('Subject') }}</span>
                    </th>
                    <th class="tb-ticket-date tb-col-md">
                        <span>{{ __('Date') }}</span>
                    </th>
                    <th class="tb-ticket-status">
                        <span>{{ __('Status') }}</span>
                    </th>
                    <th class="tb-ticket-action"> &nbsp; </th>
                </tr><!-- .tb-ticket-title -->
            </thead>
            <tbody class="tb-ticket-body">
            	@foreach ($pages as $page)
            		@php
            			$cd = json_decode($page->settings);
            		@endphp
	                <tr class="tb-ticket-item is-unread bg-white">
	                    <td class="tb-ticket-id"><a href="{{ url('page/'. $page->url) }}">{{ $page->title }}</a></td>
	                    <td class="tb-ticket-desc">
	                        <a href="{{ url('page/'. $page->url) }}"><span class="title">{!! clean(Str::limit($cd->sh_description, $limit = 40, $end = '...'), 'titles') !!}</span></a>
	                    </td>
	                    <td class="tb-ticket-date tb-col-md">
	                        <span class="date">{{ Carbon\Carbon::parse($page->date)->toDateString()}}</span>
	                    </td>
	                    <td class="tb-ticket-status">
	                        <span class="badge {{ ($page->status == 1) ? "badge-success" : "badge-warning" }}">{{ ($page->status == 1) ? "active" : "Inactive" }}</span>
	                    </td>
	                    <td class="tb-ticket-action">
                        <ul class="nk-tb-actions gx-1">
                            <li class="mr-5">
                                <a href="{{ url(route('pages') .'/'. $page->id) }}" class="btn btn-icon">{{ __('Edit') }} <em class="icon ni ni-edit"></em>
                                </a>
                            </li>
                            <li class="mr-5">
                                <a href="#" data-toggle="modal" data-target="#delete-{{$page->id}}" class="btn btn-icon" data-placement="top" title="{{ __('Delete') }}"> {{ __('delete') }} <em class="icon ni ni-cross"></em>
                                </a>
                            </li>
                          </ul>
	                    </td>
	                </tr><!-- .tb-ticket-item -->

                <div class="modal fade" tabindex="-1" role="dialog" id="delete-{{$page->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                            <div class="modal-body modal-body-lg">
                                <form action="{{ route('delete-admin-page') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$page->id}}" name="page_id">
                                     <h4 class="bold text-danger">{{ __('TYPE DELETE') }}</h4>
                                     <div class="form-group mt-5">
                                         <input type="text" class="form-control form-control-lg" name="delete" placeholder="{{ __('DELETE') }}" autocomplete="off">
                                     </div>
                                    <div class="form-group mt-5">
                                     <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                    </div>
                                </form>
                            </div><!-- .modal-body -->
                        </div><!-- .modal-content -->
                    </div><!-- .modal-dialog -->
                </div>
            	@endforeach
            </tbody>
        </table>
    </div>
  @endif
    @if (!count($pages) > 0)
         <div class="nk-block-head-content text-center">
             <h2 class="nk-block-title fw-normal">{{ __('No page found') }} <a class="btn btn-link" href="{{ route('add.pages') }}">{{ __('Add new page') }}</a></h2>
         </div>
    @endif
</div>
@endsection
