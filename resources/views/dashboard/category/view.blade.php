@extends('layouts.app')
@section('title', 'Categories')
@section('footerJS')
<script>
  (function($){
  "use strict";
    $('#update_category').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var title         = button.data('title');
      var id            = button.data('id');
      var description   = button.data('description');
      var image         = button.data('image');
      var status        = button.data('status');
      var modal = $(this);
      if(status === 1){
        modal.find('.modal-body #select-111').attr('selected', '');
        modal.find('.modal-body #select-222').removeAttr('selected');
      }
      if(status === 0){
        modal.find('.modal-body #select-111').removeAttr('selected');
        modal.find('.modal-body #select-222').attr('selected', '');
      }
      modal.find('.modal-body input[name="title"]').val(title);
      modal.find('.modal-body input[name="id"]').val(id);
      modal.find('.modal-body textarea[name="description"]').html(description);
      modal.find('.modal-body .image-upload').find('img').attr('src', image);
    });
  })(jQuery);
</script>
@stop
@section('content')
      <div class="row mt-9">
          <div class="col-12 col-md-5">
           <div class="container-fluid m-auto">
             <div class="card-shadow card card-inner bdrs-20">
                 <form method="post" action="{{ route('user-product-post-category', 'new') }}" enctype="multipart/form-data" class="mb-3">
                   @csrf
                    <h5 class="text-muted">{{ __('Post a category') }}</h5>
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <div class="form-group custom"> 
                         <input type="text" placeholder="{{ __('Category name') }}" name="title" />
                        </div>
                      </div>
                      <div class="col-md-6">
                      <div class="form-group mt-4 mt-md-2">
                         <div class="form-control-wrap">
                            <select class="form-select" data-search="off" data-ui="lg" name="status">
                               <option value="1"> {{ __('Active') }} </option>
                               <option value="0"> {{ __('Hidden') }}</option>
                           </select>
                         </div>
                      </div>
                      </div>
                      <div class="col-12 mt-4">
                         <div class="image-upload pages">
                              <label for="upload">{!! __('Click here or drop an image to upload 1048MB max') !!}</label>
                              <input type="file" id="upload" name="media" class="upload">
                              <img src=" " alt=" ">
                         </div>
                      </div>
                      <div class="col-12 mt-3">
                        <div class="form-group custom"> 
                          <textarea name="description" placeholder="{{ __('Short description *optional') }}"></textarea>
                        </div>
                      </div>
                    </div>
                   <button class="btn btn-primary btn-lg btn-block mt-3">{{ __('Post') }}</button>
                 </form>
               </p>
             </div>
           </div>
          </div>

          <div class="col-12 col-md-7 mt-5">
            <div class="nk-block">
               <div class="nk-tb-list is-separate is-medium mb-3">
                  <div class="nk-tb-item nk-tb-head">
                     <div class="nk-tb-col"></div>
                     <div class="nk-tb-col tb-col-md"><span>{{ __('Date') }}</span></div>
                     <div class="nk-tb-col"><span class="d-none d-mb-block">{{ __('Status') }}</span></div>
                     <div class="nk-tb-col"><span>{{ __('Name') }}</span></div>
                     <div class="nk-tb-col"></div>
                  </div>
                  @foreach ($categories as $category)
                  <div class="nk-tb-item card-shadow bdrs-20">
                     <div class="nk-tb-col">
                      <span class="tb-lead"><a href="#" class="user-avatar"><img src="{{ getcategoryImage($category->id) }}" alt=""></a></span>
                    </div>
                     <div class="nk-tb-col tb-col-md"><span class="tb-sub">{{ Carbon\Carbon::parse($category->created_at)->toFormattedDateString() }}</span></div>
                     <div class="nk-tb-col">
                      <span class="dot bg-{{ $category->status == 1 ? 'success' : 'warning' }}"></span>
                    </div>
                     <div class="nk-tb-col"><span class="tb-sub">{{ $category->title }}</span></div>
                     <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1">
                           <li>
                             <a href="#" data-toggle="modal" data-id="{{ $category->id }}" data-title="{{ $category->title }}" data-description="{{ $category->description }}" data-image="{{ url('media/user/categories/'.$category->media) }}" data-status="{{ $category->status }}" data-target="#update_category" class="btn btn-icon btn-trigger btn-tooltip" title="" data-toggle="dropdown" data-original-title="{{ __('Edit category') }}"><em class="icon ni ni-edit"></em>
                              </a>
                           </li>
                           <li>
                            <form action="{{ route('user-product-post-category', 'delete') }}" method="post">
                              @csrf
                              <input type="hidden" name="id" value="{{ $category->id }}">
                              <button class="btn btn-icon text-danger btn-tooltip" title="" data-confirm="{{ __('Are you sure you want to delete this category?') }}"><em class="icon ni ni-trash"></em></button>
                            </form>
                           </li>
                        </ul>
                     </div>
                  </div>
                  @endforeach
               </div>
               <div class="card">
                  <div class="card-inner">
                     <div class="nk-block-between-md g-3">
                        <div class="g">
                          
                        </div>
                     </div>
                  </div>
               </div>
            </div>

          </div>
      </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="update_category" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
              <div class="modal-body modal-body-lg">
                  <form action="{{ route('user-product-post-category', 'edit') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="id">
                      <h5 class="text-muted">{{ __('Edit category') }}</h5>
                      <div class="row mt-3">
                        <div class="col-md-6">
                          <div class="form-group custom"> 
                           <input type="text" placeholder="{{ __('Category name') }}" name="title" />
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group mt-4 mt-md-2">
                           <div class="form-control-wrap">
                              <select class="form-select" data-search="off" data-ui="lg" name="status">
                                 <option value="1" id="select-111"> {{ __('Active') }} </option>
                                 <option value="0" id="select-222"> {{ __('Hidden') }}</option>
                             </select>
                           </div>
                        </div>
                        </div>
                        <div class="col-12 mt-4">
                         <div class="image-upload pages active">
                              <label for="upload">{!! __('Click here or drop an image to upload 1048MB max') !!}</label>
                              <input type="file" id="upload" name="media" class="upload">
                              <img src=" " alt=" ">
                         </div>
                        </div>
                        <div class="col-12 mt-3">
                          <div class="form-group custom"> 
                            <textarea name="description" placeholder="{{ __('Short description *optional') }}"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group mt-5">
                       <button type="submit" class="btn btn-block btn-primary">{{ __('Submit') }}</button>
                      </div>
                  </form>
              </div><!-- .modal-body -->
          </div><!-- .modal-content -->
      </div><!-- .modal-dialog -->
  </div>
  @stop