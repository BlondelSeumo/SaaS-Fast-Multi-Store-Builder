@extends('mails.layouts.app')

@section('content')
 <tr>
     <td style="padding: 30px 30px 15px 30px;">
         <h2 style="font-size: 18px; color: #000; font-weight: 600; margin: 0;">{{ __('New reply') }}</h2>
     </td>
 </tr>
 <tr>
     <td style="padding: 0 30px 20px">
         <p style="margin-bottom: 10px; font-size: 16px;">{{ __('From:') }} {!! clean($reply->username, 'titles') !!}</p>
         <p style="margin-bottom: 10px;">{{ __('Ticket id:') }} {!! clean($reply->supportID, 'titles') !!}</p>
         <p style="margin-bottom: 10px;">{{ __('Email:') }} {!! clean($reply->email, 'titles') !!}</p>
         <p style="margin-bottom: 10px; text-decoration: underline;">{{ __('Priority:') }} <b style="{{($reply->priority == 'high') ? "color: red" : "color: blue"}}">{!! clean($reply->priority, 'titles') !!}</b></p>
         <p style="margin-top: 20px;">{!! clean($reply->messsage, 'titles') !!}</p>
     </td>
 </tr>
@endsection
