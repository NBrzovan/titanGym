@extends('welcome')

@section('content')
    @include('pages.home')
    <div class="main-panel">
        <router-view></router-view>
        <footer-component></footer-component>
    </div>
@endsection

@section('custom_styles')
    <!-- Ovde uključite Bootstrap stilove samo za ovu stranicu -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection