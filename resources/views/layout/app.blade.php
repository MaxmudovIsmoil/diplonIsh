<!DOCTYPE html>
<html class="loading dark-layout" data-theme="dark" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="keywords" content="admin template, web app">
    <meta name="author" content="Purchase">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Purchase') }}</title>
    <link rel="apple-touch-icon" href="{{ asset("assets/images/logo/toshMetroLogo.png")}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("assets/images/logo/toshMetroLogo.png")}}">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/vendors/css/vendors.min.css")}}">

    <link rel="stylesheet" type="text/css" href="{{ asset("assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/vendors/css/extensions/plyr.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/vendors/css/forms/wizard/bs-stepper.min.css")}}">

{{--    <link rel="stylesheet" type="text/css"--}}
{{--          href="{{ asset("assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css")}}">--}}
{{--    <link rel="stylesheet" type="text/css"--}}
{{--          href="{{ asset("assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css")}}">--}}
{{--    <link rel="stylesheet" type="text/css"--}}
{{--          href="{{ asset('assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css"--}}
{{--          href="{{ asset("assets/vendors/css/pickers/flatpickr/flatpickr.min.css")}}">--}}
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/fonts/font-awesome/css/font-awesome.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/bootstrap-extended.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/colors.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/components.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/themes/dark-layout.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/plugins/forms/form-validation.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/plugins/forms/form-wizard.min.css")}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/core/menu/menu-types/vertical-menu.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/plugins/extensions/ext-component-media-player.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/pages/app-user.css")}}">
    <!-- END: Page CSS-->
    @yield('style')
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css")}}">
    <!-- END: Custom CSS-->

</head>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static" data-open="click"
      data-menu="vertical-menu-modern" data-col="" data-theme="dark">
@include('layout.header')

<!-- BEGIN: Content-->
<div class="app-content content ">
    @yield('content')
</div>
<!-- END: Content-->
@include('layout.deleteModal')

@include('layout.profileModal')

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

<script src="{{ asset('assets/js/locale_storage.js') }}"></script>
<script src="{{ asset("assets/vendors/js/vendors.min.js")}}"></script>

<script src="{{ asset("assets/vendors/js/tables/datatable/jquery.dataTables.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/tables/datatable/dataTables.responsive.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/tables/datatable/responsive.bootstrap4.js")}}"></script>
<script src="{{ asset("assets/vendors/js/tables/datatable/datatables.buttons.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/tables/datatable/vfs_fonts.js")}}"></script>
{{--<script src="{{ asset('assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>--}}
{{--<script src="{{ asset('assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>--}}
<script src="{{ asset('assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset("assets/vendors/js/forms/validation/jquery.validate.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/extensions/plyr.min.js")}}"></script>
<script src="{{ asset("assets/vendors/js/extensions/plyr.polyfilled.min.js")}}"></script>

<!-- BEGIN: Theme JS-->
<script src="{{ asset("assets/js/core/app-menu.js")}}"></script>
<script src="{{ asset("assets/js/core/app.js")}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset("assets/js/scripts/pages/app-user-list.js")}}"></script>
<script src="{{ asset("assets/js/scripts/components/components-popovers.js")}}"></script>
<script src="{{ asset('assets/js/scripts/tables/table-datatables-basic.js') }}"></script>

<script src="{{ asset('assets/js/scripts/extensions/ext-component-media-player.js') }}"></script>


<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/js/delete_function.js') }}"></script>
<script src="{{ asset('assets/js/profile.js') }}"></script>
<!-- END: Page JS-->
@yield('script')
<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });

</script>


</body>
<!-- END: Body-->

</html>

