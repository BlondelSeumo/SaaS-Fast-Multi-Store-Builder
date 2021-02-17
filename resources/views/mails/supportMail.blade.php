@extends('mails.layouts.app')

@section('content')
 <tr>
     <td style="padding: 30px 30px 15px 30px;">
         <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;">{{ __('New ticket') }}</h2>
     </td>
 </tr>
 <tr>
     <td style="padding: 0 30px 20px">
         <p style="margin-bottom: 10px;">{{ __('New support ticket from') }} <br>{{$user->name}}</b></p>
         <p style="margin-bottom: 10px;">{{ __('Head to admin dashboard to view and reply ticket.') }}</p>
     </td>
 </tr>
@endsection
