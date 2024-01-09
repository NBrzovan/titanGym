<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @extends('fixed.head')
    </head>
    <body class="antialiased">
        <div id="app">
            <navbar-component></navbar-component>
            <sidebar-component></sidebar-component>
            <div>
                <router-view></router-view>
            </div>
            <footer-component></footer-component>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
