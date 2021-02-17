@extends('mails.layouts.app')

@section('content')

 <tr>
     <td style="text-align:center;padding: 30px 30px 15px 30px;">
         <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;">{{ __('Reset Password') }}</h2>
     </td>
 </tr>
 <tr>
     <td style="text-align:center;padding: 0 30px 20px">
         <p style="margin-bottom: 10px;">{{ __("Hi $content->name") }}</p>
         <p style="margin-bottom: 25px;">{{ __('Click On The link below to reset your password.') }}</p>
         <a href="{{ url('/login?reset-password=true&email='.$content->email.'&token='.$content->token) }}" style="background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0 25px">{{ __('Reset Password') }}</a>
         <p style="margin-top: 10px;">Or</p>
         {{ url('/login?reset-password=true&email='.$content->email.'&token='.$content->token) }}
     </td>
 </tr>
@endsection
