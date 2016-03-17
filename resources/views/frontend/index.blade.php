@extends('frontend.shared.master')

@section('title', 'Ask DeRay')
<!--
<button class="default-btn"><p>Button</p></button>
<p>Testing testing testing testing</p>
<p class="faded-text">Testing testing testing testing</p>
<button class="default-btn no-border-btn"><p>Button</p></button>
-->
@section('content')
    <div id="app">
        <div class="container">

            <h1>Soapbox</h1>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <feature :user="user"></feature>
                </div>
            </div>
            <ask></ask>
            <question v-for="question in questions" :question="question"></question>
        </div>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    @include('frontend.vtemplates.ask')

    <script src="frontend/js/app.js"></script>
@endsection
