@extends('frontend.shared.master')

@section('title', 'Ask DeRay')

@section('content')
    <div id="app">
        <feature :user="user"></feature>
        <question v-for="question in questions" :question="question"></question>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    <script src="frontend/js/app.js"></script>
@endsection
