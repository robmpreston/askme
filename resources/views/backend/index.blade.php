@extends('backend.shared.master')

@section('title', 'Ask DeRay')

@section('content')
    <div id="app">
        <question v-for="question in questions" :question="question"></question>
    </div>
    @include('backend.vtemplates.question')
    <script src="js/all.js"></script>
@endsection
