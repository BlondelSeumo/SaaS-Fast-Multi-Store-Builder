@extends('admin.layouts.app')

@section('title', __('Faq'))
@section('content')
<div class="nk-block-head">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Faq') }}</h2>
        </div>
        <div class="nk-block-head-content">
            <a href="#" data-toggle="modal" data-target="#new-faq" class="btn btn-warning"><em class="icon ni ni-plus"></em> {{ __('Add new faq') }}</a>
        </div>
    </div>
</div>

@if (count($faqs) > 0)
    <div class="nk-block-head-content mt-4">
        <div class="nk-block-head-sub"><span>{{ __('All faq') }}</span></div>
    </div>
@endif
<div class="nk-block mt-4">
    @if (!count($faqs) > 0)
	     <div class="nk-block-head-content text-center">
	         <h2 class="nk-block-title fw-normal">{{ __('No faq found') }} <a class="btn btn-link" href="#" data-toggle="modal" data-target="#new-faq">{{ __('Add faq page') }}</a></h2>
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
                        <span>{{ __('Note') }}</span>
                    </th>
                    <th class="tb-ticket-status">
                        <span>{{ __('Status') }}</span>
                    </th>
                    <th class="tb-ticket-action"> &nbsp; </th>
                </tr>
            </thead>
            <tbody class="tb-ticket-body">
            	@foreach ($faqs as $faq)
	                <tr class="tb-ticket-item is-unread bg-white">
	                    <td class="tb-ticket-id"><a>{{ $faq->name }}</a></td>
	                    <td class="tb-ticket-desc">
	                        <a><span class="title">{{ Str::limit($faq->note, $limit = 40, $end = '...') }}</span></a>
	                    </td>
	                    <td class="tb-ticket-status">
	                        <span class="badge {{ ($faq->status == 1) ? "badge-success" : "badge-warning" }}">{{ ($faq->status == 1) ? "active" : "Inactive" }}</span>
	                    </td>
	                    <td class="tb-ticket-action">
                          <ul class="nk-tb-actions gx-1">
                            <li class="mr-5">
                                <a href="#" data-toggle="modal" data-target="#edit-faq-{{$faq->id}}" class="btn btn-icon">{{ __('Edit') }} <em class="icon ni ni-edit"></em>
                                </a>
                            </li>
                            <li class="mr-5">
                                <a href="#" data-toggle="modal" data-target="#delete-{{$faq->id}}" class="btn btn-icon" data-placement="top" title="Delete"> {{ __('delete') }} <em class="icon ni ni-cross"></em>
                                </a>
                            </li>
                          </ul>
	                    </td>
	                </tr>
                    <!-- @ Profile Edit Modal @e -->
                    <div class="modal fade" tabindex="-1" role="dialog" id="edit-faq-{{$faq->id}}">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                <div class="modal-body modal-body-lg">
                                    <h5 class="title">{{ __('New FAQ') }}</h5>
                                    <form action="{{ route('edit.faq') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $faq->id }}" name="faq_id">
                                         <div class="row gy-4">
                                            <div class="col-md-6">
                                                <div class="form-group mt-5">
                                                    <label class="form-label" for="name">{{ __('Faq name') }}</label>
                                                    <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ $faq->name }}" placeholder="{{ __('Enter faq name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mt-5">
                                                    <label class="form-label">{{ __('Faq status') }}</label>
                                                      <select class="form-select" data-search="off" data-ui="lg" name="status">
                                                         <option value="1" {{ ($faq->status == 1) ? "selected" : "" }}>Active</option>
                                                         <option value="0" {{ ($faq->status == 0) ? "selected" : "" }}> {{ __('Hidden') }}</option>
                                                     </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gy-4">
                                           <div class="form-group mt-5">
                                               <label class="form-label">{{ __('Faq note') }}</label>
                                                <textarea class="form-control form-control-lg" name="note" placeholder="{{ __('Enter faq note') }}">{{ $faq->note }}</textarea>
                                           </div>
                                        </div>
                                           <div class="form-group mt-5">
                                            <button type="submit" class="btn btn-primary">{{ __('Post') }}</button>
                                           </div>
                                    </form>
                                </div><!-- .modal-body -->
                            </div><!-- .modal-content -->
                        </div><!-- .modal-dialog -->
                    </div><!-- .modal -->
                <div class="modal fade" tabindex="-1" role="dialog" id="delete-{{$faq->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                            <div class="modal-body modal-body-lg">
                                <form action="{{ route('delete-admin-faq') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$faq->id}}" name="faq_id">
                                     <h4 class="bold text-danger">{{ __('TYPE DELETE') }}</h4>
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
            </tbody>
        </table>
    </div>
  @endif
</div>


<!-- @ Profile Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="new-faq">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">{{ __('New FAQ') }}</h5>
                <form action="{{ route('post.faq') }}" method="post">
                    @csrf
                     <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group mt-5">
                                <label class="form-label" for="name">{{ __('Faq name') }}</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="{{ __('Enter faq name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-5">
                                <label class="form-label">{{ __('Faq status') }}</label>
                                  <select class="form-select" data-search="off" data-ui="lg" name="status">
                                     <option value="1" selected="">{{ __('Active') }}</option>
                                     <option value="0">{{ __('Hidden') }}</option>
                                 </select>
                            </div>
                        </div>
                    </div>
                    <div class="gy-4">
                       <div class="form-group mt-5">
                           <label class="form-label">{{ __('Faq note') }}</label>
                            <textarea class="form-control form-control-lg" name="note" placeholder="{{ __('Enter faq note') }}"></textarea>
                       </div>
                    </div>
                       <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary">{{ __('Post') }}</button>
                       </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
@endsection
