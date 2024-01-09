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
    </body>
</html>
