@extends('frontend.shared.master')

@section('title', 'Ask DeRay')

@section('content')
    <div id="app">
        <question v-for="question in questions" :question="question"></question>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    <script src="frontend/js/app.js"></script>
@endsection
