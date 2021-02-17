@extends('admin.layouts.app')

@section('title', __('Categories'))
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Categories') }}</h2>
        </div>
        <div class="nk-block-head-content">
            <ul class="nk-block-tools gx-3">
                <li class="btn-wrap"><a href="{{ route('add.category') }}" class="btn btn-icon btn-xl btn-warning"><em class="icon ni ni-plus"></em></a><span class="btn-extext">{{ __('add new category') }}</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="nk-block-head-content mt-4">
    <div class="nk-block-head-sub"><span>{{ __('All Categories') }}</span></div>
</div>
<div class="nk-block mt-4">
    @if (!count($categories) > 0)
	     <div class="nk-block-head-content text-center">
	         <h2 class="nk-block-title fw-normal">{{ __('No category found') }} <a class="btn btn-link" href="{{ route('add.category') }}">{{ __('Add category page') }}</a></h2>
	     </div>
     @else
    <div class="card card-bordered">
        <table class="table table-tickets">
            <thead class="tb-ticket-head">
                <tr class="tb-ticket-title">
                    <th class="tb-ticket-id">
                    	<span>{{ __('Title') }}</span>
                    </th>
                    <th class="tb-ticket-desc">
                        <span>{{ __('Description') }}</span>
                    </th>
                    <th class="tb-ticket-status">
                        <span>{{ __('Status') }}</span>
                    </th>
                    <th class="tb-ticket-action"> &nbsp; </th>
                </tr>
            </thead>
            <tbody class="tb-ticket-body">
            	@foreach ($categories as $category)
	                <tr class="tb-ticket-item is-unread bg-white">
	                    <td class="tb-ticket-id"><a href="{{ url(route('all-pages') .'/'. $category->url) }}">{{ $category->title }}</a></td>
	                    <td class="tb-ticket-desc">
	                        <a href="{{ url(route('all-pages') .'/'. $category->url) }}"><span class="title">{!! clean(Str::limit($category->description, $limit = 40, $end = '...'), 'titles') !!}</span></a>
	                    </td>
	                    <td class="tb-ticket-status">
	                        <span class="badge {{ ($category->status == 1) ? "badge-success" : "badge-warning" }}">{{ ($category->status == 1) ? __('active') : __('Inactive') }}</span>
	                    </td>
	                    <td class="tb-ticket-action">
                          <ul class="nk-tb-actions gx-1">
                            <li class="mr-5">
                                <a href="{{ url(route('category') .'/'. $category->id) }}" class="btn btn-icon">{{ __('Edit') }} <em class="icon ni ni-edit"></em>
                                </a>
                            </li>
                            <li class="mr-5">
                                <a href="#" data-toggle="modal" data-target="#delete-{{$category->id}}" class="btn btn-icon" data-placement="top" title="{{ __('Delete') }}"> {{ __('delete') }} <em class="icon ni ni-cross"></em>
                                </a>
                            </li>
                          </ul>
	                    </td>
	                </tr>
                <div class="modal fade" tabindex="-1" role="dialog" id="delete-{{$category->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                            <div class="modal-body modal-body-lg">
                                <form action="{{ route('delete-admin-category') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$category->id}}" name="category_id">
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
</div>
@endsection
