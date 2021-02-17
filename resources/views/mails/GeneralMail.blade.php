@extends('mails.layouts.app')

@section('content')
 <tr>
     <td style="padding: 30px 0 15px 30px;">
         <h2 style="font-size: 18px; color: #000; text-decoration: underline; font-weight: 900; margin: 0;">{{ $email->subject }}</h2>
     </td>
 </tr>
 <tr>
     <td style="padding: 20px 20px">
       	{!! clean($email->message, 'titles') !!}
     </td>
 </tr>
@endsection
