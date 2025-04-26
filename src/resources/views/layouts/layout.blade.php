<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>School</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico')}}">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.transitions.css')}}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/animate.css')}}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/normalize.css')}}">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/meanmenu.min.css')}}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <!-- educate icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/educate-custon-icon.css')}}">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/morrisjs/morris.css')}}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <!-- metisMenu CSS
            ============================================ -->
    <link rel="stylesheet" href="{{ asset('css/metisMenu/metisMenu.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/metisMenu/metisMenu-vertical.css')}}">
    <!-- calendar CSS
            ============================================ -->
    <link rel="stylesheet" href="{{ asset('css/calendar/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/calendar/fullcalendar.print.min.css')}}">
    <!-- dropzone CSS
		============================================ -->
{{--    <link rel="stylesheet" href="{{asset('css/dropzone/dropzone.css')}}">--}}
@if(\Request::path()!='login')
    <!-- duallistbox CSS
		============================================ -->
{{--        <link rel="stylesheet" href="{{ asset('css/duallistbox/bootstrap-duallistbox.min.css')}}">--}}

        <!-- x-editor CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('css/editor/select2.css')}}">
        <link rel="stylesheet" href="{{ asset('css/editor/datetimepicker.css')}}">
        <link rel="stylesheet" href="{{ asset('css/editor/bootstrap-editable.css')}}">
        <link rel="stylesheet" href="{{ asset('css/editor/x-editor-style.css')}}">
        <!-- normalize CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-table.css')}}">
        <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-editable.css')}}">

        <link rel="stylesheet" href="{{ asset('css/datapicker/datepicker3.css')}}">
@endif
<!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css')}}">
    <!-- modals CSS
            ============================================ -->
    <link rel="stylesheet" href="{{ asset('css/modals.css')}}">
</head>

<body>

@if(\Request::path()!='login')

    @include('layouts.sidebar')
    @include('layouts.header')



@endif

@yield('content')


@if(\Request::path()!='login' && \Request::path()!='/' && \Request::path()!='home')
    @include('layouts.footer')

@endif


<!-- jquery
		============================================ -->
<script src="{{ asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
@if(\Request::path()!='addnewmark')
<script>

    $(document).ready(function () {
         $("table tr td").not(':nth-child(2)').find(".mark").prop("disabled", true);
         $("table tr td").not(':nth-child(2)').find(":checkbox").prop("disabled", false);
        $('#table').on('click',':checkbox',function(){

                if($(this).is(':checked')){
                    $(this).closest('tr').find(".mark").prop("disabled", false);}
                else{
                    $(this).closest('tr').find(".mark").prop("disabled", true);
                }


        });
    });
</script>
@endif
<!-- bootstrap JS
    ============================================ -->
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<!-- wow JS
    ============================================ -->
<script src="{{ asset('js/wow.min.js')}}"></script>
<!-- price-slider JS
    ============================================ -->
<script src="{{ asset('js/jquery-price-slider.js')}}"></script>
<!-- meanmenu JS
    ============================================ -->
<script src="{{ asset('js/jquery.meanmenu.js')}}"></script>
<!-- owl.carousel JS
    ============================================ -->
<script src="{{ asset('js/owl.carousel.min.js')}}"></script>
<!-- sticky JS
    ============================================ -->
<script src="{{ asset('js/jquery.sticky.js')}}"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="{{ asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="{{ asset('js/scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{ asset('js/scrollbar/mCustomScrollbar-active.js')}}"></script>
<!-- counterup JS
    ============================================ -->
{{--<script src="{{ asset('js/counterup/jquery.counterup.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/counterup/waypoints.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/counterup/counterup-active.js')}}"></script>--}}

<!-- metisMenu JS
    ============================================ -->
<script src="{{ asset('js/metisMenu/metisMenu.min.js')}}"></script>
<script src="{{ asset('js/metisMenu/metisMenu-active.js')}}"></script>


@if(\Request::path()!='login')

    <!-- duallistbox JS
      ============================================ -->
    <script src="{{ asset('js/duallistbox/jquery.bootstrap-duallistbox.js')}}"></script>
    <script src="{{ asset('js/duallistbox/duallistbox.active.js')}}"></script>

    <!-- data table JS
           ============================================ -->
    <script src="{{ asset('js/data-table/bootstrap-table.js')}}"></script>
    <script src="{{ asset('js/data-table/tableExport.js')}}"></script>
    <script src="{{ asset('js/data-table/data-table-active.js')}}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-editable.js')}}"></script>
    <script src="{{ asset('js/data-table/bootstrap-editable.js')}}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-resizable.js')}}"></script>
    <script src="{{ asset('js/data-table/colResizable-1.5.source.js')}}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-export.js')}}"></script>
    <!--  editable JS
        ============================================ -->
    <script src="{{ asset('js/editable/jquery.mockjax.js')}}"></script>
    <script src="{{ asset('js/editable/mock-active.js')}}"></script>
    <script src="{{ asset('js/editable/select2.js')}}"></script>
    <script src="{{ asset('js/editable/moment.min.js')}}"></script>
    <script src="{{ asset('js/editable/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{ asset('js/editable/bootstrap-editable.js')}}"></script>
    <script src="{{ asset('js/editable/xediable-active.js')}}"></script>
    <!-- Chart JS
        ============================================ -->
    <script src="{{ asset('js/chart/jquery.peity.min.js')}}"></script>
    <script src="{{ asset('js/peity/peity-active.js')}}"></script>

@endif
<!-- morrisjs JS
    ============================================ -->
{{--<script src="{{ asset('js/morrisjs/raphael-min.js')}}"></script>--}}
{{--<script src="{{ asset('js/morrisjs/morris.js')}}"></script>--}}
{{--<script src="{{ asset('js/morrisjs/morris-active.js')}}"></script>--}}
{{--<!-- morrisjs JS--}}
{{--    ============================================ -->--}}
{{--<script src="{{ asset('js/sparkline/jquery.sparkline.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/sparkline/jquery.charts-sparkline.js')}}"></script>--}}
{{--<script src="{{ asset('js/sparkline/sparkline-active.js')}}"></script>--}}
<!-- calendar JS
    ============================================ -->

{{--<script src="{{ asset('js/calendar/moment.min.js')}}"></script>--}}
<script src="{{ asset('js/calendar/fullcalendar.min.js')}}"></script>
<script src="{{ asset('js/calendar/fullcalendar-active.js')}}"></script>
<!-- icheck JS
      ============================================ -->
<script src="{{ asset('js/icheck/icheck.min.js')}}"></script>
<script src="{{ asset('js/icheck/icheck-active.js')}}"></script>

<script src="{{ asset('js/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('js/datapicker/datepicker-active.js')}}"></script>

<script src="{{ asset('js/form-validation/jquery.form.min.js')}}"></script>
<script src="{{ asset('js/form-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('js/form-validation/form-active.js')}}"></script>


{{--<script src="{{ asset('js/password-meter/pwstrength-bootstrap.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/password-meter/zxcvbn.js')}}"></script>--}}
{{--<script src="{{ asset('js/password-meter/password-meter-active.js')}}"></script>--}}


<!-- tab JS
		============================================ -->
<script src="{{ asset('js/tab.js')}}"></script>
<!-- plugins JS
    ============================================ -->
<script src="{{ asset('js/plugins.js')}}"></script>
<!-- main JS
    ============================================ -->
<script src="{{ asset('js/main.js')}}"></script>
<!-- modernizr JS
		============================================ -->
<script src="{{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>




<!-- dropzone JS
		============================================ -->
{{--<script src="{{asset('js/dropzone/dropzone.js')}}"></script>--}}

<!-- tawk chat JS
       ============================================ -->
{{--<script src="{{ asset('js/tawk-chat.js')}}"></script>--}}

</body>
</html>
