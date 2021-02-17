@foreach ($users as $user)

@extends('profile.master')
@section('title', ucfirst($user->name))
@section('content')
 @include('profile/menu')
<style type="text/css">
   .header-wrapper.header-height{
      margin: 0;
   }
</style>
    @include('profile/menu')

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
               <h3>Contact {{ucfirst($user->name)}}</h3>
               <hr>
               <form method="post">

                   <p class="form-row form-row-first">
                     <label class="">Name<abbr class="required" title="required">*</abbr>
                     </label>
                     <input type="text" class="input-text " name="name" required="">
                   </p>
                   <p class="form-row form-row-first">
                     <label class="">Email <abbr class="required" title="required">*</abbr>
                     </label>
                     <input type="email" class="input-text " name="name" required="">
                   </p>
                  <div class="roov-additional-fields">
                     <div class="roov-additional-fields__field-wrapper">
                        <p class="form-row notes" id="order_comments_field" data-priority="">
                          <label for="order_comments" class="">Message</label>
                          <textarea name="message" class="input-text " id="message"></textarea></p>
                     </div>
                  </div>
                  <button class="checkout-button button alt wc-forward" type="submit">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>

 @stop
   @endforeach