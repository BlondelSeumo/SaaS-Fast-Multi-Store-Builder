@extends('mails.layouts.app')

@section('content')
 <tr>
     <td style="text-align:center;padding: 30px 30px 15px 30px;">
         <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;">{{ __('Your new account is ready') }}</h2>
     </td>
 </tr>
 <tr>
     <td style="text-align:center;padding: 0 30px 20px">
         <p style="margin-bottom: 10px;">{{ __("Hi ") . full_name($user->id) }},</p>
         <p style="margin-bottom: 10px;">{{ __('Click or copy the link below to activate your account.') }}</p>
         <a href="{{ url('/activate/u/' . $user->email_token) }}" style="background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0 30px">Activate</a>
         <p style="margin-top: 10px;">Or</p>
         {{ url('/activate/u/' . $user->email_token) }}
     </td>
 </tr>
@endsection
