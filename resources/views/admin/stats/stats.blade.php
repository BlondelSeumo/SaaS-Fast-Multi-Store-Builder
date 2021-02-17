@extends('admin.layouts.app')

@section('title', __('Statistics'))
@section('content')
<div class="nk-block-head">
  <div class="row">
    <div class="col-6 d-flex align-items-center">
      <div class="nk-block-head-content">
         <h2 class="nk-block-title fw-normal"><em class="icon ni ni-growth"></em> <span>{{ __('Stats') }}</span></h2>
      </div>
    </div>
  </div>
</div>
  <form class="form-inline" id="datepicker_form">
      <label class="position-relative">
          <div id="datepicker_selector" class="text-muted clickable">
            <h5 class="nk-block-title fw-normal">
              <span class="mr-1">
                @if ($options->start_date == $options->end_date)
                  {{ Carbon\Carbon::parse($options->start_date)->toFormattedDateString() }}
                  @else
                  {{ Carbon\Carbon::parse($options->start_date)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($options->end_date)->toFormattedDateString() }}
                @endif
              </span>
              <i class="fa fa-fw fa-caret-down"></i>
             </h5>
          </div>
          <input
             type="text"
             id="datepicker_input"
             data-range="true"
             name="date_range"
             value="{{$options->date->input_date_range}}"
             placeholder=""
             autocomplete="off"
             readonly="readonly"
             class="custom-control-input"
          >
      </label>
  </form>
<div class="row">
  <div class="col-md-6">
    <div class="nk-ck mt-5">
        <canvas class="line-chart" id="usersChart"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="nk-ck mt-5">
        <canvas class="line-chart" id="productschart"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="nk-ck mt-5">
        <canvas class="line-chart" id="profilevisitschart"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="nk-ck mt-5">
        <canvas class="line-chart" id="paymentsvisitschart"></canvas>
    </div>
  </div>
</div>
 @section('footerJS')
 <input type="hidden" value="{{ url('/') }}" id="url">
 <link rel="stylesheet" href="{{ url('css/datepicker.min.css') }}">
 <script src="{{ url('js/datepicker.min.js') }}"></script>
 <script>
    const redirect = (url, full = false) => {
        let base_url = $('#url').val();
        window.location.href = full ? url : `${base_url}${url}`;
    };
    $.fn.datepicker.language['clovdigital'] = <?= json_encode(require base_path('resources') .'/others/date_picker.php') ?>;
    let datepicker = $('#datepicker_input').datepicker({
        language: 'clovdigital',
        dateFormat: 'yyyy-mm-dd',
        autoClose: true,
        timepicker: false,
        toggleSelected: false,
        maxDate: new Date(),
        onSelect: (formatted_date, date) => {

            if(date.length > 1) {
                let [ start_date, end_date ] = formatted_date.split(',');

                if(typeof end_date == 'undefined') {
                    end_date = start_date
                }
                /* Redirect */
                redirect(`/dashboard/admin/stats/?start_date=${start_date}&end_date=${end_date}`);
            }
        }
    });
 </script>
 <script>
   var usersChart = {
         labels: {!! $options->userschart['labels'] ?? "[]" !!},
         dataUnit: "{{ __('Users') }}",
         lineTension: 0.1,
         legend: !0,
         datasets: [{
             label: "{{ __('Users') }}",
             color: "#a0aec0",
             background: "transparent",
             data: {!! !empty($options->userschart['users']) ? $options->userschart['users'] : '[0]' !!}
         }]
   };
   var productschart = {
         labels: {!! $options->productschart['labels'] ?? "[]" !!},
         dataUnit: "{{ __('Products created') }}",
         lineTension: 0.1,
         legend: !0,
         datasets: [{
             label: "{{ __('Products') }}",
             color: "#a0aec0",
             background: "transparent",
             data: {!! !empty($options->productschart['count']) ? $options->productschart['count'] : '[0]' !!}
         }]
   };
   var profilevisitschart = {
         labels: {!! $options->profilevisitschart['labels'] ?? "[]" !!},
         dataUnit: "Visitors",
         lineTension: 0.1,
         legend: !0,
       datasets:[{
        label: "{{ __('Impressions') }}",
        color:"#a0aec0",
        dash:[5],
        background:"transparent",
        data:{!! $options->profilevisitschart['impression'] ?? "[]" !!}},{
        label: "{{ __('Unique') }}",
        color:"#000000",
        dash:0,
        background:NioApp.hexRGB("#798bff",.15),
        data:{!! $options->profilevisitschart['unique'] ?? "[]" !!}}]
   };
   var paymentsvisitschart = {
         labels: {!! !empty($options->paymentschart['labels']) ? $options->paymentschart['labels'] : '[0]' !!},
         dataUnit: "",
         lineTension: .4,
         legend: !0,
       datasets:[{
        label: "Total Payments",
        color:"#000000",
        dash:[5],
        background:"transparent",
        data:{!! $options->paymentschart['count'] ?? "[]" !!}},{
        label: "Earned",
        color:"#a0aec0",
        dash:0,
        background:NioApp.hexRGB("#798bff",.15),
        data:{!! $options->paymentschart['amount'] ?? "[]" !!}}]
   };
 </script>
@stop
@endsection
