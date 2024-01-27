<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @extends('fixed.head')
    </head>
    <body class="container-scroller">
        <div id="app">
            <navbar-component></navbar-component>
            <div class="container-fluid page-body-wrapper">
                <sidebar-component></sidebar-component>
                <div class="main-panel">
                    <router-view></router-view>
                    <footer-component></footer-component>
                </div>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="../../assets/js/off-canvas.js"></script>
        <script src="../../assets/js/hoverable-collapse.js"></script>
        <script src="../../assets/js/misc.js"></script>
    </body>
</html>
