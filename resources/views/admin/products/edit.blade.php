@extends('admin.layouts.app')
@section('title', 'Edit Product')
@section('Js')
<link href="{{ url('css/tagify.css') }}" rel="stylesheet">
<script src="{{ url('js/tagify.min.js') }}"></script>
<script src="{{ asset('js/Sortable.min.js') }}"></script>
@stop
@section('footerJS')
<script src="{{ url('js/tagify.country.js') }}"></script>
<script src="{{ url('tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('tinymce/sr.js') }}"></script>
<script src="{{ url('js/others.js') }}"></script>
<script>
(function($){
"use strict";
  $('#view_review').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var review         = button.data('review');
    var modal = $(this);
    modal.find('.modal-body p[id="review-p"]').html(review);
  });
})(jQuery);
</script>
@stop
@section('content')
<div class="mt-9">
 <form class="form" action="{{ route('user-post-product', 'edit') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $product->id }}" name="id">
    <div class="row">
      <div class="col-12">
        <ul class="nav nav-tabs nav-tabs-s2">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#basic">{{ __('General') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#price">{{ __('Price') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#inventory">{{ __('Inventory') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#product_files">{{ __('Files') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#options">{{ __('Options') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#reviews">{{ __('Reviews') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#others">{{ __('Others') }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="basic">
              <div class="row">
               <div class="col-md-6">
                  <div class="form-group custom mb-4">
                  <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                    <span>{{ __('Product name') }}</span>
                    <small class="d-block mt-2">{{ __('Give this product a name. Ex: Phones') }}</small>
                  </label>
                     <input type="text" placeholder="Product Title" value="{{ $product->title }}" name="product_name">
                  </div>
               </div>
               <div class="col-md-6">
                <div class="form-group tags custom mb-4">
                  <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                    <span>{{ __('Shipping') }}</span>
                    <small class="d-block mt-2">{{ __('Enter shipping locations. State or country. Remove to disable shipping.') }}</small>
                  </label>
                   <div class="form-control-wrap">
                   <input type="text" value="{{ $product->extra->shipping ?? '' }}" class="form-control form-control-lg custom-tags" placeholder="{{ __('Product shipping') }}" name="product_shipping">
                   </div>
                </div>
               </div>
               <div class="col-md-6">
                <div class="form-group custom mt-5 mt-lg-2">
                   <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4"><span>{{ __('Product Condition') }}</span></label>
                   <div class="form-control-wrap">
                      <select class="form-select" data-search="off" data-ui="lg" name="product_condition">
                         <option value="none" {{ $product->product_condition == 'none' ? 'selected' : '' }}> {{ __('None') }} </option>
                         <option value="new" {{ $product->product_condition == 'new' ? 'selected' : '' }}> {{ __('New') }} </option>
                         <option value="used" {{ $product->product_condition == 'used' ? 'selected' : '' }}> {{ __('Used') }}</option>
                     </select>
                   </div>
                </div>
               </div>
               <div class="col-md-6">
                <div class="form-group custom mt-3 mt-lg-2 p-3">
                   <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4"><span>{{ __('Product Categories') }}</span></label>
                   <div class="form-control-wrap mt-3">
                      <select class="form-select" data-search="off" data-ui="lg" name="product_categories[]" multiple>
                        @foreach ($categories as $item)
                         <option value="{{ $item->slug }}" {{ !empty($product->categories) && in_array($item->slug, $product->categories) ? 'selected' : '' }}> {{ $item->title }} </option>
                        @endforeach
                     </select>
                   </div>
                </div>
               </div>
               <div class="col-md-12">
                <div class="section-head my-5">
                  <p>{{ __('Product Description') }}</p>
                </div>
               </div>
            </div>
          <div class="form-group custom mt-4">
             <textarea class="form-control editor b-0" name="product_description" placeholder="Write a description">{!! clean($product->description, 'titles') !!}</textarea>
          </div>
            </div>
            <div class="tab-pane" id="price">
              <div class="row">
                 <div class="col-md-6">
                    <div class="form-group custom mb-4">
                    <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                      <span>{{ __('Product Price') }}</span>
                      <small class="d-block mt-2">{{ __('Enter this product price.') }}</small>
                    </label>
                       <input type="text" value="{{ $product->price }}" placeholder="Product Price" name="product_price">
                    </div>
                 </div>
               <div class="col-md-6">
                  <div class="form-group custom mb-4">
                  <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                    <span>{{ __('Sale Price') }}</span>
                    <small class="d-block mt-2">{{ __('Enter sale price if this product is on discount. Remove to disable') }}</small>
                  </label>
                     <input type="text" value="{{ $product->salePrice }}" placeholder="Sale Price" name="product_salePrice">
                  </div>
               </div>
              </div>
            </div>
            <div class="tab-pane" id="inventory">
              <div class="row">
                 <div class="col-md-6">
                    <div class="form-group custom mb-4">
                      <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                        <span>{{ __('Product Stock') }}</span>
                        <small class="d-block mt-2">{{ __('Enter available stock. Leave empty to disable.') }}</small>
                      </label>
                       <input type="text" value="{{ $product->stock }}" placeholder="Product Stock" name="product_stock">
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="form-group custom mb-4">
                      <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                        <span>{{ __('Stock Management') }}</span>
                        <small class="d-block mt-2">{{ __('Choose the way you want our platform to manage your stock') }}</small>
                      </label>
                      <select class="form-select" name="manage_stock" data-search="off" data-ui="lg">
                        <option value="0" {{ $product->stock_management == 0 ? 'selected' : '' }}>{{ __('Dont manage stock') }}</option>
                        <option value="1" {{ $product->stock_management == 1 ? 'selected' : '' }}>{{ __('Manage stock') }}</option>
                      </select>
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="form-group custom mb-4">
                      <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                        <span>{{ __('Stock Status') }}</span>
                        <small class="d-block mt-2">{{ __('Choose if stock is available or not') }}</small>
                      </label>
                      <select class="form-select" name="stock_status" data-search="off" data-ui="lg">
                        <option value="1" {{ $product->stock_status == 1 ? 'selected' : '' }}>{{ __('In Stock') }}</option>
                        <option value="0" {{ $product->stock_status == 0 ? 'selected' : '' }}>{{ __('Out of stock') }}</option>
                      </select>
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="form-group custom mb-4">
                      <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                        <span>{{ __('Product Sku') }}</span>
                        <small class="d-block mt-2">{{ __('Enter product sku') }}</small>
                      </label>
                       <input type="text" value="{{ $product->sku }}" placeholder="{{ __('Product Sku') }}" name="product_sku">
                    </div>
                 </div>
              </div>
            </div>
            <div class="tab-pane" id="options">
             <div class="col-12">
              <div class="nk-tb-list po-wrap is-separate is-medium mb-3">
                @php
                  $x = 0;
                @endphp
                @foreach (product_options($user->id, $product->id) as $item)
                @php
                  $x++;
                @endphp
                   <div class="nk-tb-item po-item d-block my-4 append bg-lighter p-4" data-id="{{$x}}" data-poname="options">
                    <input type="hidden" data-po-name="id" value="{{ $item->id }}">
                      <div class="nk-item-custom">
                         <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span>{{ __('Name') }}</span></div>
                            <div class="nk-tb-col"><span>{{ __('Type') }}</span></div>
                            <div class="nk-tb-col"></div>
                            <div class="nk-tb-col"></div>
                            <div></div>
                         </div>
                         <div class="nk-tb-col bg-lighter">
                            <div class="form-group">
                               <input type="text" name="" value="{{ $item->name }}" data-po-name="name" class="form-control">
                            </div>
                         </div>
                         <div class="nk-tb-col bg-lighter">
                          <div class="h-100 d-flex align-items-center">
                            <select data-po-name="type" class="options-type">
                               <option>
                                  {{ __('Please Select') }}
                               </option>
                               <optgroup label="Select">
                                  <option value="dropdown" {{ $item->type == 'dropdown' ? 'selected' : '' }}>
                                     {{ __('Dropdown') }}
                                  </option>
                                  <option value="checkbox" {{ $item->type == 'checkbox' ? 'selected' : '' }}>
                                     {{ __('Checkbox') }}
                                  </option>
                                  <option value="radio" {{ $item->type == 'radio' ? 'selected' : '' }}>
                                     {{ __('Radio Button') }}
                                  </option>
                                  <option value="multiple_select" {{ $item->type == 'multiple_select' ? 'selected' : '' }}>
                                     {{ __('Multiple Select') }}
                                  </option>
                               </optgroup>
                            </select>
                          </div>
                         </div>
                         <div class="nk-tb-col bg-lighter">
                          <div class="h-100 d-flex align-items-center">
                             <div class="custom-control custom-control-alternative custom-checkbox">
                               <input type="hidden" data-po-name="required" value="0">
                               <input class="custom-control-input" type="checkbox" data-po-name="required" id="required-{{$item->id}}" {{ $item->is_required == 1 ? 'checked' : '' }} value="1">
                               <label class="custom-control-label" for="required-{{$item->id}}">
                                 <span class="text-muted">{{ __('Required') }}</span>
                               </label>
                             </div>
                           </div>
                         </div>
                         <div class="nk-tb-col bg-lighter">
                            <span class="tb-lead"><a data-route="{{ route('user-remove-product-option') }}" class="btn text-white btn-danger remove">

                            <span class="d-none d-md-block">{{ __('Delete') }}</span>
                            <i class="ni ni-cross d-block d-md-none"></i>
                            </a></span>
                         </div>
                      </div>
                         <div class="nk-tb-list po-val-wrap is-separate is-medium mb-3 mt-4 pt-4">
                           <div class="nk-tb-item nk-tb-head">
                              <div class="nk-tb-col hide-if-text-textarea"><span>{{ __('Label') }}</span></div>
                              <div class="nk-tb-col"><span>{{ __('Price') }}</span></div>
                              <div class="nk-tb-col"></div>
                           </div>

                           @foreach (product_options_values($item->id) as $val)
                            <div class="nk-tb-item po-val-item background-lighter" data-poval-name="values">
                            <input type="hidden" class="option-values-id" data-poval-name="id" value="{{ $val->id }}">
                              <div class="nk-tb-col background-lighter hide-if-text-textarea">
                                 <div class="form-group">
                                    <input type="text" value="{{ $val->label }}" data-poval-name="label" class="form-control">
                                 </div>
                              </div>
                              <div class="nk-tb-col background-lighter">
                                 <div class="form-group">
                                    <input type="number" value="{{ $val->price }}" data-poval-name="price" class="form-control">
                                 </div>
                              </div>
                              <div class="nk-tb-col background-lighter">
                                 <span class="tb-lead"><a data-route="{{ route('user-remove-product-option-value') }}" class="btn btn-danger text-white option-remove">
                                    <span class="d-none d-md-block">{{ __('Delete') }}</span>
                                    <i class="ni ni-cross d-block d-md-none"></i>
                                 </a></span>
                              </div>
                           </div>
                           @endforeach
                         </div>
                      <a class="btn btn-primary mx-3 my-4 po-val-add-button text-white">{{ __('Add New Row') }}</a>
                   </div>
                @endforeach
              </div>

              <a class="btn btn-primary px-5 po-add-button w-lg-50 text-white btn-lg">{{ __('Add New Option') }}</a>
             </div>
            </div>
            <div class="tab-pane" id="product_files">
              <div class="row">
                 <div class="col-12 col-md-6">
                <div class="section-head my-5">
                   <p>{{ __('Product Images') }}</p>
                </div>
                  <div class="container">
                    <div class="upload-form-wrap">
                    <div class="uploader" id="drag-and-drop-zone">
                      <div class="uploader-icon-circle">
                        <i class="icon ni ni-upload-cloud"></i>
                      </div>
                      <div class="uploader-bottom">
                        <span>{{ __('Drop images here to upload') }}</span>
                        <span>{{ __('or') }}</span>
                        <input type="file" name="media[]" class="uploader_input" multiple="">
                        <span class="uploader-button">
                         <button>
                           <span>{{ __('Browse files') }}</span>
                         </button>
                        </span>
                        <span>{{ __('The maximum file size is -') . settings('user.products_image_size') . 'MB' }} <br>{{ __('maximum image is -') }} {{ settings('user.products_image_limit') }}</span>
                      </div>
                    </div>
                    <div class="my-4">
                      <p class="text-muted">{{ __('Reorder images. Drag images to top to set as active') }}</p>
                    </div>
                      <!-- File List -->
                      <div class="files-card">
                        <ul class="list-unstyled files sortable-div" data-route="{{ route('user-products-sortable-images', $product->id) }}" id="files">
                           @foreach ($product->media as $image)
                             @if (file_exists(media_path('user/products/'.$image)))
                              <li class='file-item sortable-item' data-id="{{ $image }}">
                                <div class='file-item-thumbnail'>
                                  <div class='file-item-icon'>
                                    <img class='preview-img' src='{{ url('media/user/products/'.$image) }}'></div>
                                  </div>
                                  <div class='file-item-body'><p>{{$image}}</p><span>{{ nr(filesize(media_path('user/products/'.$image))) }}</span>
                                  </div>
                                  <div class="file-item-status">
                                    <a href="#" class="text-muted item-handle d-flex"><i class="icon ni ni-move lead mr-1"></i></a>
                                  </div>
                                  <div class='file-item-status remove-pre' data-image="{{ $image }}" data-route="{{ route('user-post-product', 'remove_single_image') }}" data-product="{{ $product->id }}">
                                    <span class='text-danger'>
                                      <i class='icon ni ni-cross'></i>
                                    </span>
                                  </div>
                                </li>
                             @endif
                           @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                 </div>
                 <div class="col-md-6">
                    <div class="section-head my-5">
                       <p>{{ __('Downloadable Product') }}</p>
                    </div>
                  <div class="container">
                    <div class="upload-form-wrap">
                    <div class="uploader" id="drag-and-drop-zone">
                      <div class="uploader-icon-circle">
                        <i class="icon ni ni-upload-cloud"></i>
                      </div>
                      <div class="uploader-bottom">
                        <span>{{ __('Drag files here to upload') }}</span>
                        <input type="file" name="downloadables" class="uploader_input">
                      </div>
                    </div>
                      <!-- File List -->
                      <div class="files-card">
                        <ul class="list-unstyled files" id="files">
                          @if (!empty($product->files))
                         <li class='file-item'>
                             <div class='file-item-body'><p>{{$product->files}}</p><span>{{ nr(filesize(media_path('user/downloadables/'.$product->files))) }}</span>
                             </div>
                             <div class='file-item-status remove-pre' data-image="{{ $product->files }}" data-route="{{ route('user-post-product', 'remove_single_file') }}" data-product="{{ $product->id }}">
                               <span class='text-danger'>
                                 <i class='icon ni ni-cross'></i>
                               </span>
                             </div>
                         </li>
                          @endif
                        </ul>
                      </div>
                    </div>
                  </div>
                 </div>
              </div>

            </div>
            <div class="tab-pane" id="reviews">
              @if (!empty($reviews))
              <div class="nk-block">
                 <div class="nk-tb-list is-separate is-medium mb-3">
                    <div class="nk-tb-item nk-tb-head">
                       <div class="nk-tb-col"><span></span></div>
                       <div class="nk-tb-col"><span>{{ __('Name') }}</span></div>
                       <div class="nk-tb-col d-none d-md-inline-flex"><span>{{ __('Rating') }}</span></div>
                       <div class="nk-tb-col">{{ __('Date') }}</div>
                       <div class="nk-tb-col"></div>
                    </div>
                    @foreach ($reviews as $review)
                    <div class="nk-tb-item background-lighter">
                       <div class="nk-tb-col background-lighter">
                          <div class="user-avatar">
                            <img src="{{ productReviewImage($review->id) }}" alt="">
                          </div>
                       </div>
                       <div class="nk-tb-col background-lighter">
                          <span class="tb-lead">{{$review->review->name ?? ''}}</span>
                       </div>
                       <div class="nk-tb-col tb-col-md background-lighter">
                          <span class="position bold text-left card-rating d-flex" data-rating="{{$review->rating}}"> </span>
                      </div>
                       <div class="nk-tb-col background-lighter">
                          <span class="tb-lead">{{Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                      </div>
                       <div class="nk-tb-col background-lighter">
                          <span class="tb-lead">
                            <a href="#" data-toggle="modal" data-target="#view_review" data-review="{{$review->review->review ?? ''}}" class="btn btn-primary">{{ __('View') }}</a>
                          </span>
                      </div>
                    </div>
                  @endforeach
                 </div>
              </div>
              @else
              <div class="nk-block-head">
                 <div class="nk-block-head-content text-center">
                     <h5 class="nk-block-title fw-normal">{{ __('Nothing found') }}</h5>
                 </div>
              </div>
              @endif
            </div>
            <div class="tab-pane" id="others">
              <div class="row">
               <div class="col-md-12">
                <div class="section-head my-5">
                  <p>{{ __('External Product *optional') }}</p>
                </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group custom mb-4">
                  <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                    <span>{{ __('External Product Url') }}</span>
                    <small class="d-block mt-2">{{ __('Link to your external product page') }}</small>
                  </label>
                     <input type="text" value="{{ $product->external_url }}" placeholder="Url" name="external_url">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group custom mb-4">
                    <label class="muted-deep fw-normal form-label fw-normal ml-2 mb-4">
                      <span>{{ __('External Product Site') }}</span>
                      <small class="d-block mt-2">{{ __('Enter name of external product site') }}</small>
                    </label>
                     <input type="text" value="{{ $product->external_url_name }}" placeholder="Ex: Amazon" name="external_url_name">
                  </div>
               </div>
              </div>
            </div>
            <div class="tab-pane" id="tabItem4">
                <p>contnet</p>
            </div>
        </div>  
      </div>
       <div class="col-12 col-md-10 mx-auto mt-6">

          <button class="btn btn-primary btn-block">{{ __('Save') }}</button>
       </div>
    </div>
 </form>
</div>




  <div class="po-val-field-add d-none">
       <div class="nk-tb-item po-val-item background-lighter" data-poval-name="values">
        <input type="hidden" data-poval-name="id" class="option-values-id">
          <div class="nk-tb-col background-lighter hide-if-text-textarea">
             <div class="form-group">
                <input type="text" data-poval-name="label" class="form-control">
             </div>
          </div>
          <div class="nk-tb-col background-lighter">
             <div class="form-group">
                <input type="number" data-poval-name="price" class="form-control">
             </div>
          </div>
          <div class="nk-tb-col background-lighter">
             <span class="tb-lead">
              <a data-route="{{ route('user-remove-product-option-value') }}" class="btn btn-danger text-white option-remove">
                <span class="d-none d-md-block">{{ __('Delete') }}</span>
                <i class="ni ni-cross d-block d-md-none"></i>
              </a></span>
          </div>
       </div>
  </div>

  <div class="po-field-add d-none">
     <div class="nk-tb-item po-item d-block my-4 bg-lighter p-4" data-id="" data-poname="options">
      <input type="hidden" data-po-name="id">
        <div class="nk-item-custom">
           <div class="nk-tb-item nk-tb-head">
              <div class="nk-tb-col"><span>{{ __('Name') }}</span></div>
              <div class="nk-tb-col"><span>{{ __('Type') }}</span></div>
              <div class="nk-tb-col"></div>
              <div class="nk-tb-col"></div>
              <div></div>
           </div>
           <div class="nk-tb-col bg-lighter">
              <div class="form-group">
                 <input type="text" name="" data-po-name="name" placeholder="{{ __('Ex: Size') }}" class="form-control">
              </div>
           </div>
           <div class="nk-tb-col bg-lighter">
            <div class="h-100 d-flex align-items-center">
              <select data-po-name="type">
                 <option>
                    {{ __('Please Select') }}
                 </option>
                 <optgroup label="Select">
                    <option value="dropdown">
                       {{ __('Dropdown') }}
                    </option>
                    <option value="checkbox">
                       {{ __('Checkbox') }}
                    </option>
                    <option value="radio">
                       {{ __('Radio Button') }}
                    </option>
                    <option value="multiple_select">
                       {{ __('Multiple Select') }}
                    </option>
                 </optgroup>
              </select>
            </div>
           </div>
           <div class="nk-tb-col bg-lighter">
            <div class="h-100 d-flex align-items-center">
               <div class="custom-control custom-control-alternative custom-checkbox">
                 <input type="hidden" data-po-name="required" value="0">
                 <input class="custom-control-input" type="checkbox" data-po-name="required" id="required" value="1">
                 <label class="custom-control-label" for="required">
                   <span class="text-muted">{{ __('Required') }}</span>
                 </label>
               </div>
             </div>
           </div>
           <div class="nk-tb-col bg-lighter">
                <span class="tb-lead"><a data-route="{{ route('user-remove-product-option') }}" class="btn text-white btn-danger remove">
                <span class="d-none d-md-block">{{ __('Delete') }}</span>
                <i class="ni ni-cross d-block d-md-none"></i></a>
                </span>
           </div>
        </div>
           <div class="nk-tb-list po-val-wrap is-separate is-medium mb-3 mt-4 pt-4">
             <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span>{{ __('Label') }}</span></div>
                <div class="nk-tb-col"><span>{{ __('Price') }}</span></div>
                <div class="nk-tb-col"></div>
             </div>
           </div>
        <a class="btn btn-primary mx-3 my-4 po-val-add-button text-white">{{ __('Add New Row') }}</a>
     </div>
 </div>


<div class="modal fade" tabindex="-1" role="dialog" id="view_review" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
              <p id="review-p"></p>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
@stop
