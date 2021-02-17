@extends('layouts.app')

@section('headJS')
<script src="{{ asset('js/Sortable.min.js') }}"></script>
@stop
@section('footerJS')
  <script src="{{ url('tinymce/tinymce.min.js') }}"></script>
  <script src="{{ url('tinymce/sr.js') }}"></script>
@stop
@section('title', __('Blogs'))
@section('content')
<div class="nk-block-head mt-8">
  <div class="row">
    <div class="col-6 d-flex align-items-center">
      <div class="nk-block-head-content">
         <h2 class="nk-block-title fw-normal">{{ __('Posts') }} <span class="badge badge-dim badge-primary badge-pill">{{ count($blogs) }}</span></h2>
      </div>
    </div>
    <div class="col-6">
      <div class="nk-block-head-content mb-3">
         <div class="nk-block-tools justify-content-right">
              <a href="#" data-toggle="modal" data-target="#new-blog" class="btn btn-primary mr-auto-rtl">
                {{ __('New blog') }}
              </a>
         </div>
      </div>
    </div>
  </div>
</div>
@if (count($blogs) < 1)
   <div class="nk-block-head-content text-center">
       <h2 class="nk-block-title fw-normal">{{ __('No blog posts found') }}</h2>
   </div>
@endif
<div class="row" id="links">
   @foreach ($blogs as $blog)
      <div class="col-sm-6 col-md-4 col-lg-3 link" data-id="{{$blog->id}}">
          <div class="links portfolio">
            <div class="image">
              <img src="{{ (!empty($blog->image) && file_exists(public_path('media/user/blog/' . $blog->image)) ? url('media/user/blog/' . $blog->image) : $blog->extra->media_url ?? '') }}" alt=" ">
            </div>
            <a class="delete-btn text-danger" data-confirm="{{ __('Are you sure you want to delete this?') }}" href="{{ url(route('user-blog-delete', $blog->id)) }}"><span><em class="icon ni ni-trash"></em></span></a>
            <div class="title">{{ $blog->name }}</div>
            <div class="row">
              <div class="col-6">
                {{ nr($blog->track_portfolio) }} {{ __('Views') }}
              </div>
              <div class="col-6">
               <div class="right-btn">           
                  <a data-toggle="modal" data-target="#edit-blog-{{ $blog->id }}"><em class="icon ni ni-edit"></em></a>
                 <a class="handle"><span><em class="icon ni ni-move"></em></span></a> 
               </div>
              </div>
            </div>
          </div>
      </div>
   <!-- @ Profile Edit Modal @e -->
   <div class="modal fade" tabindex="-1" role="dialog" id="edit-blog-{{ $blog->id }}">
       <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
           <div class="modal-content">
               <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
               <div class="modal-body modal-body-lg">
                  <div class="row mt-4">
                    <div class="col-12">
                      <a href="{{ route('user-blog-delete', $blog->id) }}" class="btn btn-block btn-danger mb-5"><em class="icon ni ni-trash"></em> <span>{{ __('Delete') }}</span></a>
                    </div>
                  </div>
                  <h5 class="title mb-5">{{ __('Edit') }} <b class="text-dark">{{ !empty($blog->name) ? $blog->name : "" }}</b></h5>
                  <form action="{{ route('user-blog') }}" method="post" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" value="{{ $blog->id }}" name="blog_id">
                     <ul class="nav nav-tabs nav-tabs-s2">
                         <li class="nav-item">
                             <a class="nav-link active" data-toggle="tab" href="#main_{{$blog->id}}"><em class="icon ni ni-files"></em> <span>{{ __('Main') }}</span></a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" data-toggle="tab" href="#other_{{$blog->id}}"><em class="icon ni ni-files"></em> <span>{{ __('Others') }}</span></a>
                         </li>
                     </ul>
                     <div class="tab-content">
                         <div class="tab-pane active" id="main_{{ $blog->id }}">
                            <div class="row gy-4">
                               <div class="col-12">
                                  <div class="form-group">
                                     <label class="form-label" for="name">{{ __('Name') }}</label>
                                     <input type="text" name="name" class="form-control form-control-lg" id="name" value="{{ $blog->name }}" placeholder="{{ __('Name') }}">
                                  </div>
                               </div>
                               <div class="col-12">
                                  <div class="form-group">
                                     <label class="form-label">{{ __('Note') }}</label>
                                      <textarea name="note" class="form-control form-control-lg editor" placeholder="{{ __('Note') }}">{{$blog->note}}</textarea>
                                  </div>
                                <h4 class="mt-3">{{ __('Note short code') }}</h4>
                                <code class="shortcode">&#123;&#123;title&#125;&#125;</code>
                                <p>{{ __('Note: use short codes with braces') }} &#123;&#123; &#125;&#125;</p>
                               </div>
                            </div>
                         </div>
                         <div class="tab-pane" id="other_{{$blog->id}}">
                           <div class="gy-4">
                               <div class="col-12">
                                  <div class="form-group">
                                     <label class="form-label" for="media_url">{{ __('Media Url') }}</label>
                                     <input type="text" name="media_url" class="form-control form-control-lg" id="media_url" value="{{ !empty($blog->settings->media_url) ? $blog->settings->media_url : "" }}" placeholder="{{ __('Media Url') }}">
                                  </div>
                               </div>
                               <div class="text-center">
                                 <h6 class="text-muted">{{ __('Or') }}</h6>
                               </div>
                               <div class="col-12">
                                  <div class="form-group">
                                    <div class="image-upload pages active">
                                         <label for="upload">{{ __('Click here or drop an image to upload') }} <small>{{ __('1048MB max') }}</small></label>
                                         <input type="file" id="upload" name="image" class="upload">
                                         <img src="{{ url('media/user/blog/' . $blog->image) }}" alt=" ">
                                    </div>
                                  </div>
                               </div>
                                @if(!empty($blog->image) && file_exists(public_path('media/user/blog/' . $blog->image)))
                                <a data-confirm="{{ __('Are you sure you want to delete this image?') }}" href="{{ route('user-blog', ['remove-image' => true, 'id' => $blog->id]) }}" class="btn btn-link">{{ __('Remove image') }}</a>
                               @endif
                           </div>
                         </div>
                      <button type="submit" class="btn btn-lg btn-primary btn-block mt-4">{{ __('Post') }}</button>
                     </div>
                  </form>
               </div><!-- .modal-body -->
           </div><!-- .modal-content -->
       </div><!-- .modal-dialog -->
   </div><!-- .modal -->
  @endforeach
</div>
   <div class="modal fade" tabindex="-1" role="dialog" id="new-blog">
       <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
           <div class="modal-content">
               <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
               <div class="modal-body modal-body-lg">
                   <h5 class="title mb-5">{{ __('New Blog') }}</h5>

                  <form action="{{ route('user-blog') }}" method="post" enctype="multipart/form-data">
                     @csrf
                     <ul class="nav nav-tabs nav-tabs-s2">
                         <li class="nav-item">
                             <a class="nav-link active" data-toggle="tab" href="#main"><em class="icon ni ni-files"></em> <span>{{ __('Main') }}</span></a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" data-toggle="tab" href="#other"><em class="icon ni ni-files"></em> <span>{{ __('Others') }}</span></a>
                         </li>
                     </ul>
                     <div class="tab-content">
                         <div class="tab-pane active" id="main">
                            <div class="row gy-4">
                               <div class="col-12">
                                  <div class="form-group">
                                     <label class="form-label" for="name">{{ __('Name') }}</label>
                                     <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="{{ __('Name') }}">
                                  </div>
                               </div>
                               <div class="col-12">
                                  <div class="form-group">
                                     <label class="form-label">{{ __('Note') }}</label>
                                      <textarea name="note" class="form-control form-control-lg editor" placeholder="{{ __('Note') }}"></textarea>
                                  </div>
                                <h4 class="mt-3">{{ __('Note short code') }}</h4>   
                                <code>&#123;&#123;title&#125;&#125;</code>
                                <p>Note: use short codes with braces &#123;&#123; &#125;&#125;</p>
                               </div>
                            </div>
                         </div>
                         <div class="tab-pane" id="other">
                           <div class="gy-4">
                               <div class="col-12">
                                  <div class="form-group">
                                     <label class="form-label" for="media_url">{{ __('Media Url') }}</label>
                                     <input type="text" name="media_url" class="form-control form-control-lg" id="media_url" placeholder="{{ __('Media Url') }}">
                                  </div>
                               </div>
                               <div class="text-center">
                                 <h6 class="text-muted">{{ __('Or') }}</h6>
                               </div>
                                  <div class="form-group">
                                    <div class="image-upload pages">
                                         <label for="upload">{{ __('Click here or drop an image to upload') }} <small>{{ __('1048MB max') }}</small></label>
                                         <input type="file" id="upload" name="image" class="upload">
                                         <img src="" alt=" ">
                                    </div>
                                  </div>
                               </div>
                           </div>
                         </div>
                      <button type="submit" class="btn btn-lg btn-primary btn-block mt-4" placeholder="Post">{{ __('Post') }}</button>
                     </div>
                  </form>
               </div><!-- .modal-body -->
           </div><!-- .modal-content -->
       </div><!-- .modal-dialog -->
   </div><!-- .modal -->
<script>
let sortable = Sortable.create(document.getElementById('links'), {
    animation: 150,
    group: "sorting",
    handle: '.handle',
    swapThreshold: 5,
    onUpdate: () => {
        let data = [];
        $('#links > .link').each((i, elm) => {
            let link = {
                id: $(elm).data('id'),
                order: i
            };

            data.push(link);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('user-blog-sortable') }}",
            dataType: 'json',
            data: {
                data: data
            }
        });
    }
});
</script>
@endsection
