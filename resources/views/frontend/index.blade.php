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
            <login-modal :show.sync="showLoginModal"></login-modal>
            <button class="default-btn" @click="showLoginModal = true">Login</button>
            <h1>Soapbox</h1>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <feature :user="recipient"></feature>
                </div>
            </div>
            <ask v-if="loggedIn"></ask>
            <question v-for="question in questions" :question="question"></question>
        </div>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    @include('frontend.vtemplates.ask')
    @include('frontend.vtemplates.modal')
    @include('frontend.vtemplates.login')

    <script src="frontend/js/app.js"></script>
@endsection
