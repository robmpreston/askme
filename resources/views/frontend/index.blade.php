@extends('frontend.shared.master')

@section('title', 'Ask DeRay')

@section('content')
    <div id="app">
        <div class="container">
            <button class="default-btn"><p>Button</p></button>
            <p>Testing testing testing testing</p>
            <p class="faded-text">Testing testing testing testing</p>
            <button class="default-btn no-border-btn"><p>Button</p></button>
            <feature :user="user"></feature>
            <question v-for="question in questions" :question="question"></question>
        </div>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    <script src="frontend/js/app.js"></script>
@endsection
