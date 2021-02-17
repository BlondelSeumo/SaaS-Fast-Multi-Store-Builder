@extends('profile.master')
@section('content')
 @include('profile/menu')
<style type="text/css">
   .header-wrapper.header-height{
      margin: 0;
   }
</style>
<div class="about-me">
   <div class="row">
      <!-- Image -->
      <div class="col-lg-6">
         <!-- About Me Image -->
         <div class="about-me_image" style="background-image: url({{ url('images/background/' . $user->backgrounds) }})"></div>
      </div>
      <!-- Content -->
      <div class="col-lg-6 align-self-center">
         <div class="lateral-content">
            <!-- About Me Title -->
            <h3>About {{ucfirst($user->name)}}</h3>
            <hr>
            <!-- About Me Content -->
            <p>{{$user->about}}</p>
         </div>
      </div>
   </div>
</div>

@stop